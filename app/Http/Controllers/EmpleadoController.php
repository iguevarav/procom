<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Tipo_Documento;  
use App\Models\Cargo;

class EmpleadoController extends Controller
{
    const PAGINATION = 10; 

    public function index(){
        $empleado = Empleado::where('estado', '=', 'ACTIVO')->paginate($this::PAGINATION);
        return view('empleados.index', compact('empleado'));
    }

    public function create(){
        $tipos_documento = Tipo_Documento::where('estado', '=', 'ACTIVO')->get();
        $cargos = Cargo::where('estado', '=', 'ACTIVO')->get();
        return view('empleados.create', compact('tipos_documento', 'cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'cargo_id' => 'required|exists:cargos,id',
            'numero_documento' => 'required|max:255',
            'telefono' => 'required|digits:9',
            'direccion' => 'required|max:255',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
            'salario' => 'required|numeric',
        ]);

        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'tipo_documento_id' => $request->tipo_documento_id,
            'cargo_id'=> $request->cargo_id,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'salario'=> $request->salario,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    public function edit($id)
    {
        $tipos_documento     =   Tipo_Documento::where('estado', 'ACTIVO')->get();
        $cargos              =   Cargo::where('estado', 'ACTIVO')->get();
        $empleado           =   Empleado::find($id);

        return view('empleados.edit', compact( 'tipos_documento', 'cargos','empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'cargo_id' => 'required|exists:cargos,id',
            'numero_documento' => 'required|max:255',
            'telefono' => 'required|digits:9',
            'direccion' => 'required|max:255',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
            'salario' => 'required|numeric',
        ]);

        $empleado = Empleado::findOrFail($id);

        $empleado->update([
            'nombre' => $request->nombre,
            'tipo_documento_id' => $request->tipo_documento_id,
            'cargo_id'=> $request->cargo_id,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'salario'=> $request->salario,
            'estado' => 'ACTIVO'
        ]);

        return redirect()->route('empleados.index')->with('success', 'Registro actualizado correctamente.');
    }
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);

        $empleado->estado = 'ANULADO';
        $empleado->save();

        return redirect()->route('empleados.index')->with('success', 'Registro eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');  
        if ($buscarPor) {
            $empleado = Empleado::where('nombre', 'LIKE', '%' . $buscarPor . '%')
                ->orWhere('numero_documento', 'LIKE', '%' . $buscarPor . '%')
                ->where('estado', 'ACTIVO') 
                ->paginate(10);
        } else {
            $empleado = Empleado::where('estado', 'ACTIVO')
                ->paginate(10);
        }

        return view('empleados.index', compact('empleado'));
    }

}
