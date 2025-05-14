<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Tipo_Documento;
class ClienteController extends Controller
{
    const PAGINATION = 10;

    public function index() {
        $cliente = Cliente::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('clientes.index', compact('cliente'));
    }

    public function create() {
        $tipos_documento = Tipo_Documento::where('estado', '=', 'ACTIVO')->get();
        return view('clientes.create', compact('tipos_documento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'numero_documento' => 'required|max:255',
            'email' => 'required|max:255',
            'telefono' => 'required|regex:/^\+?[0-9]{1,4}?[-.●]?(\(?\d{1,3}?\)?[-.●]?)?[\d●]{1,4}[-.●]?[0-9]{1,4}[-.●]?[0-9]{1,9}$/',
            'direccion' => 'required|max:255',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'tipo_documento_id' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit($id)
    {
        $tipos_documento     =   Tipo_Documento::where('estado', 'ACTIVO')->get();
        $cliente            =   Cliente::find($id);

        return view('clientes.edit', compact( 'tipos_documento', 'cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'numero_documento' => 'required|max:255',
            'email' => 'required|max:255',
            'telefono' => 'required|max:255',
            'direccion' => 'required|max:255',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
        ]);

        $cliente = Cliente::findOrFail($id);

        $cliente->update([
            'nombre' => $request->nombre,
            'tipo_documento_id' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Registro actualizado correctamente.');
    }
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->estado = 'ANULADO';
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Registro eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $cliente = Cliente::where('nombre', 'LIKE', '%' . $buscarPor . '%')
                ->orWhere('numero_documento', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $cliente = Cliente::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('clientes.index', compact('cliente'));
    }
}
