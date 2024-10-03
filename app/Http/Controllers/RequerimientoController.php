<?php

namespace App\Http\Controllers;

use App\Models\Requerimiento;
use App\Models\Tramites;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
class RequerimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requerimientos = Requerimiento::with('user')->get();
            return DataTables::of($requerimientos)
                ->addColumn('actions', function($row) {
                    return '<a href="'.route('requerimientos.edit', [$row->id]).'" class="btn btn-info"><span class="material-icons">edit</span></a>
                            <form action="'.route('requerimientos.destroy', [$row->id]).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                            </form>';
                })
                ->editColumn('fecha', function($row) {
                    return $row->created_at->format('Y-m-d');
                    
                })
                ->editColumn('tipo', function($row) {
                    return strtoupper($row->tipo);
                    
                })
                ->editColumn('usuario', function($row) {
                    return strtoupper($row->user->name);
                })
                ->editColumn('status', function($row) {
                    // Verifica el estado y devuelve un badge con el color adecuado
                    if ($row->status == 'Pendiente') {
                        return '<span class="badge badge-danger">Pendiente</span>';
                    } elseif ($row->status == 'Procesada') {
                        return '<span class="badge badge-success">Procesada</span>';
                    } else {
                        return '<span class="badge badge-secondary">'.$row->status.'</span>';
                    }
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        } else {
            return view('requerimientos.index');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('requerimientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'uso' => 'required|string',
          
        ]);

        $validated['creado_por'] = auth()->id(); // Asigna el ID del usuario autenticado
        $validated['status'] = 'SIN PROCESAR';
        Requerimiento::create($validated);

       
        Alert::success('Exito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('requerimientos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Requerimiento $requerimiento)
    {
        return view('requerimientos.show', compact('requerimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requerimiento $requerimiento)
    {
        return view('requerimientos.edit', compact('requerimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requerimiento $requerimiento)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'uso' => 'required|string',
        ]);

        $requerimiento->update($validated);
        Alert::success('Exito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('requerimientos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requerimiento $requerimiento)
    {
        $requerimiento->delete();
        Alert::success('¡Exito!', 'Registro eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('requerimientos.index')->with('success', 'Requerimiento eliminado exitosamente.');
    }
}
