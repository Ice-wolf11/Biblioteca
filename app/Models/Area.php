<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable =['descripcion'];
    public function personas(){
        return $this->hasMany(Persona::class);
    }
}
