<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Personal;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Requerimiento;
use App\Models\Solicitud;
use App\Models\Tramites;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *  
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tramites = Tramites::count();
        $productos = Producto::count();
        $solicitudes = Solicitud::count();
        $asignaciones = Asignacion::count();
        $proveedores = Proveedor::count();
        $requerimientos = Requerimiento::count();
        $personal = Personal::count();
        $productosTotales = Producto::select('id', 'nombre', 'cantidad')->get();

        // Agrupar y contar productos (si es necesario)
        $data = $productosTotales->groupBy('nombre')->map(function ($items) {
            return $items->count();
        });
        $bajoStock = Producto::where('cantidad', '<', \DB::raw('cantidad / 2'))->count();
       
        $tramitesPorMes = Tramites::select(DB::raw('MONTH(created_at) as mes'), 'tipo', DB::raw('count(*) as total'))
        ->groupBy(DB::raw('MONTH(created_at)'), 'tipo')
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get();

    // Formatear los datos para la gráfica
    $data2 = [];
    foreach ($tramitesPorMes as $tramite) {
        $data2[$tramite->mes][$tramite->tipo] = $tramite->total;
    }
       
    //dd($data2);
        return view('home', [
            'tramites' => $tramites,
            'productos' => $productos,
            'solicitudes' => $solicitudes,
            'asignaciones' => $asignaciones,
            'proveedores' => $proveedores,
            'requerimientos' => $requerimientos,
            'personal' => $personal,
            'bajoStock' => $bajoStock,
            'dataProductos' => $data,
            'tramitesPorMes' => $data2,
        ]);
    }
}
