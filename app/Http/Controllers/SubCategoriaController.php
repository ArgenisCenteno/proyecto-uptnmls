<?php

namespace App\Http\Controllers;

use App\Models\SubCategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subcategorias = SubCategoria::with('categoria')->get();
            return DataTables::of($subcategorias)
                ->addColumn('actions', function($row) {
                    return '<a href="'.route('subcategorias.edit', [$row->id]).'" class="btn btn-info"><span class="material-icons">edit</span></a>
                            <form action="'.route('subcategorias.destroy', [$row->id]).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                            </form>';
                })
                ->editColumn('status', function($row) {
                    return $row->status ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        } else {
            return view('subcategorias.index');
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre', 'id');
    
        return view('subcategorias.create')->with('categorias', $categorias);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consultar = SubCategoria::where('nombre', $request->nombre)->first();
        

        if($consultar){
            Alert::error('¡Error!', 'Existe una categoría con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $crear = SubCategoria::create([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'status' => $request->status
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la subcategoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('subcategorias.index'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
