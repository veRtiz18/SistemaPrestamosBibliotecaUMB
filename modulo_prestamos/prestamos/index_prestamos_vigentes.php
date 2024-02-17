<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Vigentes | UMB Jilotepec</title>
    <link href="./../../assets/css/styles.css" rel="stylesheet">
    <link href="./../../assets/css/all.min.css" rel="stylesheet">
    <link href="./../../assets/css/header.css" rel="stylesheet">
    <link href="./../../assets/css/footer.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mb-1 mt-1">
                <img src="./../../assets/img/logo_edomex.png" alt="Gobierno del Estado de México" width="170px" height="50px">
            </div>
            <div class="mb-1 mt-1 text-right text-light">
                <img src="./../../assets/img/logo_umb.png" alt="Universidad Mexiquense Del Bicentenario" width="100px" height="50px">
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark border-1 mb-4">
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
                                    <a href="./admin-prestamos.html" class="dropdown-item  fs-6">Menú Préstamos</a>
                                </li>
                                <li><a class="dropdown-item bg-dark text-light" href="./prestamos-vigentes.php">Préstamos Vigentes</a></li>
                                <li><a class="dropdown-item" href="./prestamos-vencidos.php">Préstamos Vencidos</a></li>
                                <li><a class="dropdown-item" href="./prestamos-devolucion.php">Historial de Prestamos</a></li>
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

    <div class="container-fluid mt-2">
        <h1><a href="./index_prestamos.php" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><i class="fa-solid fa-arrow-left"></i></a> Préstamos Vigentes </h1>
        <h5 class="fw-normal">Préstamos cuyas fechas siguen vigentes:</h5>
        <div class="col-12 mt-3">
            <form action="" method="post">
                <label for="campoBusqueda">Buscar:</label>
                <input placeholder="Escribe aquí el valor a buscar" type="text" name="campoBusqueda" id="campoBusqueda" class="form-control border border-5">
            </form>
        </div>

        <div class=" bg-warning mt-3"></div>

        <div class="container-fluid">
            <div class="row" id="card_prestamo">
                <!-- Aquí se cargarán los préstamos -->
            </div>
        </div>

        <div class="row">
            <div class="col-8"></div>
            <div class="col-2 mt-3 d-flex align-items-center">
                <label for="num_registros" class="mr-2 text-center">Registros a Mostrar:</label>
                <select name="num_registros" id="num_registros" class="form-select ms-2 border border-4 text-center">
                    <option value="6">6</option>
                    <option value="12">12</option>
                    <option value="30">30</option>
                    <option value="60">60</option>
                </select>
            </div>
            <div class="col-2 mt-3">
                <label id="lbl-total" class="mt-2"></label>
                <div class="text-center">
                    <div id="nav-paginacion"></div>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="pagina" value="1">
    <input type="hidden" id="orderCol" value="0">
    <input type="hidden" id="orderType" value="asc">

    <?php require('./modales/confirmacionModal.php'); ?>
    <script src="./../../assets/js/bootstrap.bundle.min.js"></script>

    <script>
        let confirmacionModal = document.getElementById('confirmacionModal');
        /* Llamando a la función getData() */
        getData();

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campoBusqueda").addEventListener("keyup", function() {
            getData();
        }, false);
        document.getElementById("num_registros").addEventListener("change", function() {
            getData();
        }, false);

        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campoBusqueda").value;
            let num_registros = document.getElementById("num_registros").value;
            let content = document.getElementById("card_prestamo");
            let pagina = document.getElementById("pagina").value;
            let orderCol = document.getElementById("orderCol").value;
            let orderType = document.getElementById("orderType").value;

            if (pagina == null) {
                pagina = 1;
            }

            let url = "./busqueda/cargar_prestamos_vigentes.php";
            let formaData = new FormData();
            formaData.append('campoBusqueda', input);
            formaData.append('registros', num_registros);
            formaData.append('pagina', pagina);
            formaData.append('orderCol', orderCol);
            formaData.append('orderType', orderType);

            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data;
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros';
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion;
                }).catch(err => console.log(err));
        }

        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina;
            getData();
        }

        let columns = document.getElementsByClassName("sort");
        let tamanio = columns.length;
        for (let i = 0; i < tamanio; i++) {
            columns[i].addEventListener("click", ordenar);
        }

        function ordenar(e) {
            let elemento = e.target;

            document.getElementById('orderCol').value = elemento.cellIndex;

            if (elemento.classList.contains("asc")) {
                document.getElementById("orderType").value = "asc";
                elemento.classList.remove("asc");
                elemento.classList.add("desc");
            } else {
                document.getElementById("orderType").value = "desc";
                elemento.classList.remove("desc");
                elemento.classList.add("asc");
            }

            getData();
        }


        // confirmacionModal.addEventListener('shown.bs.modal', event => {
        //     let button = event.relatedTarget
        //     let id = button.getAttribute('data-bs-id')
        //     eliminaModal.querySelector('.modal-body #id').value = id
        // })

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
    </script>
</body>

</html>