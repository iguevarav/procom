@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<form method="POST" action="{{ route('orden_compra.store') }}" id="formRegistrarOrdenCompra" class="row g-3 needs-validation" novalidate>
    @csrf
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label class="required_field mb-2" for="empleado" style="font-weight: bold;">Empleado</label>
        <select required name="empleado_id" class="form-select select2_form" id="empleado" data-placeholder="Seleccionar">
            <option></option>
            @foreach ($empleados as $empleado)
            <option
                value="{{$empleado->id}}">{{$empleado->nombre}}</option>
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
                value="{{$proveedor->id}}">{{$proveedor->razon_social}}</option>
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
            <input required id="fecha_compra" name="fecha_compra" type="date" class="form-control" aria-label="Fecha de Compra" aria-describedby="basic-addon1">
        </div>
        <span class="fecha_compra_error msgError" style="color:red;"></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="motivo_compra" class="required_field mb-2" style="font-weight: bold;">Motivo</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-file-signature"></i>
            </span>
            <input required id="motivo_compra" maxlength="260" name="motivo_compra" type="text" class="form-control" placeholder="Motivo" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <span class="motivo_compra_error msgError" style="color:red;"></span>
    </div>

    <hr>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="productoSelect" class="required_field mb-2" style="font-weight: bold; display: block;">Producto</label>
        <select
            required
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
        <label for="precioUnitario" class="mb-2" style="font-weight: bold;">Costo Unitario</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon-precio">
                <i class="fa-solid fa-dollar-sign"></i>
            </span>
            <input type="text" id="precioUnitario" name="precioUnitario" class="form-control" placeholder="Precio Unitario" aria-label="Precio Unitario" aria-describedby="basic-addon-precio" disabled>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="cantidad" class="required_field mb-2" style="font-weight: bold;">Cantidad</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-cubes"></i>
            </span>
            <input required id="cantidad" name="cantidad" type="number" min="1" value="1" class="form-control" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon1">
        </div>
        <span class="cantidad_error msgError" style="color:red;"></span>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="subtotal" class="mb-2" style="font-weight: bold;">Subtotal</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon-subtotal">
                <i class="fa-solid fa-calculator"></i>
            </span>
            <input type="text" id="subtotal" name="subtotal" class="form-control" placeholder="Subtotal" aria-label="Subtotal" aria-describedby="basic-addon-subtotal" disabled>
        </div>
    </div>

    <button class=" btn btn-primary" type="button" id="btnAgregar">
        <i class="fa-solid fa-floppy-disk"></i> Agregar Producto
    </button>

    <hr>


    <div class="table-responsive pt-5">
        @include('orden_compra.tables.table_list_productos_orden')
    </div>

    <h4>Total: <span id="total">0.00</span></h4>

    <!-- Aquí se insertarán inputs ocultos para enviar productos en el formulario -->
    <div id="inputsProductos"></div>

</form>

<script>
    const productoSelect = document.getElementById('productoSelect');
    const precioUnitarioInput = document.getElementById('precioUnitario');
    const cantidadInput = document.getElementById('cantidad');
    const subtotalInput = document.getElementById('subtotal');
    const btnAgregar = document.getElementById('btnAgregar');
    const tablaProductos = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
    const totalSpan = document.getElementById('total');
    const inputsProductos = document.getElementById('inputsProductos');

    let total = 0;
    let productosAgregados = [];

    productoSelect.addEventListener('change', () => {
        const selectedOption = productoSelect.options[productoSelect.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio') || 0;
        precioUnitarioInput.value = parseFloat(precio).toFixed(2);
        actualizarSubtotal();
    });

    cantidadInput.addEventListener('input', actualizarSubtotal);

    function actualizarSubtotal() {
        const cantidad = parseInt(cantidadInput.value) || 0;
        const precio = parseFloat(precioUnitarioInput.value) || 0;
        subtotalInput.value = (cantidad * precio).toFixed(2);
    }

    btnAgregar.addEventListener('click', () => {
        const productoId = productoSelect.value;
        const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
        const precioUnitario = parseFloat(precioUnitarioInput.value);
        const cantidad = parseInt(cantidadInput.value);

        if (!productoId || cantidad <= 0 || isNaN(precioUnitario)) {
            alert('Seleccione un producto válido y cantidad correcta.');
            return;
        }

        // Verificar si ya está agregado (sumar cantidad)
        const existeIndex = productosAgregados.findIndex(p => p.productoId === productoId);
        if (existeIndex >= 0) {
            productosAgregados[existeIndex].cantidad += cantidad;
            productosAgregados[existeIndex].subtotal = productosAgregados[existeIndex].cantidad * productosAgregados[existeIndex].precioUnitario;
        } else {
            productosAgregados.push({
                productoId,
                productoNombre,
                cantidad,
                precioUnitario,
                subtotal: cantidad * precioUnitario
            });
        }

        renderizarTabla();
        limpiarCamposProducto();
    });

    function renderizarTabla() {
        tablaProductos.innerHTML = '';
        total = 0;
        inputsProductos.innerHTML = '';

        productosAgregados.forEach((prod, index) => {
            total += prod.subtotal;

            // Fila tabla

            const row = tablaProductos.insertRow();
            row.insertCell(0).innerText = prod.productoNombre;
            row.insertCell(1).innerText = prod.cantidad;
            row.insertCell(2).innerText = prod.precioUnitario.toFixed(2);
            row.insertCell(3).innerText = prod.subtotal.toFixed(2);
            const celdaAccion = row.insertCell(4);
            const btnEliminar = document.createElement('button');
            btnEliminar.innerText = 'Eliminar';
            btnEliminar.className = 'btn btn-danger btn-sm';
            btnEliminar.classList.add('btn-eliminar');
            btnEliminar.type = 'button';
            btnEliminar.onclick = () => {
                productosAgregados.splice(index, 1);
                renderizarTabla();
            };
            celdaAccion.appendChild(btnEliminar);

            // Inputs ocultos para enviar al backend
            inputsProductos.innerHTML += `
                <input type="hidden" name="productos[${index}][producto_id]" value="${prod.productoId}">
                <input type="hidden" name="productos[${index}][cantidad]" value="${prod.cantidad}">
                <input type="hidden" name="productos[${index}][precio_unitario]" value="${prod.precioUnitario}">
            `;
        });

        totalSpan.innerText = total.toFixed(2);
    }

    function limpiarCamposProducto() {
        productoSelect.value = '';
        precioUnitarioInput.value = '';
        cantidadInput.value = 1;
        subtotalInput.value = '';
    }
</script>