<table class="table table-hover table-striped" id="table_productos">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">DESCRIPCIÓN</th>
            <th scope="col">CATEGORÍA</th>
            <th scope="col">MARCA</th>
            <th scope="col">COSTO</th>
            <th scope="col">PRECIO</th>
            <th scope="col">STOCK</th>
            <th scope="col">UNIDAD</th>
            <th scope="col">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($producto as $itemproducto)
        <tr>
            <td>{{$itemproducto->id}}</td>
            <td>{{$itemproducto->nombre}}</td>
            <td>{{$itemproducto->descripcion}}</td>
            <td>{{$itemproducto->categoria->descripcion}}</td>
            <td>{{$itemproducto->marca->descripcion}}</td>
            <td>{{$itemproducto->costo}}</td>
            <td>{{$itemproducto->precio}}</td>
            <td>{{$itemproducto->stock}}</td>
            <td>{{$itemproducto->unidad->descripcion}}</td>
            <td>
                <a href="{{route('productos.edit',$itemproducto->id)}}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <!-- No utilizar <a> -->
                <form action="{{ route('productos.destroy', $itemproducto->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>