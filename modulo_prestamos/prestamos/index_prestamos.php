<?php
session_start();
require('./../../../UMB_biblioteca/conexion/database.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos | UMB Jilotepec</title>
    <link href="./../../assets/css/styles.css" rel="stylesheet">
    <link href="./../../assets/css/all.min.css" rel="stylesheet">
    <link href="./../../assets/css/header.css" rel="stylesheet">

    <script src="./../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../../assets/js/jquery-3.7.1.min.js"></script>
</head>

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
<script>
    confirmacionModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');

        let inputId = confirmacionModal.querySelector('.modal-body #id');
        let inputnombre_libro = confirmacionModal.querySelector('.modal-body #nombre_libro')
        let inputno_inventario = confirmacionModal.querySelector('.modal-body #no_inventario')
        let inputnombre_editorial = confirmacionModal.querySelector('.modal-body #editorial')
        let inputnombre_autor = confirmacionModal.querySelector('.modal-body #autor_libro')
        let inputmatricula = confirmacionModal.querySelector('.modal-body #matricula')

        let url = "./getPrestamo.php";
        let formData = new FormData();
        formData.append('id', id);

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                inputId.value = data.id_prestamo;
                inputnombre_libro.value = data.titulo_libro;
                inputno_inventario.value = data.no_inventario;
                inputnombre_editorial.value = data.editorial_libro;
                inputnombre_autor.value = data.autor_libro;

                inputmatricula.value = data.matricula;

            })
            .catch(err => console.error(err));
    });

    let nuevoModal = document.getElementById('nuevoModal')
    let verModal = document.getElementById('verModal')

    nuevoModal.addEventListener('shown.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #campo').focus()
    })

    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #campo').value = ""
        nuevoModal.querySelector('.modal-body #campoUsuarios').value = ""
        nuevoModal.querySelector('.modal-body #fecha').value = ""
        var lista = document.getElementById('lista');
        lista.innerHTML = "";

        var listaUsuarios = document.getElementById('listaUsuarios');
        listaUsuarios.innerHTML = "";

        var btn_estatus = document.getElementById('btn_estatus')
        btn_estatus.innerHTML = "";

    })

    verModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');

        let inputId = verModal.querySelector('.modal-body #folio');
        let inputnombre_libro = verModal.querySelector('.modal-body #nombre_libro')
        let inputno_inventario = verModal.querySelector('.modal-body #no_inventario')
        let inputnombre_editorial = verModal.querySelector('.modal-body #nombre_editorial')
        let inputnombre_autor = verModal.querySelector('.modal-body #nombre_autor')
        let inputanio = verModal.querySelector('.modal-body #anio')

        let inputnombre_alumno = verModal.querySelector('.modal-body #nombre_alumno')
        let inputmatricula = verModal.querySelector('.modal-body #matricula')
        let inputcarrera = verModal.querySelector('.modal-body #carrera')
        let inputsemestre = verModal.querySelector('.modal-body #semestre')

        let inputestatus = verModal.querySelector('.modal-body #estatus')
        let inputfecha_inicio = verModal.querySelector('.modal-body #fecha_inicio')
        let inputfecha_final = verModal.querySelector('.modal-body #fecha_final')
        let carrera_alumno = verModal.querySelector('.modal-body #carrera_alumno')


        let url = "./getPrestamo.php";
        let formData = new FormData();
        formData.append('id', id);

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Asegúrate de que el elemento con el ID 'id' existe dentro del modal body
                inputId.value = data.id_prestamo;
                inputnombre_libro.value = data.titulo_libro;
                inputno_inventario.value = data.no_inventario;
                inputnombre_editorial.value = data.editorial_libro;
                inputnombre_autor.value = data.autor_libro;
                inputanio.value = data.anio_libro;

                inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
                inputmatricula.value = data.matricula;
                inputcarrera.value = data.carrera_alumno;
                inputsemestre.value = data.carrera_semestre;

                inputestatus.value = data.descripcion_estatus;
                inputfecha_inicio.value = data.fecha;
                inputfecha_final.value = data.fecha_entrega;
                // carrera_libro.value = data.carrera_libro;
                // carrera_alumno.value = data.carrera_alumno;


            })
            .catch(err => console.error(err));
    });


    //parte del modal donde se muestra el reporte PDF

    confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
        confirmacionGenerarPDF.querySelector('.modal-body #matricula').value = "";
    })
    confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
        confirmacionGenerarPDF.querySelector('.modal-body #nombre_alumno').value = "";
    })
    confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
        confirmacionGenerarPDF.querySelector('.modal-body #carrera').value = "";
    })
    confirmacionGenerarPDF.addEventListener('hide.bs.modal', event => {
        confirmacionGenerarPDF.querySelector('.modal-body #semestre').value = "";
    })

    confirmacionGenerarPDF.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        let inputId = confirmacionGenerarPDF.querySelector('.modal-body #id');

        let inputmatricula = confirmacionGenerarPDF.querySelector('.modal-body #matricula')
        let inputnombre_alumno = confirmacionGenerarPDF.querySelector('.modal-body #nombre_alumno')
        let inputcarrera = confirmacionGenerarPDF.querySelector('.modal-body #carrera')
        let inputsemestre = confirmacionGenerarPDF.querySelector('.modal-body #semestre')


        let url = "./getPrestamo.php";
        let formData = new FormData();
        formData.append('id', id);

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                inputId.value = data.id_prestamo
                inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
                inputmatricula.value = data.matricula;
                inputcarrera.value = data.carrera_alumno;
                inputsemestre.value = data.carrera_semestre;
            })
            .catch(err => console.error(err));
    });

    //parte para el posponer un prestamo: 
    aplazarPrestamoModal.addEventListener('shown.bs.modal', event => {
        aplazarPrestamoModal.querySelector('.modal-body #fecha_final').focus()
    })
    aplazarPrestamoModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');

        let inputId = aplazarPrestamoModal.querySelector('.modal-body #folio');
        let inputnombre_libro = aplazarPrestamoModal.querySelector('.modal-body #nombre_libro')
        let inputno_inventario = aplazarPrestamoModal.querySelector('.modal-body #no_inventario')
        let inputnombre_editorial = aplazarPrestamoModal.querySelector('.modal-body #nombre_editorial')
        let inputnombre_autor = aplazarPrestamoModal.querySelector('.modal-body #nombre_autor')
        let inputanio = aplazarPrestamoModal.querySelector('.modal-body #anio')

        let inputnombre_alumno = aplazarPrestamoModal.querySelector('.modal-body #nombre_alumno')
        let inputmatricula = aplazarPrestamoModal.querySelector('.modal-body #matricula')
        let inputcarrera = aplazarPrestamoModal.querySelector('.modal-body #carrera')
        let inputsemestre = aplazarPrestamoModal.querySelector('.modal-body #semestre')

        let inputestatus = aplazarPrestamoModal.querySelector('.modal-body #estatus')
        let inputfecha_inicio = aplazarPrestamoModal.querySelector('.modal-body #fecha_inicio')
        let inputfecha_final = aplazarPrestamoModal.querySelector('.modal-body #fecha_final')
        let carrera_alumno = aplazarPrestamoModal.querySelector('.modal-body #carrera_alumno')


        let url = "./getPrestamo.php";
        let formData = new FormData();
        formData.append('id', id);

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Asegúrate de que el elemento con el ID 'id' existe dentro del modal body
                inputId.value = data.id_prestamo;
                inputnombre_libro.value = data.titulo_libro;
                inputno_inventario.value = data.no_inventario;
                inputnombre_editorial.value = data.editorial_libro;
                inputnombre_autor.value = data.autor_libro;
                inputanio.value = data.anio_libro;

                inputnombre_alumno.value = data.nombre_estudiante + " " + data.ape_Paterno + " " + data.ape_Materno;
                inputmatricula.value = data.matricula;
                inputcarrera.value = data.carrera_alumno;
                inputsemestre.value = data.carrera_semestre;

                inputestatus.value = data.descripcion_estatus;
                inputfecha_inicio.value = data.fecha;
                inputfecha_final.value = data.fecha_entrega;

            })
            .catch(err => console.error(err));
    });
</script>





<script>
    /* Llamando a la función getData() */
    getData()

    /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
    document.getElementById("campoBusqueda").addEventListener("keyup", function() {
        getData()
    }, false)
    document.getElementById("num_registros").addEventListener("change", function() {
        getData()
    }, false)

    /* Peticion AJAX */
    function getData() {
        let input = document.getElementById("campoBusqueda").value
        let num_registros = document.getElementById("num_registros").value
        let content = document.getElementById("content")
        let pagina = document.getElementById("pagina").value
        let orderCol = document.getElementById("orderCol").value
        let orderType = document.getElementById("orderType").value

        if (pagina == null) {
            pagina = 1
        }

        let url = "./busqueda/cargar.php"
        let formaData = new FormData()
        formaData.append('campoBusqueda', input)
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

</html>