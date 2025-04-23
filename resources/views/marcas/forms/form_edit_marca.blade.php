<form action="" id="formActualizarMarca" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
            <label for="descripcion_edit" style="font-weight: bold;" class="required_field">Descripción</label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-tags"></i>
                </span>
                <input maxlength="150" required id="descripcion_edit" name="descripcion" type="text" class="form-control" placeholder="Marca" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>
            <span class="descripcion_edit_error msgError_edit" style="color:red;"></span>
        </div>
    </div>
</form>
