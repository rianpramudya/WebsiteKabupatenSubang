<?php

namespace App\Http\Requests\Admin\Wisata;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreObjekWisataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi ditangani oleh Policy di Controller
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['required', 'string'],
            'lokasi_teks' => ['required', 'string', 'max:255'],
            'google_maps_url' => ['nullable', 'url'],
            'is_unggulan' => ['sometimes', 'boolean'],
            
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
    
    protected function prepareForValidation()
    {
        $this->merge([
            'is_unggulan' => $this->has('is_unggulan'),
        ]);
    }
}