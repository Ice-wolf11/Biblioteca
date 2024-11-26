<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Autore;
use App\Models\Categoria;
use App\Models\Categoria_libro;
use App\Models\Copia_libro;
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
        $libro = Libro::with('categorias')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro) {
        // Cargar las relaciones necesarias, incluyendo categoria_libros
        $libro->load('categoria_libros');
    
        // Cargar las categorías y autores generales
        $categoria = Categoria::all();
        $autore = Autore::all();
    
        // Obtener las copias relacionadas con el libro
        $copias = $libro->copia_libros;
    
        // Obtener las categorías a través de la relación con Categoria_libro
        $categoriasAsociadas = $libro->categoria_libros->map(function($categoria_libro) {
            return $categoria_libro->categoria; // Asumiendo que 'categoria_libro' tiene la relación correcta con 'Categoria'
        });
    
        // Retornar la vista de edición con los datos
        return view('libro.edit', [
            'libro' => $libro,
            'categorias' => $categoria,
            'autores' => $autore,
            'copias' => $copias,
            'categoriasAsociadas' => $categoriasAsociadas
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibroRequest $request, Libro $libro)
{
    try {
        DB::beginTransaction();

        // Actualizar datos del libro
        $libro->titulo = $request->validated()['titulo'];
        $libro->fecha_publicacion = $request->validated()['fecha_publicacion'];

        // Si se subió una nueva portada, procesarla
        if ($request->hasFile('portada')) {
            $archivo = Libro::handleUploadImage($request->file('portada'));
            $libro->ruta_portada = $archivo;
        }

        // Actualizar el autor si se envió
        if (isset($request->validated()['autores'][0])) {
            $libro->id_autor = $request->validated()['autores'][0];
        }

        // Guardar cambios en el libro
        $libro->save();

        // Actualizar las categorías asociadas
        $categorias = $request->validated()['categorias'];
        Categoria_libro::where('id_libro', $libro->id)->delete(); // Eliminar categorías antiguas
        foreach ($categorias as $categoria_id) {
            Categoria_libro::create([
                'id_libro' => $libro->id,
                'id_categoria' => $categoria_id,
            ]);
        }

        DB::commit();
        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$libro = Libro::findOrFail($id); // Utiliza findOrFail para manejar el caso en que no se encuentre el trámite
        /*$libro = Libro::find($id);
        $filePath = 'public/' . $libro->ruta_portada;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        //dd($filePath);
        $libro->delete();
        //Libro::where('id',$libro->id)->delete();
        return redirect()->route('libros.index')->with('success', 'Registro eliminado correctamente');
        */
        $libro = Libro::findOrFail($id); // Utiliza findOrFail para manejar el caso en que no se encuentre el trámite

        $filePath = 'public/libros/' . $libro->ruta_portada;

        try {
            // Comienza una transacción para asegurarte de que ambas operaciones (eliminación del archivo y del registro) se completen
            DB::beginTransaction();

            // Elimina el archivo PDF si existe
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Elimina el registro del trámite
            $libro->delete();

            DB::commit();

            return redirect()->route('libros.index')->with('success', 'Libro Eliminado Correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('libros.index')->with('error', 'Ocurrió un error al eliminar el Libro: ' . $e->getMessage());
        }
    }
}
