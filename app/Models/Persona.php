<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'direccion',
        'telefono',
        'id_area',
        'id_user'
    ];
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function area(){
        return $this->belongsTo(Area::class,'id_area');
    }
    
    public function reservas(){
        return $this->hasMany(Reserva::class,'id_persona');
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class,'id_persona');
    }
}

