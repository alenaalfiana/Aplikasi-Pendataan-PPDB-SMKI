<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\FormPendaftaran;
use App\Models\Periode;
use App\Models\RegistrasiPengambilan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class FormPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        $search = $request->input('search');
        $id_periode = $request->input('id_periode'); // Ambil nilai filter periode

        $pendaftarans = FormPendaftaran::with(['registrasiPengambilan.periode'])
            ->when($search, function ($query) use ($search) {
                return $query->where('nisn', 'like', '%' . $search . '%')
                             ->orWhereHas('registrasiPengambilan', function ($q) use ($search) {
                                 $q->where('nama', 'like', '%' . $search . '%');
                             });
            })
            ->when($id_periode, function ($query) use ($id_periode) {
                return $query->whereHas('registrasiPengambilan', function ($q) use ($id_periode) {
                    $q->where('id_periode', $id_periode);
                });
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan data terbaru
            ->paginate(10);

        // Ambil daftar periode untuk dropdown filter
        $periodes = Periode::all();
        $totalLakiLaki = FormPendaftaran::where('jenis_kelamin', 'laki-laki')->count();
        $totalPerempuan = FormPendaftaran::where('jenis_kelamin', 'perempuan')->count();

        return view('form_pendaftaran.index', compact('pendaftarans', 'totalLakiLaki', 'totalPerempuan', 'periodes', 'id_periode'));
    }


    public function create()
    {
        $provinces = Province::all();
        $pengambilans = RegistrasiPengambilan::all();
        $usedIds = FormPendaftaran::pluck('id_registrasi_pengambilan')->toArray();
        $registrasiPengambilans = RegistrasiPengambilan::whereNotIn('id_registrasi_pengambilan', $usedIds)
            ->select('id_registrasi_pengambilan', 'no_pendaftar', 'nama', 'jenis_kelamin', 'alamat_lengkap',
                     'nama_ayah', 'nama_ibu', 'nama_wali', 'asal_sekolah',
                     'province_id', 'regency_id', 'district_id', 'village_id')
            ->get();

        return view('form_pendaftaran.create', compact('provinces', 'pengambilans', 'registrasiPengambilans'));
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
        // Validasi input
        $validated = $request->validate([
            'id_registrasi_pengambilan' => 'required|exists:tbl_registrasi_pengambilan,id_registrasi_pengambilan',
            'nisn' => 'required|string|max:10',
            'ukuran_baju' => 'required|in:M,L,XL,XXL',
            'jenis_kelamin' => 'required|in:perempuan,laki-laki',
            'tempat_lahir' => 'required|string|max:25',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'anak_ke' => 'required|integer|min:1',
            'dari' => 'required|integer|min:1',
            'status_siswa' => 'required|in:yatim-piatu,yatim,piatu,orang-tua-lengkap',
            'bahasa_keseharian' => 'required|string|max:20',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'alamat_lengkap' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            'nama_ayah' => 'required|string|max:75',
            'usia_ayah' => 'required|integer|min:1|max:99',
            'pendidikan_ayah' => 'required|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_ayah' => 'required|string|max:30',
            'penghasilan_ayah' => 'required|string',
            'alamat_lengkap_ayah' => 'required|string',
            'no_telepon_ayah' => 'required|regex:/^[0-9]+$/|max:15',
            'nama_ibu' => 'required|string|max:75',
            'usia_ibu' => 'required|integer|min:1|max:99',
            'pendidikan_ibu' => 'required|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_ibu' => 'required|string|max:30',
            'penghasilan_ibu' => 'required|string',
            'alamat_lengkap_ibu' => 'required|string',
            'no_telepon_ibu' => 'required|regex:/^[0-9]+$/|max:15',
            'nama_wali' => 'nullable|string|max:75',
            'usia_wali' => 'nullable|integer|min:1|max:99',
            'pendidikan_wali' => 'nullable|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_wali' => 'nullable|string|max:30',
            'penghasilan_wali' => 'nullable|string',
            'alamat_lengkap_wali' => 'nullable|string',
            'no_telepon_wali' => 'nullable|regex:/^[0-9]+$/|max:15',

            'asal_sekolah' => 'required|string|max:55',
            'alamat_lengkap_sekolah' => 'required|string',
            'tahun_lulus' => 'required|string|max:4',

            'tanggal_mendaftar' => 'required|date',
            'tanda_tangan_siswa' => 'required|string',

            'akta_lahir' => 'required|in:ada,tidak_ada,menyusul',
            'kartu_keluarga' => 'required|in:ada,tidak_ada,menyusul',
            'pas_foto_3x4' => 'required|in:ada,tidak_ada,menyusul',
            'sktm_kelurahan' => 'required|in:ada,tidak_ada,menyusul',
            'kartu_kip' => 'required|in:ada,tidak_ada,menyusul',
            'raport_smp' => 'required|in:ada,tidak_ada,menyusul',
            'ijazah_legalisir' => 'required|in:ada,tidak_ada,menyusul',
            'ktp_ortu_wali' => 'required|in:ada,tidak_ada,menyusul',
            'tanggal_pengembalian' => 'nullable|date',
            'status' => 'required|in:lengkap,tidak_lengkap'
        ]);

        // Simpan pas foto
        if ($request->hasFile('pas_foto')) {
            $file = $request->file('pas_foto');
            $filename = time() . '_pas_foto.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pas_foto', $filename);
            $validated['pas_foto'] = 'pas_foto/' . $filename;
        }

        // Simpan tanda tangan
        if ($request->filled('tanda_tangan_siswa')) {
            try {
                $validated['tanda_tangan_siswa'] = $this->saveSignature($request->tanda_tangan_siswa);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan tanda tangan: ' . $e->getMessage());
            }
        }

        FormPendaftaran::create($validated);

        return redirect()->route('form_pendaftaran.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }


    public function show($id)
    {
        $pendaftaran = FormPendaftaran::findOrFail($id);
        return view('form_pendaftaran.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = FormPendaftaran::findOrFail($id);
        $pengambilans = RegistrasiPengambilan::all();
        $provinces = Province::all(); // Get all provinces from the database
        $registrasiPengambilans = RegistrasiPengambilan::select('id_registrasi_pengambilan', 'no_pendaftar', 'nama')->get();

        return view('form_pendaftaran.edit', compact('pendaftaran', 'pengambilans', 'provinces', 'registrasiPengambilans')); // Pass the provinces to the view
    }


    public function update(Request $request, $id)
    {
        $pendaftaran = FormPendaftaran::findOrFail($id);

        $validated = $request->validate([
            'id_registrasi_pengambilan'   => 'required',
            'nisn' => 'required|string|max:10',
            'ukuran_baju' => 'required|in:M,L,XL,XXL',
            'jenis_kelamin' => 'required|in:perempuan,laki-laki',
            'tempat_lahir' => 'required|string|max:25',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'anak_ke' => 'required|integer|min:1',
            'dari' => 'required|integer|min:1',
            'status_siswa' => 'required|in:yatim-piatu,yatim,piatu,orang-tua-lengkap',
            'bahasa_keseharian' => 'required|string|max:20',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'alamat_lengkap' => 'required|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'nama_ayah' => 'required|string|max:75',
            'usia_ayah' => 'required|string|max:2',
            'pendidikan_ayah' => 'required|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_ayah' => 'required|string|max:30',
            'penghasilan_ayah' => 'required|string',
            'alamat_lengkap_ayah' => 'required|string',
            'no_telepon_ayah' => 'required|string|max:15',
            'nama_ibu' => 'required|string|max:75',
            'usia_ibu' => 'required|string|max:2',
            'pendidikan_ibu' => 'required|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_ibu' => 'required|string|max:30',
            'penghasilan_ibu' => 'required|string',
            'alamat_lengkap_ibu' => 'required|string',
            'no_telepon_ibu' => 'required|string|max:15',
            'nama_wali' => 'nullable|string|max:75',
            'usia_wali' => 'nullable|string|max:2',
            'pendidikan_wali' => 'nullable|in:tidak-sekolah,SD/MI,SMP/MTs,SMA/MA,SMK,S1,S2,S3',
            'pekerjaan_wali' => 'nullable|string|max:30',
            'penghasilan_wali' => 'nullable|string',
            'alamat_lengkap_wali' => 'nullable|string',
            'no_telepon_wali' => 'nullable|string|max:15',

            'asal_sekolah' => 'required|string|max:55',
            'alamat_lengkap_sekolah' => 'required|string',
            'tahun_lulus' => 'required|string|max:4',

            'tanggal_mendaftar' => 'required|date',
            'tanda_tangan_siswa' => 'nullable|string',

            'akta_lahir' => 'required|in:ada,tidak_ada,menyusul',
            'kartu_keluarga' => 'required|in:ada,tidak_ada,menyusul',
            'pas_foto_3x4' => 'required|in:ada,tidak_ada,menyusul',
            'sktm_kelurahan' => 'required|in:ada,tidak_ada,menyusul',
            'kartu_kip' => 'required|in:ada,tidak_ada,menyusul',
            'raport_smp' => 'required|in:ada,tidak_ada,menyusul',
            'ijazah_legalisir' => 'required|in:ada,tidak_ada,menyusul',
            'ktp_ortu_wali' => 'required|in:ada,tidak_ada,menyusul',
            'tanggal_pengembalian' => 'nullable|date',
            'status' => 'required|in:lengkap,tidak_lengkap'
        ]);

        // Simpan pas foto baru jika ada
        if ($request->hasFile('pas_foto')) {
            if ($pendaftaran->pas_foto) {
                Storage::delete('public/' . $pendaftaran->pas_foto);
            }
            $file = $request->file('pas_foto');
            $filename = time() . '_pas_foto.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pas_foto', $filename);
            $validated['pas_foto'] = 'pas_foto/' . $filename;
        }

        // Update tanda tangan jika ada perubahan
        if ($request->filled('tanda_tangan_siswa') && $request->tanda_tangan_siswa != $pendaftaran->tanda_tangan_siswa) {
            try {
                $validated['tanda_tangan_siswa'] = $this->saveSignature(
                    $request->tanda_tangan_siswa,
                    $pendaftaran->tanda_tangan_siswa
                );
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui tanda tangan: ' . $e->getMessage());
            }
        }

        $pendaftaran->update($validated);

        return redirect()->route('form_pendaftaran.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pendaftaran = FormPendaftaran::findOrFail($id);

        // Hapus pas foto jika ada
        if ($pendaftaran->pas_foto) {
            Storage::disk('public')->delete($pendaftaran->pas_foto);
        }

        // Hapus data biodata pribadi
        $pendaftaran->delete();
        return redirect()->route('form_pendaftaran.index')->with('success', 'Data berhasil dihapus!');
    }

    private function saveSignature($base64Data, $previousSignature = null)
    {
        // Hapus header data URI jika ada
        $image_parts = explode(";base64,", $base64Data);
        $image_base64 = isset($image_parts[1]) ? $image_parts[1] : $base64Data;

        // Decode base64
        $image = base64_decode($image_base64);

        // Buat nama file unik
        $filename = 'signature_' . time() . '_' . uniqid() . '.png';
        $path = 'signatures/' . $filename;

        // Hapus tanda tangan lama jika ada
        if ($previousSignature) {
            Storage::disk('public')->delete($previousSignature);
        }

        // Simpan file
        Storage::disk('public')->put($path, $image);

        return $path;
    }

    public function downloadPdf($id)
    {
        // Load form data dengan semua relasi yang dibutuhkan
        $pendaftaran = FormPendaftaran::with([
            'province',
            'regency',
            'district',
            'village'
        ])->findOrFail($id);

        // Format tanggal mendaftar
        $pendaftaran->tanggal_mendaftar = Carbon::parse($pendaftaran->tanggal_mendaftar)
            ->locale('id_registrasi_pengambilan')
            ->isoFormat('D MMMM');

        // Format status siswa untuk display
        $pendaftaran->status_siswa_formatted = str_replace('-', ' ', ucwords($pendaftaran->status_siswa));

        // Format pendidikan untuk display
        $pendaftaran->ayah_pendidikan_formatted = str_replace('-', '/', ucwords($pendaftaran->pendidikan_ayah));
        $pendaftaran->ibu_pendidikan_formatted = str_replace('-', '/', ucwords($pendaftaran->pendidikan_ibu));
        $pendaftaran->wali_pendidikan_formatted = str_replace('-', '/', ucwords($pendaftaran->pendidikan_wali));

        // Set path untuk assets
        $data = [
            'pendaftaran' => $pendaftaran,
            'logo_path' => public_path('assets/img/illustrations/smki-utama.png'),
            'logo_ybm_path' => public_path('assets/img/illustrations/ybm-pln.png'),
        ];

        // Setup DomPDF options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Initialize DomPDF
        $pdf = new Dompdf($options);

        // Load view dengan data yang sudah diformat
        $html = view('form_pendaftaran.pdf', $data)->render();

        // Load HTML ke PDF
        $pdf->loadHtml($html);

        // Set paper size
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Generate filename
        $filename = 'Formulir_Pengembalian_' . $pendaftaran->registrasiPengambilan->no_pendaftar . '_' . $pendaftaran->registrasiPengambilan->nama . '.pdf';

        // Stream PDF
        return $pdf->stream($filename);
    }

}
