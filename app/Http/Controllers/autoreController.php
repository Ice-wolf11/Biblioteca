<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\StoreAutoreRequest;
use App\Http\Requests\UpdateAutoreRequest;
use App\Models\Autore;
use Illuminate\Container\Attributes\DB as AttributesDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class autoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {   
        $this->middleware('can:ver-autor')->only('index');
        $this->middleware('can:crear-autor')->only('create', 'store');
        $this->middleware('can:editar-autor')->only('edit', 'update');
        $this->middleware('can:eliminar-autor')->only('destroy');   
    }

    public function index()
    {
        $autore = Autore::all();
        return view('autore.index',['autores'=>$autore]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('autore.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAutoreRequest $request)
    {
        //dd($request);
        try{
            
            DB::beginTransaction();
            $autor = Autore::create([
                'nombre' => $request->validated()['nombre'],
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('autores.index')->with('success','Autor agregado Correctamente');
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
    public function edit(Autore $autore)
    {
        return view('autore.edit',['autore'=>$autore]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAutoreRequest $request, Autore $autore)
    {
        Autore::where('id',$autore->id)->update($request->validated());
        
        return redirect()->route('autores.index')->with('success','Registro editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autore = Autore::find($id);
        Autore::where('id',$autore->id)->delete();
        return redirect()->route('autores.index')->with('success','Registro eliminado correctamente');
    }
}
