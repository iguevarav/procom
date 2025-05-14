@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('orden_compras.update', $ordenCompra->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Empleado -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="empleado_id" class="required_field mb-2" style="font-weight: bold;">Empleado</label>
            <select name="empleado_id" id="empleado_id" class="form-select select2_form" required>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ $ordenCompra->empleado_id == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Proveedor -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="proveedor_id" class="required_field mb-2" style="font-weight: bold;">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select select2_form" required>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ $ordenCompra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->razon_social }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Compra -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="fecha_compra" class="required_field mb-2" style="font-weight: bold;">Fecha de Compra</label>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" value="{{ $ordenCompra->fecha_compra }}" required>
        </div>

        <!-- Motivo de Compra -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="motivo_compra" class="required_field mb-2" style="font-weight: bold;">Motivo de la Compra</label>
            <input type="text" name="motivo_compra" id="motivo_compra" class="form-control" value="{{ $ordenCompra->motivo_compra }}" required>
        </div>
    </div>

    <!-- Productos -->
    <div id="productos">
        @foreach($ordenCompra->detalle_orden_compras as $detalle)
        <div class="producto">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                    <label for="producto_id" class="required_field mb-2" style="font-weight: bold;">Producto</label>
                    <select name="producto_id[]" class="form-select producto_id" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $producto->id == $detalle->producto_id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                    <label for="cantidad" class="required_field mb-2" style="font-weight: bold;">Cantidad</label>
                    <input type="number" name="cantidad[]" class="form-control cantidad" value="{{ $detalle->cantidad }}" required>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                    <label for="precio_unitario" class="required_field mb-2" style="font-weight: bold;">Precio Unitario</label>
                    <input type="number" name="precio_unitario[]" class="form-control precio_unitario" value="{{ $detalle->precio_unitario }}" required readonly>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                    <label for="subtotal_item" class="required_field mb-2" style="font-weight: bold;">Subtotal Item</label>
                    <input type="number" name="subtotal_item[]" class="form-control subtotal_item" value="{{ $detalle->subtotal_item }}" readonly>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button type="button" id="agregar_producto" class="btn btn-primary mb-3">Agregar producto</button>

    <div class="row">
        <!-- Subtotal Total -->
        <div class="col-lg-6 col-md-6 col-sm-12 pb-2">
            <label for="subtotal" class="required_field mb-2" style="font-weight: bold;">Subtotal Total</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" value="{{ $ordenCompra->subtotal }}" readonly>
        </div>
    </div>

</form>

<script>
    // Función para calcular el subtotal de cada producto
    function calcularSubtotal() {
        let totalCompra = 0;

        // Obtener todos los productos
        const productos = document.querySelectorAll('.producto');

        productos.forEach(function(producto) {
            // Obtener los valores de cantidad, precio unitario y subtotal_item
            const cantidad = producto.querySelector('.cantidad').value;
            const precioUnitario = producto.querySelector('.precio_unitario').value;
            const subtotalItem = producto.querySelector('.subtotal_item');

            // Calcular el subtotal de este producto
            const subtotal = cantidad * precioUnitario;

            // Asignar el subtotal calculado al campo subtotal_item
            subtotalItem.value = subtotal;

            // Sumar al subtotal total
            totalCompra += subtotal;
        });

        // Actualizar el subtotal total
        document.getElementById('subtotal').value = totalCompra;
    }

    // Lógica para agregar un producto más al formulario y mostrarlo en la tabla
    document.getElementById('agregar_producto').addEventListener('click', function() {
        const productoDiv = document.querySelector('.producto');
        const cantidad = productoDiv.querySelector('.cantidad').value;
        const precioUnitario = productoDiv.querySelector('.precio_unitario').value;
        const subtotalItem = productoDiv.querySelector('.subtotal_item').value;

        if (!cantidad || !precioUnitario) {
            alert("Por favor, complete todos los campos del producto.");
            return;
        }

        // Crear una nueva fila en la tabla para el producto añadido
        const tablaBody = document.querySelector('#tabla_productos tbody');
        const nuevaFila = document.createElement('tr');

        nuevaFila.innerHTML = `
            <td>${productoDiv.querySelector('.producto_id').options[productoDiv.querySelector('.producto_id').selectedIndex].text}</td>
            <td>${cantidad}</td>
            <td>${precioUnitario}</td>
            <td>${subtotalItem}</td>
            <td><button type="button" class="eliminar_producto btn btn-danger">Eliminar</button></td>
        `;

        // Añadir la nueva fila a la tabla
        tablaBody.appendChild(nuevaFila);

        // Limpiar los campos para seguir añadiendo productos
        productoDiv.querySelector('.cantidad').value = '';
        productoDiv.querySelector('.precio_unitario').value = '';
        productoDiv.querySelector('.subtotal_item').value = '';

        // Volver a calcular el subtotal total después de agregar el producto
        calcularSubtotal();

        // Eliminar producto de la tabla
        nuevaFila.querySelector('.eliminar_producto').addEventListener('click', function() {
            nuevaFila.remove();
            calcularSubtotal(); // Recalcular el subtotal total
        });
    });

    // Inicializar la lógica de cálculo del subtotal cuando se cambian los valores
    document.querySelectorAll('.cantidad').forEach(function(input) {
        input.addEventListener('input', calcularSubtotal);
    });

    document.querySelectorAll('.precio_unitario').forEach(function(input) {
        input.addEventListener('input', calcularSubtotal);
    });
</script>
