<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'materia_id',
        'profesor_id',
        'nombre',
        'tipo',
        'url',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
}
