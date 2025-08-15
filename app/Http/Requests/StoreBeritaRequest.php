<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBeritaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani di Controller dengan Policy,
        // jadi kita bisa set ke true di sini.
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

        // ======================================================================
        // PERBAIKAN: Logika validasi dinamis untuk Super Admin
        // ======================================================================
        if (Auth::user()->hasRole('super-admin')) {
            // Kolom kecamatan_id hanya wajib diisi jika owner_type yang dipilih adalah 'kecamatan'.
            $rules['kecamatan_id'] = 'required_if:owner_type,kecamatan|nullable|exists:kecamatans,id';
            
            // Kolom perangkat_daerah_id hanya wajib diisi jika owner_type yang dipilih adalah 'pd'.
            $rules['perangkat_daerah_id'] = 'required_if:owner_type,pd|nullable|exists:perangkat_daerahs,id';
        }

        return $rules;
    }
}
