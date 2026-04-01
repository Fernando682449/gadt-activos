<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset')->id;

        return [
            'codigo_patrimonial' => ['required', 'string', 'max:60', 'unique:assets,codigo_patrimonial,' . $assetId],
            'numero_serie' => ['nullable', 'string', 'max:80'],
            'asset_type_id' => ['required', 'exists:asset_types,id'],
            'status_id' => ['required', 'exists:asset_statuses,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'custodian_id' => ['required', 'exists:custodians,id'],
            'fecha_compra' => ['nullable', 'date'],
            'costo' => ['nullable', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string'],
        ];
    }
}