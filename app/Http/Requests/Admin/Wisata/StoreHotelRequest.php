<?php

namespace App\Http\Requests\Admin\Wisata;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'bintang' => ['nullable', 'integer', 'min:1', 'max:5'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string'], // Dihapus max:255 karena menggunakan Trix
            'telepon' => ['nullable', 'string', 'max:20'],
            'website_url' => ['nullable', 'url', 'max:255'],
            
            // MODIFIKASI DIMULAI DI SINI
            'gambar' => [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,webp', 
                'max:2048',
                'dimensions:ratio=16/9' // Aturan untuk rasio aspek 16:9
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
            'gambar.dimensions' => 'Ukuran gambar tidak valid. Harap gunakan gambar dengan rasio aspek 16:9.',
        ];
    }
}