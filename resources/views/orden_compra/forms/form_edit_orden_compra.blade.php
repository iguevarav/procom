@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<form id="formActualizarOrdenCompra" method="POST" class="row g-3 needs-validation" action="{{ route('orden_compra.update', $orden->id) }}">
    @csrf
    @method('PUT')

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label class="required_field mb-2" for="empleado" style="font-weight: bold;">Empleado</label>
        <select required name="empleado_id" class="form-select select2_form" id="empleado" data-placeholder="Seleccionar">
            <option></option>
            @foreach ($empleados as $empleado)
            <option
                value="{{$empleado->id}}" {{ $orden->empleado_id == $empleado->id ? 'selected' : '' }}>
                {{$empleado->nombre}}
            </option>
            @endforeach
        </select>
        <span class="empleado_error msgError" style="color:red;"></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label class="required_field mb-2" for="proveedor" style="font-weight: bold;">Proveedor</label>
        <select required name="proveedor_id" class="form-select select2_form" id="proveedor" data-placeholder="Seleccionar">
            <option></option>
            @foreach ($proveedores as $proveedor)
            <option
                value="{{$proveedor->id}}" {{ $orden->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                {{$proveedor->razon_social}}
            </option>
            @endforeach
        </select>
        <span class="proveedor_error msgError" style="color:red;"></span>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="fecha_compra" class="required_field mb-2" style="font-weight: bold;">Fecha</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-calendar-days"></i>
            </span>
            <input required id="fecha_compra" value="{{ $orden->fecha_compra->format('Y-m-d') }}" name="fecha_compra" type="date" class="form-control" aria-label="Fecha de Compra" aria-describedby="basic-addon1">
        </div>
        <span class="fecha_compra_error msgError" style="color:red;"></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="motivo_compra" class="required_field mb-2" style="font-weight: bold;">Motivo</label>
        <div class="input-group mb-3">
            <input required value="{{ $orden->motivo_compra }}" id=" motivo_compra" maxlength="260" name="motivo_compra" type="text" class="form-control" placeholder="Motivo" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <span class="motivo_compra_error msgError" style="color:red;"></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="productoSelect" class="required_field mb-2" style="font-weight: bold; display: block;">Producto</label>
        <select
            id="productoSelect"
            name="productoSelect"
            class="form-select w-100"
            aria-label="Seleccionar Producto"
            style="height: 37px; border-radius: 0.2rem;">
            <option value="" disabled selected>Seleccionar</option>
            @foreach ($productos as $producto)
            <option value="{{ $producto->id }}" data-precio="{{ $producto->costo }}">
                {{ $producto->nombre }}
            </option>
            @endforeach
        </select>
        <span class="producto_error msgError" style="color:red;"></span>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="cantidad" class="required_field mb-2" style="font-weight: bold;">Cantidad</label>
        <div class="input-group mb-3">
            <input required id="cantidadInput" type="number" min="1" value="1" class="form-control" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon1">
        </div>
        <span class="cantidad_error msgError" style="color:red;"></span>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="precioUnitario" class="mb-2" style="font-weight: bold;">Costo Unitario</label>
        <div class="input-group mb-3">
            <input type="text" id="precioInput" class="form-control" placeholder="Costo Unitario" aria-label="Precio Unitario" aria-describedby="basic-addon-precio" disabled>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="subtotal" class="mb-2" style="font-weight: bold;">Subtotal</label>
        <div class="input-group mb-3">
            <input type="text" id="subtotalInput" class="form-control" placeholder="Subtotal" aria-label="Subtotal" aria-describedby="basic-addon-subtotal" disabled>
        </div>
    </div>

    <button class=" btn btn-primary" type="button" id="btnAgregarProducto">
        <i class="fa-solid fa-floppy-disk"></i> Agregar
    </button>


    <div class="table-responsive">
        <table class="table table-hover table-striped" id="tablaProductos" style="margin-top:15px;">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->detalles as $index => $detalle)
                <tr data-index="{{ $index }}">
                    <td>
                        {{ $detalle->producto->nombre }}
                        <input required type="hidden" name="productos[{{ $index }}][producto_id]" value="{{ $detalle->producto_id }}">
                    </td>
                    <td>
                        <input required type="number" name="productos[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" min="1" required>
                    </td>
                    <td>
                        <input required type="text" name="productos[{{ $index }}][precio_unitario]" value="{{ $detalle->precio_unitario }}" readonly>
                    </td>
                    <td>
                        <input required type="text" name="productos[{{ $index }}][subtotal]" value="{{ $detalle->subtotal }}" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btnEliminarFila">
                            <i class="fas fa-times"></i>
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-light p-2 rounded shadow-sm  w-100">
        <h5 class="m-0 fw-bold text-dark">
            TOTAL :  <span id="totalSpan" class="text-success"  style="font-size:20px;font-weight:bold;" >S/. 0.00</span>
        </h5>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productoSelect = document.getElementById('productoSelect');
        const cantidadInput = document.getElementById('cantidadInput');
        const precioInput = document.getElementById('precioInput');
        const subtotalInput = document.getElementById('subtotalInput');
        const btnAgregarProducto = document.getElementById('btnAgregarProducto');
        const tablaProductos = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
        const totalSpan = document.getElementById('totalSpan');

        function actualizarSubtotal() {
            const cantidad = parseInt(cantidadInput.value) || 0;
            const precio = parseFloat(precioInput.value) || 0;
            subtotalInput.value = (cantidad * precio).toFixed(2);
        }

        productoSelect.addEventListener('change', () => {
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio') || 0;
            precioInput.value = parseFloat(precio).toFixed(2);
            actualizarSubtotal();
        });

        cantidadInput.addEventListener('input', actualizarSubtotal);

        btnAgregarProducto.addEventListener('click', () => {
            const productoId = productoSelect.value;
            const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
            const precioUnitario = parseFloat(precioInput.value);
            const cantidad = parseInt(cantidadInput.value);

            if (!productoId || cantidad <= 0 || isNaN(precioUnitario)) {
                alert('Seleccione un producto válido y cantidad correcta.');
                return;
            }

            // Validar que no esté repetido (puedes mejorar lógica)
            let repetido = false;
            for (const row of tablaProductos.rows) {
                const inputProductoId = row.querySelector('input[name*="[producto_id]"]');
                if (inputProductoId && inputProductoId.value === productoId) {
                    alert('El producto ya está agregado.');
                    repetido = true;
                    break;
                }
            }
            if (repetido) return;

            const subtotal = cantidad * precioUnitario;

            const rowCount = tablaProductos.rows.length;
            const row = tablaProductos.insertRow();

            row.setAttribute('data-index', rowCount);

            row.innerHTML = `
            <td>
                ${productoNombre}
                <input type="hidden" name="productos[${rowCount}][producto_id]" value="${productoId}">
            </td>
            <td>
                <input type="number" name="productos[${rowCount}][cantidad]" value="${cantidad}" min="1" required>
            </td>
            <td>
                <input type="text" name="productos[${rowCount}][precio_unitario]" value="${precioUnitario.toFixed(2)}" readonly>
            </td>
            <td>
                <input type="text" name="productos[${rowCount}][subtotal]" value="${subtotal.toFixed(2)}" readonly>
            </td>
            <td>
                <button type="button" class="btnEliminarFila">Eliminar</button>
            </td>
        `;

            actualizarTotal();
            limpiarInputs();
        });

        function actualizarTotal() {
            let total = 0;
            for (const row of tablaProductos.rows) {
                const subtotalInput = row.querySelector('input[name*="[subtotal]"]');
                if (subtotalInput) {
                    total += parseFloat(subtotalInput.value) || 0;
                }
            }
            totalSpan.textContent = total.toFixed(2);
        }

        function limpiarInputs() {
            productoSelect.selectedIndex = 0;
            precioInput.value = '';
            cantidadInput.value = 1;
            subtotalInput.value = '';
        }

        // Evento para eliminar fila
        tablaProductos.addEventListener('click', function(e) {
            if (e.target.classList.contains('btnEliminarFila')) {
                const fila = e.target.closest('tr');
                fila.remove();
                actualizarTotal();
                reindexarInputs();
            }
        });

        // Reindexar inputs después de eliminar fila para evitar conflictos en el name
        function reindexarInputs() {
            const filas = tablaProductos.rows;
            for (let i = 0; i < filas.length; i++) {
                filas[i].setAttribute('data-index', i);
                filas[i].querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name');
                    const nuevoName = name.replace(/\d+/, i);
                    input.setAttribute('name', nuevoName);
                });
            }
        }

        // Actualiza subtotal si cambia cantidad manualmente
        tablaProductos.addEventListener('input', function(e) {
            if (e.target.name.includes('[cantidad]')) {
                const fila = e.target.closest('tr');
                const cantidad = parseInt(e.target.value) || 1;
                const precioInput = fila.querySelector('input[name*="[precio_unitario]"]');
                const subtotalInput = fila.querySelector('input[name*="[subtotal]"]');
                const precio = parseFloat(precioInput.value) || 0;
                subtotalInput.value = (cantidad * precio).toFixed(2);
                actualizarTotal();
            }
        });

        actualizarTotal();
    });
</script>