<?php

namespace App\Http\Requests\Dokter;

use Illuminate\Foundation\Http\FormRequest;

class StoreRekamMedisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pasien_id' => ['required', 'exists:pasien,id'],
            'tanggal_periksa' => ['required', 'date'],
            'keluhan' => ['nullable', 'string'],
            'diagnosa' => ['required', 'string'],
            'tindakan' => ['nullable', 'string'],
            'resep_obat' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
