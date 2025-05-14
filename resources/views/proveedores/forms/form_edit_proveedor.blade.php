@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formActualizarProveedor" method="POST" action="{{ route('proveedores.update', $proveedor->id) }}">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="razon_social" class="required_field mb-2" style="font-weight: bold;">Razon Social</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $proveedor->razon_social }}" id="razon_social" maxlength="260" name="razon_social" type="text" class="form-control" placeholder="Razon Social" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="razon_social_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="ruc" class="required_field mb-2" style="font-weight: bold;">RUC</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $proveedor->ruc }}" id="ruc" maxlength="260" name="ruc" type="text" class="form-control" placeholder="RUC" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="ruc_error msgError" style="color:red;"></span>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label class="required_field mb-2" for="categoria" style="font-weight: bold;">Tipo</label>
            <select required name="tipo_proveedor_id" class="form-select select2_form" id="tipo_proveedor" data-placeholder="Seleccionar">
                <option></option>
                @foreach ($tipos_proveedor as $tipopro)
                <option
                @if ($proveedor->tipo_proveedor_id == $tipopro->id)
                selected
                @endif
                    value="{{$tipopro->id}}">{{$tipopro->descripcion}}</option>
                @endforeach
            </select>
            <span class="tipo_proveedor_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="telefono" class="required_field mb-2" style="font-weight: bold;">Telefono</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value ="{{ $proveedor->telefono }}" id="telefono" maxlength="15" name="telefono" type="tel" class="form-control"
                    placeholder="Telefono" aria-label="Username" aria-describedby="basic-addon1" pattern="^\+?[0-9]{1,4}?[-.●]?(\(?\d{1,3}?\)?[-.●]?)?[\d●]{1,4}[-.●]?[0-9]{1,4}[-.●]?[0-9]{1,9}$"
                    title="Introduce un número de teléfono válido">
            </div>
            @error('telefono')
            <span class="telefono_error msgError" style="color:red;">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="email" class="required_field mb-2" style="font-weight: bold;">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value = "{{ $proveedor->email }}"id="email" maxlength="260" name="email" type="text" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="email_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="direccion" class="required_field mb-2" style="font-weight: bold;">Direccion</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $proveedor->direccion }}" id="direccion" maxlength="260" name="direccion" type="text" class="form-control" placeholder="Direccion" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="direccion_error msgError" style="color:red;"></span>
        </div>

    </div>
</form>