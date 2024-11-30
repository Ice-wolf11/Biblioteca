<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDevolucioneRequest;
use App\Models\Devolucione;
use App\Models\Penalizacione;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class devolucioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*$devoluciones = Devolucione::all();
        return view('devolucione.index',$devoluciones);
        */
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
    public function store(StoreDevolucioneRequest $request)
    {
        
        // Buscar el préstamo asociado
        $prestamo = Prestamo::findOrFail($request->validated('id_prestamo'));
        
        // Determinar si está atrasado
        $fechaActual = now();
        $estado = $fechaActual > $prestamo->fecha_limite ? 'Atrasado' : 'A tiempo';

        // Crear la devolución
        $devolucion = Devolucione::create([
            'fecha' => $request->fecha,
            'detalle' => $request->detalle,
            'estado' => $estado,
            'id_prestamo' => $request->validated('id_prestamo'),
        ]);

        // Si hay un monto en el request, crear penalización
        if ($request->filled('monto')) {
            Penalizacione::create([
                'monto' => $request->monto,
                'estado' => 'activo',
                'id_prestamo' => $request->validated('id_prestamo'),
            ]);
        }

        // Cambiar el estado del préstamo a "devuelto"
        $prestamo->update(['estado' => 'devuelto']);

        if ($request->filled('extraviado')=='si'){
            $prestamo->copia_libro->update(['estado'=> 'extraviado']); 
        }else{
            $prestamo->copia_libro->update(['estado'=> 'disponible']);
        }

        // Redirigir con un mensaje de éxito
        return redirect()
            ->route('prestamos.index')
            ->with('success', 'Devolución registrada correctamente.');
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
