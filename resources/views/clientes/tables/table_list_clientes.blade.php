<table class="table table-hover table-striped" id="table_clientes">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">TIPO_DOC</th>
            <th scope="col">N° DOC</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">DIRECCION</th>
            <th scope="col">FECHA_NAC</th>
            <th scope="col">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cliente as $itemcliente)
        <tr>
            <td>{{$itemcliente->id}}</td>
            <td>{{$itemcliente->nombre}}</td>
            <td>{{$itemcliente->tipo_documento->descripcion}}</td>
            <td>{{$itemcliente->numero_documento}}</td>
            <td>{{$itemcliente->email}}</td>
            <td>{{$itemcliente->telefono}}</td>
            <td>{{$itemcliente->direccion}}</td>
            <td>{{$itemcliente->fecha_nacimiento}}</td>
            <td>
                <a href="{{route('clientes.edit',$itemcliente->id)}}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <!-- No utilizar <a> -->
                <form action="{{ route('clientes.destroy', $itemcliente->id) }}" method="POST" style="display:inline;">
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