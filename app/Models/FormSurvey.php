<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSurvey extends Model
{
    use HasFactory;

    protected $table = 'tbl_form_survey';
    protected $primaryKey = 'id_form_survey';
    public $timestamps = true;

    protected $fillable = [
        'id_form_pendaftaran',
        'id_pendataan_surveyor_siswa',
        'rata2_tpa',
        'max_tpa',
        'min_tpa',
        'rata2_tes_alquran',
        'max_alquran',
        'min_alquran',
        'income_form_ayah',
        'income_interview_ayah',
        'income_survey_ayah',
        'income_form_ibu',
        'income_interview_ibu',
        'income_survey_ibu',
        'status_rumah',
        'biaya_perbulan',
        'luas_bangunan',
        'luas_tanah',
        'fasilitas_ruang_tamu',
        'fasilitas_ruang_keluarga',
        'fasilitas_kamar_tidur',
        'besar_listrik',
        'biaya_listrik',
        'biaya_hidup_perbulan',
        'saran_rekomendasi',
        'tanggal_survey',
        'nama_lengkap_keluarga',
        'jenis_kelamin',
        'usia',
        'pendidikan',
        'kelas',
        'pekerjaan',
        'hubungan',
        'harta_milik_keluarga' ,
        'tanggungan_hutang' ,
        'alasan_pendukung' ,
        'alasan_memberatkan',
    ];

    protected $casts = [
        'nama_lengkap_keluarga' => 'array',
        'jenis_kelamin' => 'array',
        'usia' => 'array',
        'pendidikan' => 'array',
        'kelas' => 'array',
        'pekerjaan' => 'array',
        'hubungan' => 'array',
        'harta_milik_keluarga'  => 'array',
        'tanggungan_hutang'  => 'array',
        'alasan_pendukung'  => 'array',
        'alasan_memberatkan' => 'array',
    ];

    public function formInterview()
    {
        return $this->belongsTo(FormInterview::class, 'id_form_interview', 'id_form_interview');
    }

    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function registrasiPengambilan()
    {
        return $this->hasOne(RegistrasiPengambilan::class, 'id_registrasi_pengambilan', 'id_registrasi_pengambilan');
    }

    public function pendataanSurveyor()
    {
        return $this->belongsTo(PendataanSurveyorSiswa::class, 'id_pendataan_surveyor_siswa');
    }

        public function pendataanSurveyorSiswa()
    {
        return $this->belongsTo(PendataanSurveyorSiswa::class, 'id_pendataan_surveyor_siswa', 'id_pendataan_surveyor_siswa');
    }

    public function pendataanTpaBhq()
    {
        return $this->belongsTo(PendataanTpaBhq::class, 'id_pendataan_tpa_bhq', 'id_pendataan_tpa_bhq');
    }
}
