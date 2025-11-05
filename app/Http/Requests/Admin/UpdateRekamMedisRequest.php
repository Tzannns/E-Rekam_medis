<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRekamMedisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['required', 'exists:dokter,id'],
            'tanggal_periksa' => ['required', 'date'],
            'keluhan' => ['nullable', 'string'],
            'diagnosa' => ['required', 'string'],
            'tindakan' => ['nullable', 'string'],
            'resep_obat' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
