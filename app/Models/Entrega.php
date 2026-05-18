<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $fillable = [
        'tarea_id',
        'estudiante_id',
        'archivo_url',
        'comentario',
        'estado',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }
}
