<?php

return [

    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'numeric' => 'El campo :attribute debe ser numérico.',
    'date' => 'El campo :attribute debe ser una fecha válida.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'unique' => 'El :attribute ya está registrado.',
    'max' => [
        'string' => 'El campo :attribute no debe superar :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Nombres personalizados de campos
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'codigo_patrimonial' => 'código patrimonial',
        'numero_serie' => 'número de serie',
        'asset_type_id' => 'tipo',
        'status_id' => 'estado',
        'location_id' => 'ubicación',
        'brand_id' => 'marca',
        'fecha_compra' => 'fecha de compra',
        'costo' => 'costo',
        'observaciones' => 'observaciones',
    ],

];