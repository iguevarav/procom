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
                    <input type="number" name="costo[]" class="form-control costo" required readonly>
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

<script type="text/javascript">
$(document).ready(function () {
    $('#productos').on('change', '.producto_id', function() {
        const $bloque = $(this).closest('.producto');
        const costo = parseFloat($(this).find('option:selected').data('costo')) || 0;
        $bloque.find('.costo').val(costo.toFixed(2));
        recalcularItem($bloque);
    });

    $('#productos').on('input', '.cantidad', function() {
        recompute = true;
        recalcularItem($(this).closest('.producto'));
    });

    function recalcularItem($bloque) {
        const cantidad = parseFloat($bloque.find('.cantidad').val()) || 0;
        const costo    = parseFloat($bloque.find('.costo').val()) || 0;
        const subtotal = cantidad * costo;
        $bloque.find('.subtotal_item').val(subtotal.toFixed(2));
    }

    $('#agregar_producto').click(function() {
        const $bloque = $('#productos .producto').first();
        const idProd    = $bloque.find('.producto_id').val();
        const textoProd = $bloque.find('.producto_id option:selected').text();
        const cantidad  = parseFloat($bloque.find('.cantidad').val()) || 0;
        const costo     = parseFloat($bloque.find('.costo').val()) || 0;
        const subtotal  = parseFloat($bloque.find('.subtotal_item').val()) || 0;

        if (!idProd || idProd == 0) {
            alert('Por favor selecciona un producto.');
            return;
        }
        if (cantidad <= 0) {
            alert('Ingresa una cantidad válida.');
            return;
        }

        const fila = `
            <tr>
                <td>${textoProd}</td>
                <td class="text-right">${cantidad}</td>
                <td class="text-right">${costo.toFixed(2)}</td>
                <td class="text-right subtotal">${subtotal.toFixed(2)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar">
                        &times;
                    </button>
                </td>
            </tr>
        `;
        $('#tabla_productos tbody').append(fila);

        actualizarTotal();

        $bloque.find('.cantidad').val('');
        $bloque.find('.subtotal_item').val('');
    });
    

    $('#tabla_productos').on('click', '.btn-eliminar', function() {
        $(this).closest('tr').remove();
        actualizarTotal();
    });

    function actualizarTotal() {
        let total = 0;
        $('#tabla_productos tbody .subtotal').each(function() {
            total += parseFloat($(this).text()) || 0;
        });
        $('#subtotal').val(total.toFixed(2));
    }
});
</script>
