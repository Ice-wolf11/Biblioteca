<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copia_libro extends Model
{
    protected $fillable = ['codigo', 'id_libro', 'estado'];
    
    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }

    public function libro(){
        return $this->belongsTo(Libro::class,'id_libro');
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
