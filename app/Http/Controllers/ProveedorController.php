<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Tipo_Proveedor;


class ProveedorController extends Controller
{
    const PAGINATION = 10;

    public function index()
    {
        $proveedor = Proveedor::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('proveedores.index', compact('proveedor'));
    }

    public function create()
    {
        $tipos_proveedor = Tipo_Proveedor::where('estado', '=', 'ACTIVO')->get();
        return view('proveedores.create', compact('tipos_proveedor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required|max:255',
            'ruc' => 'required|digits:11', 
            'tipo_proveedor_id' => 'required|exists:tipos_proveedor,id',
            'telefono' => 'required|digits:9',
            'email' => 'required|max:255',
            'direccion' => 'required|max:255',
        ]);

        $proveedor = Proveedor::create([
            'razon_social' => $request->razon_social,
            'ruc' => $request->ruc,
            'tipo_proveedor_id' => $request->tipo_proveedor_id,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit($id)
    {
        $tipos_proveedor = Tipo_Proveedor::where('estado', 'ACTIVO')->get();
        $proveedor = Proveedor::find($id);
        return view('proveedores.edit', compact('tipos_proveedor', 'proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'razon_social' => 'required|max:255',
            'ruc' => 'required|digits:11',
            'tipo_proveedor_id' => 'required|exists:tipos_proveedor,id',
            'telefono' => 'required|digits:9',
            'email' => 'required|max:255',
            'direccion' => 'required|max:255',
        ]);

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update([
            'razon_social' => $request->razon_social,
            'ruc' => $request->ruc,
            'tipo_proveedor_id' => $request->tipo_proveedor_id,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'estado' => 'ACTIVO'
        ]);
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->estado = 'ANULADO';
        $proveedor->save();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  // Obtener el valor del input

        // Si se ingresa un valor en el campo de búsqueda
        if ($buscarPor) {
            // Buscar proveedores con estado 'ACTIVO' y filtro por nombre
            $proveedor = Proveedor::where('razon_social', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO')  // Filtrar por estado 'ACTIVO'
                ->paginate(10);
        } else {
            // Si no hay búsqueda, devolver solo los proveedores con estado 'ACTIVO'
            $proveedor = Proveedor::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        // Devolver la vista con los resultados
        return view('proveedores.index', compact('proveedor'));
    }
}
