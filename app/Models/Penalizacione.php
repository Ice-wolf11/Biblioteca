<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalizacione extends Model
{
    protected $fillable =['monto', 'estado', 'id_prestamo'];
    public function prestamo(){
        return $this->belonsgTo(Prestamo::class,'id_prestamo');
    }
}
