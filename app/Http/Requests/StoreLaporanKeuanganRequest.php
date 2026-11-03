<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanKeuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $rules = [
            'tahun' => 'required|integer|digits:4|min:2000|max:' . (date('Y') + 1),
            'judul_laporan' => 'required|string|max:255',
            'jenis_laporan' => 'required|string|max:100',
            'deskripsi_singkat' => 'nullable|string|max:500',

            'file_laporan' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240',
        ];

        if ($this->isMethod('post')) {
            $rules['file_laporan'] = 'required|file|mimes:pdf,xls,xlsx,doc,docx|max:10240';
        }

        return $rules;
    }

    /**
     * Custom attribute names for validation errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'judul_laporan' => 'judul laporan',
            'jenis_laporan' => 'jenis laporan',
            'deskripsi_singkat' => 'deskripsi singkat',
            'file_laporan' => 'file laporan',
        ];
    }
}