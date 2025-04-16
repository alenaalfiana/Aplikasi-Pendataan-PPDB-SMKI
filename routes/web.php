<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IndoRegionController;
use App\Http\Controllers\FormPendaftaranController;
use App\Http\Controllers\FormSurveyController;
use App\Http\Controllers\FormInterviewController;
use App\Http\Controllers\RegistrasiPengambilanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PendataanSurveyorSiswaController;
use App\Models\FormPendaftaran;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PendataanTpaBhqController;
use App\Http\Controllers\LaporanPenerimaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Auth::routes(['register' => false]);

// Route untuk verifikasi email cuy
Auth::routes(['verify' => true]);

Route::post('/login-with-code', [LoginController::class, 'loginWithCode'])->name('login.with.code');

Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Pastikan view ini ada
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    $user = Auth::user();

    if (!$user) {
        return redirect('/login'); // Redirect ke login jika belum login
    }

    switch ($user->role_as) {
        case '1':
            return redirect('/admin-dashboard');
        case '2':
            return redirect('/teacher-dashboard');
        case '0':
        default:
            return redirect('/user-dashboard');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route forgot password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::group(['middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Menampilkan daftar user


Route::group(['middleware' => ['auth', 'isTeacher']], function () {

    Route::get('/teacher-dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {

    Route::resource('pendataan_tpa_bhq', PendataanTpaBhqController::class);

    Route::get('/laporan-penerimaan', [LaporanPenerimaanController::class, 'index'])->name('laporan-penerimaan.index');
    Route::get('/laporan-penerimaan/create', [LaporanPenerimaanController::class, 'create'])->name('laporan-penerimaan.create');
    Route::post('/laporan-penerimaan', [LaporanPenerimaanController::class, 'store'])->name('laporan-penerimaan.store');
    Route::get('/laporan-penerimaan/{laporanPenerimaan}', [LaporanPenerimaanController::class, 'show'])->name('laporan-penerimaan.show');
    Route::get('/laporan-penerimaan/{laporanPenerimaan}/edit', [LaporanPenerimaanController::class, 'edit'])->name('laporan-penerimaan.edit');
    Route::put('/laporan-penerimaan/{laporanPenerimaan}', [LaporanPenerimaanController::class, 'update'])->name('laporan-penerimaan.update');
    Route::delete('/laporan-penerimaan/{laporanPenerimaan}', [LaporanPenerimaanController::class, 'destroy'])->name('laporan-penerimaan.destroy');

    // Additional routes
    Route::get('/laporan-penerimaan/get-form-pendaftaran', [LaporanPenerimaanController::class, 'getFormPendaftaran'])->name('laporan-penerimaan.get-form-pendaftaran');
    Route::get('/laporan-penerimaan/{laporanPenerimaan}/download-ppt', [LaporanPenerimaanController::class, 'downloadPowerPoint'])->name('laporan-penerimaan.download-ppt');
    Route::get('/laporan-penerimaan/download/pdf', [LaporanPenerimaanController::class, 'downloadPdf'])->name('laporan-penerimaan.download');

    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::get('/periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::get('/periode/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
    Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

    Route::get('form_pendaftaran', [FormPendaftaranController::class, 'index'])->name('form_pendaftaran.index');
    Route::get('form_pendaftaran/create', [FormPendaftaranController::class, 'create'])->name('form_pendaftaran.create');
    Route::post('form_pendaftaran', [FormPendaftaranController::class, 'store'])->name('form_pendaftaran.store');
    Route::get('form_pendaftaran/{id}', [FormPendaftaranController::class, 'show'])->name('form_pendaftaran.show');
    Route::get('form_pendaftaran/{id}/edit', [FormPendaftaranController::class, 'edit'])->name('form_pendaftaran.edit');
    Route::put('form_pendaftaran/{id}', [FormPendaftaranController::class, 'update'])->name('form_pendaftaran.update');
    Route::delete('form_pendaftaran/{id}', [FormPendaftaranController::class, 'destroy'])->name('form_pendaftaran.destroy');
    Route::get('/form_pendaftaran/download/{id}', [FormPendaftaranController::class, 'downloadPdf'])->name('form_pendaftaran.download');

    Route::get('/registrasi_pengambilan', [RegistrasiPengambilanController::class, 'index'])->name('registrasi_pengambilan.index');
    Route::get('/registrasi_pengambilan/create', [RegistrasiPengambilanController::class, 'create'])->name('registrasi_pengambilan.create');
    Route::post('/registrasi_pengambilan', [RegistrasiPengambilanController::class, 'store'])->name('registrasi_pengambilan.store');
    Route::get('/registrasi_pengambilan/{id}', [RegistrasiPengambilanController::class, 'show'])->name('registrasi_pengambilan.show');
    Route::get('/registrasi_pengambilan/{id}/edit', [RegistrasiPengambilanController::class, 'edit'])->name('registrasi_pengambilan.edit');
    Route::put('/registrasi_pengambilan/{id}', [RegistrasiPengambilanController::class, 'update'])->name('registrasi_pengambilan.update');
    Route::delete('/registrasi_pengambilan/{id}', [RegistrasiPengambilanController::class, 'destroy'])->name('registrasi_pengambilan.destroy');
    Route::get('/registrasi_pengambilan/download/{id}', [RegistrasiPengambilanController::class, 'downloadPdf'])
        ->name('registrasi_pengambilan.download');
});

// Surveyor routes for viewing their assignments
Route::middleware(['auth', 'isTeacher'])->group(function () {
    Route::get('/surveyor/dashboard', [PendataanSurveyorSiswaController::class, 'surveyorDashboard'])
        ->name('surveyor.dashboard');

    // Allow surveyor to mark assignments as complete
    Route::patch('/surveyor/assignments/{id}/status', [PendataanSurveyorSiswaController::class, 'updateStatus'])
        ->name('surveyor.assignments.update-status');
});

// Rute untuk login dengan login_code
Route::get('/login/code', [LoginController::class, 'showLoginCodeForm'])->name('login.code');
Route::post('/login/code', [LoginController::class, 'loginWithCode']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('form_interview', [FormInterviewController::class, 'index'])->name('form_interview.index');
    Route::get('/form-interview/create/{id_pendataan_surveyor_siswa}', [FormInterviewController::class, 'create'])
        ->name('form_interview.create');
    Route::post('form_interview', [FormInterviewController::class, 'store'])->name('form_interview.store');
    Route::get('form_interview/{id}', [FormInterviewController::class, 'show'])->name('form_interview.show');
    Route::get('form_interview/{id}/edit', [FormInterviewController::class, 'edit'])->name('form_interview.edit');
    Route::put('form_interview/{id}', [FormInterviewController::class, 'update'])->name('form_interview.update');
    Route::delete('form_interview/{id}', [FormInterviewController::class, 'destroy'])->name('form_interview.destroy');
    Route::get('/form_interview/download/{id}', [FormInterviewController::class, 'downloadPdf'])->name('form_interview.download');
    Route::get('/get-family-dependents/{id_pendataan_surveyor_siswa}', [FormInterviewController::class, 'getFamilyDependents']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}/detail', [UserController::class, 'getDetail'])->name('users.detail');

    // Tambahkan route berikut di routes/api.php
    Route::get('/form-pendaftaran/{id}', 'API\FormPendaftaranController@show');
    Route::get('/form-pendaftaran/{id}', [FormInterviewController::class, 'getFormPendaftaran'])->name('form-pendaftaran.get');
    Route::get('/get-tanggungan-keluarga/{id}', [FormSurveyController::class, 'getTanggunganKeluarga']);

    Route::resource('pendataan-surveyor-siswa', PendataanSurveyorSiswaController::class);
    Route::get('/surveyors-by-region', [PendataanSurveyorSiswaController::class, 'getSurveyorsByRegion']);
    Route::get('/students-by-region', [PendataanSurveyorSiswaController::class, 'getStudentsByRegion']);
    Route::get('/get-surveyor-details/{id_pendataan_surveyor_siswa}', [PendataanSurveyorSiswaController::class, 'getSurveyorDetails']);
    Route::get('/get-available-students', [PendataanSurveyorSiswaController::class, 'getAllStudents']);

    Route::get('/regencies/{province_id}', [PendataanSurveyorSiswaController::class, 'getRegencies']);
    Route::get('/districts/{regency_id}', [PendataanSurveyorSiswaController::class, 'getDistricts']);
    Route::get('/villages/{district_id}', [PendataanSurveyorSiswaController::class, 'getVillages']);

    Route::get('form_survey', [FormSurveyController::class, 'index'])->name('form_survey.index');
    Route::get('/form-survey/create/{id_pendataan_surveyor_siswa}', [FormSurveyController::class, 'create'])
        ->name('form_survey.create');
    Route::post('form_survey', [FormSurveyController::class, 'store'])->name('form_survey.store');
    Route::get('form_survey/{id}', [FormSurveyController::class, 'show'])->name('form_survey.show');
    Route::get('form_survey/{id}/edit', [FormSurveyController::class, 'edit'])->name('form_survey.edit');
    Route::put('form_survey/{id}', [FormSurveyController::class, 'update'])->name('form_survey.update');
    Route::delete('form_survey/{id}', [FormSurveyController::class, 'destroy'])->name('form_survey.destroy');
    Route::get('/form_survey/download/{id}', [FormSurveyController::class, 'downloadPdf'])->name('form_survey.download');
});

Route::get('/get-siswa/{id}', function ($id) {
    $siswa = FormPendaftaran::find($id);
    return response()->json($siswa);
});

Route::get('/provinces', [IndoRegionController::class, 'provinces']);
Route::get('/regencies/{province}', [IndoRegionController::class, 'regencies']);
Route::get('/districts/{regency}', [IndoRegionController::class, 'districts']);
Route::get('/villages/{district}', [IndoRegionController::class, 'villages']);
Route::get('/villages/{district}', [PendataanSurveyorSiswaController::class, 'getVillages']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
