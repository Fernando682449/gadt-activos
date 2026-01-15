<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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

}
