<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfografisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh Policy di dalam Controller,
        // jadi di sini kita izinkan saja.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Aturan untuk file gambar: wajib ada saat membuat baru (store), opsional saat update.
        $gambarRules = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'; // Max 2MB

        if ($this->isMethod('post')) {
            $gambarRules = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'published_at' => 'required|date',
            'gambar' => $gambarRules,
            'hapus_gambar' => 'nullable|boolean',
        ];
    }
}