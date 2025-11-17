<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserManagementRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $userId = $user->id;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['nullable', 'in:Admin,Dokter,Petugas,Pasien'],
        ];

        // Dokter-specific fields (if user has dokter relation)
        if ($user->dokter || $this->role === 'Dokter') {
            $dokterRecord = $user->dokter;
            $rules['nip'] = [
                'nullable',
                'string',
                'max:50',
                Rule::unique('dokter', 'nip')->ignore($dokterRecord?->id),
            ];
            $rules['spesialisasi'] = ['nullable', 'string', 'max:100'];
            $rules['no_telp'] = ['nullable', 'string', 'max:20'];
        }

        // Pasien-specific fields (if user has pasien relation)
        if ($user->pasien || $this->role === 'Pasien') {
            $pasienRecord = $user->pasien;
            $rules['nik'] = [
                'nullable',
                'string',
                'max:20',
                Rule::unique('pasien', 'nik')->ignore($pasienRecord?->id),
            ];
            $rules['tanggal_lahir'] = ['nullable', 'date'];
            $rules['jenis_kelamin'] = ['nullable', 'in:L,P'];
            $rules['alamat'] = ['nullable', 'string', 'max:500'];
            $rules['no_telp'] = ['nullable', 'string', 'max:20'];
        }

        return $rules;
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
            'nip.unique' => 'NIP sudah digunakan',
            'nip.max' => 'NIP maksimal 50 karakter',
            'spesialisasi.max' => 'Spesialisasi maksimal 100 karakter',
            'nik.unique' => 'NIK sudah digunakan',
            'nik.max' => 'NIK maksimal 20 karakter',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan)',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'no_telp.max' => 'No. Telepon maksimal 20 karakter',
        ];
    }
}
