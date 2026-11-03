<?php

namespace App\Http\Requests\Admin\Wisata;

use Illuminate\Foundation\Http\FormRequest;

class StoreRumahMakanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kuliner' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'telepon' => ['nullable', 'string', 'max:20'],

            'gambar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                'dimensions:ratio=16/9'
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'gambar.dimensions' => 'Ukuran gambar tidak valid. Harap gunakan gambar dengan rasio aspek 16:9.',
        ];
    }
}