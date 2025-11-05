<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilPasienRequest extends FormRequest
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
        $pasienId = optional(auth()->user()->pasien)->id;

        return [
            'nik' => ['required', 'string', 'size:16', 'unique:pasien,nik,'.($pasienId ?? 'NULL').',id'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:20'],
        ];
    }
}
