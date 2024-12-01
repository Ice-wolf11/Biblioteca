<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamo_catalogoRequest;
use App\Http\Requests\StorePrestamo_reservaRequest;
use App\Models\Copia_libro;
use App\Models\Prestamo;
use App\Models\Persona;
use App\Models\Libro;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class prestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $prestamos = Prestamo::with('persona','copia_libro')->latest()->get();
        return view('prestamo.index',['prestamos'=>$prestamos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_catalogo($id)
    {
        $persona = Persona::all();
        $libro = Libro::with('autor', 'categoria_libros.categoria', 'copia_libros')->findOrFail($id);
        return view('prestamo.create-catalogo', compact('libro', 'persona'));
    }
    public function create_reserva($id)
    {
        // Buscar la reserva por ID y cargar relaciones necesarias
        $reserva = Reserva::with(['persona', 'copia_libro.libro'])->findOrFail($id);
    
        // Pasar los datos de la reserva a la vista
        return view('prestamo.create-reserva', compact('reserva'));
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store_catalogo(StorePrestamo_catalogoRequest $request)
    {
        // Validar los datos del request
        $validatedData = $request->validated();

        // Verificar si la persona ya tiene un préstamo activo
        $usuarioConPrestamoActivo = Prestamo::where('id_persona', $validatedData['id_persona'])
            ->where('estado', 'activo')
            ->exists();
        $usuarioConReserva = Reserva::where('id_persona', $request->id_persona)
            ->where('estado', 'activo')
            ->exists();
        $persona = Persona::with('prestamos.penalizacione')->findOrFail($request->id_persona);

        $tienePenalizacionActiva = $persona->prestamos->contains(function ($prestamo) {
            return $prestamo->penalizacione && $prestamo->penalizacione->estado === 'activo';
        });
        
        if ($usuarioConPrestamoActivo) {
            // Redirigir a la misma página con un mensaje de error
            return back()->with('error', 'La persona ya tiene un préstamo activo. No puede tener más de un préstamo a la vez.');
        }
        if ($usuarioConReserva) {
            return redirect()->back()->with('error', 'Ya tienes una reserva activa. Solo puedes reservar un libro a la vez.');
        }
        if ($tienePenalizacionActiva) {
            return redirect()->back()->with('error', 'Tienes una penalización pendiente. Por favor, resuélvela.');
        }


        try {
            // Iniciar una transacción para garantizar la integridad de los datos
            DB::beginTransaction();

            // Crear el préstamo
            $prestamo = Prestamo::create([
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_limite' => $validatedData['fecha_fin'],
                'estado' => 'activo', // Préstamo activo
                'id_persona' => $validatedData['id_persona'],
                'id_copia' => $validatedData['id_copia'],
            ]);

            // Actualizar el estado de la copia
            $copia = Copia_libro::find($validatedData['id_copia']);
            $copia->update(['estado' => 'prestado']);

            // Confirmar la transacción
            DB::commit();

            // Redirigir con éxito y mostrar mensaje de éxito
            return redirect()->route('prestamos.index')
                            ->with('success', 'Préstamo realizado exitosamente.');

        } catch (\Exception $e) {
            // Revertir si ocurre un error
            DB::rollBack();
            //\Log::error('Error al crear el préstamo: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al crear el préstamo.');
        }
    }



    public function store_reserva(StorePrestamo_reservaRequest $request)
    {
        // Validar los datos del request
        $validatedData = $request->validated();

        // Verificar si la persona ya tiene un préstamo activo
        $usuarioConPrestamoActivo = Prestamo::where('id_persona', $validatedData['id_persona'])
            ->where('estado', 'activo')
            ->exists();
        $usuarioConReserva = Reserva::where('id_persona', $request->id_persona)
            ->where('estado', 'activo')
            ->exists();
        $persona = Persona::with('prestamos.penalizacione')->findOrFail($request->id_persona);

        $tienePenalizacionActiva = $persona->prestamos->contains(function ($prestamo) {
            return $prestamo->penalizacione && $prestamo->penalizacione->estado === 'activo';
        });
        
        if ($usuarioConPrestamoActivo) {
            // Redirigir a la misma página con un mensaje de error
            return back()->with('error', 'La persona ya tiene un préstamo activo. No puede tener más de un préstamo a la vez.');
        }
        if ($usuarioConReserva) {
            return redirect()->back()->with('error', 'Ya tienes una reserva activa. Solo puedes reservar un libro a la vez.');
        }
        if ($tienePenalizacionActiva) {
            return redirect()->back()->with('error', 'Tienes una penalización pendiente. Por favor, resuélvela.');
        }
        try {
            // Iniciar una transacción para garantizar la integridad de los datos
            DB::beginTransaction();

            // Crear el préstamo
            $prestamo = Prestamo::create([
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_limite' => $validatedData['fecha_fin'],
                'estado' => 'activo', // Préstamo activo
                'id_persona' => $validatedData['id_persona'],
                'id_copia' => $validatedData['id_copia'],
            ]);

            // Actualizar el estado de la copia
            $copia = Copia_libro::find($validatedData['id_copia']);
            $copia->update(['estado' => 'prestado']);

            // Actualizar el estado de la reserva a "inactivo"
            $reserva = Reserva::find($request->input('id_reserva'));
            if ($reserva) {
                $reserva->update(['estado' => 'inactivo']);
            }

            // Confirmar la transacción
            DB::commit();

            // Redirigir con éxito y mostrar mensaje de éxito
            return redirect()->route('prestamos.index')
                            ->with('success', 'Préstamo realizado exitosamente.');

        } catch (\Exception $e) {
            // Revertir si ocurre un error
            DB::rollBack();
            //\Log::error('Error al crear el préstamo: ' . $e->getMessage());
            return back()->with('error', 'Hubo un error al crear el préstamo.');
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
        $prestamo = Prestamo::find($id);
        
            // Cambiar el estado de la copia a 'disponible'
            $prestamo->copia_libro->estado = 'disponible';
            $prestamo->copia_libro->save();
        

        $prestamo->delete();
        //Prestamo::where('id',$prestamo->id)->delete;
        return redirect()->route('prestamos.index')->with('success','Registro eliminado correctamente');
    }
}
