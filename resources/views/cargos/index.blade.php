@extends ('admin.dashboard')


@section('content_header')
<h3 class="container-custom">LISTA DE CARGOS</h3>
@endsection

@section('content')
@include('cargos.modals.modal_create_cargo')
@include('cargos.modals.modal_edit_cargo')

<div class="container-custom">
    <button class="btn btn-primary" onclick="openModalNuevoCargo()">
        <i class="fas fa-plus"></i> Registrar
    </button>

    <nav class="navbar navbar-light float-right">
        <form class="form-inline my-lg-0" method="GET" action="{{ route('cargos.buscar')}}">
            <input name="buscarpor" class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" arial-label="Search">
            <button class="btn btn-secondary my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

    @if(session('datos'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{ session('datos') }}
        <button type="button" class="close" data-dismiss="alert" arial-label="close">
            <span arial-hidden="true">&times;</span>
        </button>
    </div>

    @endif
    <div class="table-responsive">
        @include('cargos.tables.table_list_cargos')
    </div>
    {{$cargo->links()}}
</div>
@endsection