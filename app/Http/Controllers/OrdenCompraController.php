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
    /**
     * Muestra el listado de las órdenes de compra.
     *
     * @return \Illuminate\View\View
     */

    
    public function index()
    {
        $orden_compra = Orden_Compra::with('empleado', 'proveedor', 'detalle_orden_compras.producto')->paginate($this::PAGINATION);
        return view('orden_compras.index', compact('orden_compra'));
    }

    /**
     * Muestra el formulario para crear una nueva orden de compra.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $empleados = Empleado::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('orden_compras.create', compact('empleados', 'proveedores', 'productos'));
    }

    /**
     * Registra una nueva orden de compra en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        $orden_compra = new Orden_Compra();
        $orden_compra->proveedor_id = $request->proveedor_id;
        $orden_compra->empleado_id = $request->empleado_id;
        $orden_compra->numero_documento = $this->generateOrderNumber(); // Método para generar el número de orden
        $orden_compra->fecha_compra = $request->fecha_compra;
        $orden_compra->motivo_compra = $request->motivo_compra;
        $orden_compra->subtotal = 0; // Inicializamos el subtotal en 0
        $orden_compra->estado = 'pendiente';
        $orden_compra->save();

        $totalCompra = 0;

        foreach ($request->producto_id as $key => $productoId) {
            $detalle = new Detalle_Orden_Compra();
            $detalle->orden_compra_id = $orden_compra->id;
            $detalle->producto_id = $productoId;
            $detalle->cantidad = $request->cantidad[$key];
            $detalle->precio_unitario = $request->precio_unitario[$key];
            $detalle->subtotal_item = $request->cantidad[$key] * $request->precio_unitario[$key];
            $detalle->save();

            $totalCompra += $detalle->subtotal_item;
        }

        $orden_compra->subtotal = $totalCompra;
        $orden_compra->save();

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra registrada con éxito');
    }

     /**
     * Muestra el formulario para editar una orden de compra.
     *
     * @param  \App\Models\Orden_Compra  $orden_compra
     * @return \Illuminate\View\View
     */
    public function edit(Orden_Compra $ordenCompra)
    {
        $empleados = Empleado::all();
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        
        return view('orden_compras.edit', compact('orden_compra', 'empleados', 'proveedores', 'productos'));
    }

        /**
     * Actualiza los datos de una orden de compra en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orden_Compra  $orden_compra
     * @return \Illuminate\Http\RedirectResponse
     */
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

        $orden_compra->empleado_id = $request->empleado_id;
        $orden_compra->proveedor_id = $request->proveedor_id;
        $orden_compra->fecha_compra = $request->fecha_compra;
        $orden_compra->motivo_compra = $request->motivo_compra;
        $orden_compra->subtotal = 0; // Reiniciamos el subtotal antes de recalcular
        $orden_compra->save();

        $total_compra = 0;

        // Limpiar detalles previos antes de actualizarlos
        $orden_compra->detalle_orden_compras()->delete();

        foreach ($request->producto_id as $key => $productoId) {
            $detalle = new Detalle_Orden_Compra();
            $detalle->orden_compra_id = $orden_compra->id;
            $detalle->producto_id = $productoId;
            $detalle->cantidad = $request->cantidad[$key];
            $detalle->precio_unitario = $request->precio_unitario[$key];
            $detalle->subtotal_item = $request->cantidad[$key] * $request->precio_unitario[$key];
            $detalle->save();

            $total_compra += $detalle->subtotal_item;
        }

        $orden_compra->subtotal = $total_compra;
        $orden_compra->save();

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra actualizada con éxito');
    }

        /**
     * Elimina una orden de compra de la base de datos.
     *
     * @param  \App\Models\Orden_Compra  $orden_compra
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Orden_Compra $orden_compra)
    {
        // Eliminar los detalles de la orden de compra
        $orden_compra->detalle_orden_compras()->delete();

        // Eliminar la orden de compra
        $orden_compra->delete();

        return redirect()->route('orden_compras.index')->with('success', 'Orden de compra eliminada con éxito');
    }

        /**
     * Método para generar el número de documento de la orden de compra.
     *
     * @return string
     */
    private function generateOrderNumber()
    {
        $lastOrder = Orden_Compra::whereYear('created_at', date('Y'))->latest()->first();
        $lastOrderNumber = $lastOrder ? substr($lastOrder->numero_documento, -3) : 0;
        $nextOrderNumber = str_pad($lastOrderNumber + 1, 3, '0', STR_PAD_LEFT);

        return 'OC-' . date('Y') . '-' . $nextOrderNumber;
    }

    public function buscar(Request $request)
{
    $buscarPor = $request->input('buscarpor');  

    if ($buscarPor) {
        // Buscar por número de documento de la orden o nombre del empleado
        $orden_compra = Orden_Compra::where('numero_documento', 'LIKE', '%' . $buscarPor . '%')
            ->orWhereHas('empleado', function ($query) use ($buscarPor) {
                $query->where('nombre', 'LIKE', '%' . $buscarPor . '%');
            })
            ->where('estado', 'ACTIVO') // Filtrar por estado activo (puedes cambiar a lo que necesites)
            ->paginate(10);
    } else {
        // Si no hay filtro, solo mostrar las órdenes activas
        $orden_compra = Orden_Compra::where('estado', 'ACTIVO')
            ->paginate(10);
    }

    return view('orden_compras.index', compact('orden_compra'));
}


}
