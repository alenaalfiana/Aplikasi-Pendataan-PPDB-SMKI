<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanPenerimaanRequest extends FormRequest
{
    /**
     * Determine if the user has authorization to make this request.
     */
    public function authorize(): bool
    {
        // Add authorization logic if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_form_pendaftaran' => 'required|exists:tbl_form_pendaftaran,id_form_pendaftaran',
            'id_periode' => 'required|exists:tbl_periode,id_periode',
            'hasil_akhir' => 'required|in:diterima,tidak_diterima'
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'id_form_pendaftaran.required' => 'Formulir pendaftaran harus dipilih.',
            'id_form_pendaftaran.exists' => 'Formulir pendaftaran tidak valid.',
            'id_periode.required' => 'Periode harus dipilih.',
            'id_periode.exists' => 'Periode tidak valid.',
            'hasil_akhir.required' => 'Hasil akhir harus ditentukan.',
            'hasil_akhir.in' => 'Hasil akhir hanya bisa "diterima" atau "tidak_diterima".'
        ];
    }
}