<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Persona;
use App\Models\Libro;
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
    public function create($id)
    {
        $persona = Persona::all();
        $libro = Libro::with('autor', 'categoria_libros.categoria', 'copia_libros')->findOrFail($id);
        return view('prestamo.create', compact('libro', 'persona'));
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
