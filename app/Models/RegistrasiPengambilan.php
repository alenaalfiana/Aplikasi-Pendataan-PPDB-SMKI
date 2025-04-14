<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegistrasiPengambilan extends Model
{
    use HasFactory;

    protected $table = 'tbl_registrasi_pengambilan';
    protected $primaryKey = 'id_registrasi_pengambilan';
    public $timestamps = true;

    protected $fillable = [
        'id_periode',
        'no_pendaftar',
        'nama_pengambil',
        'nama',
        'jenis_kelamin',
        'alamat_lengkap',
        'no_telepon',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'keterangan',
        'foto_bukti_pengisian',
        'tanggal_pengambilan',
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

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil nomor terakhir berdasarkan ID tertinggi
            $lastEntry = self::latest('id_registrasi_pengambilan')->first();
            $lastNumber = $lastEntry ? intval($lastEntry->no_pendaftar) : 0;

            // Buat nomor baru dengan format 5 digit
            $model->no_pendaftar = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        });
    }

}
