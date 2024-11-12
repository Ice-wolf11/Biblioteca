<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria_libro extends Model
{
    public function libro(){
        return $this->belongsTo(Libro::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
