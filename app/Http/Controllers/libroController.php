<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\StoreLibroRequest;
use App\Models\Autore;
use App\Models\Categoria;
use App\Models\Categoria_libro;
use App\Models\Libro;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class libroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libro = Libro::all();
        return view('libro.index',['libros'=>$libro]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoria = Categoria::all();
        $autore = Autore::all();
        return view('libro.create',['categorias'=>$categoria, 'autores'=>$autore]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(StoreLibroRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $archivo = Libro::handleUploadImage($request->file('portada'));

            $libro = Libro::create([
                'titulo' => $request->validated()['titulo'],
                'fecha_publicacion' => $request->validated()['fecha'],
                'ruta_portada' => $archivo,
                'id_autor'=>$request->validated()['autores'],
            ]);

            //$libro->categorias()->sync($request->validated()['categorias']);
            $cat_libro = Categoria_libro::create([
                'id_categoria' => $request->validated()['categorias'], 
                //'id_libro' =>  
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('libros.index')->with('success','Libro agregado Correctamente');
        
    }*/
    public function store(StoreLibroRequest $request)
{
    try {
        DB::beginTransaction();

        // Subir la imagen
        $archivo = Libro::handleUploadImage($request->file('portada'));

        // Crear el libro
        $libro = Libro::create([
            'titulo' => $request->validated()['titulo'],
            'fecha_publicacion' => $request->validated()['fecha'],
            'ruta_portada' => $archivo,
            'id_autor' => $request->validated()['autores'][0],
        ]);

        // Crear registros en categoria_libro
        foreach ($request->validated()['categorias'] as $categoria_id) {
            Categoria_libro::create([
                'id_libro' => $libro->id,
                'id_categoria' => $categoria_id,
            ]);
        }

        DB::commit();
        return redirect()->route('libros.index')->with('success', 'Libro agregado correctamente.');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
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
