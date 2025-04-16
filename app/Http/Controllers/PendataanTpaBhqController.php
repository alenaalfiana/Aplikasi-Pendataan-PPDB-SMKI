<?php

namespace App\Http\Controllers;

use App\Models\PendataanTpaBhq;
use App\Models\FormPendaftaran;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PendataanTpaBhqController extends Controller
{
    /**
     * Menampilkan daftar periode.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(404); // Jika belum login, tampilkan halaman 404
        }

        $search = $request->input('search');
        $id_periode = $request->input('id_periode'); // Ambil nilai filter periode

        $nilais = PendataanTpaBhq::with(['formPendaftaran.periode'])
        ->when($search, function ($query) use ($search) {
            return $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        })

        ->when($id_periode, function ($query) use ($id_periode) {
            return $query->whereHas('formPendaftaran.registrasiPengambilan', function ($q) use ($id_periode) {
                $q->where('id_periode', $id_periode);
            });
        })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan data terbaru
            ->paginate(10);

        // Ambil daftar periode untuk dropdown filter
        $periodes = Periode::all();

        return view('pendataan_tpa_bhq.index', compact('periodes', 'nilais'));
    }


    /**
     * Menampilkan form untuk membuat periode baru.
     */
    public function create()
    {
        // Ambil ID yang sudah digunakan di tabel PendataanTpaBhq
        $usedIds = PendataanTpaBhq::pluck('id_form_pendaftaran')->toArray();

        // Ambil data FormPendaftaran yang belum digunakan
        $formPendaftarans = FormPendaftaran::whereNotIn('id_form_pendaftaran', $usedIds)->get();

        return view('pendataan_tpa_bhq.create', compact('formPendaftarans'));
    }



    /**
     * Menyimpan data periode baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_form_pendaftaran' => 'required|integer',
            'rata2_tpa' => 'nullable|string|max:5',
            'max_tpa' => 'nullable|string|max:5',
            'min_tpa' => 'nullable|string|max:5',
            'rata2_tes_alquran' => 'nullable|string|max:5',
            'max_alquran' => 'nullable|string|max:5',
            'min_alquran' => 'nullable|string|max:5',
        ]);

        PendataanTpaBhq::create($request->all());
        return redirect()->route('pendataan_tpa_bhq.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit untuk periode tertentu.
     */
    public function edit($id)
    {
        $nilai = PendataanTpaBhq::findOrFail($id);
        $formPendaftarans = FormPendaftaran::all(); // Pastikan model ini benar

        return view('pendataan_tpa_bhq.edit', compact('formPendaftarans', 'nilai'));
    }

    /**
     * Memperbarui data periode dalam database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_form_pendaftaran' => 'required|integer',
            'rata2_tpa' => 'nullable|string|max:5',
            'max_tpa' => 'nullable|string|max:5',
            'min_tpa' => 'nullable|string|max:5',
            'rata2_tes_alquran' => 'nullable|string|max:5',
            'max_alquran' => 'nullable|string|max:5',
            'min_alquran' => 'nullable|string|max:5',
        ]);

        $nilai = PendataanTpaBhq::findOrFail($id);
        $nilai->update($request->all());
        return redirect()->route('pendataan_tpa_bhq.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Menghapus data periode dari database.
     */
    public function destroy($id)
    {
        $nilai = PendataanTpaBhq::findOrFail($id);
        $nilai->delete();
        return redirect()->route('pendataan_tpa_bhq.index')->with('success', 'Data berhasil dihapus');
    }
}
