<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
    
    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
}

