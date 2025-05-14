@extends('admin.dashboard')

@section('content_header')
    <h3 class="container-custom">LISTA DE ÓRDENES DE COMPRA</h3>
@endsection

@section('content')
<div class="container-custom">
    <a href="{{ route('orden_compras.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Orden de Compra</a>

    <nav class="navbar navbar-light float-right">
        <form class="form-inline my-lg-0" method="GET" action="{{ route('orden_compras.buscar') }}">
            <input name="buscarpor" class="form-control mr-sm-2" type="search" placeholder="Buscar por número de documento" aria-label="Search" value="">
            <button class="btn btn-secondary my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

    @if(session('datos'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{ session('datos') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <table class="table-responsive">
        @include('orden_compras.tables.table_list_orden_compras')
    </table>
    
    {{$orden_compra->links()}}
</div>
@endsection
