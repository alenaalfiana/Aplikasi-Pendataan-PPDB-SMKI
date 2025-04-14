<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormInterview extends Model
{
    use HasFactory;

    protected $table = 'tbl_form_interview';
    protected $primaryKey = 'id_form_interview';
    public $timestamps = true;

    protected $fillable = [
        'id_form_pendaftaran',
        'id_pendataan_surveyor_siswa',
        'nama_panggilan',
        'jumlah_saudara_kandung',
        'jumlah_saudara_tiri',
        'jumlah_saudara_angkat',
        'cita_cita',
        'alasan_cita_cita',
        'usaha_yang_dilakukan',
        'motto',
        'kekurangan',
        'kelebihan',
        'organisasi_sekolah',
        'organisasi_masyarakat',
        'hobi',
        'nilai_komunikasi',
        'nilai_kepercayaan_diri',
        'uang_saku',
        'kemampuan_bermotor',

        'prestasi_yang_dicapai',
        'mata_pelajaran',
        'rencana_pilihan_sekolah',
        'alasan_pilihan_sekolah',
        'kenalan_yang_diterima_di_smki',
        'historis_sakit',
        'historis_ijin',
        'historis_alfa',
        'catatan_kasus_pelanggaran',
        'bhq',
        'hafalan_juz',

        'merokok_narkoba',
        'jenis_merek_harga',
        'anggota_keluarga_yg_merokok',
        'riwayat_kesehatan',
        'terpapar_pornografi',
        'media_sosial',
        'ketertarikan_dengan_lawan_jenis',

        'status_hubungan_ortu',
        'pendapatan_ayah_per_bulan',
        'pendapatan_ibu_per_bulan',

        'nama_lengkap_keluarga',
        'jenis_kelamin',
        'usia',
        'pendidikan',
        'kelas',
        'pekerjaan',
        'hubungan',

        'siswa_tinggal_bersama',
        'status_pernikahan_ortu',
        'status_rumah',
        'harga_kontrak',
        'daya_listrik',
        'biaya_listrik',
        'transportasi_yg_dimiliki',
        'harta_milik_keluarga',
        'berat_kalung_gr',
        'berat_cincin_gr',
        'berat_gelang_gr',
        'berat_anting_gr',
        'tanggungan_kredit',
        'pendapat',

        'nama',
        'hubungan_dgn_siswa',
        'alamat_kontak_darurat',
        'no_telepon',
        'no_hp',

        'kesimpulan',
        'denah_lokasi',
        'nama_lengkap',
        'nama_panggilan_di_lingkungan',
        'ciri_ciri_rumah',
        'tanggal_pengisian',
        'status_interview'
    ];

    protected $casts = [
        'prestasi_yang_dicapai' => 'array',
        'rencana_pilihan_sekolah' => 'array',
        'alasan_pilihan_sekolah' => 'array',
        'nama_lengkap_keluarga' => 'array',
        'jenis_kelamin' => 'array',
        'usia' => 'array',
        'pendidikan' => 'array',
        'kelas' => 'array',
        'pekerjaan' => 'array',
        'hubungan' => 'array',
        'ciri_ciri_rumah' => 'array',
    ];

    public function formPendaftaran()
    {
        return $this->belongsTo(FormPendaftaran::class, 'id_form_pendaftaran', 'id_form_pendaftaran');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'id');
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

}
