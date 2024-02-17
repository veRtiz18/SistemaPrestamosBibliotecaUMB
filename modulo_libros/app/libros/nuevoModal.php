<!-- Modal -->
<div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-umb-color text-light">
                <h1 class="modal-title fs-5" id="nuevoModalLabel">Agregar Libro</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guardaLibro.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="no_inventario">Número De Inventario:</label>
                            <input placeholder="Escriba aquí el número de inventario" type="text" name="no_inventario" id="no_inventario" class="form-control border-umb-color" id="miInput" oninput="this.value = this.value.toUpperCase()" required>
                            <div class="invalid-feedback">
                                Es necesario colocar un número de inventario.
                            </div>
                        </div>

                        <div class="mb-3 col">
                            <label for="c_barras">Código de Barras:</label>
                            <input placeholder="Escriba aquí el código de barras" type="number" name="c_barras" id="c_barras" class="form-control border-umb-color" required>
                            <div class="invalid-feedback">
                                Es necesario colocar un código de barras.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="carrera">Carrera:</label>
                            <select type="text" name="carrera" id="carrera" class="form-select border-umb-color" required>
                                <option value="">Seleccionar...</option>
                                <?php while ($row_carrera = $carreras->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_carrera["id_carrera"]; ?>"><?= $row_carrera["nombre_carrera"] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">
                                Debe seleccionar una carrera.
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="n_libro">Nombre del Libro:</label>
                            <input placeholder="Escriba aquí el nombre del libro" type="text" name="n_libro" id="n_libro" class="form-control border-umb-color" id="miInput" oninput="this.value = this.value.toUpperCase()" required>
                            <div class="invalid-feedback">
                                Es necesario colocar un nombre de libro.
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="autor">Autor:</label>
                            <input placeholder="Escriba aquí el autor" type="text" name="autor" id="autor" class="form-control border-umb-color" id="miInput" oninput="this.value = this.value.toUpperCase()" required>
                            <div class="invalid-feedback">
                                Es necesario colocar un autor.
                            </div>
                        </div>

                        <div class="mb-3 col">
                            <label for="editorial">Editorial:</label>
                            <input placeholder="Escriba aquí la editorial" type="text" name="editorial" id="editorial" class="form-control border-umb-color" id="miInput" oninput="this.value = this.value.toUpperCase()" required>
                            <div class="invalid-feedback">
                                Es necesario colocar una editorial.
                            </div>
                        </div>

                        <div class="mb-3 col">
                            <label for="anio">Año:</label>
                            <input placeholder="Escriba aquí el año" type="number" name="anio" id="anio" class="form-control border-umb-color" required>
                            <div class="invalid-feedback">
                                Es necesario colocar un año.
                            </div>
                        </div>

                        <div class="mb-3 col">
                            <label for="edicion">Edición:</label>
                            <input placeholder="Escriba aquí la edición" type="text" name="edicion" id="edicion" class="form-control border-umb-color" id="miInput" oninput="this.value = this.value.toUpperCase()" required>
                            <div class="invalid-feedback">
                                Es necesario colocar la edición.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_don_rec">Fecha de Donación (Rectoria):</label>
                            <input placeholder="Escriba aquí la fecha de donación" type="date" name="fecha_don_rec" id="fecha_don_rec" class="form-control border-umb-color" required>
                            <div class="invalid-feedback">
                                Coloque una fecha correcta.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="estatus">Estatus:</label>
                            <select type="text" name="estatus" id="estatus" class="form-select border-umb-color" required>
                                <option value="">Seleccionar...</option>
                                <?php while ($row_estatus = $estatus->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_estatus["id_estatus"]; ?>"><?= $row_estatus["nombre_estatus"] ?></option>
                                <?php } ?>

                            </select>
                            <div class="invalid-feedback">
                                Debe seleccionar una opción.
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end mb-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-umb-color text-light">Agregar Libro</button>
                        </div>


                    </div>
                </form>
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