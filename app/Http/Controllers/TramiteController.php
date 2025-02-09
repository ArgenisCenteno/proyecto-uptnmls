<?php

namespace App\Http\Controllers;

use App\Exports\TramitesExport;
use App\Models\Asignacion;
use App\Models\Producto;
use App\Models\ProductoAsignado;
use App\Models\ProductoOrdenado;
use App\Models\ProductoPendiente;
use App\Models\Requerimiento;
use App\Models\Solicitud;
use App\Models\Tramites;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Alert;
class TramiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tramites = Tramites::with('user', 'personal')->get();
            return DataTables::of($tramites)
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('tramites.edit', [$row->id]) . '" class="btn btn-info"><span class="material-icons">edit</span></a>
                        <form action="' . route('tramites.destroy', [$row->id]) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                        </form>';
                })
                ->editColumn('fecha', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->editColumn('usuario', function ($row) {
                    return $row->user->name;
                })
                ->editColumn('estado', function ($row) {
                    // Verifica el estado y devuelve un badge con el color adecuado
                    switch ($row->estado) {
                        case 'pendiente':
                            return '<span class="badge badge-danger">Pendiente</span>';
                        case 'en_proceso':
                            return '<span class="badge badge-warning">En Proceso</span>';
                        case 'completado':
                            return '<span class="badge badge-success">Completado</span>';
                        case 'rechazado':
                            return '<span class="badge badge-dark">Rechazado</span>';
                        default:
                            return '<span class="badge badge-secondary">' . $row->estado . '</span>';
                    }
                })
                ->rawColumns(['actions', 'estado'])
                ->make(true);
        } else {
            return view('tramites.index');
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tramite = Tramites::find($id);

        if (!$tramite) {
            Alert::error('¡Error!', 'Este tramite no existe')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('tramites.index'); // Redirigir al index

        }

        if ($tramite->tipo == 'ASIGNACION DE CONSUMIBLES') {

            $movimiento = Asignacion::where('tramite_id', $tramite->id)->first();
            $productos = ProductoAsignado::where('asignacion_id', $movimiento->id)->get();

        } else if ($tramite->tipo == 'SOLICITUD DE CONSUMIBLES') {
            $movimiento = Solicitud::where('tramite_id', $tramite->id)->first();
            $productos = ProductoOrdenado::where('solicitud_id', $movimiento->id)->get();
        } else if ($tramite->tipo == 'DEVOLUCIÓN DE PRODUCTOS') {


            $productos = ProductoPendiente::where('tramite_id', $tramite->id)->get();
            if (!$productos) {
                Alert::error('¡Error!', 'No hay productos para esta devolución')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return view('tramites.index');
            }
            $movimiento = Asignacion::where('id', $productos[0]->producto_asignado_id)->first();


        } else {
            Alert::error('¡Error!', 'Tramite invalido')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return view('tramites.index');
        }



        return view('tramites.edit')->with('tramite', $tramite)->with('movimiento', $movimiento)->with('productos', $productos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtener el trámite
        $tramite = Tramites::find($id);

        if (!$tramite) {
            Alert::error('¡Error!', 'Este trámite no existe')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('tramites.index');
        }



        $nuevoStatus = $request->input('status');

        if ($nuevoStatus == 'completado' && $tramite->estado == 'completado') {
            Alert::error('¡Error!', 'Este tramite ya se encuentra completado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('tramites.index');
        } elseif ($nuevoStatus == 'rechazado' && $tramite->estado == 'rechazado') {
            Alert::error('¡Error!', 'Este tramite ya se encuentra rechazado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('tramites.index');
        } else if ($nuevoStatus != 'rechazado' && $tramite->estado == 'rechazado') {
            Alert::error('¡Error!', 'Un tramite rechazado no puede pasar a un estado superior, debe crear un tramite nuevo para proceder')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('tramites.index');
        } else if ($nuevoStatus == 'pendiente' && $tramite->estado != 'pendiente') {
            Alert::error('¡Error!', 'Un tramite en estado no superior no puede volver a estar pendiente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('tramites.index');
        }


        if ($tramite->tipo == 'ASIGNACION DE CONSUMIBLES') {
            $asignacion = Asignacion::where('tramite_id', $tramite->id)->first();
            $productosAsignados = ProductoAsignado::where('asignacion_id', $asignacion->id)->get();

            if ($tramite->estado != 'completado' && $nuevoStatus == 'completado') {
                // Descontar productos del stock para asignación completada
                foreach ($productosAsignados as $productoAsignado) {
                    $producto = Producto::find($productoAsignado->producto_id);


                    $producto->cantidad -= $productoAsignado->cantidad;
                    $producto->save();
                    if ($producto->cantidad == 0) {

                        $producto->disponible = 0;

                        $producto->save();
                    }



                }
            } elseif ($tramite->estado == 'completado' && $nuevoStatus == 'rechazado') {
                // Sumar productos de vuelta al stock si el trámite fue completado y se rechaza
                foreach ($productosAsignados as $productoAsignado) {
                    $producto = Producto::find($productoAsignado->producto_id);
                    $producto->cantidad += $productoAsignado->cantidad;
                    $producto->save();
                }

                $requerimiento = Requerimiento::find($asignacion->requerimiento_id);
                $requerimiento->status = 'Pendiente';
                $requerimiento->save();

            }
            $asignacion->status = $nuevoStatus;
            $asignacion->save();
        } elseif ($tramite->tipo == 'SOLICITUD DE CONSUMIBLES') {
            $solicitud = Solicitud::where('tramite_id', $tramite->id)->first();
            $productosSolicitados = ProductoOrdenado::where('solicitud_id', $solicitud->id)->get();

            if ($tramite->estado != 'completado' && $nuevoStatus == 'completado') {
                // Sumar productos al stock para solicitud completada
                foreach ($productosSolicitados as $productoSolicitado) {
                    $producto = Producto::find($productoSolicitado->producto_id);
                    $producto->cantidad += $productoSolicitado->cantidad;
                    $producto->save();
                }
            } elseif ($tramite->estado == 'completado' && $nuevoStatus == 'rechazado') {
                // Descontar productos del stock si el trámite fue completado y se rechaza
                foreach ($productosSolicitados as $productoSolicitado) {
                    $producto = Producto::find($productoSolicitado->producto_id);
                    $producto->cantidad -= $productoSolicitado->cantidad;
                    $producto->save();
                }

                $requerimiento = Requerimiento::find($solicitud->requerimiento_id);
                $requerimiento->status = 'Pendiente';
                $requerimiento->save();

            }

            $solicitud->status = $nuevoStatus;
            $solicitud->save();
        } else {
            $productosPendientes = ProductoPendiente::where('tramite_id', $tramite->id)->get();

            if ($request->status = 'completado') {
                foreach ($productosPendientes as $dato) {



                    $producto = ProductoAsignado::find($dato->producto_asignado_id);
                    if ($producto) {
                        $producto->estado = 'Devuelto';
                        $producto->save();
                        $dato->fecha_entrega = Carbon::now();
                        $dato->save();

                        $tramite->descripcion = $request->descripcion;
                        $tramite->save();

                        $inventario = Producto::find($producto->producto_id);
                        $inventario->cantidad += $dato->cantidad;
                    
                        $inventario->save();


                        if($inventario->cantidad > 0){
                            $inventario->Disponible = 1;
                            $inventario->save();
                        }

                    }
                }
            } elseif ($request->status = 'cancelado')
                foreach ($productosPendientes as $dato) {



                    $producto = ProductoAsignado::find($dato->producto_asignado_id);
                    if ($producto) {
                        $producto->estado = 'Cancelado';
                        $producto->save();
                        $dato->fecha_entrega = Carbon::now();
                        $dato->save();

                        if($request->descripcion){
                            $tramite->descripcion = $request->descripcion;
                            $tramite->save();
                        }
                        
                    }
                }
        }

        // Cambiar el estado del trámite
        $tramite->estado = $nuevoStatus;
        $tramite->save();

        // Redirigir con mensaje de éxito
        Alert::success('¡Éxito!', 'El trámite ha sido actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('tramites.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the Tramites record by ID
        $tramite = Tramites::find($id);

        // Check if the record exists
        if (!$tramite) {
            return redirect()->route('tramites.index')->with('error', 'Trámite not found.');
        }

        // Delete the record
        $tramite->delete();

        // Redirect back with a success message
        Alert::success('Exito!', 'Registro eliminado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('tramites.index')->with('success', 'Trámite deleted successfully.');
    }

    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($toDate < $fromDate) {
            // Usar SweetAlert para mostrar el error
            Alert::error('¡Error!', 'La fecha final no puede ser menor a la fecha de inicio.')
                ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return view('tramites.index');
        }

        return Excel::download(new TramitesExport($fromDate, $toDate), 'tramites.xlsx');
    }
}
