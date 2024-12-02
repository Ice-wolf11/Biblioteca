<?php

namespace App\Http\Controllers;

use App\Models\Copia_libro;
use App\Models\Libro;
use App\Models\Penalizacione;
use App\Models\Persona;
use App\Models\Prestamo;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class reservaController extends Controller
{
    public function __construct()
    {   
        $this->middleware('permission:ver-reserva|ver-mis-reservas')->only('index');
        $this->middleware('can:crear-reserva')->only('create', 'store');
        $this->middleware('can:eliminar-reserva')->only('destroy');
        
    }
    
    public function index()
    {
        $reservas = Reserva::with('persona','copia_libro')->latest()->get();
        return view('reserva.index',['reservas'=>$reservas]);
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

    // Verificar si el usuario ya tiene una reserva activa
    $usuarioConReserva = Reserva::where('id_persona', $request->id_persona)
        ->where('estado', 'activo')
        ->exists();

    $usuarioConPrestamo = Prestamo::where('id_persona', $request->id_persona)
        ->where('estado', 'activo')
        ->exists();
    
    $persona = Persona::with('prestamos.penalizacione')->findOrFail($request->id_persona);

    $tienePenalizacionActiva = $persona->prestamos->contains(function ($prestamo) {
        return $prestamo->penalizacione && $prestamo->penalizacione->estado === 'activo';
    });
    /*$usuarioConPenalizacion = Penalizacione::where('id_prestamo', $request->id_persona)
        ->where('estado', 'activo')
        ->exists();*/
    

    if ($usuarioConReserva) {
        return redirect()->back()->with('error', 'Ya tienes una reserva activa. Solo puedes reservar un libro a la vez.');
    }
    if ($usuarioConPrestamo) {
        return redirect()->back()->with('error', 'Ya tienes un prestamo activo. Solo puedes reservar un libro a la vez.');
    }
    if ($tienePenalizacionActiva) {
        return redirect()->back()->with('error', 'Tienes una penalización pendiente. Por favor, resuélvela.');
    }

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
        $reserva = Reserva::find($id);
        // Verificar si la reserva tiene una copia asociada
        
            // Cambiar el estado de la copia a 'disponible'
            $reserva->copia_libro->estado = 'disponible';
            $reserva->copia_libro->save();
        

        // Eliminar la reserva
        $reserva->delete();

        Reserva::where('id',$reserva->id)->delete();

        return redirect()->route('reservas.index')->with('success','Registro eliminado correctamente');
    }
}
