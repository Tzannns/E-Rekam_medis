<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserManagementRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:Admin,Dokter,Petugas,Pasien'],
        ];

        // Dokter-specific fields
        if ($this->role === 'Dokter') {
            $rules['nip'] = ['required', 'string', 'max:50', 'unique:dokter,nip'];
            $rules['spesialisasi'] = ['required', 'string', 'max:100'];
            $rules['no_telp'] = ['required', 'string', 'max:20'];
        }

        // Pasien-specific fields
        if ($this->role === 'Pasien') {
            $rules['nik'] = ['required', 'string', 'max:20', 'unique:pasien,nik'];
            $rules['tanggal_lahir'] = ['required', 'date'];
            $rules['jenis_kelamin'] = ['required', 'in:L,P'];
            $rules['alamat'] = ['required', 'string', 'max:500'];
            $rules['no_telp'] = ['required', 'string', 'max:20'];
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
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'nip.max' => 'NIP maksimal 50 karakter',
            'spesialisasi.required' => 'Spesialisasi harus diisi',
            'spesialisasi.max' => 'Spesialisasi maksimal 100 karakter',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah digunakan',
            'nik.max' => 'NIK maksimal 20 karakter',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan)',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'no_telp.required' => 'No. Telepon harus diisi',
            'no_telp.max' => 'No. Telepon maksimal 20 karakter',
        ];
    }
}
