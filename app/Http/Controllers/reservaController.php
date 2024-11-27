<?php

namespace App\Http\Controllers;

use App\Models\Copia_libro;
use App\Models\Libro;
use App\Models\Reserva;
use Illuminate\Http\Request;

class reservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reserva.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $libro = Libro::with('autor', 'categoria_libros.categoria', 'copia_libros')->findOrFail($id);
        return view('reserva.create', compact('libro'));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'id_persona' => 'required|exists:personas,id', // Asegúrate de que la persona esté registrada
            'id_copia' => 'required|exists:copia_libros,id',
        ]);

        // Verificar que la copia esté disponible
        $copia = Copia_libro::find($request->id_copia);

        if ($copia->estado != 'disponible') {
            return redirect()->back()->with('error', 'La copia seleccionada no está disponible.');
        }

        // Crear la reserva
        $reserva = Reserva::create([
            'estado' => 'activo', // El estado de la reserva es 'activo' por defecto
            'id_persona' => $request->id_persona,
            'id_copia' => $request->id_copia,
        ]);

        // Cambiar el estado de la copia a 'reservado'
        $copia->estado = 'reservado';
        $copia->save();

        return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito.');
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
