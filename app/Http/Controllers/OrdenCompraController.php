<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraDetalle;
use App\Models\Empleado;
use App\Models\Proveedor;
use App\Models\Producto;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $ordenes = OrdenCompra::with(['empleado', 'proveedor'])->paginate(10);
        return view('orden_compra.index', compact('ordenes'));
    }

    private function generateOrderNumber()
    {
        $last = OrdenCompra::orderBy('id', 'desc')->first();
        $next = $last ? $last->id + 1 : 1;
        return 'OC-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $empleados = Empleado::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('orden_compra.create', compact('empleados', 'proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'motivo_compra' => 'required|string|max:255',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $numeroDocumento = $this->generateOrderNumber();

        $subtotal = 0;
        foreach ($request->productos as $item) {
            $subtotal += $item['cantidad'] * $item['precio_unitario'];
        }

        $orden = OrdenCompra::create([
            'numero_documento' => $numeroDocumento,
            'empleado_id' => $request->empleado_id,
            'proveedor_id' => $request->proveedor_id,
            'fecha_compra' => $request->fecha_compra,
            'motivo_compra' => $request->motivo_compra,
            'subtotal' => $subtotal,
            'estado' => 'pendiente',
        ]);

        foreach ($request->productos as $item) {
            $orden->detalles()->create([
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'subtotal' => $item['cantidad'] * $item['precio_unitario'],
            ]);
        }

        return redirect()->route('orden_compra.index')->with('success', 'Orden creada correctamente');
    }

    public function show($id)
     {
         $orden = OrdenCompra::with(['empleado', 'proveedor', 'detalles.producto'])->findOrFail($id);
         return view('orden_compra.show', compact('orden'));
     }


    public function edit($id)
    {
        $orden = OrdenCompra::with('detalles.producto')->findOrFail($id);
        $empleados = Empleado::where('estado', 'ACTIVO')->get();
        $proveedores = Proveedor::where('estado', 'ACTIVO')->get();
        $productos = Producto::where('estado', 'ACTIVO')->get();

        return view('orden_compra.edit', compact('orden', 'empleados', 'proveedores', 'productos'));
    }

    public function update(Request $request, $id)
    {
        // Validar datos principales
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'motivo_compra' => 'required|string|max:255',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Buscar orden
        $orden = OrdenCompra::findOrFail($id);

        // Actualizar datos principales
        $orden->empleado_id = $request->empleado_id;
        $orden->proveedor_id = $request->proveedor_id;
        $orden->fecha_compra = $request->fecha_compra;
        $orden->motivo_compra = $request->motivo_compra;

        // Calcular subtotal total
        $subtotal = 0;
        foreach ($request->productos as $producto) {
            $subtotal += $producto['cantidad'] * $producto['precio_unitario'];
        }
        $orden->subtotal = $subtotal;

        $orden->save();

        // Actualizar detalles

        // Primero, eliminar detalles existentes para evitar duplicados
        $orden->detalles()->delete();

        // Insertar nuevos detalles
        foreach ($request->productos as $producto) {
            $orden->detalles()->create([
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['cantidad'] * $producto['precio_unitario'],
            ]);
        }

        return redirect()->route('orden_compra.index')->with('success', 'Orden de compra actualizada correctamente.');
    }

    public function destroy($id)
    {
        $orden = OrdenCompra::findOrFail($id);

        // Eliminar detalles relacionados primero para mantener integridad
        $orden->detalles()->delete();

        // Eliminar la orden
        $orden->delete();

        return redirect()->route('orden_compra.index')->with('success', 'Orden de compra eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = OrdenCompra::query()->with(['empleado', 'proveedor']);

        if ($request->filled('empleado_nombre')) {
            $nombre = $request->empleado_nombre;
            $query->whereHas('empleado', function ($q) use ($nombre) {
                $q->where('nombre', 'like', "%{$nombre}%");
            });
        }

        if ($request->filled('proveedor_razon_social')) {
            $razonSocial = $request->proveedor_razon_social;
            $query->whereHas('proveedor', function ($q) use ($razonSocial) {
                $q->where('razon_social', 'like', "%{$razonSocial}%");
            });
        }

        $ordenes = $query->paginate(10);

        return view('orden_compra.index', compact('ordenes'));
    }
}
