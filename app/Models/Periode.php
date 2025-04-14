<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'tbl_periode';
    protected $primaryKey = 'id_periode';
    public $timestamps = true;

    protected $fillable = [
        'tahun_periode',
        'mulai_tanggal',
        'sampai_tanggal',
    ];

    public function laporanPenerimaan()
{
    return $this->hasMany(LaporanPenerimaan::class, 'id_periode');
}

}
