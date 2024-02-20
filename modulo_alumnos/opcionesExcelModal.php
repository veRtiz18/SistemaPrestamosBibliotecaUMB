<!-- Modal -->
<div class="modal fade" id="modalMenuExcel" aria-hidden="true" aria-labelledby="modalMenuExcelLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-excel-color text-light">
                <h1 class="modal-title fs-5" id="modalExportarExcelLabel"><i class="fa-solid fa-user-check"></i> Importar usuarios desde Excel</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <h5>Seleccione una opción a realizar:</h5>

                        <!-- Alert dentro del modal -->

                        <div class="justify-content-md-end col-12">
                            <p class="fs-6">Importar usuarios desde Excel:</p>
                            <form enctype="multipart/form-data" method="post" action="./accionesExcel/importarRegistros.php" class="needs-validation" novalidate>
                                <div class="form-group">
                                    <!-- <label for="importar_excel" class="fs-6">Selecciona un archivo Excel:</label> -->
                                    <input type="file" class="form-control form-control-sm" id="importar_excel" id="archivo_excel" name="archivo_excel" accept=".xlsx, .xls" required>
                                    <div class="invalid-feedback">
                                        ¡Ups! No se ha seleccionado ningún archivo
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-excel-color mt-1 btn-sm">
                                        <i class="fa-solid fa-upload"></i> Importar registros</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // script: Funciona para validar campos vacios
        (function() {
            'use strict'

            // Obtener todos los formularios a los que queremos aplicar estilos de validación de Bootstrap personalizados
            var forms = document.querySelectorAll('.needs-validation')
            // Bucle sobre ellos y evitar el envío
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>