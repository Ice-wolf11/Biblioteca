<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Copia_libro;
class copia_libroController extends Controller
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
        Copia_libro::where('id',$copia->id)->delete();
        return redirect()->route('libros.edit', ['libro' => $libro])->with('success', 'Registro eliminado correctamente');

    }
}
