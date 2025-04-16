<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\PendataanSurveyorSiswa;
use App\Models\FormPendaftaran;
use App\Models\User;
use App\Models\Periode;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\FormInterview;
use App\Models\FormSurvey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\SurveyorAssignmentNotification;
use Illuminate\Support\Collection;

class PendataanSurveyorSiswaController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        // Jika user surveyor, tampilkan detail seperti show method
        if (auth()->user()->role_as == 2) {
            $firstRecord = PendataanSurveyorSiswa::with('user')->where('id_user', auth()->id())->first();

            if (!$firstRecord) {
                // Tampilkan view khusus jika surveyor belum mendapatkan tugas
                return view('pendataan-surveyor-siswa.no-assignment');
            }

            $students = PendataanSurveyorSiswa::with([
                'formPendaftaran.registrasiPengambilan',
                'formPendaftaran.village',
                'formPendaftaran.district',
                'formPendaftaran.regency',
                'formPendaftaran.province',
            ])->where('id_user', auth()->id())->get();

            foreach ($students as $student) {
                $idFormPendaftaran = $student->id_form_pendaftaran;

                $formInterview = FormInterview::where('id_form_pendaftaran', $idFormPendaftaran)->first();
                $formSurvey = FormSurvey::where('id_form_pendaftaran', $idFormPendaftaran)->first();

                // Assign ke properti agar bisa diakses di Blade
                $student->formInterview = $formInterview;
                $student->formSurvey = $formSurvey;

                // Hitung status otomatis tapi simpan di property baru (tidak disimpan ke database)
                $student->computed_status = ($formInterview && $formSurvey) ? 'Selesai' : 'Belum Selesai';
            }

            return view('pendataan-surveyor-siswa.surveyor-index', compact('firstRecord', 'students'));
        }

        // Existing code for role_as '1' remains unchanged
        $search = $request->input('search');
        $id_periode = $request->input('id_periode');

        // Get unique user IDs that match the filters
        $userIds = PendataanSurveyorSiswa::select('id_user')
            ->distinct()
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('nisn', 'like', '%' . $search . '%');
                });
            })
            ->when($id_periode, function ($query) use ($id_periode) {
                return $query->where('id_periode', $id_periode);
            })
            ->pluck('id_user');

        // Query builder for main data
        $query = PendataanSurveyorSiswa::with([
            'user',
            'formPendaftaran.registrasiPengambilan.periode',
            'formPendaftaran'
        ])
            ->whereIn('id_user', $userIds);

        // Paginate by distinct user_id
        $pendataanSurveyorSiswa = $query->orderBy('id_user')->paginate(10);
        $periodes = Periode::all();
        $provinces = Province::all();

        return view('pendataan-surveyor-siswa.index', compact('pendataanSurveyorSiswa', 'periodes', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Get surveyors (users with role_as = 2)
        $usedSurveyorIds = DB::table('tbl_pendataan_surveyor_siswa')->pluck('id_user');

        $surveyors = User::where('role_as', 2) // atau role surveyor sesuai strukturmu
            ->whereNotIn('id', $usedSurveyorIds)
            ->get();

        $provinces = Province::all();
        $periodes = Periode::all();

        return view('pendataan-surveyor-siswa.create', compact('surveyors', 'provinces', 'periodes'));
    }

    public function getRegencies($provinceId)
    {
        $regencies = Regency::where('province_id', $provinceId)->get();
        return response()->json($regencies);
    }

    public function getDistricts($regencyId)
    {
        $districts = District::where('regency_id', $regencyId)->get();
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_periode' => 'required|exists:tbl_periode,id_periode',
            'id_user' => 'required|exists:users,id',
            'id_form_pendaftaran' => 'required|array',
            'id_form_pendaftaran.*' => 'exists:tbl_form_pendaftaran,id_form_pendaftaran',
            'status' => 'required|in:selesai,belum_selesai', // Changed from Belum-selesai
        ]);

        // Create multiple records for each form pendaftaran
        foreach ($request->id_form_pendaftaran as $formId) {
            PendataanSurveyorSiswa::create([
                'id_periode' => $request->id_periode,
                'id_user' => $request->id_user,
                'id_form_pendaftaran' => $formId,
                'status' => $request->status,
            ]);
        }

        // Get the surveyor
        $surveyor = User::find($request->id_user);

        // Get the periode
        $periode = Periode::find($request->id_periode);

        // Get students data
        $studentsCollection = new Collection();
        foreach ($request->id_form_pendaftaran as $formId) {
            $student = FormPendaftaran::with('registrasiPengambilan')
                ->find($formId);
            $studentsCollection->push($student);
        }

        // Send email notification to the surveyor
        if ($surveyor && $surveyor->role_as == 2) {
            $surveyor->notify(new SurveyorAssignmentNotification($studentsCollection, $periode));
        }

        return redirect()->route('pendataan-surveyor-siswa.index')
            ->with('success', 'Data berhasil disimpan dan notifikasi telah dikirim ke surveyor');
    }

