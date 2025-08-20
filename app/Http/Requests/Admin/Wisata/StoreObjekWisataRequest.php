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
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'lokasi_teks' => ['required', 'string', 'max:255'],
            // --- PERBAIKAN DI SINI ---
            'google_maps_url' => ['nullable', 'url'], // Menggunakan nama yang benar (semua huruf kecil)
            // -------------------------
            'is_unggulan' => ['sometimes', 'boolean'],
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'is_unggulan' => $this->has('is_unggulan'),
        ]);
    }
}