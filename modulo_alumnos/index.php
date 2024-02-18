<?php
session_start();
require 'config/database.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Buscar datos en tiempo real con PHP, MySQL y AJAX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos y Profesores | UMB Jilotepec</title>

    <link href="./../assets/css/styles.css" rel="stylesheet">
    <link href="./../assets/css/header.css" rel="stylesheet">
    <link href="./../assets/css/all.min.css" rel="stylesheet">
    <script src="./../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../assets/js/jquery-3.7.1.min.js"></script>


</head>

<body>
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
    <main>
        <div class="container-fluid bg-dark border-1">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <ul class="nav col-12 col-lg-12 my-4 justify-content-center my-md-0 text-small">
                        <li>
                            <a href="./../index.html" class="nav-link fs-6">Inicio</a>
                        </li>
                        <li>
                            <a href="./../modulo_prestamos/sistema-prestamos.html" class="nav-link fs-6 ">Prestámos</a>

                        </li>
                        <li>
                            <a href="./../modulo_libros/app/libros/index.php" class="nav-link fs-6">Libros</a>

                        </li>
                        <li>
                            <a href="./../modulo_alumnos/index.php" class="nav-link fs-6 active">Alumnos</a>
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
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-6">
                    <h1>Administrador de Alumnos y Profesores </h1>
                    <h5 class="fw-normal">Verifique el estado de alumnos y profesores, darlos de alta y crear un préstamo:</h5>
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
                    <div class="d-grid gap-2 d-md-flex justify-content-end rounded mb-1 mb-md-0">
                        <a href="#" class="btn bg-success text-light" data-bs-toggle="modal" data-bs-target="#nuevoModal">
                            <i class="fa-solid fa-circle-plus"></i> Nuevo Registro</a>
                    </div>
                </div>
            </div>

            <article class="col-12 col-md-12 mt-2 text-center">
                <table class="table table-sm table-bordered table-striped ">
                    <thead class="table-dark">
                        <th class="sort asc">Matricula</th>
                        <th class="sort asc">Nombre</th>
                        <th class="sort asc">Apellido Paterno</th>
                        <th class="sort asc">Apellido Materno</th>
                        <th class="sort asc">Carrera</th>
                        <th class="sort asc">Semestre</th>
                        <th class="sort asc">Editar</th>
                        <th class="sort asc">Eliminar</th>

                    </thead>
                    <tbody id="content">

                    </tbody>
                </table>
            </article>

            <div class="row">
                <div class="col-4"></div>
                <div class="col-2">
                    <label id="lbl-total" class="mt-2"></label>
                </div>
                <div class="col-6" id="nav-paginacion"></div>
            </div>
            <input type="hidden" id="pagina" value="1">
            <input type="hidden" id="orderCol" value="0">
            <input type="hidden" id="orderType" value="asc">

            </div>
        </main>

        <script>
            /* Llamando a la función getData() */
            getData()

            /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
            document.getElementById("campo").addEventListener("keyup", function() {
                getData()
            }, false)
            document.getElementById("num_registros").addEventListener("change", function() {
                getData()
            }, false)


            /* Peticion AJAX */
            function getData() {
                let input = document.getElementById("campo").value
                let num_registros = document.getElementById("num_registros").value
                let content = document.getElementById("content")
                let pagina = document.getElementById("pagina").value
                let orderCol = document.getElementById("orderCol").value
                let orderType = document.getElementById("orderType").value

                if (pagina == null) {
                    pagina = 1
                }

                let url = "load.php"
                let formaData = new FormData()
                formaData.append('campo', input)
                formaData.append('registros', num_registros)
                formaData.append('pagina', pagina)
                formaData.append('orderCol', orderCol)
                formaData.append('orderType', orderType)

                fetch(url, {
                        method: "POST",
                        body: formaData
                    }).then(response => response.json())
                    .then(data => {
                        content.innerHTML = data.data
                        document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                            ' de ' + data.totalRegistros + ' registros'
                        document.getElementById("nav-paginacion").innerHTML = data.paginacion
                    }).catch(err => console.log(err))
            }

            function nextPage(pagina) {
                document.getElementById('pagina').value = pagina
                getData()
            }

            let columns = document.getElementsByClassName("sort")
            let tamanio = columns.length
            for (let i = 0; i < tamanio; i++) {
                columns[i].addEventListener("click", ordenar)
            }

            function ordenar(e) {
                let elemento = e.target

                document.getElementById('orderCol').value = elemento.cellIndex

                if (elemento.classList.contains("asc")) {
                    document.getElementById("orderType").value = "asc"
                    elemento.classList.remove("asc")
                    elemento.classList.add("desc")
                } else {
                    document.getElementById("orderType").value = "desc"
                    elemento.classList.remove("desc")
                    elemento.classList.add("asc")
                }

                getData()
            }
        </script>

        <?php
        $sqlSemestre = "SELECT id_semestre, nombre_semestre FROM semestre ORDER BY id_semestre";
        $semestre = $conn->query($sqlSemestre);
        ?>
        <?php
        $sqlCarrera = "SELECT id_carrera, nombre_carrera FROM carrera";
        $carrera = $conn->query($sqlCarrera);
        ?>


        <?php include 'nuevoModal.php'; ?>

        <?php $carrera->data_seek(0); ?>
        <?php $semestre->data_seek(0); ?>

        <?php include 'editaModal.php'; ?>
        <?php include 'eliminaModal.php'; ?>

        <script>
            let nuevoModal = document.getElementById('nuevoModal')
            let editaModal = document.getElementById('editaModal')
            let eliminaModal = document.getElementById('eliminaModal')

            //Para poner el cursor en un input determinado
            nuevoModal.addEventListener('shown.bs.modal', event => {
                nuevoModal.querySelector('.modal-body #nombre').focus()
            })

            nuevoModal.addEventListener('hide.bs.modal', event => {
                nuevoModal.querySelector('.modal-body #id_estudiante').value = ""
                nuevoModal.querySelector('.modal-body #matricula').value = ""
                nuevoModal.querySelector('.modal-body #nombre_estudiante').value = ""
                nuevoModal.querySelector('.modal-body #ape_Paterno').value = ""
                nuevoModal.querySelector('.modal-body #ape_Materno').value = ""
                nuevoModal.querySelector('.modal-body #id_carrera').value = ""
                nuevoModal.querySelector('.modal-body #id_semestre').value = ""
            })

            //Para poner el cursor en un input determinado
            editaModal.addEventListener('shown.bs.modal', event => {
                editaModal.querySelector('.modal-body #nombre').focus()
            })

            editaModal.addEventListener('hide.bs.modal', event => {
                editaModal.querySelector('.modal-body #id').value = ""
                editaModal.querySelector('.modal-body #matricula').value = ""
                editaModal.querySelector('.modal-body #nombre').value = ""
                editaModal.querySelector('.modal-body #apellidoP').value = ""
                editaModal.querySelector('.modal-body #apellidoM').value = ""
                editaModal.querySelector('.modal-body #carrera').value = ""
                editaModal.querySelector('.modal-body #semestre').value = ""
            })

            editaModal.addEventListener('shown.bs.modal', event => {
                let button = event.relatedTarget
                let id = button.getAttribute('data-bs-id')

                let inputId = editaModal.querySelector('.modal-body #id')
                let inputMatricula = editaModal.querySelector('.modal-body #matricula')
                let inputNombre = editaModal.querySelector('.modal-body #nombre')
                let inputApeP = editaModal.querySelector('.modal-body #apellidoP')
                let inputApeM = editaModal.querySelector('.modal-body #apellidoM')
                let inputCarrera = editaModal.querySelector('.modal-body #carrera')
                let inputSemestre = editaModal.querySelector('.modal-body #semestre')

                let url = "getEstudiante.php"
                let formData = new FormData()
                formData.append('id', id)

                fetch(url, {
                        method: "POST",
                        body: formData
                    }).then(response => response.json())
                    .then(data => {

                        inputId.value = data.id_estudiante
                        inputMatricula.value = data.matricula
                        inputNombre.value = data.nombre_estudiante
                        inputApeP.value = data.ape_Paterno
                        inputApeM.value = data.ape_Materno
                        inputCarrera.value = data.id_carrera
                        inputSemestre.value = data.id_semestre

                    }).catch(err => console.log(err))

            })

            eliminaModal.addEventListener('shown.bs.modal', event => {
                let button = event.relatedTarget
                let id = button.getAttribute('data-bs-id')
                eliminaModal.querySelector('.modal-footer #id').value = id
            })
        </script>



</body>

</html>