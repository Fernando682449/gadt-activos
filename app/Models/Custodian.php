<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Custodian extends Model
{
    protected $fillable = [
        'nombres','apellidos','cargo','unidad','email','activo','estado',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function assignments()
    {
        return $this->hasMany(\App\Models\Assignment::class);
    }

    public function assets()
    {
        return $this->hasMany(\App\Models\Asset::class, 'custodian_id');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS (ANTES DE GUARDAR EN BD)
    | Guarda todo en MAYÚSCULAS para que la BD quede uniforme.
    |--------------------------------------------------------------------------
    */

    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = $this->toUpperClean($value);
    }

    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = $this->toUpperClean($value);
    }

    public function setCargoAttribute($value)
    {
        $this->attributes['cargo'] = $this->toUpperClean($value);
    }

    public function setUnidadAttribute($value)
    {
        $this->attributes['unidad'] = $this->toUpperClean($value);
    }

    // Email normalmente se guarda en minúscula
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ? strtolower(trim($value)) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (AL MOSTRAR EN VISTAS)
    | Formatea bonito para pantalla, sin tocar la BD.
    |--------------------------------------------------------------------------
    */

    // Tu accessor original (mejorado para que salga bonito)
    public function getNombreCompletoAttribute()
    {
        // Modo oración / Title Case para mostrar
        $nombres  = $this->toTitleClean($this->nombres);
        $apellidos = $this->toTitleClean($this->apellidos);

        return trim($nombres . ' ' . $apellidos);
    }

    // Opcional: mostrar cargo bonito en vistas
    public function getCargoFormatoAttribute()
    {
        return $this->toTitleClean($this->cargo);
    }

    // Opcional: mostrar unidad bonito en vistas
    public function getUnidadFormatoAttribute()
    {
        return $this->toTitleClean($this->unidad);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS (internos)
    |--------------------------------------------------------------------------
    */

    private function toUpperClean($value): ?string
    {
        if ($value === null) return null;

        // Limpia espacios y lo pone en mayúsculas (soporta tildes)
        $value = preg_replace('/\s+/', ' ', trim($value));
        return mb_strtoupper($value, 'UTF-8');
    }

    private function toTitleClean($value): ?string
    {
        if ($value === null) return null;

        $value = preg_replace('/\s+/', ' ', trim($value));

        // Convierte a "Title Case" respetando UTF-8
        // Str::title usa mbstring internamente en Laravel
        return Str::title(mb_strtolower($value, 'UTF-8'));
    }
}