<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
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

        $periodes = Periode::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('tahun_periode', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('periode.index', compact('periodes'));
    }


    /**
     * Menampilkan form untuk membuat periode baru.
     */
    public function create()
    {
        return view('periode.create');
    }

    /**
     * Menyimpan data periode baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_periode' => 'required|string|max:10',
            'mulai_tanggal' => 'nullable|date',
            'sampai_tanggal' => 'nullable|date',
        ]);

        Periode::create($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk periode tertentu.
     */
    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return view('periode.edit', compact('periode'));
    }

    /**
     * Memperbarui data periode dalam database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_periode' => 'required|string|max:10',
            'mulai_tanggal' => 'nullable|date',
            'sampai_tanggal' => 'nullable|date',
        ]);

        $periode = Periode::findOrFail($id);
        $periode->update($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui.');
    }

    /**
     * Menghapus data periode dari database.
     */
    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();

        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus.');
    }
}
