<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'materia_id',
        'profesor_id',
        'titulo',
        'descripcion',
        'fecha_limite',
    ];

    protected $casts = [
        'fecha_limite' => 'datetime',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}
