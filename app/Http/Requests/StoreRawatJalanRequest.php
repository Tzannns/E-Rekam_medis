<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRawatJalanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'pasien_id' => ['required', 'exists:pasien,id'],
            'dokter_id' => ['nullable', 'exists:dokter,id'],
            'poli_id' => ['nullable', 'exists:polis,id'],
            'tanggal_kunjungan' => ['required', 'date_format:Y-m-d H:i,Y-m-d\TH:i'],
            'keluhan' => ['required', 'string', 'max:1000'],
            'diagnosa' => ['nullable', 'string', 'max:1000'],
            'tindakan' => ['nullable', 'string', 'max:1000'],
            'resep_obat' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:Menunggu,Sedang Diperiksa,Selesai,Batal'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'pasien_id.required' => 'Pasien harus dipilih',
            'pasien_id.exists' => 'Pasien yang dipilih tidak ditemukan',
            'dokter_id.exists' => 'Dokter yang dipilih tidak ditemukan',
            'poli_id.exists' => 'Poli yang dipilih tidak ditemukan',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan harus diisi',
            'tanggal_kunjungan.date_format' => 'Format tanggal kunjungan tidak valid (Y-m-d H:i)',
            'keluhan.required' => 'Keluhan harus diisi',
            'status.required' => 'Status harus dipilih',
        ];
    }
}
