@extends('admin.dashboard')

@section('content_header')
    <h3 class="container-custom">EDITAR ORDEN DE COMPRA</h3>
@endsection

@section('content')
<div class="container-custom">
    @include('orden_compras.forms.form_edit_orden_compra')
</div>

<div class="container-custom card-style settings-card-1 mb-30">
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="color:rgb(219, 155, 35);font-size:14px;font-weight:bold;">Los campos con * son obligatorios</span>

        <div style="display:flex;">
            <button class="btn btn-danger btnVolver" style="margin-right:5px;" type="button">
                <i class="fa-solid fa-door-open"></i> VOLVER
            </button>
            <button class="btn btn-primary" type="submit" form="formActualizarEmpleado">
                <i class="fa-solid fa-floppy-disk"></i> ACTUALIZAR
            </button>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.btnVolver').addEventListener('click', function () {
            window.location.href = "{{ route('orden_compras.index') }}";
        });
    });
</script>
