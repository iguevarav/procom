@extends('admin.dashboard')

@section('content_header')
<h3 class="container-custom">REGISTRAR ORDEN DE COMPRA</h3>
@endsection


@section('content')
<div class="container-custom">
    @include('orden_compra.forms.form_create_orden_compra')
</div>

<div class="container-custom card-style settings-card-1 mb-30">
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="color:rgb(219, 155, 35);font-size:14px;font-weight:bold;">Los campos son obligatorios</span>

        <div style="display:flex;">
            <button class="btn btn-danger btnVolver" style="margin-right:5px;" type="button">
                <i class="fa-solid fa-door-open"></i> VOLVER
            </button>
            <button class="btn btn-primary" type="submit" form="formRegistrarOrdenCompra">
                <i class="fa-solid fa-floppy-disk"></i> REGISTRAR
            </button>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.btnVolver').addEventListener('click', function () {
            window.location.href = "{{ route('clientes.index') }}";
        });
    });
</script>






<!-- @section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('orden_compra.store') }}" class="row g-3 needs-validation" novalidate>
    @csrf
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label class="required_field mb-2" for="empleado" style="font-weight: bold;">Empleado</label>
        <select  name="empleado_id" class="form-select select2_form" id="empleado" data-placeholder="Seleccionar">
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
        <select  name="proveedor_id" class="form-select select2_form" id="proveedor" data-placeholder="Seleccionar">
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

    <h4>Agregar Productos</h4>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
        <label for="productoSelect" class="required_field mb-2" style="font-weight: bold;">Producto</label>
        <select id="productoSelect" class="form-select">
            <option value="">Seleccione producto</option>
            @foreach($productos as $producto)
            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">{{ $producto->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Precio Unitario</label>
        <input type="text" id="precioUnitario" disabled>
    </div>

    <div>
        <label>Cantidad</label>
        <input type="number" id="cantidad" min="1" value="1">
    </div>

    <div>
        <label>Subtotal</label>
        <input type="text" id="subtotal" disabled>
    </div>

    <button type="button" id="btnAgregar">Agregar Producto</button>

    <hr>

    <h4>Productos agregados</h4>

    <table class="table-responsive">
        @include('orden_compra.tables.table_list_productos_orden')
    </table>

    <h4>Total: <span id="total">0.00</span></h4>

    <!-- Aquí se insertarán inputs ocultos para enviar productos en el formulario -->
    <div id="inputsProductos"></div>

    <button type="submit">Registrar Orden</button>
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

@endsection -->