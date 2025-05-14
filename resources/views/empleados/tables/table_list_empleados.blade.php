<table class="table table-hover table-striped" id="table_empleados">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">TIPO_DOC</th>
            <th scope="col">CARGO</th>
            <th scope="col">N° DOC</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">DIRECCION</th>
            <th scope="col">FECHA_NAC</th>
            <th scope="col">SALARIO</th>
            <th scope="col">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($empleado as $itemempleado)
        <tr>
            <td>{{$itemempleado->id}}</td>
            <td>{{$itemempleado->nombre}}</td>
            <td>{{$itemempleado->tipo_documento->descripcion}}</td>
            <td>{{$itemempleado->cargo->descripcion}}</td>
            <td>{{$itemempleado->numero_documento}}</td>
            <td>{{$itemempleado->telefono}}</td>
            <td>{{$itemempleado->direccion}}</td>
            <td>{{$itemempleado->fecha_nacimiento}}</td>
            <td>{{$itemempleado->salario}}</td>
            <td>
                <a href="{{route('empleados.edit',$itemempleado->id)}}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <!-- No utilizar <a> -->
                <form action="{{ route('empleados.destroy', $itemempleado->id) }}" method="POST" style="display:inline;">
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