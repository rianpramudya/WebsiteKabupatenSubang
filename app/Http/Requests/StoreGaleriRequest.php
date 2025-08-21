<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreGaleriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isSuperAdmin = $this->user() && $this->user()->hasRole('super-admin');

        return [
            'judul' => 'required|string|max:255',
            'tipe' => 'required|string|in:foto,video_upload,video_yt',
            
            'file_foto' => [
                Rule::requiredIf($this->input('tipe') === 'foto'),
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048', // max 2MB
                'dimensions:ratio=4/3' // Aturan untuk rasio aspek 4:3
            ],

            // MODIFIKASI DIMULAI DI SINI
            'file_video_upload' => [
                Rule::requiredIf($this->input('tipe') === 'video_upload'),
                'nullable',
                'file',
                'mimes:mp4,mov,webm',
                'max:102400', // max 100MB
                'dimensions:ratio=16/9' // Aturan untuk rasio aspek 16:9
            ],
            // AKHIR MODIFIKASI

            'file_video_yt' => [
                Rule::requiredIf($this->input('tipe') === 'video_yt'),
                'nullable',
                'url'
            ],

            'owner_type' => [
                Rule::requiredIf($isSuperAdmin),
                'nullable',
                'string',
                Rule::in(['kecamatan', 'pd', 'kabupaten']),
            ],
            
            'kecamatan_id' => [
                Rule::requiredIf(fn() => $isSuperAdmin && $this->input('owner_type') === 'kecamatan'),
                'nullable',
                'exists:kecamatans,id'
            ],
            
            'perangkat_daerah_id' => [
                Rule::requiredIf(fn() => $isSuperAdmin && $this->input('owner_type') === 'pd'),
                'nullable',
                'exists:perangkat_daerahs,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file_foto.dimensions' => 'Ukuran foto tidak valid. Harap gunakan gambar dengan rasio aspek 4:3.',
            // MODIFIKASI DIMULAI DI SINI
            'file_video_upload.dimensions' => 'Rasio video tidak valid. Harap gunakan video dengan rasio aspek 16:9.',
            // AKHIR MODIFIKASI
        ];
    }
}