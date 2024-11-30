<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePenalizacioneRequest;
use App\Models\Penalizacione;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class penalizacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, Penalizacione $penalizacione)
    {
        // Validar el estado recibido
        $validated = $request->validate([
            'estado_penalizacion' => 'required|in:activo,pagado,anulado',
        ]);

        // Buscar la penalización por su ID
        //$penalizacion = Penalizacione::findOrFail();

        // Actualizar el estado de la penalización
        $penalizacione->estado = $request->estado_penalizacion;
        $penalizacione->save(); // Guardar los cambios

        // Redirigir a la página anterior con un mensaje de éxito
        return redirect()->back()->with('success', 'Estado de la penalización actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
