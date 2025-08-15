<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani di Controller dengan Policy,
        // jadi kita bisa set ke true di sini.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'struktur_organisasi_url' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            // Tambahkan validasi untuk kolom profil lain jika ada
        ]; // Pastikan ditutup dengan kurung siku dan titik koma
    }
}
