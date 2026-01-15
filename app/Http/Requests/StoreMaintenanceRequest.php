<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required','exists:assets,id'],
            'tipo' => ['required','in:PREVENTIVO,CORRECTIVO'],
            'fecha_inicio' => ['required','date'],
            'fecha_fin' => ['nullable','date','after_or_equal:fecha_inicio'],
            'proveedor_tecnico' => ['nullable','string','max:150'],
            'costo' => ['nullable','numeric','min:0'],
            'descripcion_falla' => ['nullable','string'],
            'trabajo_realizado' => ['nullable','string'],
            'estado' => ['required','in:ABIERTO,EN_PROCESO,FINALIZADO'],
        ];
    }
}
