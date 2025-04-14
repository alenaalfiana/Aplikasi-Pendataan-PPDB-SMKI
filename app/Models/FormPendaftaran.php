<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'tbl_form_pendaftaran';
    protected $primaryKey = 'id_form_pendaftaran';
    protected $fillable = [
        'id_registrasi_pengambilan',
        'no_pendaftar',
        'nisn',
        'ukuran_baju',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'anak_ke',
        'dari',
        'status_siswa',
        'bahasa_keseharian',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'alamat_lengkap',
        'pas_foto',

        'nama_ayah',
        'usia_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'alamat_lengkap_ayah',
        'no_telepon_ayah',
        'nama_ibu',
        'usia_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'alamat_lengkap_ibu',
        'no_telepon_ibu',
        'nama_wali',
        'usia_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'alamat_lengkap_wali',
        'no_telepon_wali',

        'asal_sekolah',
        'alamat_lengkap_sekolah',
        'tahun_lulus',

        'tanggal_mendaftar',
        'tanda_tangan_siswa',

        'akta_lahir',
        'kartu_keluarga',
        'pas_foto_3x4',
        'sktm_kelurahan',
        'kartu_kip',
        'raport_smp',
        'ijazah_legalisir',
        'ktp_ortu_wali',
        'tanggal_pengembalian',
        'status'
    ];

    /**
     * Get the province associated with the biodata.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the regency associated with the biodata.
     */
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    /**
     * Get the district associated with the biodata.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the village associated with the biodata.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function registrasiPengambilan()
    {
        return $this->belongsTo(RegistrasiPengambilan::class, 'id_registrasi_pengambilan', 'id_registrasi_pengambilan');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    /**
     * Get the pendataan surveyor siswa associated with the form pendaftaran.
     */
    public function pendataanSurveyorSiswa()
    {
        return $this->hasMany(PendataanSurveyorSiswa::class, 'id_form_pendaftaran', 'id');
    }

    public function laporanPenerimaan()
    {
        return $this->hasOne(LaporanPenerimaan::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function formInterview()
    {
        return $this->hasOne(FormInterview::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function formSurvey()
    {
        return $this->hasOne(FormSurvey::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }
}
