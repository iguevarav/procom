<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden_Compra;
use App\Models\Empleado;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Detalle_Orden_Compra;

class OrdenCompraController extends Controller
{
    const PAGINATION = 10;

    public function index()
    {
        $orden_compra = Orden_Compra::where('estado', '!=', '0')
            ->with('empleado', 'proveedor', 'detalle_orden_compras.producto')
            ->paginate(self::PAGINATION);

        return view('orden_compras.index', compact('orden_compra'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('orden_compras.create', compact('empleados', 'proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'motivo_compra' => 'required|string|max:255',
            'producto_id' => 'required|array',
            'cantidad' => 'required|array',
            'precio_unitario' => 'required|array',
        ]);

        $orden_compra = Orden_Compra::create([
            'proveedor_id' => $request->proveedor_id,
            'empleado_id' => $request->empleado_id,
            'numero_documento' => $this->generateOrderNumber(),
            'fecha_compra' => $request->fecha_compra,
            'motivo_compra' => $request->motivo_compra,
            'subtotal' => 0,
            'estado' => 'pendiente'
        ]);

        $totalCompra = 0;

        foreach ($request->producto_id as $key => $productoId) {
            $precio = $request->precio_unitario[$key];
            $cantidad = $request->cantidad[$key];

            Detalle_Orden_Compra::create([
                'orden_compra_id' => $orden_compra->id,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'subtotal_item' => $cantidad * $precio
            ]);

            $totalCompra += $cantidad * $precio;
        }

        $orden_compra->update(['subtotal' => $totalCompra]);

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra registrada con éxito');
    }

    public function edit(Orden_Compra $orden_compra)
    {
        $empleados = Empleado::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('orden_compras.edit', compact('orden_compra', 'empleados', 'proveedores', 'productos'));
    }

    public function update(Request $request, Orden_Compra $orden_compra)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_compra' => 'required|date',
            'motivo_compra' => 'required|string|max:255',
            'producto_id' => 'required|array',
            'cantidad' => 'required|array',
            'precio_unitario' => 'required|array',
        ]);

        $orden_compra->update([
            'empleado_id' => $request->empleado_id,
            'proveedor_id' => $request->proveedor_id,
            'fecha_compra' => $request->fecha_compra,
            'motivo_compra' => $request->motivo_compra,
            'subtotal' => 0
        ]);

        $orden_compra->detalle_orden_compras()->delete();

        $totalCompra = 0;

        foreach ($request->producto_id as $key => $productoId) {
            $precio = $request->precio_unitario[$key];
            $cantidad = $request->cantidad[$key];

            Detalle_Orden_Compra::create([
                'orden_compra_id' => $orden_compra->id,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'subtotal_item' => $cantidad * $precio
            ]);

            $totalCompra += $cantidad * $precio;
        }

        $orden_compra->update(['subtotal' => $totalCompra]);

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra actualizada con éxito');
    }

    public function destroy(Orden_Compra $orden_compra)
    {
        $orden_compra->update(['estado' => '0']);

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra desactivada con éxito');
    }

    private function generateOrderNumber()
    {
        $year = date('Y');

        do {
            $lastOrder = Orden_Compra::whereYear('created_at', $year)->orderByDesc('id')->first();
            $lastNumber = $lastOrder ? intval(substr($lastOrder->numero_documento, -3)) : 0;
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $newNumber = "OC-$year-$nextNumber";
        } while (Orden_Compra::where('numero_documento', $newNumber)->exists());

        return $newNumber;
    }

    public function buscar(Request $request)
    {
        $buscarPor = $request->input('buscarpor');

        if ($buscarPor) {
            $orden_compra = Orden_Compra::where('numero_documento', 'LIKE', "%$buscarPor%")
                ->orWhereHas('empleado', function ($query) use ($buscarPor) {
                    $query->where('nombre', 'LIKE', "%$buscarPor%");
                })
                ->where('estado', '!=', '0')
                ->paginate(self::PAGINATION);
        } else {
            $orden_compra = Orden_Compra::where('estado', '!=', '0')
                ->paginate(self::PAGINATION);
        }

        return view('orden_compras.index', compact('orden_compra'));
    }
}