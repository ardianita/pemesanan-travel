<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $conditionalRule = Rule::when($this->isMethod('put'), 'sometimes', 'required');

        return [
            'tujuan' => [$conditionalRule],
            'tgl' => [$conditionalRule],
            'waktu' => [$conditionalRule],
            'kuota' => [$conditionalRule],
            'harga' => [$conditionalRule],
        ];
    }

    public function messages()
    {
        return [
            'tujuan.required' => 'Tujuan Travel harus diisi!',
            'tgl.required' => 'Tanggal Keberangkatan harus diisi!',
            'waktu.required' => 'Waktu Keberangkatan harus diisi!',
            'kuota.required' => 'Kuota harus diisi!',
            'harga.required' => 'Harga harus diisi!',
        ];
    }
}
