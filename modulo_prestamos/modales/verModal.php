<!-- Modal actualizar registro Estudiantes -->
<div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5 text-light" id="verModalLabel"><i class="fa-solid fa-eye"></i> Ver Préstamo</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">

                        <label class="fw-semibold">Folio:</label>
                        <input type="text" name="folio" id="folio" value="0001222" class="border-0 fs-5 mb-1" readonly>

                        <div class="card">

                            <div class="row">
                                <div class="col">

                                    <ul class="list-group">
                                        <li class="list-group-item bg-primary text-light mt-2" aria-current="true">
                                            <h6><i class="fas fa-book"></i> Datos del libro</h6>
                                        </li>

                                        <li class="list-group-item fw-bolder">
                                            <input type="text" name="nombre_libro" id="nombre_libro" value="La tormenta del siglo" class="input-group-sm border-0 form-control fs-6 mb-1 fw-bold" readonly>
                                        </li>
                                        <li class="list-group-item fw-bolder">

                                            <input type="text" name="no_inventario" id="no_inventario" value="UESJILO-JILO-001222" class="border-0 mt-1 form-control fs-6 mb-1 fw-bold" readonly>
                                        </li>
                                        <li class="list-group-item fw-bolder">
                                            <input type="text" name="nombre_editorial" id="nombre_editorial" value="SANTILLANA" class="border-0 form-control mb-1" readonly>
                                        </li>

                                        <li class="list-group-item fw-bolder">
                                            <input type="text" name="nombre_autor" id="nombre_autor" value="José Madero Vízcaino" class="border-0 form-control" readonly>
                                        </li>

                                        <li class="list-group-item fw-bolder mb-2">
                                            <input type="text" name="anio" id="anio" value="ANIO" class="border-0 form-control" readonly>
                                        </li>

                                    </ul>
                                </div>
                                <div class="col">

                                    <ul class="list-group">
                                        <li class="list-group-item bg-primary text-light mt-2" aria-current="true">
                                            <h6><i class="fa-solid fa-person-circle-plus"></i> Datos de (la) deudor (a)</h6>
                                        </li>

                                        <li class="list-group-item text-light" aria-current="true">

                                            <input type="text" name="nombre_alumno" id="nombre_alumno" value="Marisol Rosaldo Jimenéz" class="mb-1 border-0 fs-6 form-control fw-bold" readonly>

                                        </li>
                                        <li class="list-group-item text-light" aria-current="true">

                                            <input type="text" name="matricula" id="matricula" value="202023097" class="mb-1 border-0 form-control fs-6  fw-bold" readonly>

                                        </li>
                                        <li class="list-group-item text-light" aria-current="true">
                                            <input type="text" name="carrera" id="carrera" value="INGENIERÍA EN SISTEMAS COMPUTACIONALES" class="mb-1 border-0 form-control" readonly>

                                        </li>


                                        <li class="list-group-item text-light" aria-current="true">
                                            <input type="text" name="semestre" id="semestre" value="8vo semestre" class="border-0 form-control p" readonly>
                                        </li>

                                </div>
                            </div>
                            </ul>
                        </div>
                        <div class="col-6 mb-3">

                            <label class="mt-2 fw-semibold">Estado del préstamo:</label>
                            <input type="text" name="estatus" id="estatus" value="Vencido" class="border-0  fs-5 mb-1" readonly>
                        </div>


                        <div class="col-2">
                            <label class="mt-2 me-2 fw-semibold">Inicio:</label>
                            <input type="text" name="fecha_inicio" id="fecha_inicio" value="19/12/2023" class="border-0 fs-5 mb-1" readonly>
                        </div>

                        <div class="col-2">
                            <label class="mt-2 me-2 fw-semibold">Devolución:</label>
                            <input type="text" name="fecha_final" id="fecha_final" value="21/12/2023" class="border-0 fs-5 mb-1" readonly>
                        </div>

                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end mb-2 mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>