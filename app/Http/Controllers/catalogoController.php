<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;
class catalogoController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:ver-catalogo')->only('index');
         
    }

    //filto de categorias
    public function filter(Request $request)
    {
        $categoriaId = $request->input('categoria_id');
        
        $libros = Libro::with('copia_libros')
            ->when($categoriaId, function ($query) use ($categoriaId) {
                return $query->whereHas('categoria_libros', function ($query) use ($categoriaId) {
                    $query->where('id_categoria', $categoriaId);
                });
            })
            ->get()
            ->map(function ($libro) {
                return [
                    'id' => $libro->id,
                    'titulo' => $libro->titulo,
                    'ruta_portada' => $libro->ruta_portada,
                    'copias_disponibles' => $libro->copia_libros->where('estado', 'disponible')->count(),
                ];
            });

        return response()->json($libros);
    }

    
    /*if ($categoriaId) {
                $libros = Libro::whereHas('categoria_libros', function ($query) use ($categoriaId) {
                    $query->where('id_categoria', $categoriaId);
                })->get();
            } else {
                // Si no se selecciona ninguna categoría, se devuelven todos los libros
                $libros = Libro::all();
            } */
    
/*$libros = Libro::with('copiaLibros')
            ->when($categoriaId, function ($query) use ($categoriaId) {
                return $query->whereHas('categorias', function ($query) use ($categoriaId) {
                    $query->where('id', $categoriaId);
                });
            })
            ->get()
            ->map(function ($libro) {
                return [
                    'id' => $libro->id,
                    'titulo' => $libro->titulo,
                    'ruta_portada' => $libro->ruta_portada,
                    'copias_disponibles' => $libro->copia_libros->where('estado', 'disponible')->count(),
                ];
            }); */




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
