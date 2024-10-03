<?php

namespace App\Http\Controllers;

use App\Exports\SolicitudExport;
use App\Models\Producto;
use App\Models\ProductoOrdenado;
use App\Models\Proveedor;
use App\Models\Requerimiento;
use App\Models\Solicitud;
use App\Models\Tramites;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Alert;
class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $solicitudes = Solicitud::with('user', 'proveedor')->get();
    
            return DataTables::of($solicitudes)
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('solicitudes.edit', [$row->id]) . '" class="btn btn-info"><span class="material-icons">edit</span></a>
                        <form action="' . route('solicitudes.destroy', [$row->id]) . '" method="POST" style="display:inline;">
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
                ->editColumn('proveedor', function ($row) {
                    return $row->proveedor->razon_social;
                })
                ->editColumn('tramite', function ($row) {
                    return $row->tramite_id;
                })
                ->editColumn('status', function ($row) {
                    // Verifica el estado y devuelve un badge con el color adecuado
                    switch ($row->status) {
                        case 'pendiente':
                            return '<span class="badge badge-danger">Pendiente</span>';
                        case 'completado':
                            return '<span class="badge badge-success">Completado</span>';
                        default:
                            return '<span class="badge badge-secondary">'.$row->status.'</span>';
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('solicitudes.index');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $requerimientos = Requerimiento::where('tipo', 'SOLICITUD')->where('status', 'SIN PROCESAR')->get();
        return view('solicitudes.create')->with('proveedores', $proveedores)->with('requerimientos', $requerimientos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obtener el requerimiento
        $requerimiento = Requerimiento::find($request->requerimiento);

        if (!$requerimiento) {
            Alert::error('!Error!', 'Requerimiento no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('requerimientos.index');
        }

        // Crear el tramite
        $tramite = new Tramites();
        $tramite->fecha = Carbon::now();
        $tramite->tipo = 'SOLICITUD DE CONSUMIBLES';
        $tramite->descripcion = $requerimiento->descripcion;
        $tramite->creado_por = auth()->id();
        $tramite->estado = 'pendiente';
        $tramite->save();

        // Crear la solicitud
        $now = Carbon::now();
        $solicitud = new Solicitud();
        $solicitud->fecha = $now;
        $solicitud->descripcion = $requerimiento->descripcion;
        $solicitud->proveedor_id = $request->proveedor;
        $solicitud->creado_por = auth()->id();
        $solicitud->status = 'pendiente';
        $solicitud->financiamiento = $request->financiamiento;
        $solicitud->requerimiento_id = $requerimiento->id;
        $solicitud->tramite_id = $tramite->id;
        $solicitud->save();



        $productos = is_string($request->productos) ? json_decode($request->productos, true) : $request->productos;

        // Debug the structure of productos
        // dd($productos); // Inspect the structure
    
        foreach ($productos as $productoData) {
           $a = json_decode($productoData, true);
            // Ensure productoData is treated as an array
            if (is_array($a)) {
                // Verify the keys exist before accessing them
                $nombre = $a['nombre'] ?? null;
                $cantidad = $a['cantidad'] ?? null;
    
                // Debug to verify contents
                // dd($nombre, $cantidad); // Check what we're getting
    
                // Busca el producto en la base de datos
                $producto = Producto::where('nombre', $nombre)->first();
    
                // Crea una nueva instancia de ProductoOrdenado
                $productoOrdenado = new ProductoOrdenado();
                $productoOrdenado->fecha = now(); // Usa Carbon directamente para la fecha actual
                $productoOrdenado->cantidad = $cantidad;
                $productoOrdenado->producto_id = $producto ? $producto->id : null; // Maneja caso donde no se encuentra el producto
                $productoOrdenado->solicitud_id = $solicitud->id;
    
                // Guarda la instancia
                $productoOrdenado->save();
            } else {
                // If productoData is not an array, output an error
                dd("Error: productoData is not an array", $productoData);
            }
        }


        $requerimiento->status = 'Procesada';
        $requerimiento->save();
        Alert::success('Exito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('solicitudes.index');
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
        
        $solicitud = Solicitud::find($id);

     //  dd($solicitud->id);
        $productos = ProductoOrdenado::where('solicitud_id', $solicitud->id)->get();
        $proveedores = Proveedor::all();
        $requerimientos = Requerimiento::where('tipo', 'SOLICITUD')->where('status', 'SIN PROCESAR')->orWhere('id', $solicitud->requerimiento_id)->get();
        return view('solicitudes.edit')->with('proveedores', $proveedores)->with('requerimientos', $requerimientos)->with('solicitud', $solicitud)->with('productos', $productos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar la solicitud por ID
        $solicitud = Solicitud::findOrFail($id);
    
        // Actualizar los campos principales de la solicitud
        $solicitud->proveedor_id = $request->input('proveedor');
        $solicitud->financiamiento = $request->input('financiamiento');
        $solicitud->requerimiento_id = $request->input('requerimiento');
        $solicitud->save();
    
        // Obtener los productos enviados en la solicitud (productos seleccionados en el formulario)
        $productosEnFormulario = is_string($request->productos) ? json_decode($request->productos, true) : $request->productos;
    
        // Obtener los productos actuales asociados a la solicitud
        $productosExistentes = ProductoOrdenado::where('solicitud_id', $solicitud->id)->get();
    
        // Guardar IDs de productos seleccionados en el formulario
        $productosIdsEnFormulario = [];
    
        // Actualizar o agregar productos
        foreach ($productosEnFormulario as $productoData) {
            $productoArray = json_decode($productoData, true);
    
            if (is_array($productoArray)) {
                $nombre = $productoArray['nombre'] ?? null;
                $cantidad = $productoArray['cantidad'] ?? null;
    
                // Buscar el producto en la base de datos por nombre
                $producto = Producto::where('nombre', $nombre)->first();
    
                if ($producto) {
                    // Guardar el producto_id en el array para la comparación posterior
                    $productosIdsEnFormulario[] = $producto->id;
    
                    // Verificar si el producto ya está en la solicitud
                    $productoExistente = ProductoOrdenado::where('solicitud_id', $solicitud->id)
                        ->where('producto_id', $producto->id)
                        ->first();
    
                    if ($productoExistente) {
                        // Si el producto ya existe en la solicitud, actualizar la cantidad
                        $productoExistente->cantidad = $cantidad;
                        $productoExistente->save();
                    } else {
                        // Si el producto no existe en la solicitud, agregarlo
                        $nuevoProducto = new ProductoOrdenado();
                        $nuevoProducto->solicitud_id = $solicitud->id;
                        $nuevoProducto->producto_id = $producto->id;
                        $nuevoProducto->cantidad = $cantidad;
                        $nuevoProducto->fecha = now(); // Usamos Carbon para la fecha actual
                        $nuevoProducto->save();
                    }
                } else {
                    // Si el producto no se encuentra en la base de datos, manejar el error o crear un nuevo producto si es necesario
                    Alert::error('¡Error!', 'Producto no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                }
            } else {
                // Si $productoData no es un array, mostrar un error
                Alert::error('¡Error!', 'Datos inválidos')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            }
        }
    
        // Eliminar productos que ya no están en la lista
        foreach ($productosExistentes as $productoExistente) {
            if (!in_array($productoExistente->producto_id, $productosIdsEnFormulario)) {
                // Eliminar el producto si ya no está en la nueva lista de productos seleccionados
                $productoExistente->delete();
            }
        }
    
        // Redireccionar después de actualizar la solicitud
        Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
    
        return redirect()->route('solicitudes.index')->with('success', 'Solicitud actualizada correctamente');
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
            return view('solicitudes.index');
        }

        return Excel::download(new SolicitudExport($fromDate, $toDate), 'solicitudes.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the Solicitud record by ID
        $solicitud = Solicitud::find($id);

        // Check if the record exists
        if (!$solicitud) {
            return redirect()->route('solicitudes.index')->with('error', 'Solicitud not found.');
        }

        // Delete the record
        $solicitud->delete();

        // Redirect back with a success message
        Alert::success('Exito!', 'Registro eliminado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud deleted successfully.');
    }
}
