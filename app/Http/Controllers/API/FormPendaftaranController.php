<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FormPendaftaran;
use Illuminate\Http\Request;

class FormPendaftaranController extends Controller
{
    public function show($id)
    {
        $formPendaftaran = FormPendaftaran::with(['dataOrangtua', 'dataKelengkapan'])
            ->findOrFail($id);

        return response()->json($formPendaftaran);
    }
}
