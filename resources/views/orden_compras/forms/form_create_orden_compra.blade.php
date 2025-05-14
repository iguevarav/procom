@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formRegistrarOrdenCompra" method="POST" action="{{ route('orden_compras.store') }}">
    @csrf

    <div class="row">
        <!-- Empleado -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="empleado_id" class="required_field mb-2" style="font-weight: bold;">Empleado</label>
            <select name="empleado_id" id="empleado_id" class="form-select select2_form" required>
                @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Proveedor -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="proveedor_id" class="required_field mb-2" style="font-weight: bold;">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-select select2_form" required>
                @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->razon_social }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Compra -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="fecha_compra" class="required_field mb-2" style="font-weight: bold;">Fecha de Compra</label>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control" required>
        </div>

        <!-- Motivo de Compra -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="motivo_compra" class="required_field mb-2" style="font-weight: bold;">Motivo de la Compra</label>
            <input type="text" name="motivo_compra" id="motivo_compra" class="form-control" required>
        </div>
    </div>

    <!-- Formulario de Productos -->
    <div id="productos">
        <div class="producto">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                    <label for="producto_id" class="required_field mb-2" style="font-weight: bold;">Producto</label>
                    <select name="producto_id[]" class="form-select select2_form producto_id" required>
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-costo="{{ $producto->costo }}">
                            {{ $producto->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                    <label for="cantidad" class="required_field mb-2" style="font-weight: bold;">Cantidad</label>
                    <input type="number" name="cantidad[]" class="form-control cantidad" required>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                    <label for="costo" class="required_field mb-2" style="font-weight: bold;">Costo</label>
                    <input type="number" name="precio_unitario[]" class="form-control precio_unitario" required readonly>
                    </div>

                <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                    <label for="subtotal_item" class="required_field mb-2" style="font-weight: bold;">Subtotal Item</label>
                    <input type="number" name="subtotal_item[]" class="form-control subtotal_item" readonly>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="agregar_producto" class="btn btn-primary mb-3">Agregar producto</button>

    <h3>Productos Añadidos:</h3>
    <table id="tabla_productos" class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los productos se irán añadiendo aquí -->
        </tbody>
    </table>

    <!-- Subtotal Total -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 pb-2">
            <label for="subtotal" class="required_field mb-2" style="font-weight: bold;">Subtotal Total</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('.select2_form').select2(); // Asegúrate de que esto se llama

    // Evento que actualiza precio_unitario al seleccionar producto
    $(document).on('select2:select', '.producto_id', function () {
        const $bloque = $(this).closest('.producto');
        const costo = parseFloat($(this).find('option:selected').data('costo')) || 0;

        console.log("Costo leído:", costo); // Verifica en consola

        $bloque.find('.precio_unitario').val(costo.toFixed(2));
        recalcularItem($bloque);
    });

    // Recalcula el subtotal cuando cambia la cantidad
    $('#productos').on('input', '.cantidad', function () {
        recalcularItem($(this).closest('.producto'));
    });

    // Función para calcular subtotal de un producto
    function recalcularItem($bloque) {
        const cantidad = parseFloat($bloque.find('.cantidad').val()) || 0;
        const precio = parseFloat($bloque.find('.precio_unitario').val()) || 0;
        const subtotal = cantidad * precio;
        $bloque.find('.subtotal_item').val(subtotal.toFixed(2));
    }

    // Botón Agregar Producto
    $('#agregar_producto').click(function () {
        const $bloque = $('#productos .producto').first();

        const nombreProducto = $bloque.find('.producto_id option:selected').text();
        const cantidad = parseFloat($bloque.find('.cantidad').val()) || 0;
        const precio = parseFloat($bloque.find('.precio_unitario').val()) || 0;
        const subtotal = cantidad * precio;

        if (cantidad <= 0 || precio <= 0) {
            alert('Por favor, completa producto, cantidad y precio.');
            return;
        }

        const fila = `
            <tr>
                <td>${nombreProducto}</td>
                <td>${cantidad}</td>
                <td>${precio.toFixed(2)}</td>
                <td class="subtotal">${subtotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm btn-eliminar">&times;</button></td>
            </tr>
        `;
        $('#tabla_productos tbody').append(fila);
        actualizarTotal();

        // Limpia valores
        $bloque.find('.cantidad').val('');
        $bloque.find('.precio_unitario').val('');
        $bloque.find('.subtotal_item').val('');
    });

    // Botón Eliminar producto
    $('#tabla_productos').on('click', '.btn-eliminar', function () {
        $(this).closest('tr').remove();
        actualizarTotal();
    });

    function actualizarTotal() {
        let total = 0;
        $('#tabla_productos tbody .subtotal').each(function () {
            total += parseFloat($(this).text()) || 0;
        });
        $('#subtotal').val(total.toFixed(2));
    }
});
</script>