<!-- Modal de insertar rutas -->
<div class="modal fade" id="nuevoModal_usuarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="nuevoModal_usuario_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h1 class="modal-title fs-5 text-light" id="nuevoModal_usuario_label"><i class="fa-solid fa-user-plus"></i> Registrar usuario</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="needs-validation" action="guarda_u.php" method="post" enctype="multipart/form-data" novalidate>
                    <!-- <input type="hidden" name="id" id="id"> -->

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-12 col-xl-12 pb-3">
                                Complete los siguientes campos:
                            </div>
                            <div class="col-12 col-md-2 col-xl-4">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="nombre_usuario_label">Nombre:</span>
                                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un nombre.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-xl-4 ">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="apellido_paterno_label">Apellido Paterno:</span>
                                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un apellido Paterno.
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-md-5 col-xl-4">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="apellido_materno_label">Apellido Materno:</span>
                                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required oninput="this.value = this.value.toUpperCase()" required>
                                    <div class="invalid-feedback">
                                        Por favor, escribe un apellido Materno.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-xl-5 pt-2">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text" id="alias_user_label">Usuario:</span>
                                    <input type="text" class="form-control" id="alias_user" name="alias_user" required>
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        Por favor, escribe un usuario.
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-7 col-xl-7 pt-2">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="correo_user_label">Correo:</span>
                                    <input type="email" class="form-control" id="correo_user" name="correo_user" required>
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        Por favor, escribe un correo electrónico correcto.
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-md-6 col-xl-6 pt-2">

                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="contrasenia_user_label">Contraseña:</span>
                                    <input type="text" class="form-control" id="contrasenia_user" name="contrasenia_user" required>
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        Elige una contraseña.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-6 pt-2">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="select_rol">Options</label>
                                    <select class="form-select " id="select_rol" name="select_rol" required>
                                        <option selected disabled value=''>Selecciona un rol</option>
                                        <?php
                                        while ($row_usuario = $usuarios->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_usuario["id_rol"]; ?>"><?= $row_usuario['rol'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        Elige una opción.
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end mb-2 mt-2">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-dark">Registrar Usuario</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Este escript funciona para las validaciones de campos vacios, -->
<!-- si llegas hasta aqui, basicamente lo que hice fue ver este video: https://www.youtube.com/watch?v=hcno1fusrR8&t=344s, todo esta ahi, nada del otro mundo -->
<!-- <script>
   
</script> -->