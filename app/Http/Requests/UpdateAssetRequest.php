<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset')?->id ?? $this->route('asset');

        return [
            'codigo_patrimonial' => [
                'required',
                'string',
                'max:60',
                Rule::unique('assets', 'codigo_patrimonial')->ignore($assetId),
            ],
            'numero_serie'       => ['nullable', 'string', 'max:80'],
            'asset_type_id'      => ['required', 'exists:asset_types,id'],
            'status_id'          => ['required', 'exists:asset_statuses,id'],
            'location_id'        => ['required', 'exists:locations,id'],
            'brand_id'           => ['nullable', 'exists:brands,id'],
            'custodian_id'       => ['required', 'exists:custodians,id'],
            'fecha_compra'       => ['nullable', 'date'],
            'costo'              => ['nullable', 'numeric', 'min:0'],
            'nro_factura'        => ['nullable', 'string', 'max:100'],
            'observaciones'      => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_patrimonial.required' => 'El código patrimonial es obligatorio.',
            'codigo_patrimonial.unique'   => 'Ya existe otro activo con ese código patrimonial.',
            'asset_type_id.required'      => 'Debe seleccionar el tipo de activo.',
            'asset_type_id.exists'        => 'El tipo seleccionado no es válido.',
            'status_id.required'          => 'Debe seleccionar el estado.',
            'status_id.exists'            => 'El estado seleccionado no es válido.',
            'location_id.required'        => 'Debe seleccionar la ubicación.',
            'location_id.exists'          => 'La ubicación seleccionada no es válida.',
            'custodian_id.required'       => 'Debe seleccionar el responsable o custodio.',
            'custodian_id.exists'         => 'El custodio seleccionado no es válido.',
            'brand_id.exists'             => 'La marca seleccionada no es válida.',
            'fecha_compra.date'           => 'La fecha de compra no es válida.',
            'costo.numeric'               => 'El costo debe ser numérico.',
            'nro_factura.max'             => 'El número de factura no debe superar 100 caracteres.',
        ];
    }
}