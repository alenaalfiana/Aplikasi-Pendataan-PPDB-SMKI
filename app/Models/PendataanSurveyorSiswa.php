<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendataanSurveyorSiswa extends Model
{
    use HasFactory;

    protected $table = 'tbl_pendataan_surveyor_siswa';
    protected $primaryKey = 'id_pendataan_surveyor_siswa';
    protected $fillable = ['id_periode', 'id_user', 'id_form_pendaftaran', 'status'];

    /**
     * Get the user associated with the pendataan surveyor siswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Get the form pendaftaran associated with the pendataan surveyor siswa.
     */
    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

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

    public function registrasiPengambilan()
    {
        return $this->hasOne(RegistrasiPengambilan::class, 'id_registrasi_pengambilan', 'id_registrasi_pengambilan');
    }

    public function formInterview()
{
    return $this->hasOne(FormInterview::class, 'id_pendataan_surveyor_siswa', 'id_pendataan_surveyor_siswa');
}

public function formSurvey()
{
    return $this->hasOne(FormSurvey::class, 'id_pendataan_surveyor_siswa', 'id_pendataan_surveyor_siswa');
}

public function getComputedStatusAttribute()
{
    return ($this->formInterview && $this->formSurvey) ? 'Selesai' : 'Belum Selesai';
}

public function getStatusFormAttribute()
{
    return $this->formPendaftaran && $this->formPendaftaran->registrasiPengambilan
        ? 'Selesai'
        : 'Belum Selesai';
}
}
