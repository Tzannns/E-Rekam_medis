<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIGDRequest extends FormRequest
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
            'tanggal_masuk' => ['required', 'date_format:Y-m-d H:i,Y-m-d\TH:i'],
            'tanggal_keluar' => ['nullable', 'date_format:Y-m-d H:i,Y-m-d\TH:i'],
            'keluhan_utama' => ['required', 'string', 'max:1000'],
            'triase_level' => ['required', 'in:Hijau,Kuning,Merah,Hitam'],
            'status' => ['required', 'in:Menunggu,Sedang Ditangani,Selesai,Dirujuk'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'pasien_id.required' => 'Pasien harus dipilih',
            'pasien_id.exists' => 'Pasien yang dipilih tidak ditemukan',
            'dokter_id.exists' => 'Dokter yang dipilih tidak ditemukan',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date_format' => 'Format tanggal masuk tidak valid (Y-m-d H:i)',
            'keluhan_utama.required' => 'Keluhan utama harus diisi',
            'triase_level.required' => 'Level triase harus dipilih',
            'status.required' => 'Status harus dipilih',
        ];
    }
}
