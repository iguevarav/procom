<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidad;

class UnidadController extends Controller
{
    const PAGINATION = 5;
    public function index()
    {
        $unidad = Unidad::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('unidades.index', compact('unidad'));
    }

    // public function create()
    // {
    //     return view('unidades.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
        ]);

        $unidad =  Unidad::create([
            'descripcion' => $request->descripcion,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidad registrada!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'nullable|max:255',
        ]);

        $unidad = Unidad::findOrFail($id);

        $unidad->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidad actualizada correctamente.');
    }

    public function show($id)
    {
        $unidad = Unidad::findOrFail($id);
        return response()->json($unidad);
    }

    public function destroy($id)
    {
        $unidad = Unidad::findOrFail($id);

        // Cambiar el estado de la categoría a 'ANULADO'
        $unidad->estado = 'ANULADO';
        $unidad->save();

        return redirect()->route('unidades.index')->with('success', 'Unidad eliminada correctamente.');
    }
}
