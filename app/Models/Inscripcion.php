<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable =[
        'estudiante_id',
        'materia_id',
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
