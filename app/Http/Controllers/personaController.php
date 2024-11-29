<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Persona;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class personaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function search(Request $request)
     {
         $nombre = $request->input('nombre');
         $persona = Persona::where('nombres', 'LIKE', "%$nombre%")->first();  // Busca la persona por nombre
     
         if ($persona) {
             return response()->json([
                 'id' => $persona->id,
                 'nombres' => $persona->nombres,
                 'apellidos' => $persona->apellidos,
                 'dni' => $persona->dni,
                 'direccion' => $persona->direccion,
                 'telefono' => $persona->telefono,
             ]);
         } else {
             return response()->json(null);
         }
     }
      
    public function index()
    {
        $personas = Persona::with('user','area')->latest()->get();
        return view('persona.index',['personas'=>$personas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$roles = Role::all();
        $areas = Area::all();
        return view('persona.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        $firstName = explode(' ', trim($request->validated()['nombre']))[0];
        $lastName = explode(' ', trim($request->validated()['apellido']))[0];
        $fullName = $firstName . ' ' . $lastName;

        $fieldHash = Hash::make($request->password);
        $request->merge(['password' => $fieldHash]);
        try{
            //creando usuario
            DB::beginTransaction();
            //Encriptar contraseña
           
            $user = User::create([
                'name' => $fullName,
                'email' => $request->validated()['email'],
                'password' => $request->validated()['password'],

            ]);

            $persona = Persona::create([
                'nombres' => $request->validated()['nombre'],
                'apellidos' => $request->validated()['apellido'],
                'dni' => $request->validated()['dni'],
                'direccion' => $request->validated()['direccion'],
                'telefono' => $request->validated()['telefono'],
                'id_area' => $request->validated()['area'],
                'id_user' => $user->id,

            ]);
            //$user->assignRole($request->role);  ->ahorita te hago funcionar

            /*$trabajador = Trabajadore::create([
                'nombre' => $request->validated()['nombre'],
                'apellido' => $request->validated()['apellido'],
                'area_id' => $request->validated()['area'],
                'user_id' => $user->id,
            ]);*/

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('personas.index')->with('success','Usuario creado correctamente');
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
    public function edit(Persona $persona)
    {
        //$roles = Role::all();
        $areas = Area::all(); // Obtener todas las áreas
        //dd($trabajadore);
        return view('persona.edit', ['persona' => $persona, 'areas' => $areas, /*'roles' => $roles*/]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {
        $firstName = explode(' ', trim($request->validated()['nombre']))[0];
        $lastName = explode(' ', trim($request->validated()['apellido']))[0];
        $fullName = $firstName . ' ' . $lastName;

        $user = $persona->user;
        $user->name = $fullName;
        $user->email = $request->validated()['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated()['password']);
        }
        $user->save();
        //$user->syncRoles([$request->role]);

        $persona->nombres = $request->validated()['nombre'];
        $persona->apellidos = $request->validated()['apellido'];
        $persona->dni = $request->validated()['dni'];
        $persona->direccion = $request->validated()['direccion'];
        $persona->telefono = $request->validated()['telefono'];
        $persona->id_area = $request->validated()['area'];
        $persona->save();

        
        
        return redirect()->route('personas.index')->with('success', 'Usuario editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // //$area = Area::find($id);
        $user = User::find($id);
        $persona = Persona::find($id);
        $persona->user()->delete(); // Eliminar el usuario asociado
        $persona->delete(); // Eliminar el trabajador

        //Eliminar rol
        //$rolUser = $user->getRoleNames()->first();
        //$user->removeRole($rolUser);

        return redirect()->route('personas.index')->with('success', 'Usuario eliminado correctamente');
    }
}
