<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'asset_id' => ['required', 'exists:assets,id'],
        'custodian_id' => ['required', 'exists:custodians,id'],
        'location_id' => ['required', 'exists:locations,id'],
        'tipo_movimiento' => ['required', 'in:ASIGNACION,REASIGNACION,TRASLADO'],
        'fecha_asignacion' => ['required', 'date'],
        'observaciones' => ['nullable', 'string'],
    ];
}
}
