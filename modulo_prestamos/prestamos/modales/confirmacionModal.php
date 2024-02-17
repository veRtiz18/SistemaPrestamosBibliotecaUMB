<!-- Modal actualizar registro Estudiantes -->
<div class="modal fade" id="confirmacionModal" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h1 class="modal-title fs-5 text-light" id="confirmacionModalLabel"><i class="fa-regular fa-calendar-check"></i> Concluir Préstamo</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./pdf/concluir_prestamo.php" method="POST">
                    <div class="container">
                        <div class="row">

                            <h5 class="body text-center">¿Quiere terminar el préstamo?</h5>
                            <input type="text" id="id" name="id" hidden>

                            <ul class="list-group mb-3">
                                <li class="list-group-item bg-success text-light mt-2" aria-current="true">
                                    <h6><i class="fas fa-book"></i> Datos del libro</h6>
                                </li>
                                <li class="list-group-item fw-bolder">
                                    <input type="text" name="no_inventario" id="no_inventario" class="input-group-sm border-0 form-control fs-6 mb-1 fw-bold" readonly>
                                </li>
                                <li class="list-group-item fw-bolder">
                                    <input type="text" name="nombre_libro" id="nombre_libro" class="input-group-sm border-0 form-control fs-6 mb-1 fw-bold" readonly>
                                </li>
                                <li class="list-group-item">
                                    <input type="text" name="autor_libro" id="autor_libro" class="input-group-sm border-0 form-control fs-6 mb-1 fw-bold" readonly>
                                </li>
                                <li class="list-group-item">
                                    <input type="text" name="editorial" id="editorial" class="input-group-sm border-0 form-control fs-6 mb-1 fw-bold" readonly>
                                    <input type="text" hidden  name="matricula" id="matricula" readonly>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-check"></i> Terminar</button>
                    </div>
                </form>





            </div>

        </div>
    </div>
</div>
</div>