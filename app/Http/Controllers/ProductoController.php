<?php

namespace App\Http\Controllers;
 
use App\Exports\ProductosExport;
use App\Exports\ProductosPendientesExport;
use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\ProductoPendiente;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function almacen(Request $request)
    {
        if ($request->ajax()) {
            $productos = Producto::with('subCategoria')->get(); // Cargar la relación subCategoria

            return DataTables::of($productos)
                ->addColumn('fecha_vencimiento', function ($producto) {
                    $date = Carbon::now();
                    if ($producto->fecha_vencimiento <= $date) {
                        return '<span class="badge bg-danger">Vencido</span>';
                    } else {
                        return $producto->fecha_vencimiento;
                    }
                })
                ->editColumn('created_at', function ($producto) {
                    return $producto->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('subCategoria', function ($producto) {
                    return $producto->subCategoria ? $producto->subCategoria->nombre : '';
                })
                ->addColumn('unidad_medida', function ($producto) {
                    return strtoupper($producto->unidad_medida);
                })
                ->addColumn('subCategoria', function ($producto) {
                    return $producto->subCategoria ? $producto->subCategoria->nombre : '';
                })
                ->addColumn('disponible', function ($producto) {
                    if ($producto->disponible == '1') {
                        return '<span class="badge bg-success">Disponible</span>';
                    } else {
                        return '<span class="badge bg-danger">Agotado</span>';
                    }
                })
                ->addColumn('actions', 'productos.actions')
                ->rawColumns(['status', 'actions', 'disponible'])
                ->make(true);
        } else {
            return view('productos.index');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategorias = SubCategoria::pluck('nombre', 'id');

        return view('productos.create')->with('subcategorias', $subcategorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $consulta = Producto::where('nombre', $request->nombre)->exists();

        if ($consulta) {
            Alert::error('¡Error!', 'Ya existe un producto con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('inventario'));
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'sub_categoria_id' => $request->sub_categoria_id,
            'disponible' => $request->disponible,
            'unidad_medida' => $request->unidad_medida
        ]);




        // Mensaje de éxito y redirección
        Alert::success('¡Éxito!', 'Producto Registrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('inventario'));
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
        $subcategorias = SubCategoria::pluck('nombre', 'id');
        $producto = Producto::where('id', $id)->first();

        return view('productos.edit')->with('subcategorias', $subcategorias)->with('producto', $producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'cantidad' => 'required|integer|min:0',
            'sub_categoria_id' => 'required|exists:sub_categorias,id',
            'disponible' => 'required|boolean',
        ]);

        // Buscar el producto por su ID
        $producto = Producto::findOrFail($id);

        // Actualizar los campos del producto
        $producto->nombre = $request->nombre;
        $producto->tipo = $request->tipo;
        $producto->descripcion = $request->descripcion;
        $producto->unidad_medida = $request->unidad_medida;
        $producto->cantidad = $request->cantidad;
        $producto->sub_categoria_id = $request->sub_categoria_id;
        $producto->disponible = $request->disponible;

        // Guardar el producto actualizado
        $producto->save();

        // Redireccionar con un mensaje de éxito
        Alert::success('¡Éxito!', 'Producto actualizado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('inventario');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $producto = Producto::where('id', $id)->first();


        if (!$producto) {
            Alert::error('¡Error!', 'No existe este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('inventario'));
        }

        $producto->delete();
        Alert::success('¡Éxito!', 'Producto eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('inventario');
    }

    public function buscarProducto(Request $request)
    {
        $query = $request->get('q');

        $contribuyentes = Producto::where('nombre', 'LIKE', "%$query%")
            ->orWhere('descripcion', 'LIKE', "%$query%")
            ->take(10) // Limita la cantidad de resultados para mejorar rendimiento
            ->get();

        return response()->json($contribuyentes);
    }

    public function productosPendientes(Request $request)
    {
        if ($request->ajax()) {
            $productos = ProductoPendiente::with('productoAsignado.producto')->get();

            return DataTables::of($productos)
                ->addColumn('nombre_producto', function ($productoPendiente) {
                    return $productoPendiente->productoAsignado->producto->nombre ?? 'N/A';
                })
                ->addColumn('cantidad_asignada', function ($productoPendiente) {
                    return $productoPendiente->productoAsignado->cantidad ?? 'N/A';
                })
                ->addColumn('personal', function ($productoPendiente) {
                    return $productoPendiente->productoAsignado->asignacion->personal->nombre ?? 'N/A';
                })
                ->editColumn('created_at', function ($productoPendiente) {
                    return $productoPendiente->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('fecha_devolucion', function ($productoPendiente) {
                    if ($productoPendiente->productoAsignado->estado != 'Devuelto') {
                        return '<span class="badge bg-primary">Pendiente</span>';
                    } else {
                        return $productoPendiente->fecha_entrega;
                    }
                })
                ->editColumn('estado', function ($productoPendiente) {
                    $estado = $productoPendiente->productoAsignado->estado ?? 'S/D';

                    // Asignar un color según el estado
                    $color = match ($estado) {
                        'Pendiente' => 'primary',   // Amarillo
                        'Devuelto' => 'success',   // Verde
                        'Cancelado' => 'danger',    // Rojo
                        default => 'secondary',     // Gris
                    };

                    return '<span class="badge bg-' . $color . '">' . $estado . '</span>';
                })

                ->addColumn('unidad_medida', function ($productoPendiente) {
                    return strtoupper($productoPendiente->productoAsignado->producto->unidad_medida ?? 'N/A');
                })

                ->addColumn('actions', 'productos.actionsPendientes')
                ->rawColumns(['fecha_vencimiento', 'disponible', 'actions', 'estado', 'fecha_devolucion'])
                ->make(true);
        } else {
            return view('productos.pendientes');
        }
    }


    public function eliminarPendiente(Request $request, $id)
    {
        $dato = ProductoPendiente::find($id);

        if (!$dato) {
            Alert::error('¡Error!', 'No existe este registro')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('productosPendientes'));
        }

        $dato->delete();
        Alert::success('¡Éxito!', 'Registro eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('productosPendientes');
    }

    public function exportProductosPendientes(Request $request)
    {
        $startDate = $request->input('start_date'); // Get start date from request
        $endDate = $request->input('end_date'); // Get end date from request
    
        return Excel::download(new ProductosPendientesExport($startDate, $endDate), 'productos_pendientes.xlsx');
    }

    public function exportProductos()
    {
        return Excel::download(new ProductosExport, 'productos_inventario.xlsx');
    }
}
