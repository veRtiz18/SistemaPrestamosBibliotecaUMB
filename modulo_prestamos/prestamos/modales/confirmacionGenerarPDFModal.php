<!-- Modal actualizar registro Estudiantes -->
<div class="modal fade" id="confirmacionGenerarPDF" tabindex="-1" aria-labelledby="confirmacionGenerarPDFModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="confirmacionGenerarPDFModalLabel"><i class="fa-solid fa-file-pdf"></i> Generar Reporte PDF</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./pdf/reporte_libros_prestamo.php" method="POST">
                    <div class="container">
                        <div class="row">
                            <h6 class="text-center">En el archivo PDF se generarán todos los adeudos vigentes de la siguiente persona:</h6>
                            <input type="text" id="id" name="id" class="form-control mb-3" readonly hidden>

                            <ul class="list-group">

                                <li class="list-group-item bg-danger text-light">
                                    <h6><i class="fa-solid fa-person-circle-plus"></i> Datos de (la) deudor (a)</h6>
                                </li>
                                <li class="list-group-item">
                                    <input type="text" name="matricula" id="matricula" class="mb-1 border-0 fs-6 form-control fw-bold" readonly value="">
                                </li>

                                <li class="list-group-item">
                                    <input type="text" name="nombre_alumno" id="nombre_alumno" class="mb-1 border-0 fs-6 form-control fw-bold" readonly value="">
                                </li>
                     
                                <li class="list-group-item">
                                    <input type="text" name="carrera" id="carrera" class="mb-1 border-0 fs-6 form-control" readonly value="">
                                </li>
                                <li class="list-group-item">
                                    <input type="text" name="semestre" id="semestre" class="mb-1 border-0 fs-6 form-control" readonly value="">
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-check"></i> Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
