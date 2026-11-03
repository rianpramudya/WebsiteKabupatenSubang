<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfografisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $gambarRules = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:ratio=9/16';

        if ($this->isMethod('post')) {
            $gambarRules = 'required|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:ratio=9/16';
        }

        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'published_at' => 'required|date',
            'gambar' => $gambarRules,
            'hapus_gambar' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'gambar.dimensions' => 'Ukuran gambar tidak valid. Harap gunakan gambar dengan rasio aspek 9:16 (potret).',
        ];
    }
}