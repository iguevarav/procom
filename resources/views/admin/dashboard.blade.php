@extends('adminlte::page')

@section('title', 'Panel de Compras')

@section('content')
<div class="hero-section d-flex flex-column align-items-center pt-3">
    <h1 class="text-white  display-1 text-uppercase animate__animated animate__fadeInDown">
        SISGECOM
    </h1>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/custom.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2_form + .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border-radius: 0.375rem;
    }

    .container-custom {
        max-width: 85%;
        margin: auto;
    }

    .hero-section {
        background-image: url('/images/wall.jpg'); /* Cambia por tu ruta */
        background-size: cover;
        background-position: center;
        height: 710px; /* altura ajustable */
        position: relative;
        display: flex;
        align-items: flex-start; /* texto arriba */
        justify-content: center;
        color: white;
        padding-top: 20px;
        font-weight: 900; 
    }

    .hero-section h1 {
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
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