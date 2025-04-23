@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form id="formRegistrarProducto" method="post" action="{{ route('productos.store') }}">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="nombre" class="required_field mb-2" style="font-weight: bold;">Nombre</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required id="nombre" maxlength="260" name="nombre" type="text" class="form-control" placeholder="Nombre" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="nombre_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="descripcion" class="mb-2" style="font-weight: bold;">Descripcion</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-key"></i>
                </span>
                <input id="descripcion" maxlength="260" name="descripcion" type="text" class="form-control" placeholder="Descripcion" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="descripcion_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label class="required_field mb-2" for="categoria" style="font-weight: bold;">CATEGORÍA</label>
            <select required name="id_categoria" class="form-select select2_form" id="categoria" data-placeholder="Seleccionar">
                <option></option>
                @foreach ($categorias as $categoria)
                <option
                    value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
                @endforeach
            </select>

            <span class="categoria_error msgError" style="color:red;"></span>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label class="required_field mb-2" for="marca" style="font-weight: bold;">
                MARCA
            </label>
            <select required name="id_marca" required class="form-select select2_form" id="marca" data-placeholder="Seleccionar">
                <option></option>
                @foreach ($marcas as $marca)
                <option value="{{$marca->id}}">{{$marca->descripcion}}</option>
                @endforeach
            </select>
            <span class="marca_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="costo" class="required_field mb-2" style="font-weight: bold;">Costo</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </span>
                <input value="1.00" required id="costo" maxlength="20" name="costo" type="text" class="form-control inputDecimalPositivo" placeholder="Costo" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="costo_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="precio" class="required_field mb-2" style="font-weight: bold;">Precio</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </span>
                <input value="1.00" required id="precio" maxlength="20" name="precio" type="text" class="form-control inputDecimalPositivo" placeholder="Precio" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="precio_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="stock" class="required_field mb-2" style="font-weight: bold;">Stock</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <input required min="0" id="stock" maxlength="20" name="stock" type="number" class="form-control" placeholder="Stock" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="stock_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label class="required_field mb-2" for="unidad" style="font-weight: bold;">UNIDAD</label>
            <select required name="id_unidad" required class="form-select select2_form" id="unidad" data-placeholder="Seleccionar">
                <option></option>
                @foreach ($unidades as $unidad)
                <option value="{{$unidad->id}}">{{$unidad->descripcion}}</option>
                @endforeach
            </select>
            <span class="unidad_error msgError" style="color:red;"></span>
        </div>
    </div>
</form>