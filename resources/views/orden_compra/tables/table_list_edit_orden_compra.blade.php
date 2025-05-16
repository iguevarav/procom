<table class="table table-hover table-striped" id="tablaProductos" style="margin-top:15px;">
    <thead>
        <tr>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio Unitario</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orden->detalles as $index => $detalle)
        <tr data-index="{{ $index }}">
            <td>
                {{ $detalle->producto->nombre }}
                <input type="hidden" name="productos[{{ $index }}][producto_id]" value="{{ $detalle->producto_id }}">
            </td>
            <td>
                <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" min="1" required>
            </td>
            <td>
                <input type="text" name="productos[{{ $index }}][precio_unitario]" value="{{ $detalle->precio_unitario }}" readonly>
            </td>
            <td>
                <input type="text" name="productos[{{ $index }}][subtotal]" value="{{ $detalle->subtotal }}" readonly>
            </td>
            <td>
                <button type="button" class="btnEliminarFila">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>