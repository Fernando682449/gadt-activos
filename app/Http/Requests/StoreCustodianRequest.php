<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustodianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required','string','max:120'],
            'apellidos' => ['required','string','max:120'],
            'cargo' => ['nullable','string','max:120'],
            'unidad' => ['nullable','string','max:120'],
            'email' => ['nullable','email','max:150'],
            'activo' => ['required','boolean'],
        ];
    }
}
