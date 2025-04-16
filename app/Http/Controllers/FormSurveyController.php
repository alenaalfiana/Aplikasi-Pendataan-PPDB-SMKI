<?php

namespace App\Http\Controllers;

use App\Models\FormInterview;
use App\Models\FormSurvey;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FormPendaftaran;
use App\Models\PendataanSurveyorSiswa;
use App\Models\Periode;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class FormSurveyController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        $search = $request->input('search');
        $id_periode = $request->input('id_periode');
        $user = Auth::user();

        $surveys = FormSurvey::with(['formPendaftaran.registrasiPengambilan.periode', 'pendataanSurveyor.user'])
            ->when($user->role_as == '2', function ($query) use ($user) {
                $query->whereHas('pendataanSurveyor', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                });
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('formPendaftaran', function ($q) use ($search) {
                    $q->where('nisn', 'like', '%' . $search . '%')
                        ->orWhereHas('registrasiPengambilan', function ($q2) use ($search) {
                            $q2->where('nama', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($id_periode, function ($query) use ($id_periode) {
                return $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($id_periode) {
                    $q->where('id_periode', $id_periode);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $periodes = Periode::all();

        // Hitung jumlah rekap berdasarkan role juga
        if ($user->role_as == '2') {
            // Jika crew, hitung hanya data mereka
            $totalLulus = FormSurvey::where('saran_rekomendasi', 'Diterima')
                ->whereHas('pendataanSurveyor', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                })->count();

            $totalTidakLulus = FormSurvey::where('saran_rekomendasi', 'Ditolak')
                ->whereHas('pendataanSurveyor', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                })->count();

            $totalAbuAbu = FormSurvey::where('saran_rekomendasi', 'Abu-abu')
                ->whereHas('pendataanSurveyor', function ($q) use ($user) {
                    $q->where('id_user', $user->id);
                })->count();
        } else {
            // Jika admin, hitung semua data
            $totalLulus = FormSurvey::where('saran_rekomendasi', 'Diterima')->count();
            $totalTidakLulus = FormSurvey::where('saran_rekomendasi', 'Ditolak')->count();
            $totalAbuAbu = FormSurvey::where('saran_rekomendasi', 'Abu-abu')->count();
        }

        $totalKeseluruhan = $totalLulus + $totalTidakLulus + $totalAbuAbu;

        return view('form_survey.index', compact('surveys', 'periodes', 'totalLulus', 'totalTidakLulus', 'totalAbuAbu', 'totalKeseluruhan'));
    }

    public function create($id_pendataan_surveyor_siswa)
    {
        // Ambil data pendataan beserta user terkait
        $pendataan = PendataanSurveyorSiswa::with('user')->findOrFail($id_pendataan_surveyor_siswa);

        // Ambil data form pendaftaran terkait
        $formPendaftaran = FormPendaftaran::where('id_form_pendaftaran', $pendataan->id_form_pendaftaran)->first();

        // Ambil data form interview jika ada
        $formInterview = FormInterview::where('id_form_pendaftaran', $pendataan->id_form_pendaftaran)->first();

        return view('form_survey.create', compact('pendataan', 'formPendaftaran', 'formInterview'));
    }

    public function store(Request $request)
    {
        $arrayFields = [
            'nama_lengkap_keluarga',
            'jenis_kelamin',
            'usia',
            'pendidikan',
            'kelas',
            'pekerjaan',
            'hubungan',
            'harta_milik_keluarga',
            'tanggungan_hutang',
            'alasan_pendukung',
            'alasan_memberatkan',
        ];

        $validated = $request->validate([
            'id_pendataan_surveyor_siswa' => 'required|exists:tbl_pendataan_surveyor_siswa,id_pendataan_surveyor_siswa',
            'id_form_pendaftaran' => 'required|exists:tbl_pendataan_surveyor_siswa,id_form_pendaftaran',

            'rata2_tpa' => 'nullable|string|max:5',
            'max_tpa' => 'nullable|string|max:5',
            'min_tpa' => 'nullable|string|max:5',
            'rata2_tes_alquran' => 'nullable|string|max:5',
            'max_alquran' => 'nullable|string|max:5',
            'min_alquran' => 'nullable|string|max:5',
            'income_form_ayah' => 'required|string|max:10',
            'income_interview_ayah' => 'required|string|max:10',
            'income_survey_ayah' => 'required|string|max:10',
            'income_form_ibu' => 'required|string|max:10',
            'income_interview_ibu' => 'required|string|max:10',
            'income_survey_ibu' => 'required|string|max:10',
            'status_rumah' => 'nullable|in:Sendiri,Kontrak,Menumpang',
            'biaya_perbulan' => 'nullable|string|max:12',
            'luas_bangunan' => 'nullable|string|max:10',
            'luas_tanah' => 'nullable|string|max:10',
            'fasilitas_ruang_tamu' => 'nullable|string|max:2',
            'fasilitas_ruang_keluarga' => 'nullable|string|max:2',
            'fasilitas_kamar_tidur' => 'nullable|string|max:2',
            'besar_listrik' => 'nullable|string|max:12',
            'biaya_listrik' => 'nullable|string|max:12',
            'biaya_hidup_perbulan' => 'nullable|string|max:12',
            'saran_rekomendasi' => 'nullable|in:Diterima,Ditolak,Abu-abu',
            'tanggal_survey' => 'nullable|date',
            'nama_lengkap_keluarga' => 'nullable|array',
            'jenis_kelamin' => 'nullable|array',
            'usia' => 'nullable|array',
            'pendidikan' => 'nullable|array',
            'kelas' => 'nullable|array',
            'pekerjaan' => 'nullable|array',
            'hubungan' => 'nullable|array',
            'harta_milik_keluarga' => 'nullable|array',
            'tanggungan_hutang' => 'nullable|array',
            'alasan_pendukung' => 'nullable|array',
            'alasan_memberatkan' => 'nullable|array',
        ]);

        // JSON encode semua field array
        foreach ($arrayFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        // Simpan data ke dalam database
        FormSurvey::create($validated);

        // Ambil id_user berdasarkan id_pendataan_surveyor_siswa
        $surveyor = PendataanSurveyorSiswa::find($request->id_pendataan_surveyor_siswa);

        if (!$surveyor) {
            return redirect()->back()->with('error', 'Data surveyor tidak ditemukan.');
        }

        $user = auth()->user();
        if ($user->role_as == '1') {
            // Admin akan diarahkan ke show
            return redirect()->route('pendataan-surveyor-siswa.show', $surveyor->id_user)
                ->with('success', 'Survey berhasil disimpan!');
        } else {
            // Surveyor akan diarahkan ke index (surveyor-index)
            return redirect()->route('pendataan-surveyor-siswa.index')
                ->with('success', 'Survey berhasil disimpan!');
        }
    }

    public function getFormSurvey($id)
{
    $FormSurvey = FormSurvey::where('id_form_interview', $id)->first();

    if ($FormSurvey) {
        return response()->json($FormSurvey);
    }

    return response()->json(['message' => 'Data tidak ditemukan'], 404);
}

    public function show($id)
    {
        $formSurvey = FormSurvey::with(['pendataanTpaBhq'])->findOrFail($id);
        return view('form_survey.show', compact('formSurvey'));
    }

    public function edit($id)
    {
        $survey = FormSurvey::findOrFail($id);
        $formPendaftarans = FormPendaftaran::all(); // Pastikan model ini benar
        $selectedSiswa = FormPendaftaran::find($survey->id_form_pendaftaran);
        $pendataan = PendataanSurveyorSiswa::all();

        return view('form_survey.edit', compact('pendataan', 'survey', 'formPendaftarans', 'selectedSiswa'));
    }


    public function update(Request $request, $id)
    {
        $arrayFields = [
            'nama_lengkap_keluarga',
            'jenis_kelamin',
            'usia',
            'pendidikan',
            'kelas',
            'pekerjaan',
            'hubungan',
            'harta_milik_keluarga',
            'tanggungan_hutang',
            'alasan_pendukung',
            'alasan_memberatkan',
        ];

        $validated = $request->validate([
            'id_pendataan_surveyor_siswa' => 'required|exists:tbl_pendataan_surveyor_siswa,id_pendataan_surveyor_siswa',
	        'id_form_pendaftaran' => 'required|exists:tbl_pendataan_surveyor_siswa,id_form_pendaftaran',

            'rata2_tpa' => 'nullable|string|max:5',
            'max_tpa' => 'nullable|string|max:5',
            'min_tpa' => 'nullable|string|max:5',
            'rata2_tes_alquran' => 'nullable|string|max:5',
            'max_alquran' => 'nullable|string|max:5',
            'min_alquran' => 'nullable|string|max:5',
            'income_form_ayah' => 'required|string|max:10',
            'income_interview_ayah' => 'required|string|max:10',
            'income_survey_ayah' => 'required|string|max:10',
            'income_form_ibu' => 'required|string|max:10',
            'income_interview_ibu' => 'required|string|max:10',
            'income_survey_ibu' => 'required|string|max:10',
            'status_rumah' => 'nullable|in:Sendiri,Kontrak,Menumpang',
            'biaya_perbulan' => 'nullable|string|max:12',
            'luas_bangunan' => 'nullable|string|max:10',
            'luas_tanah' => 'nullable|string|max:10',
            'fasilitas_ruang_tamu' => 'nullable|string|max:2',
            'fasilitas_ruang_keluarga' => 'nullable|string|max:2',
            'fasilitas_kamar_tidur' => 'nullable|string|max:2',
            'besar_listrik' => 'nullable|string|max:12',
            'biaya_listrik' => 'nullable|string|max:12',
            'biaya_hidup_perbulan' => 'nullable|string|max:12',
            'saran_rekomendasi' => 'nullable|in:Diterima,Ditolak,Abu-abu',
            'tanggal_survey' => 'nullable|date',
            'nama_lengkap_keluarga' => 'nullable|array',
            'jenis_kelamin' => 'nullable|array',
            'usia' => 'nullable|array',
            'pendidikan' => 'nullable|array',
            'kelas' => 'nullable|array',
            'pekerjaan' => 'nullable|array',
            'hubungan' => 'nullable|array',
            'harta_milik_keluarga' => 'nullable|array',
            'tanggungan_hutang' => 'nullable|array',
            'alasan_pendukung' => 'nullable|array',
            'alasan_memberatkan' => 'nullable|array',
        ]);

        foreach ($arrayFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_encode($validated[$field]);
            }
        }

        $FormSurvey = FormSurvey::findOrFail($id);
        $FormSurvey->update($validated);

        return redirect()->route('form_survey.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $survey = FormSurvey::findOrFail($id);

        $survey->delete();
        return redirect()->route('form_survey.index')->with('success', 'Data berhasil dihapus!');
    }

    public function getTanggunganKeluarga($id)
{
    try {
        $formInterview = FormInterview::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'nama_lengkap_keluarga' => $formInterview->nama_lengkap_keluarga,
                'jenis_kelamin' => $formInterview->jenis_kelamin,
                'usia' => $formInterview->usia,
                'pendidikan' => $formInterview->pendidikan,
                'kelas' => $formInterview->kelas,
                'pekerjaan' => $formInterview->pekerjaan,
                'hubungan' => $formInterview->hubungan
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }
}

public function downloadPdf($id)
{
    try {
        // Load form data with all necessary relationships
        $survey = FormSurvey::with([
            'users',
            'formInterview',
            'formPendaftaran.registrasiPengambilan',
        ])->findOrFail($id);

        // Ensure formInterview exists
        if (!$survey->formInterview) {
            // Try to find FormInterview manually
            $formInterview = FormInterview::where('id_form_interview', $survey->id_form_interview)
                ->orWhere('id_form_pendaftaran', $survey->id_form_pendaftaran)
                ->first();

            if ($formInterview) {
                $survey->setRelation('formInterview', $formInterview);
            } else {
                // Create a dummy FormInterview to prevent null reference
                $formInterview = new FormInterview();
                $formInterview->historis_sakit = 'N/A';
                $formInterview->historis_ijin = 'N/A';
                $formInterview->historis_alfa = 'N/A';
                $survey->setRelation('formInterview', $formInterview);
            }
        }

        // Format tanggal
        $survey->tanggal_survey = Carbon::parse($survey->tanggal_survey)
            ->locale('id')
            ->isoFormat('D MMMM Y');

        // Path gambar
        $data = [
            'survey' => $survey,
            'logo_path' => public_path('assets/img/illustrations/smki-utama.png'),
            'logo_ybm_path' => public_path('assets/img/illustrations/ybm-pln.png'),
        ];

        // **🔹 Aktifkan opsi untuk gambar**
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial'); // Mengurangi beban font

        // Initialize DomPDF
        $pdf = new Dompdf($options);

        // Load view dengan data yang sudah diformat
        $html = view('form_survey.pdf', $data)->render();

        // Load HTML ke PDF
        $pdf->loadHtml($html);

        // Set paper size
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Generate filename with fallback
        $filename = 'Formulir_Survey_' . (
            optional($survey->formPendaftaran)->registrasiPengambilan->nama ??
            'Unknown'
        ) . '.pdf';

        // Stream PDF
        return $pdf->stream($filename);

    } catch (\Exception $e) {

        // Return a user-friendly error response
        return response()->view('errors.custom', [
            'message' => 'Unable to generate PDF. Please contact support.',
            'details' => $e->getMessage()
        ], 500);
    }
}
}
