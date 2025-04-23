<div class="table-responsive">
    <table class="table table-hover table-striped" id="table_unidades">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">DESCRIPCIÓN</th>
                <th scope="col">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidad as $itemunidad)
            <tr>
                <td>{{ $itemunidad->id }}</td>
                <td>{{ $itemunidad->descripcion }}</td>
                <td>
                    <button onclick="openMdlEditUnidad({{ $itemunidad->id }})" class="btn btn-info btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </button>

                    <!-- laravel no permite solicitudes delete directamente -->
                    <form action="{{ route('unidades.destroy', $itemunidad->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>