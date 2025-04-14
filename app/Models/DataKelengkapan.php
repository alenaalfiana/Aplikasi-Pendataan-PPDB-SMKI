<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKelengkapan extends Model
{
    use HasFactory;

    protected $table = 'tbl_data_kelengkapan';
    protected $primaryKey = 'id_data_kelengkapan';
    public $timestamps = true;

    protected $fillable = [
        'id_form_pendaftaran',
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

    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran');
    }
}
