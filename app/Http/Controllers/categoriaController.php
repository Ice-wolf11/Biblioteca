<?php

namespace App\Http\Controllers;

Use Exception;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class categoriaController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:ver-categoria')->only('index');
        $this->middleware('can:crear-categoria')->only('create', 'store');
        $this->middleware('can:editar-categoria')->only('edit', 'update');
        $this->middleware('can:eliminar-categoria')->only('destroy');   
    }
    public function index()
    {
        $categoria = Categoria::all();
        return view('categoria.index',['categorias'=>$categoria]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        try{
            DB::beginTransaction();
            $area = Categoria::create([
                'nombre' => $request->validated()['nombre'],
                'descripcion' => $request->validated()['descripcion']
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('categorias.index')->with('success','Categoria creada correctamente');
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
    public function edit(Categoria $categoria)
    {
        //dd($categoria);
        return view('categoria.edit',['categoria'=> $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        
        Categoria::where('id',$categoria->id)->update($request->validated());
        
        return redirect()->route('categorias.index')->with('success','Registro editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        Categoria::where('id',$categoria->id)->delete();
        return redirect()->route('categorias.index')->with('success','Registro eliminado correctamente');
    }
}
