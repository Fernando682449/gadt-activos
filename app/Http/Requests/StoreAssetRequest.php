<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_patrimonial' => ['required', 'string', 'max:60', 'unique:assets,codigo_patrimonial'],
            'numero_serie' => ['nullable', 'string', 'max:80'],
            'asset_type_id' => ['required', 'exists:asset_types,id'],
            'status_id' => ['required', 'exists:asset_statuses,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'fecha_compra' => ['nullable', 'date'],
            'costo' => ['nullable', 'numeric', 'min:0'],
            'nro_factura' => ['nullable', 'string', 'max:100'],
            'observaciones' => ['nullable', 'string'],
            'brand_id' => ['nullable', 'exists:brands,id'],
        ];
    }
}   