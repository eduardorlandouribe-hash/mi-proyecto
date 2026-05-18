<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable= [
        'numero',
        'estudiante_id',
        'total',
        'estado',
    ];
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }
}
