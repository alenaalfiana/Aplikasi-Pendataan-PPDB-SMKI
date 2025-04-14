<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\RegistrasiPengambilan;
use App\Models\Periode;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RegistrasiPengambilanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $periodeId = $request->input('periode_id');

        $pengambilans = RegistrasiPengambilan::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('no_pendaftar', 'like', '%' . $search . '%')
                      ->orWhere('nama_ayah', 'like', '%' . $search . '%')
                      ->orWhere('nama_ibu', 'like', '%' . $search . '%')
                      ->orWhere('nama_wali', 'like', '%' . $search . '%');
                });
            })
            ->when($periodeId, function ($query) use ($periodeId) {
                return $query->where('id_periode', $periodeId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $periodes = Periode::all(); // Mengambil semua periode untuk dropdown
        $totalLakiLaki = RegistrasiPengambilan::where('jenis_kelamin', 'laki-laki')->count();
        $totalPerempuan = RegistrasiPengambilan::where('jenis_kelamin', 'perempuan')->count();

        return view('registrasi_pengambilan.index', compact('pengambilans', 'totalLakiLaki', 'totalPerempuan', 'periodes', 'periodeId'));
    }

    public function create()
    {
        $provinces = Province::all();
        $periodes = Periode::all();
        $lastEntry = RegistrasiPengambilan::latest('id_registrasi_pengambilan')->first();
        $lastNumber = $lastEntry ? intval($lastEntry->no_pendaftar) : 0;
        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return view('registrasi_pengambilan.create', compact('provinces', 'periodes', 'nextNumber'));
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
        $validated = $request->validate([
            'id_periode' => 'required|exists:tbl_periode,id_periode',
            'no_pendaftar' => 'required|string|max:10',
            'nama_pengambil' => 'required|string|max:75',
            'nama' => 'required|string|max:75',
            'jenis_kelamin' => 'required|in:perempuan,laki-laki',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'alamat_lengkap' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:55',
            'nama_ayah' => 'required|string|max:75',
            'nama_ibu' => 'required|string|max:75',
            'nama_wali' => 'nullable|string|max:75',
            'keterangan' => 'required|string',
            'foto_bukti_pengisian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_pengambilan' => 'required|date',
        ]);

        // Perbaikan penanganan foto
        if ($request->hasFile('foto_bukti_pengisian')) {
            $file = $request->file('foto_bukti_pengisian');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('public/foto_bukti', $filename);
            $validated['foto_bukti_pengisian'] = 'foto_bukti/' . $filename;
        }

        // Simpan data ke database dan ambil instance yang tersimpan
        $registrasi = RegistrasiPengambilan::create($validated);

        return redirect()->route('registrasi_pengambilan.index')
        ->with('success', "Data berhasil disimpan! Silahkan tulis kode <b>{$registrasi->no_pendaftar}</b> untuk <b>{$registrasi->nama}</b>");
    }


    public function show($id)
    {
        $pengambilan = RegistrasiPengambilan::with([
            'periode:id_periode,tahun_periode',
            'province:id,name',
            'regency:id,name',
            'district:id,name',
            'village:id,name'
        ])->find($id);

        $pengambilan->foto_bukti_pengisian = asset('storage/' . $pengambilan->foto_bukti_pengisian);
        return response()->json($pengambilan);
    }

    public function edit($id)
    {
        $pengambilan = RegistrasiPengambilan::findOrFail($id);
        $provinces = Province::all(); // Get all provinces from the database
        $periodes = Periode::all();

        return view('registrasi_pengambilan.edit', compact('pengambilan', 'provinces', 'periodes')); // Pass the provinces to the view
    }


    public function update(Request $request, $id)
    {
        $pengambilan = RegistrasiPengambilan::findOrFail($id);

        $validated = $request->validate([
            'id_periode' => 'required|exists:tbl_periode,id_periode',
            'no_pendaftar' => 'required|string|max:10',
            'nama_pengambil' => 'required|string|max:75',
            'nama' => 'required|string|max:75',
            'jenis_kelamin' => 'required|in:perempuan,laki-laki',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'alamat_lengkap' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:55',
            'nama_ayah' => 'required|string|max:75',
            'nama_ibu' => 'required|string|max:75',
            'nama_wali' => 'nullable|string|max:75',
            'keterangan' => 'required|string',
            'tanggal_pengambilan' => 'required|date',
        ]);

        // Update hanya kolom yang diperbolehkan
        $pengambilan->update($validated);

        return redirect()->route('registrasi_pengambilan.index')
            ->with('success', 'Data berhasil diperbarui!');
    }


public function destroy($id)
{
    $pengambilan = RegistrasiPengambilan::findOrFail($id);

    // Hapus foto jika ada
    if ($pengambilan->foto_bukti_pengisian) {
        Storage::delete('public/' . $pengambilan->foto_bukti_pengisian);
    }

    $pengambilan->delete();
    return redirect()->route('registrasi_pengambilan.index')
        ->with('success', 'Data berhasil dihapus!');
}

public function downloadPdf($id)
{
    $pengambilan = RegistrasiPengambilan::with([
        'periode', 'province', 'regency', 'district', 'village'
    ])->findOrFail($id);

    $data = [
        'pengambilan' => $pengambilan,
        'logo_path' => public_path('assets/img/illustrations/smki-utama.png'),
        'logo_ybm_path' => public_path('assets/img/illustrations/ybm-pln.png'),
    ];

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);

    $pdf = new Dompdf($options);
    $html = View::make('registrasi_pengambilan.pdf', $data)->render();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    $filename = 'Registrasi_Pendaftaran_' . $pengambilan->nama . '.pdf';

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, $filename);
}

}
