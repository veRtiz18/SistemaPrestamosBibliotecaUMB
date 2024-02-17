<!-- Modal actualizar registro Estudiantes -->
<div class="modal fade" id="editaModal" tabindex="-1" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fs-5" id="editaModalLabel"><i class="fa-solid fa-pen"></i> Actualizar Estudiante</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualiza.php" method="post" enctype="multipart/form-data">

                    <div class="container-fluid">
                        <div class="row">

                            <input type="hidden" id="id" name="id">

                            <div class="col-12 col-md-2 col-xl-4">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="">Nombre:</span>
                                    <input type="text" name="nombre" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un nombre.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-xl-4 ">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="">A. Paterno:</span>
                                    <input type="text" name="apellidoP" id="apellidoP" class="form-control" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un apellido Paterno.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-xl-4">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="">A. Materno:</span>
                                    <input type="text" name="apellidoM" id="apellidoM" class="form-control" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un apellido Materno.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-5">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="">Matrícula:</span>
                                    <input type="text" name="matricula" id="matricula" class="form-control" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe una matrícula.
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2"></div>
                            <div class="col-12 col-md-6 col-xl-5">
                                <div class="input-group input-group-sm mb-2">
                                    <label class="input-group-text" for="">Carrera:</label>
                                    <select name="carrera" id="carrera" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <?php while ($row_carrera = $carrera->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_carrera["id_carrera"]; ?>"><?= $row_carrera["nombre_carrera"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-3"></div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="input-group input-group-sm mb-2">
                                    <label class="input-group-text" for="carrera">Semestre:</label>
                                    <select name="semestre" id="semestre" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <?php while ($row_semestre = $semestre->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_semestre["id_semestre"]; ?>"><?= $row_semestre["nombre_semestre"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3"></div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end mb-2 mt-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-warning"><i class="fa-solid fa-floppy-disk"></i> Actualizar</button>
                            </div>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>