<table class="table table-hover table-striped" id="table_proveedores">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">RAZON SOCIAL</th>
            <th scope="col">RUC</th>
            <th scope="col">TIPO</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">EMAIL</th>
            <th scope="col">DIRECCION</th>
            <th scope="col">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proveedor as $itemproveedor)
        <tr>
            <td>{{$itemproveedor->id}}</td>
            <td>{{$itemproveedor->razon_social}}</td>      
            <td>{{$itemproveedor->ruc}}</td>
            <td>{{$itemproveedor->tipo_proveedor->descripcion}}</td>
            <td>{{$itemproveedor->telefono}}</td>
            <td>{{$itemproveedor->email}}</td>
            <td>{{$itemproveedor->direccion}}</td>
            <td>
                <a href="{{route('proveedores.edit',$itemproveedor->id)}}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <!-- No utilizar <a> -->
                <form action="{{ route('proveedores.destroy', $itemproveedor->id) }}" method="POST" style="display:inline;">
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