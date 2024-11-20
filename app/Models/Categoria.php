<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //protected $table = 'categorias';
    public function categoria_libros(){
        return $this->hasMany(Categoria_libro::class);
    }
    /*public function libros() { 
        return $this->belongsToMany(Libro::class, 'categoria_libro', 'id_categoria', 'id_libro');
    }*/
    protected $fillable=['nombre','descripcion'];
}
