<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\Request;

class catalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //filto de categorias
    public function filter(Request $request)
    {
        $categoriaId = $request->input('categoria_id');
    
        // Si se selecciona una categoría, filtramos los libros que tengan esa categoría a través de la tabla pivote
        if ($categoriaId) {
            $libros = Libro::whereHas('categoria_libros', function ($query) use ($categoriaId) {
                $query->where('id_categoria', $categoriaId);
            })->get();
        } else {
            // Si no se selecciona ninguna categoría, se devuelven todos los libros
            $libros = Libro::all();
        }
    
        return response()->json($libros);
    }
    





    public function index()
    {
        $categorias = Categoria::all();
        $libros = Libro::paginate(8); // Cambiamos all() por paginate()
        return view('catalogo.index', ['libros' => $libros, 'categorias' => $categorias]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
