<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucione extends Model
{
    public function prestamo(){
        return $this->belongsTo(Prestamo::class);
    }
}
