<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStatus extends Model
{
    use HasFactory;

    // Configura las columnas que pueden ser llenadas
    protected $fillable = ['name'];

    // Relación con el modelo Asset
   public function status()
    {
        return $this->belongsTo(AssetStatus::class);  // Relación inversa
    }
}
