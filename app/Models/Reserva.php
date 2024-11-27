<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable=['estado','id_persona','id_copia'];
    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    
}