/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\View\View
 */
public function show($id): View
{
    $firstRecord = PendataanSurveyorSiswa::with('user')->where('id_user', $id)->first();

    if (!$firstRecord) {
        abort(404);
    }

    $students = PendataanSurveyorSiswa::with([
        'formPendaftaran.registrasiPengambilan',
        'formPendaftaran.village',
        'formPendaftaran.district',
        'formPendaftaran.regency',
        'formPendaftaran.province',
    ])->where('id_user', $id)->get();

    foreach ($students as $student) {
        $idFormPendaftaran = $student->id_form_pendaftaran;

        $formInterview = FormInterview::where('id_form_pendaftaran', $idFormPendaftaran)->first();
        $formSurvey = FormSurvey::where('id_form_pendaftaran', $idFormPendaftaran)->first();

        // Assign ke properti agar bisa diakses di Blade
        $student->formInterview = $formInterview;
        $student->formSurvey = $formSurvey;

        // Hitung status otomatis tapi simpan di property baru (tidak disimpan ke database)
        $student->status_form = ($formInterview && $formSurvey) ? 'Selesai' : 'Belum Selesai';
    }

    return view('pendataan-surveyor-siswa.show', compact('firstRecord', 'students'));
}


    public function getAllStudents()
    {
        $students = FormPendaftaran::with('registrasiPengambilan') // pastikan relasi benar
            ->get()
            ->map(function ($siswa) {
                return [
                    'id' => $siswa->id_form_pendaftaran,
                    'nama' => $siswa->registrasiPengambilan->nama ?? 'Tidak ada nama',
                    'nisn' => $siswa->nisn,
                    'asal_sekolah' => $siswa->asal_sekolah,
                ];
            });

        return response()->json($students);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
// In your controller's edit method
$firstRecord = PendataanSurveyorSiswa::where('id_periode', $id)
    ->latest('updated_at')  // Get the most recently updated record
    ->first();

        $pendataanRecords = PendataanSurveyorSiswa::where('id_periode', $firstRecord->id_periode)
            ->where('id_user', $firstRecord->id_user)
            ->get(); // Pastikan variabel ini ada

        $selectedFormIds = $pendataanRecords->pluck('id_form_pendaftaran')->toArray();

        $surveyors = User::where('role_as', 2)->get();
        $provinces = Province::all();
        $periodes = Periode::all();
        $pendataan = $pendataanRecords;

        $firstStudent = FormPendaftaran::find($firstRecord->id_form_pendaftaran);

        $regionDetails = null;
        $regionId = null;

        if ($firstStudent && $firstStudent->id_region) {
            $regionId = $firstStudent->id_region;
            $village = Village::find($regionId);

            if ($village) {
                $district = District::find($village->district_id);
                $regency = $district ? Regency::find($district->regency_id) : null;
                $province = $regency ? Province::find($regency->province_id) : null;

                $regionDetails = [
                    'province_id' => $province ? $province->id : null,
                    'regency_id' => $regency ? $regency->id : null,
                    'district_id' => $district ? $district->id : null,
                    'village_id' => $village->id
                ];
            }
        }

        return view('pendataan-surveyor-siswa.edit', compact(
            'pendataan',
            'pendataanRecords',
            'firstRecord',
            'selectedFormIds',
            'surveyors',
            'provinces',
            'periodes',
            'regionDetails',
            'regionId'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'id_periode' => 'required|exists:tbl_periode,id_periode',
            'id_user' => 'required|exists:users,id',
            'id_form_pendaftaran' => 'required|array',
            'id_form_pendaftaran.*' => 'exists:tbl_form_pendaftaran,id_form_pendaftaran',
            'status' => 'required|in:selesai,belum_selesai',
        ]);

        // Ambil data sebelumnya berdasarkan periode dan user
        $existingRecords = PendataanSurveyorSiswa::where('id_periode', $request->id_periode)
            ->where('id_user', $request->id_user)
            ->get();

        $existingFormIds = $existingRecords->pluck('id_form_pendaftaran')->toArray();
        $newFormIds = $request->id_form_pendaftaran;

        // Begin transaction for better data integrity
        DB::beginTransaction();

        try {
            // First update all existing records with new status
            PendataanSurveyorSiswa::where('id_periode', $request->id_periode)
                ->where('id_user', $request->id_user)
                ->update(['status' => $request->status]);

            // Handle additions
            foreach ($newFormIds as $formId) {
                if (!in_array($formId, $existingFormIds)) {
                    PendataanSurveyorSiswa::create([
                        'id_periode' => $request->id_periode,
                        'id_user' => $request->id_user,
                        'id_form_pendaftaran' => $formId,
                        'status' => $request->status,
                    ]);
                }
            }

            // Handle deletions
            foreach ($existingFormIds as $formId) {
                if (!in_array($formId, $newFormIds)) {
                    PendataanSurveyorSiswa::where('id_periode', $request->id_periode)
                        ->where('id_user', $request->id_user)
                        ->where('id_form_pendaftaran', $formId)
                        ->delete();
                }
            }

            DB::commit();

            // Kirim ulang notifikasi ke surveyor
            $surveyor = User::find($request->id_user);
            $periode = Periode::find($request->id_periode);

            $studentsCollection = new \Illuminate\Support\Collection();
            foreach ($request->id_form_pendaftaran as $formId) {
                $student = FormPendaftaran::with('registrasiPengambilan')->find($formId);
                $studentsCollection->push($student);
            }

            if ($surveyor && $surveyor->role_as == 2) {
                $surveyor->notify(new SurveyorAssignmentNotification($studentsCollection, $periode));
            }

            return redirect()->route('pendataan-surveyor-siswa.index')->with('success', 'Data berhasil diperbarui dan notifikasi telah dikirim ulang ke surveyor.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        // Delete all records for this surveyor
        PendataanSurveyorSiswa::where('id_user', $id)->delete();

        return redirect()->route('pendataan-surveyor-siswa.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function getSurveyorsByRegion(Request $request)
    {
        $surveyors = User::where('role_as', 2)
            ->where('province_id', $request->province_id)
            ->where('regency_id', $request->regency_id)
            ->where('district_id', $request->district_id)
            ->where('village_id', $request->village_id)
            ->get();

        return response()->json($surveyors);
    }

    public function getStudentsByRegion(Request $request)
    {
        $students = DB::table('tbl_form_pendaftaran')
            ->join('tbl_registrasi_pengambilan', 'tbl_form_pendaftaran.id_registrasi_pengambilan', '=', 'tbl_registrasi_pengambilan.id_registrasi_pengambilan')
            ->leftJoin('tbl_pendataan_surveyor_siswa', 'tbl_form_pendaftaran.id_form_pendaftaran', '=', 'tbl_pendataan_surveyor_siswa.id_form_pendaftaran')
            ->whereNull('tbl_pendataan_surveyor_siswa.id_form_pendaftaran') // hanya yang belum pernah dipakai
            ->where('tbl_form_pendaftaran.province_id', $request->province_id)
            ->where('tbl_form_pendaftaran.regency_id', $request->regency_id)
            ->where('tbl_form_pendaftaran.district_id', $request->district_id)
            ->where('tbl_form_pendaftaran.village_id', $request->village_id)
            ->where('tbl_form_pendaftaran.status', 'lengkap') // Fixed the syntax here
            ->select('tbl_form_pendaftaran.*', 'tbl_registrasi_pengambilan.nama') // Ambil nama dari tabel lain
            ->get();

        return response()->json($students);
    }


    public function getSurveyorDetails($id)
    {
        $surveyor = User::where('id', $id)
            ->where('role_as', 2)
            ->first();

        if (!$surveyor) {
            return response()->json(['error' => 'Surveyor not found'], 404);
        }

        return response()->json([
            'name' => $surveyor->name,
            'email' => $surveyor->email,
            'alamat' => $surveyor->alamat,
            'province_name' => $surveyor->province->name ?? null,
            'regency_name' => $surveyor->regency->name ?? null,
            'district_name' => $surveyor->district->name ?? null,
            'village_name' => $surveyor->village->name ?? null,
        ]);
    }
}
