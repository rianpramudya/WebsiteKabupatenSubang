<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreLayananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isSuperAdmin = Auth::check() && Auth::user()->hasRole('super-admin');

        return [
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_url'  => 'nullable|url|max:255',
            'icon'      => 'nullable|string|max:100',
            'urutan'    => 'required|integer',
            
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
}
