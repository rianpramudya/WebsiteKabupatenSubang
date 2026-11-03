<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBeritaRequest extends FormRequest
{

    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_berita_id' => 'required|exists:kategori_beritas,id',
            'tags' => 'nullable|string',
        ];

        if (Auth::user()->hasRole('super-admin')) {

            $rules['kecamatan_id'] = 'required_if:owner_type,kecamatan|nullable|exists:kecamatans,id';

            $rules['perangkat_daerah_id'] = 'required_if:owner_type,pd|nullable|exists:perangkat_daerahs,id';
        }

        return $rules;
    }
}
