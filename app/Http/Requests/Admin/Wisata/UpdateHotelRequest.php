<?php

namespace App\Http\Requests\Admin\Wisata;

class UpdateHotelRequest extends StoreHotelRequest
{
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'bintang' => 'nullable|integer|min:1|max:5',
            'telepon' => 'nullable|string|max:20',
            'gambar' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url|max:255',
        ];
    }
}
