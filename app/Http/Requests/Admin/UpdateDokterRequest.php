<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateDokterRequest extends FormRequest
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
        $dokter = $this->route('dokter');
        $userId = $dokter instanceof \App\Models\Dokter ? $dokter->user_id : $dokter;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'nip' => ['required', 'string', 'max:50', Rule::unique('dokter', 'nip')->ignore($dokter)],
            'spesialisasi' => ['required', 'string', 'max:100'],
            'no_telp' => ['required', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'nip.max' => 'NIP maksimal 50 karakter',
            'spesialisasi.required' => 'Spesialisasi harus diisi',
            'spesialisasi.max' => 'Spesialisasi maksimal 100 karakter',
            'no_telp.required' => 'No. Telepon harus diisi',
            'no_telp.max' => 'No. Telepon maksimal 20 karakter',
        ];
    }
}
