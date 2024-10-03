<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categorias = Categoria::all();
    
            return DataTables::of($categorias)
                ->addColumn('status', function ($categoria) {
                    if ($categoria->status == 0) {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    } elseif ($categoria->status == 1) {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($categoria) {
                    return $categoria->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('actions', 'categorias.actions')
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('categorias.index');
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consultar = Categoria::where('nombre', $request->nombre)->first();
        

        if($consultar){
            Alert::error('¡Error!', 'Existe una categoría con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $crear = Categoria::create([
            'nombre' => $request->nombre,
            'status' => '1'
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('categorias.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::where('id', $id)->first();
       

        if(!$categoria){
            Alert::error('¡Error!', 'No existe esta categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        return view('categorias.show')->with('categoria', $categoria);


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.edit')->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $actualizar = Categoria::where('id', $id)->first();
       

        if(!$actualizar){
            Alert::error('¡Error!', 'No existe esta categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
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
            Alert::error('¡Error!', 'Error al intentar actualizar la categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('categorias.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $categoria = Categoria::where('id', $id)->first();
       

        if(!$categoria){
            Alert::error('¡Error!', 'No existe esta categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $categoria->delete();
        Alert::success('¡Éxito!', 'Categoría eliminada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('categorias.index');

    }
}
