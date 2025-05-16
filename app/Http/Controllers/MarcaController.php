<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    const PAGINATION = 5;
    public function index()
    {
        $marca = Marca::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('marcas.index', compact('marca'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
        ]);

        $marca =  Marca::create([
            'descripcion' => $request->descripcion,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('marcas.index')->with('success', 'Marca registrada!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'nullable|max:255',
        ]);

        $marca = Marca::findOrFail($id);

        $marca->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
    }

    public function show($id)
    {
        $marca = Marca::findOrFail($id);
        return response()->json($marca);
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);

        // Cambiar el estado de la categoría a 'ANULADO'
        $marca->estado = 'ANULADO';
        $marca->save();

        return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $marca = Marca::where('descripcion', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $marca = Marca::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('marcas.index', compact('marca'));
    }
}
