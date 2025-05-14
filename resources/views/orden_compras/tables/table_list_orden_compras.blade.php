    <table class="table table-hover table-striped" id="table_orden_compras">
        <thead>
            <tr>
                <th scope = "col">#</th>
                <th scope = "col">Número de Documento</th>
                <th scope = "col">Proveedor</th>
                <th scope = "col">Fecha de Compra</th>
                <th scope = "col">Subtotal</th>
                <th scope = "col">Estado</th>
                <th scope = "col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden_compra as $itemorden_compra)
            <tr>
                <td>{{ $itemorden_compra->id }}</td>
                <td>{{ $itemorden_compra->numero_documento }}</td>
                <td>{{ $itemorden_compra->proveedor->razon_social }}</td>
                <td>{{ $itemorden_compra->fecha_compra }}</td>
                <td>{{ $itemorden_compra->subtotal }}</td>
                <td>{{ $itemorden_compra->estado }}</td>
                <td>
                    <a href="{{ route('orden_compras.edit', $itemorden_compra->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('orden_compras.destroy', $itemorden_compra->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick=" return confirm('¿Estás seguro de eliminar este registro?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>