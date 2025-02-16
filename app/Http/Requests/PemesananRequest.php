<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemesananRequest extends FormRequest
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
            'jadwal_id' => [$conditionalRule, 'exists:jadwals,id'],
            'kuantitas' => [$conditionalRule, 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'jadwal_id.required' => 'Jadwal harus diisi!',
            'kuantitas.required' => 'Kuantitas harus diisi!',
            'kuantitas.numeric' => 'Kuantitas berupa angka',
        ];
    }
}
