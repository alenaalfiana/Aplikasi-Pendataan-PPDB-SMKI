<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        $search = $request->input('search');
        $roleFilter = $request->input('role_as');

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($roleFilter !== null, function ($query) use ($roleFilter) {
                $query->where('role_as', $roleFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.index', compact('users', 'roleFilter'));
    }

    public function create()
    {
        if (Auth::user()->role_as != 1) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk menambahkan user.');
        }
        $provinces = Province::all();

        return view('users.create', compact('provinces'));
    }

    public function getRegencies($provinceId)
    {
        return response()->json(Regency::where('province_id', $provinceId)->get());
    }

    public function getDistricts($regencyId)
    {
        return response()->json(District::where('regency_id', $regencyId)->get());
    }

    public function getVillages($districtId)
    {
        return response()->json(Village::where('district_id', $districtId)->get());
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_as != 1) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk menambahkan user.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_as' => 'nullable|in:0,1,2',
            'province_id' => 'nullable|exists:provinces,id',
            'regency_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
            'alamat' => 'nullable|string',
            'tanda_tangan' => 'nullable|string',
            'verify_email' => 'boolean',  // This ensures it's treated as a boolean
        ]);

        // Inisialisasi variabel
        $tandaTanganPath = null;
        $tandaTanganBase64 = null;

        // Simpan password yang belum di-hash untuk dikirim via email
        $plainPassword = $request->password;

        // Proses tanda tangan jika ada
        if ($request->filled('tanda_tangan')) {
            try {
                $signatureData = $this->saveSignature($request->tanda_tangan);
                $tandaTanganPath = $signatureData['path'];
                $tandaTanganBase64 = $signatureData['base64'];
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan tanda tangan: ' . $e->getMessage());
            }
        }

        // Siapkan data user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role_as' => $request->role_as,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'alamat' => $request->alamat,
            'tanda_tangan' => $tandaTanganBase64,
            'tanda_tangan_path' => $tandaTanganPath,
        ];

        // Cast verify_email to boolean and check its value
        $verifyEmail = filter_var($request->verify_email, FILTER_VALIDATE_BOOLEAN);

        // If verify_email is true, set email_verified_at to current time
        if ($verifyEmail) {
            $userData['email_verified_at'] = now();
        } else {
            $userData['email_verified_at'] = null; // Ensure it's null if false
        }

        // Buat user baru
        $user = User::create($userData);

        // Kirim email dengan informasi kredensial
        try {
            Mail::to($user->email)->send(new UserCredentialsMail([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $plainPassword, // Password yang belum di-hash
                'verified' => $verifyEmail, // Add verification status
            ]));
        } catch (\Exception $e) {
            // Log error jika pengiriman email gagal, tapi tetap lanjutkan proses
            Log::error('Gagal mengirim email: ' . $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan dan email kredensial telah dikirim.');
    }

    public function edit($id, Request $request)
    {
        $user = User::findOrFail($id);

        $provinces = Province::all();
        $regencies = [];
        $districts = [];
        $villages = [];

        if ($user->province_id) {
            $regencies = Regency::where('province_id', $user->province_id)->get();
        }

        if ($user->regency_id) {
            $districts = District::where('regency_id', $user->regency_id)->get();
        }

        if ($user->district_id) {
            $villages = Village::where('district_id', $user->district_id)->get();
        }

        $source = $request->query('source', 'users.index'); // Ambil source dari URL atau default ke users.index

        return view('users.edit', compact('user', 'provinces', 'regencies', 'districts', 'villages', 'source'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'tanda_tangan' => 'nullable|string',
            'province_id' => 'nullable|exists:provinces,id',
            'regency_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
            'alamat' => 'nullable|string',
            'verify_email' => 'boolean',  // Ensure it's treated as boolean
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        if (Auth::user()->role_as == 1) {
            $rules['role_as'] = 'required|in:0,1,2';
        }

        $request->validate($rules);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'alamat' => $request->alamat,
        ];

        // Cast verify_email to boolean and handle verification status
        $verifyEmail = filter_var($request->verify_email, FILTER_VALIDATE_BOOLEAN);

        if ($verifyEmail) {
            $userData['email_verified_at'] = $user->email_verified_at ?? now();
        } else {
            $userData['email_verified_at'] = null;
        }

        if (Auth::user()->role_as == 1) {
            $userData['role_as'] = $request->role_as;
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->filled('tanda_tangan') && $request->tanda_tangan != $user->tanda_tangan) {
            try {
                $signatureData = $this->saveSignature($request->tanda_tangan, $user->tanda_tangan_path);
                $userData['tanda_tangan'] = $signatureData['base64'];
                $userData['tanda_tangan_path'] = $signatureData['path'];
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui tanda tangan: ' . $e->getMessage());
            }
        }

        $user->update($userData);

        // Redirect berdasarkan role yang sedang login (Auth)
        switch (Auth::user()->role_as) {
            case 1:
                $redirectRoute = 'users.index';
                break;
            case 2:
                $redirectRoute = 'teacher.dashboard';
                break;
            case 0:
            default:
                $redirectRoute = 'student.dashboard'; // atau route sesuai kebutuhan siswa
                break;
        }

        return redirect()->route($redirectRoute)->with('success', 'User berhasil diperbarui.');
    }

    public function show(User $user)
    {
        // Tambahkan data lokasi untuk tampilan detail
        $province = $user->province_id ? Province::find($user->province_id) : null;
        $regency = $user->regency_id ? Regency::find($user->regency_id) : null;
        $district = $user->district_id ? District::find($user->district_id) : null;
        $village = $user->village_id ? Village::find($user->village_id) : null;

        return view('users.show', compact('user', 'province', 'regency', 'district', 'village'));
    }

    /**
     * Simpan tanda tangan ke storage dan kembalikan path dan base64
     *
     * @param string $base64Data
     * @param string|null $previousSignaturePath
     * @return array
     * @throws \Exception
     */
    private function saveSignature($base64Data, $previousSignaturePath = null)
    {
        // Pastikan data base64 valid
        if (empty($base64Data)) {
            throw new \Exception('Data tanda tangan kosong');
        }

        // Pisahkan header dari data base64 jika ada
        $image_parts = explode(";base64,", $base64Data);
        $image_base64 = isset($image_parts[1]) ? $image_parts[1] : $base64Data;

        // Decode base64 menjadi binary
        $image = base64_decode($image_base64);
        if ($image === false) {
            throw new \Exception('Format tanda tangan tidak valid');
        }

        // Buat nama file unik
        $filename = 'signature_' . time() . '_' . Str::random(10) . '.png';
        $path = 'signatures_users/' . $filename;

        // Hapus file lama jika ada
        if ($previousSignaturePath) {
            Storage::disk('public')->delete($previousSignaturePath);
        }

        // Simpan file baru
        if (!Storage::disk('public')->put($path, $image)) {
            throw new \Exception('Gagal menyimpan file tanda tangan');
        }

        return [
            'path' => $path, // Path untuk penyimpanan file
            'base64' => $base64Data // Base64 untuk disimpan di database
        ];
    }

    /**
     * Mendapatkan URL gambar tanda tangan
     *
     * @param User $user
     * @return string|null
     */
    public function getSignatureUrl(User $user)
    {
        if ($user->tanda_tangan_path) {
            return asset('storage/' . $user->tanda_tangan_path);
        }

        return null;
    }

    public function destroy($id)
    {
        if (Auth::user()->role_as != 1) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk menghapus user.');
        }

        $user = User::findOrFail($id);

        // Cek jika user yang akan dihapus adalah admin
        if ($user->role_as == 1 && Auth::user()->id != $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus user admin lain.');
        }

        // Hapus file tanda tangan jika ada
        if ($user->tanda_tangan_path) {
            Storage::disk('public')->delete($user->tanda_tangan_path);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Get user detail data for modal
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetail($id)
    {
        $user = User::findOrFail($id);

        // Ambil data lokasi
        $province = $user->province_id ? Province::find($user->province_id) : null;
        $regency = $user->regency_id ? Regency::find($user->regency_id) : null;
        $district = $user->district_id ? District::find($user->district_id) : null;
        $village = $user->village_id ? Village::find($user->village_id) : null;

        // Tangani tanda tangan dengan beberapa opsi
        $signatureUrl = null;
        $signatureBase64 = null;

        // Opsi 1: Gunakan path file jika tersedia
        if ($user->tanda_tangan_path && Storage::disk('public')->exists($user->tanda_tangan_path)) {
            $signatureUrl = asset('storage/' . $user->tanda_tangan_path);
        }
        // Opsi 2: Gunakan data base64 langsung jika tersedia
        elseif ($user->tanda_tangan) {
            $signatureBase64 = $user->tanda_tangan;
        }

        return response()->json([
            'province' => $province ? $province->name : null,
            'regency' => $regency ? $regency->name : null,
            'district' => $district ? $district->name : null,
            'village' => $village ? $village->name : null,
            'alamat' => $user->alamat,
            'signature_url' => $signatureUrl,
            'signature_base64' => $signatureBase64,
            // Tambahkan debugging info
            'has_path' => !empty($user->tanda_tangan_path),
            'path' => $user->tanda_tangan_path,
            'file_exists' => !empty($user->tanda_tangan_path) ? Storage::disk('public')->exists($user->tanda_tangan_path) : false
        ]);
    }
}
