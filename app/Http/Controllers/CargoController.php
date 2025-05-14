<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
class CargoController extends Controller
{
    const PAGINATION = 5;
    public function index()
    {
        $cargo = Cargo::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('cargos.index', compact('cargo'));
    }

    // public function create()
    // {
    //     return view('cargos.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
        ]);

        $cargo =  Cargo::create([
            'descripcion' => $request->descripcion,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('cargos.index')->with('success', 'Cargo registrado!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'nullable|max:255',
        ]);

        $cargo = Cargo::findOrFail($id);

        $cargo->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('cargos.index')->with('success', 'Cargo actualizada correctamente.');
    }

    public function show($id)
    {
        $cargo = Cargo::findOrFail($id);
        return response()->json($cargo);
    }

    public function destroy($id)
    {
        $cargo = Cargo::findOrFail($id);

        // Cambiar el estado del cargo a 'ANULADO'
        $cargo->estado = 'ANULADO';
        $cargo->save();

        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado correctamente.');
    }
    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $cargo = Cargo::where('descripcion', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $cargo = Cargo::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('cargos.index', compact('cargo'));
    }
}
