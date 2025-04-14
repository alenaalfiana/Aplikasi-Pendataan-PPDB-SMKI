<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendataanTpaBhq extends Model
{
    use HasFactory;

    protected $table = 'tbl_pendataan_tpa_bhq';
    protected $primaryKey = 'id_pendataan_tpa_bhq';
    protected $fillable = [
        'id_form_pendaftaran',
        'rata2_tpa',
        'max_tpa',
        'min_tpa',
        'rata2_tes_alquran',
        'max_alquran',
        'min_alquran',
    ];

    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function registrasiPengambilan()
    {
        return $this->belongsTo(RegistrasiPengambilan::class, 'id_registrasi_pengambilan');
    }
}
