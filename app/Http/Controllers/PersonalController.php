<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $personal = Personal::all(); // Cargar la relación subCategoria

            return DataTables::of($personal)
                ->addColumn('actions', 'personal.actions')
                ->editColumn('estado', function ($producto) {
                    if ($producto->estado == '1') {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    }
                })
                ->rawColumns(['estado', 'actions'])
                ->make(true);
        } else {
            return view('personal.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos requeridos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:11',
            'rif' => 'required|string|max:12|unique:personals,rif',
            'direccion' => 'required|string|max:255',
            'disponible' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar si ya existe un personal con el mismo nombre o RIF
        $existingPersonal = Personal::where('nombre', $request->nombre)
            ->orWhere('rif', $request->rif)
            ->first();

        if ($existingPersonal) {
            Alert::error('¡Error!', 'Ya existe un personal con ese nombre o RIF')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('personal.index');
        }

        // Crear un nuevo personal
        $personal = new Personal();
        $personal->nombre = $request->nombre;
        $personal->telefono = $request->telefono;
        $personal->rif = $request->rif;
        $personal->direccion = $request->direccion;
        $personal->estado = $request->disponible;
        $personal->area = $request->area;
        $personal->save();

        // Retornar un mensaje de éxito
        Alert::success('Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('personal.index');
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
        $personal = Personal::find($id);
        return view('personal.edit')->with('personal', $personal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validación de campos requeridos
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'telefono' => 'required|string|max:11',
       
        'direccion' => 'required|string|max:255',
        'disponible' => 'required|string|max:255',
        'area' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Buscar el registro del personal por su ID
    $personal = Personal::findOrFail($id);

    // Verificar si ya existe un personal con el mismo nombre o RIF (excluyendo el actual)
    $existingPersonal = Personal::where(function($query) use ($request) {
            $query->where('nombre', $request->nombre)
                  ->orWhere('rif', $request->rif);
        })
        ->where('id', '!=', $id)
        ->first();

    if ($existingPersonal) {
        Alert::error('¡Error!', 'Ya existe un personal con ese nombre o RIF')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('personal.index');
    }

    // Actualizar los campos del personal
    $personal->nombre = $request->nombre;
    $personal->telefono = $request->telefono;
    $personal->rif = $request->rif;
    $personal->direccion = $request->direccion;
    $personal->estado = $request->disponible;
    $personal->area = $request->area;
    $personal->save();

    // Retornar un mensaje de éxito
    Alert::success('Éxito!', 'Actualización realizada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

    return redirect()->route('personal.index');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
