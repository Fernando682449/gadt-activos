<?php

namespace App\Models;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Asset extends Model
{
    protected $fillable = [
        'codigo_patrimonial',
        'numero_serie',
        'asset_type_id',
        'status_id',
        'location_id',
        'fecha_compra',
        'costo',
        'observaciones',

        'category_id',
        'brand_id',
        'purchase_order_number',
        'custodian_id',
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}

public function brand()
{
    return $this->belongsTo(\App\Models\Brand::class);
}

    public function type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

    public function status()
    {
        return $this->belongsTo(AssetStatus::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function assignments()
{
    return $this->hasMany(\App\Models\Assignment::class);
}
public function maintenances()
{
    return $this->hasMany(\App\Models\Maintenance::class);
}


public function histories()
{
    return $this->hasMany(\App\Models\AssetHistory::class);
}

public function custodian()
{
    return $this->belongsTo(\App\Models\Custodian::class, 'custodian_id');
}


public function lastAssignment()
{
    return $this->hasOne(Assignment::class, 'asset_id')
        ->whereIn('tipo_movimiento', ['ASIGNACION', 'REASIGNACION'])
        ->orderByDesc('fecha_asignacion');
}

public function lastAssignmentEntrega()
{
    // última entrega: ASIGNACION o REASIGNACION
    return $this->hasOne(Assignment::class, 'asset_id')
        ->whereIn('tipo_movimiento', ['ASIGNACION', 'REASIGNACION'])
        ->orderByDesc('fecha_asignacion');
}

}
