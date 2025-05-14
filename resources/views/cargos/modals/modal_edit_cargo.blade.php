<div class="modal fade" id="mdlEditCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cargo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('cargos.forms.form_edit_cargo')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary btnActualizarCargo" type="submit" form="formActualizarCargo">
                    <i class="fa-solid fa-floppy-disk"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    let rowEditar = null;

    function eventsMdlEditCargo() {
        document.querySelector('#formActualizarCargo').addEventListener('submit', (e) => {
            e.preventDefault();
            actualizarCargo();
        })

        $('#mdlEditCargo').on('hidden.bs.modal', function(e) {
            const formActualizarCargo = document.querySelector('#formActualizarCargo');
            formActualizarCargo.reset();
            limpiarErroresValidacion('msgError_edit');
        });
    }

    function openMdlEditCargo(id) {
    fetch(`/cargos/show/${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#descripcion_edit').value = data.descripcion;

            document.querySelector('#formActualizarCargo').action = `/cargos/update/${id}`;

            // Mostrar el modal
            $('#mdlEditCargo').modal('show');
        })
        .catch(error => {
            toastr.error('Error al cargar el cargo');
        });
}



    function actualizarCargo() {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "DESEA ACTUALIZAR EL CARGO?",
            text: `Cargo: ${rowEditar.nombre}`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "SÍ, ACTUALIZAR!",
            cancelButtonText: "NO, CANCELAR!",
            reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {
                limpiarErroresValidacion('msgError_edit');
                const token = document.querySelector('input[name="_token"]').value;
                const formActualizarCargo = document.querySelector('#formActualizarCargo');
                const formData = new FormData(formActualizarCargo);
                // Usar un placeholder como __ID__ que Blade sí puede renderizar, y luego lo reemplazas tú en JS.
                let urlUpdateCargo = `{{ route('cargos.update', ['id' => '__ID__']) }}`;
                urlUpdateCargo = urlUpdateCargo.replace('__ID__', rowEditar.id);

                Swal.fire({
                    title: 'Cargando...',
                    html: 'Actualizando cargo...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch(urlUpdateCargo, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        body: formData
                    });

                    const res = await response.json();

                    console.log(res);

                    if (response.status === 422) {
                        if ('errors' in res) {
                            pintarErroresValidacionEdit(res.errors);
                        }
                        Swal.close();
                        return;
                    }

                    if (res.success) {
                        dtCargos.draw();
                        $('#mdlEditCargo').modal('hide');
                        toastr.success(res.message, 'OPERACIÓN COMPLETADA');
                        Swal.close();
                    } else {
                        toastr.error(res.message, 'ERROR EN EL SERVIDOR');
                        Swal.close();
                    }

                } catch (error) {
                    toastr.error(error, 'ERROR EN LA PETICIÓN ACTUALIZAR CARGO');
                    Swal.close();
                }


            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "OPERACIÓN CANCELADA",
                    text: "NO SE REALIZARON ACCIONES",
                    icon: "error"
                });
            }
        });
    }


    function pintarErroresValidacionEdit(objErroresValidacion) {
        for (let clave in objErroresValidacion) {
            const pError = document.querySelector(`.${clave}_error`);
            pError.textContent = objErroresValidacion[clave][0];
        }
    }
</script>