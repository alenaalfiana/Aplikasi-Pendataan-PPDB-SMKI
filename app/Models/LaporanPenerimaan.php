<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPenerimaan extends Model
{
    protected $table = 'tbl_laporan_penerimaan';
    protected $primaryKey = 'id_penerimaan';

    protected $fillable = [
        'id_form_pendaftaran',
        'hasil_akhir',
        'file_powerpoint'
    ];

    // Relationship with Form Pendaftaran
    public function formPendaftaran(): BelongsTo
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function registrasiPengambilan()
    {
        return $this->hasOne(RegistrasiPengambilan::class, 'id_penerimaan', 'id_penerimaan');
        // atau mungkin lebih tepat:
        // return $this->belongsTo(RegistrasiPengambilan::class, 'id_registrasi_pengambilan', 'id_registrasi_pengambilan');
    }

    // Relationship with Periode
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    // Scope to get accepted students
    public function scopeDiterima($query)
    {
        return $query->where('hasil_akhir', 'diterima');
    }

    // Method to generate detailed data for reporting
    public function getDetailedReportData()
    {
        return [
            'pendaftaran' => $this->formPendaftaran,
            'interview' => $this->formPendaftaran->formInterview,
            'survey' => $this->formPendaftaran->formSurvey,
            'tpa_bhq' => $this->formPendaftaran->pendataanTpaBhq
        ];
    }
}
