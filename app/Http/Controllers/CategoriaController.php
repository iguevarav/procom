<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    const PAGINATION = 5;
    public function index()
    {
        $categoria = Categoria::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('categorias.index', compact('categoria'));
    }

    // public function create()
    // {
    //     return view('categorias.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
        ]);

        $categoria =  Categoria::create([
            'descripcion' => $request->descripcion,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoria registrada!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'nullable|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);

        $categoria->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada correctamente.');
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria);
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Cambiar el estado de la categoría a 'ANULADO'
        $categoria->estado = 'ANULADO';
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $categoria = Categoria::where('descripcion', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $categoria = Categoria::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('categorias.index', compact('categoria'));
    }
}
