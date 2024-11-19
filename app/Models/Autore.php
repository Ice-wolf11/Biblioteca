<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autore extends Model
{
    public function libros(){
        return $this->hasMany(Libro::class);
    }
    protected $fillable=['nombre'];
}
