<?php

namespace App\Http\Requests\Admin\Wisata;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudayaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            
            // MODIFIKASI DIMULAI DI SINI
            'gambar' => [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,webp', 
                'max:2048',
                'dimensions:ratio=4/3' // Aturan untuk rasio aspek 4:3
            ],
            // AKHIR MODIFIKASI
        ];
    }

    /**
     * Menambahkan pesan error kustom agar lebih ramah pengguna.
     */
    public function messages(): array
    {
        return [
            'gambar.dimensions' => 'Ukuran gambar tidak valid. Harap gunakan gambar dengan rasio aspek 4:3.',
        ];
    }
}