<?php
session_start();
require './../../../conexion/database.php'
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros | UMB Jilotepec</title>
    <link href="./../../../assets/css/styles.css" rel="stylesheet">
    <link href="./../../../assets/css/all.min.css" rel="stylesheet">
    <link href="./../../../assets/css/header.css" rel="stylesheet">

    <script src="./../../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../../../assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="container-fluid mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mb-1 mt-1">
                <img src="./../../../assets/img/logo_edomex.png" alt="Gobierno del Estado de México" width="170px" height="50px">

            </div>
            <div class="mb-1 mt-1 text-right text-light">
                <img src="./../../../assets/img/logo_umb.png" alt="Universidad Mexiquense Del Bicentenario" width="100px" height="50px">
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark border-1">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <ul class="nav col-12 col-lg-12 my-4 justify-content-center my-md-0 text-small">
                    <li>
                        <a href="./../../../index.html" class="nav-link fs-6">Inicio</a>
                    </li>
                    <li>
                        <a href="./../../../modulo_prestamos/sistema-prestamos.html" class="nav-link fs-6 ">Prestámos</a>
                    </li>
                    <li>
                        <a href="./index.php" class="nav-link fs-6 active">Libros</a>
                    </li>
                    <li>
                        <a href="./../../../modulo_alumnos/index.php" class="nav-link fs-6">Alumnos</a>
                    </li>
                    <li>
                        <a href="./../../../modulo_qr/index.html" class="nav-link fs-6">Códigos QR</a>
                    </li>
                    <li>
                        <a href="./../../../modulo_usuarios/index_usuarios.php" class="nav-link fs-6">Usuarios</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">

        <div class="row">
            <div class="col-6">
                <h1 class="">Administrador de Libros </h1>
                <h5 class="fw-normal">Verifique el estado de los libros, así como la inserción, modificación y eliminación de los mismos:</h5>
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

    <div class="container-fluid">
        <article class="col-12 col-md-12">
            <?php
            if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
                <div class="alert alert-<?= ($_SESSION['color']) ?> alert-dismissible fade show" role="alert">

                    <?= ($_SESSION['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
                unset($_SESSION['msg']);
                unset($_SESSION['color']);
            }
            ?>
            <script>
                // Agregar un script para ocultar el elemento después de 5 segundos
                setTimeout(function() {
                    var alertElement = document.querySelector('.alert');
                    if (alertElement) {
                        alertElement.style.display = 'none';
                    }
                }, 5000); // 5000 milisegundos = 5 segundos
            </script>
        </article>

        <div class="row">
            <div class="col-7 mt-3">
                <form action="" method="post">
                    <label for="campo">Buscar:</label>
                    <input placeholder="Escribe aquí el valor a buscar" type="text" name="campo" id="campo" class="form-control">
                </form>
            </div>

            <div class="col-2 mt-3">
                <label for="num_registros">Registros a Mostrar:</label>
                <select name="num_registros" id="num_registros" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="col-3 mt-5">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="#" class="btn btn-excel-color me-md-2" data-bs-toggle="modal" data-bs-target="#modalMenuExcel">
                        <i class="fa-solid fa-file-excel"></i> Opciones Excel</a>
                    <a href="#" class="btn btn-umb-color text-light" data-bs-toggle="modal" data-bs-target="#nuevoModal">
                        <i class="fa-solid fa-circle-plus"></i> Nuevo Registro</a>
                </div>
            </div>
        </div>



        <table class="table table-sm table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th class="bg-dark text-light text-center small">No. Inventario</th>
                    <th class="bg-dark text-light text-center small">Carrera</th>
                    <th class="bg-dark text-light text-center small">Código de Barras</th>
                    <th class="bg-dark text-light text-center small">Nombre del Libro</th>
                    <th class="bg-dark text-light text-center small">Autor</th>
                    <th class="bg-dark text-light text-center small">Editorial</th>
                    <th class="bg-dark text-light text-center small">Año</th>
                    <th class="bg-dark text-light text-center small">Edición</th>
                    <th class="bg-dark text-light text-center small">Fecha de Donación</th>
                    <th class="bg-dark text-light text-center small">Estatus</th>
                    <th class="bg-dark text-light text-center small">Acciones</th>
                </tr>
            </thead>
            <tbody id="content">
            </tbody>
        </table>

        <div class="row">
            <div class="col-4"></div>
            <div class="col-2">
                <label id="lbl-total" class="mt-2"></label>
            </div>
            <div class="col-6" id="nav-paginacion"></div>
        </div>

        <script>
            let paginaActual = 1
            getData(paginaActual);

            document.getElementById("campo").addEventListener("keyup", function() {
                getData(1)
            })
            document.getElementById("num_registros").addEventListener("change", function() {
                getData(paginaActual)
            }, false)

            function getData(pagina) {
                let input = document.getElementById("campo").value
                let num_registros = document.getElementById("num_registros").value
                let content = document.getElementById("content")

                if (pagina != null) {
                    paginaActual = pagina
                }

                let url = '../libros/busqueda/cargar.php'
                let formData = new FormData()
                formData.append('campo', input)
                formData.append('registros', num_registros)
                formData.append('pagina', paginaActual)

                fetch(url, {
                        method: "POST",
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        content.innerHTML = data.data
                        document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                            ' de ' + data.totalRegistros + ' registros'
                        document.getElementById("nav-paginacion").innerHTML = data.paginacion
                    }).catch(err => console.log(err))
            }
        </script>
    </div>

    <?php
    //cmb de las fechas para generar excel:
    $sqlFechas = "SELECT 
    CASE
        WHEN fecha_libro = '1970-01-01' THEN 'SIN FECHA'
        ELSE fecha_libro
    END AS fecha_libro
    FROM libros
    UNION
    SELECT 'SIN FECHA' AS fecha_libro
    ORDER BY fecha_libro DESC;
    ";
    $fechas = $conn->query($sqlFechas);
    //cmb del estatus de carrera en editaModal
    $sqlEstatus = "SELECT id_estatus, nombre_estatus FROM estatus_libro";
    $estatus = $conn->query($sqlEstatus);
    //cmb de las carreras en nuevoModal
    $sqlCarrera = "SELECT carrera.id_carrera, carrera.nombre_carrera FROM carrera";
    $carreras = $conn->query($sqlCarrera);
    ?>
    <?php include 'nuevoModal.php'; ?>

    <?php
    $estatus->data_seek(0);
    $carreras->data_seek(0);
    $fechas->data_seek(0); ?>

    <?php include 'editaModal.php'; ?>
    <?php include 'eliminaModal.php'; ?>
    <?php include 'opcionesExcelModal.php'; ?>

    <script>
        let nuevoModal = document.getElementById('nuevoModal');
        let editaModal = document.getElementById('editaModal');
        let eliminaModal = document.getElementById('eliminaModal');


        nuevoModal.addEventListener('hide.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #no_inventario').value = ""
            nuevoModal.querySelector('.modal-body #carrera').value = ""
            nuevoModal.querySelector('.modal-body #c_barras').value = ""
            nuevoModal.querySelector('.modal-body #n_libro').value = ""
            nuevoModal.querySelector('.modal-body #autor').value = ""
            nuevoModal.querySelector('.modal-body #editorial').value = ""
            nuevoModal.querySelector('.modal-body #anio').value = ""
            nuevoModal.querySelector('.modal-body #edicion').value = ""
            nuevoModal.querySelector('.modal-body #fecha_don_rec').value = ""
            nuevoModal.querySelector('.modal-body #estatus').value = ""
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNoInv = editaModal.querySelector('.modal-body #no_inventario')
            let inputCarrera = editaModal.querySelector('.modal-body #carrera')
            let inputCBarras = editaModal.querySelector('.modal-body #c_barras')
            let inputN_Libro = editaModal.querySelector('.modal-body #n_libro')
            let inputAutor = editaModal.querySelector('.modal-body #autor')
            let inputEditorial = editaModal.querySelector('.modal-body #editorial')
            let inputAnio = editaModal.querySelector('.modal-body #anio')
            let inputEdicion = editaModal.querySelector('.modal-body #edicion')
            let inputFecha = editaModal.querySelector('.modal-body #fecha_don_rec')
            let inputEstatus = editaModal.querySelector('.modal-body #estatus')

            let url = "getLibro.php"
            let formData = new FormData()
            formData.append('id', id)

            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    inputId.value = data.id_libro
                    inputNoInv.value = data.no_inventario
                    inputCarrera.value = data.id_carrera
                    inputCBarras.value = data.codigo_barras
                    inputN_Libro.value = data.titulo_libro
                    inputAutor.value = data.autor_libro
                    inputEditorial.value = data.editorial_libro
                    inputAnio.value = data.anio_libro
                    inputEdicion.value = data.edicion_libro
                    inputFecha.value = data.fecha_libro
                    inputEstatus.value = data.id_estatus
                }).catch(err => console.log(err))
        });

        eliminaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-body #id').value = id
        })
    </script>


</body>

</html>

<script>
    // Función para mostrar el alert y cerrarlo después de 6 segundos
    function mostrarAlert() {
        const alertElement = document.querySelector('.alert-exportacion'); // Agrega la clase de la alerta deseada
        alertElement.classList.remove('d-none'); // Mostrar el alert

        // Cerrar el alert automáticamente después de 6 segundos (6000 ms)
        setTimeout(function() {
            alertElement.classList.add('d-none'); // Ocultar el alert
        }, 6000); // 6000 ms = 6 segundos
    }

    // Agregar un controlador de eventos al botón o lugar donde se muestra el alert
    document.addEventListener("DOMContentLoaded", function() {
        if (document.querySelector('.alert-exportacion')) {
            mostrarAlert();
        }
    });
</script>