<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Caja;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Flash;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $caja = Caja::all();
    
            return DataTables::of($caja)
                ->addColumn('status', function ($categoria) {
                    if ($categoria->activa == 0) {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    } elseif ($categoria->activa == 1) {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($categoria) {
                    return $categoria->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('actions', 'caja.actions')
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('caja.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consultar = Caja::where('nombre', $request->nombre)->first();
        
       

        if($consultar){
            Alert::error('¡Error!', 'Existe una caja con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $crear = Caja::create([
            'nombre' => $request->nombre,
            'activa' => $request->status
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('cajas.index'));
    }

    /**
     * Display the specified resource.
     */
    public function aperturarCaja(string $id)
    {
        $caja = Caja::where('id', $id)->where('activa', 1)->first();



        if(!$caja){
            Alert::error('¡Error!', 'No se puede abrir una caja inactiva')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('cajas.index'));
        }

        return view('caja.abrirCaja')->with('caja', $caja);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $caja = Caja::findOrFail($id);

        return view('caja.edit')->with('caja', $caja);
    }

    /**  
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actualizar = Caja::where('id', $id)->first();
       

        if(!$actualizar){
            Alert::error('¡Error!', 'No existe esta caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $actualizar->update([
            'nombre' => $request->nombre,
            'status' => $request->status
        ]);
        if ($actualizar) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar actualizar la caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('cajas.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $caja = Caja::where('id', $id)->first();
       

        if(!$caja){
            Alert::error('¡Error!', 'No existe esta caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $caja->delete();
        Alert::success('¡Éxito!', 'Caja eliminada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('cajas.index');
    }

    public function registrarApertura(Request $request, $id)
    {
       
      
      
        // Crear el registro de apertura de caja
        $aperturaCaja = AperturaCaja::create([
            'caja_id' => $id,
            'usuario_id' => Auth::id(), // Asigna el ID del usuario autenticado
            'monto_inicial_bolivares' => $request->input('monto_inicial_bolivares'),
            'monto_inicial_dolares' => $request->input('monto_inicial_dolares'),
            'apertura' => now(), // Asigna la fecha y hora actuales
        ]);

        // Devolver una respuesta
        Alert::success('¡Éxito!', 'Caja aperturada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('cajas.index');
    }
}
