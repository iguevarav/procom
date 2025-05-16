<table class="table table-hover table-striped" id="table_orden_compra">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">N° Orden</th>
            <th scope="col">EMPLEADO</th>
            <th scope="col">PROVEEDOR</th>
            <th scope="col">FECHA</th>
            <th scope="col">TOTAL (S/.)</th>
            <th scope="col">ESTADO</th>
            <th scope="col">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordenes as $orden)
        <tr>
            <td>{{ $orden->id }}</td>
            <td>{{ $orden->numero_documento }}</td>
            <td>{{ $orden->empleado->nombre }}</td>
            <td>{{ $orden->proveedor->razon_social }}</td>
            <td>{{ $orden->fecha_compra->format('d/m/Y') }}</td>
            <td>{{ number_format($orden->subtotal, 2) }}</td>
            <td>{{ ucfirst($orden->estado) }}</td>

            <td>
                <a href="{{ route('orden_compra.show', $orden->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Ver
                </a>

                <a href="{{ route('orden_compra.edit', $orden->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('orden_compra.destroy', $orden->id) }}" method="POST" style="display:inline;">
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