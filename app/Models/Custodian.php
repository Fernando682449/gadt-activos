<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custodian extends Model
{
    protected $fillable = [
        'nombres','apellidos','cargo','unidad','email','activo'
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellidos);
    }
}
