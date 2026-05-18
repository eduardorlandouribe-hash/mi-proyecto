<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable=[
            'nombre',
            'codigo',
            'creditos',
            'horario',
            'salon',
            'profesor_id',
    ];
    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
    public function materiales()
    {
        return $this->hasMany(Material::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
