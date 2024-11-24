<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Copia_libro;
use App\Models\Libro;

class copia_libroController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Libro $libro)
    {
        // No se requiere implementación ya que el formulario se maneja en la vista principal con un modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del request
        $validated = $request->validate([
            'codigo' => 'required|string|max:255|unique:copia_libros,codigo',
            'libro_id' => 'required|exists:libros,id',
        ]);

        // Crear una nueva copia del libro
        Copia_libro::create([
            'codigo' => $validated['codigo'],
            'id_libro' => $validated['libro_id'],
        ]);

        return redirect()->route('libros.edit', ['libro' => $validated['libro_id']])->with('success', 'Copia agregada correctamente.');
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
        $copia = Copia_libro::find($id);
        $libro = $copia->id_libro;
        Copia_libro::where('id', $copia->id)->delete();
        return redirect()->route('libros.edit', ['libro' => $libro])->with('success', 'Registro eliminado correctamente');
    }
}
