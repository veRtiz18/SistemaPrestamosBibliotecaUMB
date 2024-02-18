<?php
session_start();
require('./../../UMB_biblioteca/conexion/database.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos | UMB Jilotepec</title>
    <link href="./../assets/css/styles.css" rel="stylesheet">
    <link href="./../assets/css/all.min.css" rel="stylesheet">
    <link href="./../assets/css/header.css" rel="stylesheet">

    <script src="./../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../assets/js/jquery-3.7.1.min.js"></script>
</head>
<div class="container-fluid mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="mb-1 mt-1">
            <img src="./../assets/img/logo_edomex.png" alt="Gobierno del Estado de México" width="170px" height="50px">

        </div>
        <div class="mb-1 mt-1 text-right text-light">
            <img src="./../assets/img/logo_umb.png" alt="Universidad Mexiquense Del Bicentenario" width="100px" height="50px">
        </div>
    </div>
</div>

<div class="container-fluid bg-dark border-1">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <ul class="nav col-12 col-lg-12 my-4 justify-content-center my-md-0 text-small">
                <li>
                    <a href="./../index.html" class="nav-link fs-6">Inicio</a>
                </li>

                <li>
                    <div class="dropdown">
                        <a class="nav-link fs-6 active dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Prestámos </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="./sistema-prestamos.html" class="dropdown-item bg-dark text-light fs-6">Menú Principal</a>
                            </li>
                            <li><a class="dropdown-item" href="./index_prestamos_vigentes.php">Préstamos Vigentes</a></li>
                            <li><a class="dropdown-item" href="./prestamos-vencidos.php">Préstamos Vencidos</a></li>
                            <li><a class="dropdown-item" href="./prestamos-devolucion.php">Préstamos Vigentes</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="./../modulo_libros/app/libros/index.php" class="nav-link fs-6">Libros</a>
                </li>
                <li>
                    <a href="./../modulo_alumnos/index.php" class="nav-link fs-6">Alumnos</a>
                </li>
                <li>
                    <a href="./../modulo_qr/index.html" class="nav-link fs-6">Códigos QR</a>
                </li>
                <li>
                    <a href="./../modulo_usuarios/index_usuarios.php" class="nav-link fs-6">Usuarios</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<body>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-6">
                <h1 class="">Administrador de Préstamos</h1>
                <h5 class="fw-normal">Verifique el estado de los préstamos, dar de alta y crear un préstamo:</h5>
            </div>

            <div class="col-2"></div>
            <div class="col-4">
                <!-- inicia parte de alertas, con variable de sesion que se encuentra en guarda_u, edita_u y elimina_u -->
                <div class="row justify-content-end mt-2 me-3">
                    <?php
                    if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
                        <div id="myAlert" class="alert alert-<?= ($_SESSION['color']) ?> alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-info"></i> <?= ($_SESSION['msg']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['msg']);
                        unset($_SESSION['color']);
                    }
                    ?>
                </div>
                <script>
                    // Agregar un script para ocultar el elemento después de 5 segundos
                    setTimeout(function() {
                        var alertElement = document.querySelector('.alert');
                        if (alertElement) {
                            alertElement.style.display = 'none';
                        }
                    }, 5000); // 5000 milisegundos = 5 segundos
                </script>
            </div>
        </div>
    </div>

    <main class="container-fluid">
        <div class="row">

            <div class="col-6 mt-3">
                <form action="" method="post">
                    <label for="campoBusqueda">Buscar:</label>
                    <input placeholder="Escribe aquí el valor a buscar" type="text" name="campoBusqueda" id="campoBusqueda" class="form-control">
                </form>
            </div>

            <div class="col-1"></div>
            <div class="col-3 mt-5 d-flex align-items-end">
                <div class="ms-4"> <!-- Agrega un div contenedor -->
                    <a href="index_prestamos_vigentes.php" class="link-success link-offset-2 link-underline-opacity-100 link-underline-opacity-100-hover d-block">Préstamos Vigentes</a>
                </div>
                <div class="ms-3"> <!-- Agrega un div contenedor -->
                    <a href="#" class="link-danger link-offset-2 link-underline-opacity-100 link-underline-opacity-100-hover d-block">Préstamos Vencidos</a>
                </div>
            </div>

            <div class="col-2 mt-5">
                <div class="d-grid gap-2 d-md-flex justify-content-end rounded mb-1 mb-md-0">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoModal">
                        <i class="fa-solid fa-calendar-plus"></i> Realizar Préstamo
                    </button>
                </div>
            </div>
        </div>

        <article class="col-12 col-md-12 mt-2 text-center">
            <table class="table table-sm table-bordered table-striped">
                <thead class="table-dark">
                    <th class="sort asc">ID</th>
                    <th class="sort asc">Matrícula</th>
                    <th class="sort asc">Deudor</th>
                    <th class="sort asc">Título del libro</th>
                    <th class="sort asc">Número Inventario</th>
                    <th class="sort asc">Fecha inicio préstamo</th>
                    <th class="sort asc">Fecha entrega préstamo</th>
                    <th class="sort asc">Estado</th>
                    <th class="sort asc">Acción</th>
                </thead>
                <tbody id="content">

                </tbody>
            </table>
        </article>

        <div class="row">
            <div class="col-4">

            </div>
            <div class="col-2">
                <label id="lbl-total" class="mt-2"></label>
            </div>
            <div class="col-4" id="nav-paginacion"></div>
            <div class="col-2">

                <div class="d-flex align-items-center">
                    <label for="num_registros" class="mr-2 text-center">Registros a Mostrar:</label>
                    <select name="num_registros" id="num_registros" class="form-select ms-2 border border-4 text-center">
                        <option value="5">6</option>
                        <option value="10">12</option>
                        <option value="25">30</option>
                        <option value="50">60</option>
                    </select>
                </div>

            </div>
        </div>

        <input type="hidden" id="pagina" value="1">
        <input type="hidden" id="orderCol" value="0">
        <input type="hidden" id="orderType" value="asc">
    </main>

</body>
<?php require('./modales/nuevoModal.php'); ?>
<?php require('./modales/verModal.php'); ?>
<?php require('./modales/confirmacionModal.php'); ?>
<?php require('./modales/confirmacionGenerarPDFModal.php'); ?>
<?php require('./modales/aplazarPrestamoModal.php'); ?>

<script src="./assets/funcionalidad_index_prestamos/funcionalidad_table.js"></script>

</html>