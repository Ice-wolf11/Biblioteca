<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucione extends Model
{
    protected $fillable =['fecha','detalle','estado', 'id_prestamo'];

    public function prestamo(){
        return $this->belongsTo(Prestamo::class,'id_prestamo');
    }
}
