<!-- Modal -->
<div class="modal fade" id="modalMenuExcel" aria-hidden="true" aria-labelledby="modalMenuExcelLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-excel-color text-light">
                <h1 class="modal-title fs-5" id="modalExportarExcelLabel">Importar y Exportar desde Excel</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <h5>Seleccione una opción a realizar:</h5>
                        <div class="col-12">
                            <!-- Alert dentro del modal -->
                            <div class="alert alert-success d-none" id="excelAlert">
                                Exportación de libros hacia Excel iniciada!
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="fs-6">Exportar registros hacia Excel</p>
                            <form action="./accionesExcel/exportarRegistros.php" method="POST" class="needs-validation" novalidate>

                                <select class="form-select form-select-sm" id="fecha_don" name="fecha_don" required>
                                    <option value="">Seleccione una fecha:</option>
                                    <option value="TODOS LOS LIBROS">TODOS LOS LIBROS</option>
                                    <?php while ($row_fechas = $fechas->fetch_assoc()) { ?>
                                        <option value="<?php echo $row_fechas["fecha_libro"]; ?>"><?= $row_fechas["fecha_libro"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Debe seleccionar una opción.
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-excel-color mt-1 btn-sm">
                                        <i class="fa-solid fa-download"></i> Exportar registros</button>
                                </div>
                            </form>
                        </div>




                        <div class="justify-content-md-end col-6">
                            <p class="fs-6">Importar registros desde Excel:</p>
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