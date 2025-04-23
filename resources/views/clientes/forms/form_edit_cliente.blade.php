@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formActualizarCliente" method="POST" action="{{ route('clientes.update', $cliente->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="nombre" class="required_field mb-2" style="font-weight: bold;">Nombre</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $cliente->nombre }}" id="nombre" maxlength="260" name="nombre" type="text" class="form-control" placeholder="Nombre" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="nombre_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label class="required_field mb-2" for="categoria" style="font-weight: bold;">Tipo Documento</label>
            <select required name="tipo_documento_id" class="form-select select2_form" id="tipo_documento" data-placeholder="Seleccionar">
                <option></option>
                @foreach ($tipos_documento as $tipodoc)
                <option
                    @if ($cliente->tipo_documento_id === $tipodoc->id)
                    selected
                    @endif
                    value="{{$tipodoc->id}}">{{$tipodoc->descripcion}}</option>
                @endforeach
            </select>

            <span class="tipo_documento_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="numero_documento" class="required_field mb-2" style="font-weight: bold;">N° Documento</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $cliente -> numero_documento }}" id="numero_documento" maxlength="260" name="numero_documento" type="text" class="form-control" placeholder="N° Documento" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="numero_documento_error msgError" style="color:red;"></span>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="email" class="required_field mb-2" style="font-weight: bold;">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value = "{{ $cliente->email }}"id="email" maxlength="260" name="email" type="text" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="email_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="telefono" class="required_field mb-2" style="font-weight: bold;">Telefono</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value = "{{ $cliente->telefono }}" id="telefono" maxlength="15" name="telefono" type="tel" class="form-control"
                    placeholder="Telefono" aria-label="Username" aria-describedby="basic-addon1" pattern="^\+?[0-9]{1,4}?[-.●]?(\(?\d{1,3}?\)?[-.●]?)?[\d●]{1,4}[-.●]?[0-9]{1,4}[-.●]?[0-9]{1,9}$"
                    title="Introduce un número de teléfono válido">
            </div>
            @error('telefono')
            <span class="telefono_error msgError" style="color:red;">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="direccion" class="required_field mb-2" style="font-weight: bold;">Direccion</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value= "{{ $cliente->direccion }}"id="direccion" maxlength="260" name="direccion" type="text" class="form-control" placeholder="Direccion" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="direccion_error msgError" style="color:red;"></span>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-2">
            <label for="fecha_nacimiento" class="required_field mb-2" style="font-weight: bold;">Fecha Nacimiento</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-file-signature"></i>
                </span>
                <input required value="{{ $cliente->fecha_nacimiento }}" id="fecha_nacimiento" maxlength="260" name="fecha_nacimiento" type="text" class="form-control" placeholder="Fecha Nacimiento" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <span class="fecha_nacimiento_error msgError" style="color:red;"></span>
        </div>


    </div>
</form>