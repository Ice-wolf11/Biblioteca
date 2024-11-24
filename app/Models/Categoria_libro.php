<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria_libro extends Model
{
    protected $fillable=['id_categoria','id_libro'];
    public function libro(){
        return $this->belongsTo(Libro::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class,'id_categoria');
    }
}
