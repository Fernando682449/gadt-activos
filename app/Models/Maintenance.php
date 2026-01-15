<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'asset_id','tipo','fecha_inicio','fecha_fin','proveedor_tecnico','costo',
        'descripcion_falla','trabajo_realizado','estado','user_id'
    ];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function user() { return $this->belongsTo(User::class); }
}
