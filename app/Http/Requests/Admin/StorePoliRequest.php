<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePoliRequest extends FormRequest
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
            'nama_poli' => ['required', 'string', 'max:100'],
            'kode_poli' => ['required', 'string', 'max:20', 'unique:polis,kode_poli'],
            'deskripsi' => ['nullable', 'string'],
            'lokasi' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_poli.required' => 'Nama poli harus diisi',
            'nama_poli.max' => 'Nama poli maksimal 100 karakter',
            'kode_poli.required' => 'Kode poli harus diisi',
            'kode_poli.unique' => 'Kode poli sudah digunakan',
            'kode_poli.max' => 'Kode poli maksimal 20 karakter',
            'lokasi.max' => 'Lokasi maksimal 100 karakter',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
        ];
    }
}
