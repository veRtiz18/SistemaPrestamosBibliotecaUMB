<!-- Modal -->
<div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-calendar-plus"></i> Realizar préstamo</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="inserta_prestamo.php" method="post">
                    <div class="container">
                        <div class="row">
                            <div class="card col-6">
                                <div class="card-body">
                                    <h4><i class="fa-solid fa-book"></i> Búsqueda de libro.</h4>
                                    <h6>Ingrese el número de Inventario del libro que desea prestar:</h6>
                                    <p>
                                        <label for="campo"><i class="fa-solid fa-magnifying-glass"></i> Buscar:</label>
                                        <input type="text" name="campo" id="campo" class="form-control" placeholder="Ingrese aquí el número de inventario" autocomplete="off" required>
                                    <div id="lista"></div>
                                    </p>
                                    <script src="./../assets/js/peticiones.js"></script>
                                </div>
                            </div>

                            <div class="card col-6">
                                <div class="card-body">
                                    <h4><i class="fa-solid fa-person-circle-plus"></i> Búsqueda de usuario.</h4>
                                    <h6>Ingrese la matrícula de usuario. Si no está registrado, <a href="./../modulo_alumnos/index.php">click aquí</a></h6>
                                    <p>
                                        <label for=""><i class="fa-solid fa-magnifying-glass"></i> Buscar:</label>
                                        <input type="text" name="campoUsuarios" id="campoUsuarios" class="form-control" placeholder="Ingrese aquí la matrícula del usuario" autocomplete="off" required>
                                    <div id="listaUsuarios"></div>
                                    </p>
                                    <script src="./../assets/js/peticionesUsuarios.js"></script>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-2">
                                <div>
                                    <h4><i class="fa-solid fa-calendar-days"></i> Fecha de entrega</h4>
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-4">
                                <input type="date" id="fecha" name="fecha" class="form-control" required>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>

                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <div id="btn_estatus"></div>
                        <!-- <button type='submit' class='btn btn-success'><i class='fa-solid fa-floppy-disk'></i> Registrar</button> -->
                    </div>
                </form>
                <script src="./../assets/js/peticionesBoton.js"></script>
            </div>
        </div>
    </div>
</div>