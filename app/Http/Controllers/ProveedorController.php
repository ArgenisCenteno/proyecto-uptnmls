<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $proveedores = Proveedor::all(); // Cargar la relación subCategoria

            return DataTables::of($proveedores)
                ->addColumn('actions', 'proveedores.actions')
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('proveedores.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos requeridos
        $validator = Validator::make($request->all(), [
            'razon_social' => 'required|string|max:255',
            'telefono' => 'required|string|max:11',
            'email' => 'required|email|max:255',
            'estado' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'parroquia' => 'required|string|max:255',
            'rif' => 'required|string|max:12',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar si ya existe un proveedor con el mismo nombre o RIF
        $existingProveedor = Proveedor::where('razon_social', $request->razon_social)
            ->orWhere('rif', $request->rif)
            ->first();

        if ($existingProveedor) {
            Alert::error('¡Error!', 'Ya existe una proveedor con ese nombre o RIF')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('proveedores.index');
        }

        // Crear un nuevo proveedor
        $proveedor = new Proveedor();
        $proveedor->razon_social = $request->razon_social;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->estado = $request->estado;
        $proveedor->municipio = $request->municipio;
        $proveedor->parroquia = $request->parroquia;
        $proveedor->rif = $request->rif;
        $proveedor->save();

        // Retornar un mensaje de éxito
        Alert::success('Exito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
       
        return redirect()->route('proveedores.index');
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
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            Alert::error('¡Error!', 'Proveedor no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('proveedores.index'));
        }

        return view('proveedores.edit')->with('proveedor', $proveedor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos ingresados
        $validatedData = $request->validate([
            'razon_social' => 'required|string|max:255|unique:proveedores,razon_social,' . $id,
            'telefono' => 'required|string|max:11',
            'email' => 'required|email|max:255',
            'estado' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'parroquia' => 'required|string|max:255',
            'rif' => 'required|string|max:10|unique:proveedores,rif,' . $id,
        ]);
    
        // Buscar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);
        if (!$proveedor) {
            Alert::error('¡Error!', 'Proveedor no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('proveedores.index'));
        }
    
        // Asignar los valores directamente
        $proveedor->razon_social = $request->razon_social;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->area = $request->area;
        $proveedor->estado = $request->estado;
        $proveedor->municipio = $request->municipio;
        $proveedor->parroquia = $request->parroquia;
        $proveedor->rif = $request->rif;
    
        // Guardar los cambios en la base de datos
        $proveedor->save();
    
        // Redireccionar con mensaje de éxito
        Alert::success('Exito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');


        return redirect()->route('proveedores.index');
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::where('id', $id)->first();
       

        if(!$proveedor){
            Alert::error('¡Error!', 'No existe este proveedor')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('proveedores.index'));
        }

        $proveedor->delete();
        Alert::success('¡Éxito!', 'Proveedor eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('proveedores.index');
    }
}
