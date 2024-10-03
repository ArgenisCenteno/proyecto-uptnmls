<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Alert;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requerimientos = User::all(); // Agrega otros campos que necesites aquí
           
            //dd($requerimientos);
            return DataTables::of($requerimientos)
                ->addColumn('actions', function($row) {
                    return '<a href="'.route('usuarios.edit', [$row->id]).'" class="btn btn-info"><span class="material-icons">edit</span></a>
                            <form action="'.route('usuarios.destroy', [$row->id]).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                            </form>';
                })
                ->editColumn('fecha', function($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->editColumn('estado', function($row) {
                    if ($row->status == 'Activo') {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    }
                })
               
               
                ->rawColumns(['actions', 'estado'])
                ->make(true);
        } else {
            return view('usuarios.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        // Retornar la vista con los roles
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Asegúrate de que el campo se valide correctamente
            'password' => 'required|string|min:8',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'cedula' => 'required|string|max:20',
            'status' => 'required|in:Activo,Inactivo',
            'role' => 'required|string|exists:roles,name', // Valida que el rol existe
        ]);
    
    
        // Crear el usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Asegúrate de hashear la contraseña
            'telefono' => $validatedData['telefono'],
            'direccion' => $validatedData['direccion'],
            'cedula' => $validatedData['cedula'],
            'status' => $validatedData['status'],
        ]);
    
        // Asignar el rol al usuario
        $user->assignRole($validatedData['role']); // Utiliza el método assignRole del paquete Spatie
    
        // Redirigir o retornar una respuesta
        Alert::success('¡Exito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('usuarios.index');
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
        $roles = Role::all();
        $usuario = User::find($id);

        // Retornar la vista con los roles
        return view('usuarios.edit', compact('roles', 'usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // 1. Validar la entrada
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'cedula' => 'required|string|max:20',
        'status' => 'required|in:Activo,Inactivo',
        'role' => 'required|string|exists:roles,name',
        'password' => 'nullable|string|min:8', // Si se deja vacío, no se actualiza
    ]);

    // 2. Buscar el usuario
    $usuario = User::findOrFail($id);

    // 3. Actualizar los campos
    $usuario->name = $validatedData['name'];
    $usuario->email = $validatedData['email'];
    $usuario->telefono = $validatedData['telefono'];
    $usuario->dirrecion = $validatedData['direccion'];
    $usuario->cedula = $validatedData['cedula'];
    $usuario->status = $validatedData['status'];

    // Si se proporciona una nueva contraseña, actualizarla
    if (!empty($validatedData['password'])) {
        $usuario->password = Hash::make($validatedData['password']);
    }

    // 4. Guardar los cambios
    $usuario->save();
    Alert::success('¡Exito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

    // 5. Redirigir al usuario con un mensaje de éxito
    return redirect()->route('usuarios.index');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
