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

            'gambar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                'dimensions:ratio=4/3'
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'gambar.dimensions' => 'Ukuran gambar tidak valid. Harap gunakan gambar dengan rasio aspek 4:3.',
        ];
    }
}