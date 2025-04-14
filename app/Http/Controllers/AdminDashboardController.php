<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use App\Models\FormPendaftaran;
use App\Models\LaporanPenerimaan;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = auth()->user();

        // Ambil jumlah pendaftaran yang berhasil tersimpan berdasarkan periode
        $pendaftaranPerPeriode = FormPendaftaran::join('tbl_registrasi_pengambilan', 'tbl_form_pendaftaran.id_registrasi_pengambilan', '=', 'tbl_registrasi_pengambilan.id_registrasi_pengambilan')
            ->join('tbl_periode', 'tbl_registrasi_pengambilan.id_periode', '=', 'tbl_periode.id_periode')
            ->select('tbl_periode.tahun_periode as periode', DB::raw('COUNT(tbl_form_pendaftaran.id_form_pendaftaran) as total'))
            ->groupBy('tbl_periode.tahun_periode')
            ->get();

        // Ambil jumlah siswa diterima berdasarkan periode
        $pendaftaranDiterimaPerPeriode = LaporanPenerimaan::join('tbl_form_pendaftaran', 'tbl_laporan_penerimaan.id_form_pendaftaran', '=', 'tbl_form_pendaftaran.id_form_pendaftaran')
            ->join('tbl_registrasi_pengambilan', 'tbl_form_pendaftaran.id_registrasi_pengambilan', '=', 'tbl_registrasi_pengambilan.id_registrasi_pengambilan')
            ->join('tbl_periode', 'tbl_registrasi_pengambilan.id_periode', '=', 'tbl_periode.id_periode')
            ->where('tbl_laporan_penerimaan.hasil_akhir', 'diterima')
            ->select('tbl_periode.tahun_periode as periode', DB::raw('COUNT(tbl_laporan_penerimaan.id_penerimaan) as total'))
            ->groupBy('tbl_periode.tahun_periode')
            ->get();

        $periodeLabels = $pendaftaranPerPeriode->pluck('periode');
        $periodeData = $pendaftaranPerPeriode->pluck('total');
        $periodeDataDiterima = $pendaftaranDiterimaPerPeriode->pluck('total');

        return view('admin.dashboard', compact('periodeLabels', 'periodeData', 'periodeDataDiterima', 'user'));
    }
}
