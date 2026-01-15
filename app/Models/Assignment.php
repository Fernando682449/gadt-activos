<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'asset_id','custodian_id','location_id','tipo_movimiento',
        'fecha_asignacion','observaciones','user_id'
    ];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function custodian() { return $this->belongsTo(Custodian::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function user() { return $this->belongsTo(User::class); }
}
