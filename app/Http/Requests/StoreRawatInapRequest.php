<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRawatInapRequest extends FormRequest
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
            'tanggal_masuk' => ['required', 'date'],
            'tanggal_keluar' => ['nullable', 'date'],
            'ruang' => ['required', 'string', 'max:50'],
            'no_tempat_tidur' => ['required', 'string', 'max:20'],
            'diagnosa' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:Menunggu,Sedang Dirawat,Selesai,Dirujuk'],
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
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid',
            'ruang.required' => 'Ruang harus dipilih',
            'no_tempat_tidur.required' => 'Nomor tempat tidur harus diisi',
            'diagnosa.required' => 'Diagnosa harus diisi',
            'status.required' => 'Status harus dipilih',
        ];
    }
}
