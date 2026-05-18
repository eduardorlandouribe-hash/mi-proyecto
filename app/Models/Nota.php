<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'estudiante_id',
        'materia_id',
        'nota1',
        'nota2',
        'nota3',
    ];

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
