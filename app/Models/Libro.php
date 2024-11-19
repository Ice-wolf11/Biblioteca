<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    //este es un comentario de prueba
    public function copia_libros(){
        return $this->hasMany(Copia_libro::class);
    }

    public function autor(){
        return $this->belongsTo(Autore::class);
    }

    public function categoria_libros(){
        return $this->hasMany(Categoria_Libro::class);
    }
}
