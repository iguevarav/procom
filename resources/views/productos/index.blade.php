@extends ('admin.dashboard')

@section('content_header')
    <h3 class="container-custom"  >LISTA DE PRODUCTOS</h3>
@endsection

@section('content')
<div class="container-custom">
    <a href="{{route('productos.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar</a>

    <nav class="navbar navbar-light float-right">
        <form class="form-inline my-lg-0" method="GET">
            <input name="buscarpor" class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" arial-label="Search" value="">
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
    <table class="table-responsive">
        @include('productos.tables.table_list_productos')
    </table>
    {{$producto->links()}}
</div>
@endsection