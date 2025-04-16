<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenerimaan;
use App\Models\Periode;
use App\Models\FormPendaftaran;
use App\Models\RegistrasiPengambilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Style\Color;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpPresentation\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanPenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        $query = LaporanPenerimaan::with([
            'formPendaftaran.registrasiPengambilan.periode',
            'periode'
        ]);

        // Filter berdasarkan id_periode (dari registrasiPengambilan)
        if ($request->filled('id_periode')) {
            $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($request) {
                $q->where('id_periode', $request->id_periode);
            });
        }

        // Optional: pencarian nama/nisn
        if ($request->filled('search')) {
            $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $laporanPenerimaan = $query->orderBy('created_at', 'desc')->paginate(10);

        // Perlu dikirim ke view agar dropdown periode muncul
        $periodes = Periode::all();

        return view('laporan-penerimaan.index', compact('laporanPenerimaan', 'periodes'));
    }

    /**
     * Show the create form
     */
    public function create()
    {
        $periodes = Periode::all();

        $formPendaftarans = FormPendaftaran::with(['registrasiPengambilan'])
            ->whereHas('formInterview', function ($query) {
                $query->where('status_interview', 'sudah');
            })
            ->whereHas('formSurvey', function ($query) {
                $query->whereIn('saran_rekomendasi', ['Diterima', 'Abu-abu']);
            })
            ->get();

        return view('laporan-penerimaan.create', compact('periodes', 'formPendaftarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_form_pendaftaran' => 'required|exists:tbl_form_pendaftaran,id_form_pendaftaran',
            'hasil_akhir' => 'required|in:diterima,tidak_diterima'
        ]);

        // Create laporan penerimaan
        $laporanPenerimaan = LaporanPenerimaan::create($validatedData);

        // Generate PowerPoint
        $this->generatePowerPoint($laporanPenerimaan);

        return redirect()->route('laporan-penerimaan.index')
            ->with('success', 'Laporan Penerimaan berhasil dibuat');
    }

    /**
     * Generate PowerPoint for the report
     */
    private function generatePowerPoint(LaporanPenerimaan $laporanPenerimaan)
    {
        // Ambil data lengkap dengan relasi
        $reportData = $laporanPenerimaan->getDetailedReportData();

        $pendaftaran = $reportData['pendaftaran'];
        $namaLengkap = $pendaftaran->nama_lengkap ?? ($pendaftaran->registrasiPengambilan->nama ?? '-');
        $nisn = $pendaftaran->nisn ?? '-';
        $jenisKelamin = $pendaftaran->jenis_kelamin ?? '-';
        $ttl = ($pendaftaran->tempat_lahir ?? '-') . ', ' . ($pendaftaran->tanggal_lahir ?? '-');
        $periode = $pendaftaran->registrasiPengambilan->periode->tahun_periode ?? '-';
        $hasilAkhir = $laporanPenerimaan->hasil_akhir === 'diterima' ? 'Diterima' : 'Tidak Diterima';

        // Data formulir
        $formulirData1 = [
            "Ukuran Baju: " . ($pendaftaran->ukuran_baju ?? '-'),
            "Agama: " . ($pendaftaran->agama ?? '-'),
            "Anak ke: " . ($pendaftaran->anak_ke ?? '-') . " dari " . ($pendaftaran->dari ?? '-'),
            "Status Siswa: " . ($pendaftaran->status_siswa ?? '-'),
            "Bahasa Keseharian: " . ($pendaftaran->bahasa_keseharian ?? '-'),
            "Alamat Lengkap: " . ($pendaftaran->alamat_lengkap ?? '-'),
            "",
            "Asal Sekolah: " . ($pendaftaran->asal_sekolah ?? '-'),
            "Alamat Sekolah: " . ($pendaftaran->alamat_lengkap_sekolah ?? '-'),
            "Tahun Lulus: " . ($pendaftaran->tahun_lulus ?? '-'),
        ];

        $formulirData2 = [
            "Nama Ayah: " . ($pendaftaran->nama_ayah ?? '-'),
            "Usia Ayah: " . ($pendaftaran->usia_ayah ?? '-'),
            "Pendidikan Ayah: " . ($pendaftaran->pendidikan_ayah ?? '-'),
            "Pekerjaan Ayah: " . ($pendaftaran->pekerjaan_ayah ?? '-'),
            "Penghasilan Ayah: " . ($pendaftaran->penghasilan_ayah ?? '-'),
            "",
            "Nama Ibu: " . ($pendaftaran->nama_ibu ?? '-'),
            "Usia Ibu: " . ($pendaftaran->usia_ibu ?? '-'),
            "Pendidikan Ibu: " . ($pendaftaran->pendidikan_ibu ?? '-'),
            "Pekerjaan Ibu: " . ($pendaftaran->pekerjaan_ibu ?? '-'),
            "Penghasilan Ibu: " . ($pendaftaran->penghasilan_ibu ?? '-'),
        ];

        // Buat objek PowerPoint
        $objPHPPresentation = new PhpPresentation();
        $objPHPPresentation->removeSlideByIndex(0);

        // Slide Judul
        $titleSlide = $objPHPPresentation->createSlide();
        $titleShape = $titleSlide->createRichTextShape()
            ->setHeight(100)
            ->setWidth(600)
            ->setOffsetX(50)
            ->setOffsetY(200);
        $titleShape->createTextRun('Laporan Penerimaan Siswa')
            ->getFont()
            ->setSize(36)
            ->setColor(new Color(Color::COLOR_BLACK));

        // Tambahan: Nama dan Nomor Pendaftar
        $namaDanNoPendaftar = $laporanPenerimaan->formPendaftaran->registrasiPengambilan->nama . ' - ' . $laporanPenerimaan->formPendaftaran->registrasiPengambilan->no_pendaftar;
        $subtitleShape = $titleSlide->createRichTextShape()
            ->setHeight(50)
            ->setWidth(600)
            ->setOffsetX(50)
            ->setOffsetY(280); // diletakkan di bawah judul
        $subtitleShape->createTextRun($namaDanNoPendaftar)
            ->getFont()
            ->setSize(20)
            ->setColor(new Color('FF555555')); // pakai kode warna hex untuk dark gray


        // Slide Informasi Siswa
        $personalSlide = $objPHPPresentation->createSlide();
        $headerShape = $personalSlide->createRichTextShape()
            ->setHeight(50)
            ->setWidth(700)
            ->setOffsetX(50)
            ->setOffsetY(50);
        $headerShape->createTextRun('Informasi Siswa')
            ->getFont()
            ->setSize(24)
            ->setColor(new Color(Color::COLOR_BLUE));

        $personalDetails = [
            "Nama Lengkap: $namaLengkap",
            "NISN: $nisn",
            "Jenis Kelamin: $jenisKelamin",
            "Tempat, Tanggal Lahir: $ttl",
            "Periode: $periode",
            "Hasil Akhir: $hasilAkhir"
        ];

        $yOffset = 120;
        foreach ($personalDetails as $detail) {
            $textShape = $personalSlide->createRichTextShape()
                ->setHeight(30)
                ->setWidth(600)
                ->setOffsetX(50)
                ->setOffsetY($yOffset);
            $textShape->createTextRun($detail)
                ->getFont()
                ->setSize(14);
            $yOffset += 40;
        }

        // Slide Formulir 1
        $formulirSlide1 = $objPHPPresentation->createSlide();
        $formulirHeader1 = $formulirSlide1->createRichTextShape()
            ->setHeight(50)->setWidth(700)->setOffsetX(50)->setOffsetY(50);
        $formulirHeader1->createTextRun('Data Formulir Pendaftaran (Bagian 1)')
            ->getFont()->setSize(24)->setColor(new Color(Color::COLOR_DARKBLUE));

        $yOffset = 120;
        foreach ($formulirData1 as $item) {
            $textShape = $formulirSlide1->createRichTextShape()
                ->setHeight(30)->setWidth(700)->setOffsetX(50)->setOffsetY($yOffset);
            $textShape->createTextRun($item)->getFont()->setSize(14);
            $yOffset += 35;
        }

        // Slide Formulir 2
        $formulirSlide2 = $objPHPPresentation->createSlide();
        $formulirHeader2 = $formulirSlide2->createRichTextShape()
            ->setHeight(50)->setWidth(700)->setOffsetX(50)->setOffsetY(50);
        $formulirHeader2->createTextRun('Data Orang Tua')
            ->getFont()->setSize(24)->setColor(new Color(Color::COLOR_DARKBLUE));

        $yOffset = 120;
        foreach ($formulirData2 as $item) {
            $textShape = $formulirSlide2->createRichTextShape()
                ->setHeight(30)->setWidth(700)->setOffsetX(50)->setOffsetY($yOffset);
            $textShape->createTextRun($item)->getFont()->setSize(14);
            $yOffset += 35;
        }

        // Simpan file PowerPoint
        $filename = 'laporan_penerimaan_' . $laporanPenerimaan->id_penerimaan . '_ ' . $laporanPenerimaan->formPendaftaran->registrasiPengambilan->nama . '.pptx';
        $filepath = 'public/laporan_penerimaan/' . $filename;

        $writer = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
        $writer->save(storage_path('app/' . $filepath));

        // Update kolom file_powerpoint di database
        $laporanPenerimaan->update(['file_powerpoint' => $filename]);
    }


    /**
     * Add slides to PowerPoint with report data
     */
    private function addSlidesWithReportData($presentation, $reportData)
    {
        // Implement slide creation logic based on report data
        // This is a basic implementation and should be customized
        $currentSlide = $presentation->createSlide();

        // Add title slide
        $shape = $currentSlide->createRichTextShape()
            ->setHeight(100)
            ->setWidth(600)
            ->setOffsetX(50)
            ->setOffsetY(50);
        $shape->createTextRun('Laporan Penerimaan Siswa')
            ->setFont('Arial')
            ->setFontSize(24);

        // Add more slides with specific data...
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPenerimaan $laporanPenerimaan)
    {
        $reportData = $laporanPenerimaan->getDetailedReportData();

        // Decode JSON jika perlu (cek dulu apakah string)
        $survey = $reportData['survey'];
        $survey->alasan_pendukung = is_string($survey->alasan_pendukung)
            ? json_decode($survey->alasan_pendukung, true)
            : $survey->alasan_pendukung;

        $survey->alasan_memberatkan = is_string($survey->alasan_memberatkan)
            ? json_decode($survey->alasan_memberatkan, true)
            : $survey->alasan_memberatkan;

        return view('laporan-penerimaan.show', compact('laporanPenerimaan', 'reportData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPenerimaan $laporanPenerimaan)
    {
        return view('laporan-penerimaan.edit', compact('laporanPenerimaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPenerimaan $laporanPenerimaan)
    {
        $validatedData = $request->validate([
            'hasil_akhir' => 'required|in:diterima,tidak_diterima'
        ]);

        $laporanPenerimaan->update($validatedData);

        // Regenerate PowerPoint when status changes
        $this->generatePowerPoint($laporanPenerimaan);

        return redirect()->route('laporan-penerimaan.index')
            ->with('success', 'Laporan Penerimaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPenerimaan $laporanPenerimaan)
    {
        // Delete associated PowerPoint file
        if ($laporanPenerimaan->file_powerpoint) {
            Storage::delete('public/laporan_penerimaan/' . $laporanPenerimaan->file_powerpoint);
        }

        $laporanPenerimaan->delete();

        return redirect()->route('laporan-penerimaan.index')
            ->with('success', 'Laporan Penerimaan berhasil dihapus');
    }

    /**
     * Download PowerPoint file
     */
    public function downloadPowerPoint(LaporanPenerimaan $laporanPenerimaan)
    {
        $filepath = storage_path('app/public/laporan_penerimaan/' . $laporanPenerimaan->file_powerpoint);

        return response()->download($filepath);
    }

public function downloadPdf(Request $request)
{
    try {
        $query = LaporanPenerimaan::with([
            'formPendaftaran.registrasiPengambilan.periode',
            'periode'
        ])->where('hasil_akhir', 'diterima');

        // Jika ada filter id_periode dari index
        if ($request->filled('id_periode')) {
            $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($request) {
                $q->where('id_periode', $request->id_periode);
            });
        }

        $data = $query->get();

        $viewData = [
            'data' => $data,
            'logo_path' => public_path('assets/img/illustrations/smki-utama.png'),
            'logo_ybm_path' => public_path('assets/img/illustrations/ybm-pln.png'),
        ];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $pdf = new Dompdf($options);
        $html = view('laporan-penerimaan.pdf', $viewData)->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'potrait');
        $pdf->render();

        return $pdf->stream('laporan_penerimaan_diterima.pdf');

    } catch (\Exception $e) {
        return response()->view('errors.custom', [
            'message' => 'Gagal membuat PDF. Silakan hubungi tim IT.',
            'details' => $e->getMessage()
        ], 500);
    }
}


}
