<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalizacione extends Model
{
    public function prestamo(){
        return $this->belonsgTo(Prestamo::class);
    }
}
