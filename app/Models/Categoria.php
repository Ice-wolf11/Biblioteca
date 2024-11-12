<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function categoria_libros(){
        return $this->hasMany(Categoria_Libro::class);
    }
}
