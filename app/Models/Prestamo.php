<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable=['fecha_limite','fecha_inicio','estado','id_persona','id_copia'];
    public function persona(){
        return $this->belongsTo(Persona::class,'id_persona');
    }

    public function devolucione(){
        return $this->hasOne(Devolucione::class);
    }

    public function penalizacione(){
        return $this->hasOne(Penalizacione::class);
    }

    public function copia_libro(){
        return $this->belongsTo(Copia_libro::class,'id_copia');
    }
}
