@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido al panel de administración</h1>
@stop

@section('content')
<p>Este es el contenido principal del dashboard.</p>
@stop

@section('css')
<link rel="stylesheet" href="/css/custom.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2_form+.select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border-radius: 0.375rem;
    }

    .container-custom {
        max-width: 85%;
        margin: auto;
    }
</style>


@stop

@section('js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Inicialización global -->
<script>
    $(document).ready(function() {
        $('.select2_form').select2({
            width: '100%',
            placeholder: 'Seleccionar',
            allowClear: true
        });
    });
</script>
@stop