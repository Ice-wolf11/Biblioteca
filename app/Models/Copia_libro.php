<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copia_libro extends Model
{
    
    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }

    public function libro(){
        return $this->belongsTo(Libro::class);
    }
}
