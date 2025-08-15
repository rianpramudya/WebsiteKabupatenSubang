<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AgendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Otorisasi ditangani oleh Policy di controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $isSuperAdmin = Auth::check() && Auth::user()->hasRole('super-admin');

        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',

            // Hanya validasi owner_type jika super-admin
            'owner_type' => [
                Rule::requiredIf($isSuperAdmin),
                'nullable',
                'string',
                Rule::in(['kecamatan', 'pd', 'kabupaten']),
            ],

            // Wajib diisi jika super-admin memilih 'kecamatan'
            'kecamatan_id' => [
                Rule::requiredIf(fn() => $isSuperAdmin && $this->input('owner_type') === 'kecamatan'),
                'nullable',
                'exists:kecamatans,id'
            ],

            // Wajib diisi jika super-admin memilih 'pd'
            'perangkat_daerah_id' => [
                Rule::requiredIf(fn() => $isSuperAdmin && $this->input('owner_type') === 'pd'),
                'nullable',
                'exists:perangkat_daerahs,id'
            ],
        ];
    }
}
