<?php

namespace App\Http\Controllers;

use App\Models\Tasa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
class TasasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tasas = Tasa::all();
    
            return DataTables::of($tasas)
                ->addColumn('status', function ($tasa) {
                    if ($tasa->status == 'Inactivo') {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    } elseif ($tasa->status == 'Activo') {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($tasa) {
                    return $tasa->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('actions', 'tasas.actions')
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('tasas.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tasa = Tasa::where('name', $request->name)->first();
        

        if($tasa){
            Alert::error('¡Error!', 'Existe una tasa con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('tasas.index'));
        }

        $crear = Tasa::create([
            'name' => $request->name,
            'valor' => $request->valor,
            'status' => 'Activo'
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Tasa registrada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la tasa')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('tasas.index'));
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
    public function edit(Request $request, $id)
    {
        $tasa = Tasa::find($id);
        return view('tasas.edit')->with('tasa', $tasa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
        ]);
    
        try {
            // Buscar la tasa por su id
            $tasa = Tasa::findOrFail($id);
    
            // Verificar si existe otra tasa con el mismo nombre
            $tasaExistente = Tasa::where('name', $request->name)->where('id', '!=', $id)->first();
            if ($tasaExistente) {
                Alert::error('¡Error!', 'Ya existe una tasa con ese nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect(route('tasas.index'));
            }
    
            // Actualizar la tasa
            $tasa->update([
                'name' => $request->name,
                'valor' => $request->valor,
                'status' => 'Activo',
            ]);
    
            // Mensaje de éxito
            Alert::success('¡Éxito!', 'Tasa actualizada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } catch (\Exception $e) {
            // Manejo de errores
            Alert::error('¡Error!', 'Error al intentar actualizar la tasa: ' . $e->getMessage())->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('tasas.index'));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tasa = Tasa::where('id', $id)->first();
       

        if(!$tasa){
            Alert::error('¡Error!', 'No existe esta tasa')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }

        $tasa->delete();
        Alert::success('¡Éxito!', 'Tasa eliminada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('tasas.index');
    }
}
