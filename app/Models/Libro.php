<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Libro extends Model
{
    protected $fillable=['titulo','fecha_publicacion','ruta_portada','id_autor'];
    //este es un comentario de prueba
    public function copia_libros(){
        return $this->hasMany(Copia_libro::class);
    }

    public function autor(){
        return $this->belongsTo(Autore::class);
    }

    public function categoria_libros(){
        return $this->hasMany(Categoria_libro::class);
    }
    /*public function categorias() { 
        return $this->belongsToMany(Categoria::class, 'categoria_libro', 'id_libro', 'id_categoria'); 
    }*/

    public static function handleUploadImage($image){
        $file = $image;
        $name = time() . $file->getClientOriginalName();
        //$file->move(public_path().'/img/libros/', $name);
        Storage::putFileAs('libros',$file,$name,'public');
        return $name;
    }

}
