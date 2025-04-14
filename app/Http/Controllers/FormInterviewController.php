<?php

namespace App\Http\Controllers;

use App\Models\DataKelengkapan;
use App\Models\PendataanSurveyorSiswa;
use Illuminate\Http\Request;
use App\Models\FormInterview;
use App\Models\FormPendaftaran;
use App\Models\User;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class FormInterviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $id_periode = $request->input('id_periode');
        $user = Auth::user();

        $query = FormInterview::with(['formPendaftaran.registrasiPengambilan.periode', 'pendataanSurveyor.user'])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('formPendaftaran', function ($q) use ($search) {
                    $q->where('nisn', 'like', '%' . $search . '%')
                      ->orWhereHas('registrasiPengambilan', function ($q2) use ($search) {
                          $q2->where('nama', 'like', '%' . $search . '%');
                      });
                });
            })
            ->when($id_periode, function ($query) use ($id_periode) {
                return $query->whereHas('pendataanSurveyor', function ($q) use ($id_periode) {
                    $q->where('id_periode', $id_periode);
                });
            });

        // Jika role_as = 2 (crew), tampilkan hanya data milik user login
        if ($user->role_as == '2') {
            $query->whereHas('pendataanSurveyor', function ($q) use ($user) {
                $q->where('id_user', $user->id);
            });
        }

        $interviews = $query->orderBy('created_at', 'desc')->paginate(10);

        $periodes = Periode::all();

        // Hitung jumlah siswa berdasarkan status interview
        $totalLulus = FormInterview::where('status_interview', 'sudah')->count();
        $totalTidakLulus = FormInterview::where('status_interview', 'belum')->count();
        $totalKeseluruhan = $totalLulus + $totalTidakLulus;

        return view('form_interview.index', compact('interviews', 'periodes', 'totalLulus', 'totalTidakLulus', 'id_periode', 'totalKeseluruhan'));
    }


    public function create($id_pendataan_surveyor_siswa)
    {
        // Ambil data pendataan beserta user terkait
        $pendataan = PendataanSurveyorSiswa::with('user')->findOrFail($id_pendataan_surveyor_siswa);

        // Ambil data form pendaftaran terkait
        $formPendaftaran = FormPendaftaran::where('id_form_pendaftaran', $pendataan->id_form_pendaftaran)->first();

        return view('form_interview.create', compact('pendataan', 'formPendaftaran'));
    }

    public function store(Request $request)
    {
        // Array field yang perlu di-encode
        $arrayFields = [
            'prestasi_yang_dicapai',
            'rencana_pilihan_sekolah',
            'alasan_pilihan_sekolah',
            'nama_lengkap_keluarga',
            'jenis_kelamin',
            'usia',
            'pendidikan',
            'kelas',
            'pekerjaan',
            'hubungan',
            'ciri_ciri_rumah',
            'media_sosial',
            'transportasi_yg_dimiliki',
            'harta_milik_keluarga'
        ];

        // Validasi input
        $validated = $request->validate([
            'id_pendataan_surveyor_siswa' => 'required|exists:tbl_pendataan_surveyor_siswa,id_pendataan_surveyor_siswa',
            'id' => 'nullable|exists:users,id',
            'id_form_pendaftaran' => 'required|exists:tbl_pendataan_surveyor_siswa,id_form_pendaftaran',

            'nama_panggilan' => 'nullable|string|max:25',
            'jumlah_saudara_kandung' => 'nullable|string|max:2',
            'jumlah_saudara_tiri' => 'nullable|string|max:2',
            'jumlah_saudara_angkat' => 'nullable|string|max:2',
            'cita_cita' => 'nullable|string|max:100',
            'alasan_cita_cita' => 'nullable|string',
            'usaha_yang_dilakukan' => 'nullable|string',
            'motto' => 'nullable|string|max:150',
            'kekurangan' => 'nullable',
            'kelebihan' => 'nullable',
            'organisasi_sekolah' => 'nullable|string|max:50',
            'organisasi_masyarakat' => 'nullable|string|max:50',
            'hobi' => 'nullable',
            'nilai_komunikasi' => 'nullable|in:baik,cukup,kurang',
            'nilai_kepercayaan_diri' => 'nullable|in:baik,cukup,kurang',
            'uang_saku' => 'nullable|string',
            'kemampuan_bermotor' => 'nullable|in:bisa,tidak_bisa',

            'prestasi_yang_dicapai' => 'nullable|array',
            'mata_pelajaran' => 'nullable|in:Matematika,Bahasa_Indonesia,Bahasa_Inggris,IPA,IPS,PKN,Seni_Budaya,Olahraga,Agama,Tidak_ada',
            'rencana_pilihan_sekolah' => 'nullable|array',
            'alasan_pilihan_sekolah' => 'nullable|array',
            'kenalan_yang_diterima_di_smki' => 'nullable|string|max:100',
            'historis_sakit' => 'nullable|string|max:2',
            'historis_ijin' => 'nullable|string|max:2',
            'historis_alfa' => 'nullable|string|max:2',
            'catatan_kasus_pelanggaran' => 'nullable|string|max:100',
            'bhq' => 'nullable|in:lancar,terbata_bata,tidak_bisa',
            'hafalan_juz' => 'nullable|string|max:2',

            'merokok_narkoba' => 'nullable|string|max:50',
            'jenis_merek_harga' => 'nullable|string|max:100',
            'anggota_keluarga_yg_merokok' => 'nullable|string|max:100',
            'riwayat_kesehatan' => 'nullable|string|max:100',
            'terpapar_pornografi' => 'nullable|in:melihat_gambar,menonton_video,menyebarluaskan,tidak_terpapar',
            'media_sosial' => 'nullable|array',
            'ketertarikan_dengan_lawan_jenis' => 'nullable|in:tidak_pacaran,pacaran,pernah_pacaran',

            'nama_lengkap_keluarga' => 'nullable|array',
            'jenis_kelamin' => 'nullable|array',
            'usia' => 'nullable|array',
            'pendidikan' => 'nullable|array',
            'kelas' => 'nullable|array',
            'pekerjaan' => 'nullable|array',
            'hubungan' => 'nullable|array',

            'siswa_tinggal_bersama' => 'nullable|string|max:35',
            'status_pernikahan_ortu' => 'nullable|string|max:35',
            'status_rumah' => 'nullable|string|max:35',
            'harga_kontrak' => 'nullable|max:100',
            'daya_listrik' => 'nullable|string|max:5',
            'biaya_listrik' => 'nullable|max:100',
            'transportasi_yg_dimiliki' => 'nullable|array',
            'harta_milik_keluarga' => 'nullable|array',
            'berat_kalung_gr' => 'nullable|string|max:5',
            'berat_cincin_gr' => 'nullable|string|max:5',
            'berat_gelang_gr' => 'nullable|string|max:5',
            'berat_anting_gr' => 'nullable|string|max:5',
            'tanggungan_kredit' => 'nullable|string|max:30',
            'pendapat' => 'nullable|string',

            'nama' => 'nullable|string|max:75',
            'hubungan_dgn_siswa' => 'nullable|string|max:50',
            'alamat_kontak_darurat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'no_hp' => 'nullable|string|max:15',

            'kesimpulan' => 'nullable|string',

            'denah_lokasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10048',
            'nama_lengkap' => 'nullable|string|max:75',
            'nama_panggilan_di_lingkungan' => 'nullable|string|max:20',
            'ciri_ciri_rumah' => 'nullable|array',
            'tanggal_pengisian' => 'nullable|date',
            'status_interview' => 'nullable|in:sudah,belum'
        ]);

        // JSON encode semua field array
        foreach ($arrayFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        // Khusus untuk mata pelajaran (bila perlu)
        if (is_array($request->mata_pelajaran)) {
            $validated['mata_pelajaran'] = implode(',', $request->mata_pelajaran);
        }

        // Simpan file denah_lokasi ke storage
        if ($request->hasFile('denah_lokasi')) {
            $file = $request->file('denah_lokasi');
            $filePath = $file->store('denah_lokasi', 'public');
            $validated['denah_lokasi'] = $filePath;
        }

        // Simpan data ke dalam database
        FormInterview::create($validated);

        // Ambil id_user berdasarkan id_pendataan_surveyor_siswa
        $surveyor = PendataanSurveyorSiswa::find($request->id_pendataan_surveyor_siswa);

        if (!$surveyor) {
            return redirect()->back()->with('error', 'Data surveyor tidak ditemukan.');
        }

        $user = auth()->user();
        if ($user->role_as == '1') {
            // Admin akan diarahkan ke show
            return redirect()->route('pendataan-surveyor-siswa.show', $surveyor->id_user)
                ->with('success', 'Interview berhasil disimpan!');
        } else {
            // Surveyor akan diarahkan ke index (surveyor-index)
            return redirect()->route('pendataan-surveyor-siswa.index')
                ->with('success', 'Interview berhasil disimpan!');
        }
    }


    public function getFormPendaftaran($id)
{
    $formPendaftaran = FormPendaftaran::where('id_form_pendaftaran', $id)->first();

    if ($formPendaftaran) {
        return response()->json($formPendaftaran);
    }

    return response()->json(['message' => 'Data tidak ditemukan'], 404);
}

    public function show($id)
    {
        $interview = FormInterview::findOrFail($id);
        return view('form_interview.show', compact('interview'));
    }

    public function edit($id)
    {
        $interview = FormInterview::findOrFail($id);
        $formPendaftarans = FormPendaftaran::all(); // Pastikan model ini benar
        $selectedSiswa = FormPendaftaran::find($interview->id_form_pendaftaran);
        $pendataan = PendataanSurveyorSiswa::all();

        return view('form_interview.edit', compact('pendataan', 'interview', 'formPendaftarans', 'selectedSiswa'));
    }

    public function update(Request $request, $id)
    {
        $formInterview = FormInterview::findOrFail($id);

        $arrayFields = [
            'prestasi_yang_dicapai',
            'rencana_pilihan_sekolah',
            'alasan_pilihan_sekolah',
            'nama_lengkap_keluarga',
            'jenis_kelamin',
            'usia',
            'pendidikan',
            'kelas',
            'pekerjaan',
            'hubungan',
            'ciri_ciri_rumah',
            'media_sosial',
            'transportasi_yg_dimiliki',
            'harta_milik_keluarga'
        ];

        $validated = $request->validate([
            'id_pendataan_surveyor_siswa' => 'required|exists:tbl_pendataan_surveyor_siswa,id_pendataan_surveyor_siswa',
            'id' => 'nullable|exists:users,id',
            'id_form_pendaftaran' => 'required|exists:tbl_pendataan_surveyor_siswa,id_form_pendaftaran',

            'nama_panggilan' => 'required|string|max:25',
            'jumlah_saudara_kandung' => 'nullable|string|max:2',
            'jumlah_saudara_tiri' => 'nullable|string|max:2',
            'jumlah_saudara_angkat' => 'nullable|string|max:2',
            'cita_cita' => 'required|string|max:100',
            'alasan_cita_cita' => 'required|string|max:25',
            'usaha_yang_dilakukan' => 'required',
            'motto' => 'required|string|max:150',
            'kekurangan' => 'required',
            'kelebihan' => 'required',
            'organisasi_sekolah' => 'required|string|max:50',
            'organisasi_masyarakat' => 'required|string|max:50',
            'hobi' => 'required',
            'nilai_komunikasi' => 'required|in:baik,cukup,kurang',
            'nilai_kepercayaan_diri' => 'required|in:baik,cukup,kurang',
            'uang_saku' => 'required|string',
            'kemampuan_bermotor' => 'required|in:bisa,tidak_bisa',
            'prestasi_yang_dicapai' => 'required|array',
            'mata_pelajaran' => 'required|in:Matematika,Bahasa_Indonesia,Bahasa_Inggris,IPA,IPS,PKN,Seni_Budaya,Olahraga,Agama,Tidak_ada',
            'rencana_pilihan_sekolah' => 'required|array',
            'alasan_pilihan_sekolah' => 'required|array',
            'kenalan_yang_diterima_di_smki' => 'required|string|max:100',
            'historis_sakit' => 'required|string|max:2',
            'historis_ijin' => 'required|string|max:2',
            'historis_alfa' => 'required|string|max:2',
            'catatan_kasus_pelanggaran' => 'required|string|max:100',
            'bhq' => 'required|in:lancar,terbata_bata,tidak_bisa',
            'hafalan_juz' => 'nullable|string|max:2',
            'merokok_narkoba' => 'required|string|max:50',
            'jenis_merek_harga' => 'required|string|max:100',
            'anggota_keluarga_yg_merokok' => 'required|string|max:100',
            'riwayat_kesehatan' => 'required|string|max:100',
            'terpapar_pornografi' => 'required|in:melihat_gambar,menonton_video,menyebarluaskan,tidak_terpapar',
            'media_sosial' => 'required|array',
            'ketertarikan_dengan_lawan_jenis' => 'required|in:tidak_pacaran,pacaran,pernah_pacaran',
            'siswa_tinggal_bersama' => 'required|string|max:35',
            'status_pernikahan_ortu' => 'required|string|max:35',
            'status_rumah' => 'required|string|max:35',
            'harga_kontrak' => 'nullable|max:100',
            'daya_listrik' => 'required|string|max:5',
            'biaya_listrik' => 'required|max:100',
            'denah_lokasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10048',
            'status_interview' => 'nullable|in:sudah,belum',
            'kesimpulan' => 'nullable|string',
        ]);

        foreach ($arrayFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        if (is_array($request->mata_pelajaran)) {
            $validated['mata_pelajaran'] = implode(',', $request->mata_pelajaran);
        }

        if ($request->hasFile('denah_lokasi')) {
            $file = $request->file('denah_lokasi');
            $filePath = $file->store('denah_lokasi', 'public');
            $validated['denah_lokasi'] = $filePath;
        }

        $formInterview->update($validated);

        return redirect()->route('form_interview.index')->with('success', 'Data berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $interview = FormInterview::findOrFail($id);

        $interview->delete();
        return redirect()->route('form_interview.index')->with('success', 'Data berhasil dihapus!');
    }

    public function downloadPdf($id)
    {
        set_time_limit(0);

        // Load form data dengan relasi yang dibutuhkan
        $interview = FormInterview::with([
            'users',
            'formPendaftaran.registrasiPengambilan.periode',
        ])->findOrFail($id);

        // Format tanggal
        $interview->tanggal_pengisian = Carbon::parse($interview->tanggal_pengisian)
            ->locale('id')
            ->isoFormat('D MMMM Y');

            $tandaTanganBase64 = null;
            $user = $interview->pendataanSurveyor->user ?? null;

            if ($user && !empty($user->tanda_tangan)) {
                $tandaTanganBase64 = $user->tanda_tangan;
            }


        // Path gambar untuk logo
        $data = [
            'interview' => $interview,
            'logo_path' => public_path('assets/img/illustrations/smki-utama.png'),
            'logo_ybm_path' => public_path('assets/img/illustrations/ybm-pln.png'),
            'tandaTanganBase64' => $tandaTanganBase64, // Kirim Base64 ke Blade
        ];

        // **🔹 Aktifkan opsi untuk gambar dalam DomPDF**
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        // Initialize DomPDF
        $pdf = new Dompdf($options);

        // Load view dengan data yang sudah diformat
        $html = view('form_interview.pdf', $data)->render();
        $pdf->loadHtml($html);

        // Set paper size
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Generate filename
        $filename = 'Formulir_Interview_' . ($interview->formPendaftaran->registrasiPengambilan->nama ?? 'Unknown') . '.pdf';

        // Stream PDF
        return $pdf->stream($filename);
    }


}
