<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Unidad;

class ProductoController extends Controller
{
    const PAGINATION = 10;
    public function index()
    {
        $producto = Producto::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('productos.index', compact('producto'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', '=', 'ACTIVO')->get();
        $marcas = Marca::where('estado', '=', 'ACTIVO')->get();
        $unidades = Unidad::where('estado', '=', 'ACTIVO')->get();
        return view('productos.create', compact('categorias', 'marcas', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:255',
            'id_categoria' => 'required|exists:categorias,id',
            'id_marca' => 'required|exists:marcas,id',
            'costo' => 'required|numeric',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'id_unidad' => 'required|exists:unidades,id',
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_categoria' => $request->id_categoria,
            'id_marca' => $request->id_marca,
            'costo' => $request->costo,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'id_unidad' => $request->id_unidad,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function edit($id)
    {
        $marcas      =   Marca::where('estado', 'ACTIVO')->get();
        $categorias  =   Categoria::where('estado', 'ACTIVO')->get();
        $unidades    =   Unidad::where('estado', 'ACTIVO')->get();
        $producto    =   Producto::find($id);

        return view('productos.edit', compact('marcas', 'categorias', 'unidades', 'producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:255',
            'id_categoria' => 'required|exists:categorias,id',
            'id_marca' => 'required|exists:marcas,id',
            'costo' => 'required|numeric',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'id_unidad' => 'required|exists:unidades,id',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_categoria' => $request->id_categoria,
            'id_marca' => $request->id_marca,
            'costo' => $request->costo,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'id_unidad' => $request->id_unidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $producto->estado = 'ANULADO';
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $producto = Producto::where('nombre', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $producto = Producto::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('productos.index', compact('producto'));
    }
}
