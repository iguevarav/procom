@extends ('admin.dashboard')

@section('content_header')
<h3 class="container-custom"></h3>
@endsection

@section('content')
<div class="container-custom p-5 bg-white rounded shadow-sm">
    <h2 class="mb-3">Detalle Orden: <span class="text-primary">{{ $orden->numero_documento }}</span></h2>

    <div class="mb-3 row">
        <div class="col-md-3">
            <p><strong>Empleado:</strong> <span class="text-secondary">{{ $orden->empleado->nombre }}</span></p>
        </div>
        <div class="col-md-3">
            <p><strong>Proveedor:</strong> <span class="text-secondary">{{ $orden->proveedor->razon_social }}</span></p>
        </div>
        <div class="col-md-3">
            <p><strong>Fecha:</strong> <span class="text-secondary">{{ $orden->fecha_compra->format('d/m/Y') }}</span></p>
        </div>
        <div class="col-md-3">
            <p><strong>Motivo:</strong> <span class="text-secondary">{{ $orden->motivo_compra }}</span></p>
        </div>
    </div>


    <h3 class="mb-3">Productos</h3>
    <div class="table-responsive mb-3">
        <table class="table table-striped">
            @include('orden_compra.tables.table_list_productos_detalle', ['detalles' => $orden->detalles])
        </table>
    </div>

    <p class="fs-6"><strong>Total: </strong> <span class="text-success">S/. {{ number_format($orden->subtotal, 2) }}</span></p>

    <button class="btn btn-danger btnVolver mt-3" type="button">
        <i class="fa-solid fa-door-open me-2"></i> VOLVER
    </button>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.btnVolver').addEventListener('click', function() {
            window.location.href = "{{ route('orden_compra.index') }}";
        });
    });
</script>
@endsection