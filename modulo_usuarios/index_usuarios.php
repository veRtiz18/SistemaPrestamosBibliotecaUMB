<?php
session_start();
// if ($_SESSION['acceso'] == 'acceso') {

require './../conexion/database.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios | UMB Jilotepec</title>

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
                        <a href="./../modulo_alumnos/index.php" class="nav-link fs-6">Alumnos</a>
                    </li>
                    <li>
                        <a href="./../modulo_qr/index.html" class="nav-link fs-6">Códigos QR</a>
                    </li>
                    <li>
                        <a href="./index_usuarios.php" class="nav-link fs-6 active">Usuarios</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <main class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Administrador de Usuarios </h1>
                <h5 class="fw-normal">Visualiza, crea, edita y elimina usuarios que pueden acceder al sistema:</h5>
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
                <!-- termina parte de alertas, con variable de sesion que se encuentra en guarda_p, edita_p y elimina_p esto tambien esta en el video de modales -->
            </div>
        </div>
        <section class="row">
            <article class="col-12 col-md-6 col-xl-8 mb-3">
                <label>Buscar un usuario:</label>
                <div class="input-group">
                    <input name="campo_u" id="campo_u" class="form-control mb-2 rounded" placeholder="Escribe aquí el valor a buscar..." aria-label="Search">
                </div>
            </article>

            <article class="col-12 col-md-3 col-xl-3 mr-0">
                <label>Registros a Mostrar:</label>
                <select name="num_registros_u" id="num_registros_u" class="form-select">
                    <option value="5">5</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </article>

            <article class="col-12 col-md-3 col-xl-1">
                <label type="hidden" class="m-0"></label>
                <div class="d-grid gap-2 d-md-flex justify-content-end rounded mb-1 mb-md-0">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoModal_usuarios" type="button">
                        <i class="fa-solid fa-circle-plus fa-sm"></i> Agregar
                    </button>
                </div>
            </article>

            <article class="col-12 col-md-12 mt-2">
                <table class="table table-sm table-bordered table-striped ">
                    <thead class="bg-light text-dark">
                        <tr class="bg-dark text-light">
                            <th class="bg-dark text-light text-center ">ID</th>
                            <th class="bg-dark text-light text-center ">Nombre Del Usuario</th>
                            <th class="bg-dark text-light text-center ">Usuario</th>
                            <th class="bg-dark text-light text-center ">Correo Electrónico</th>
                            <th class="bg-dark text-light text-center ">Contraseña</th>
                            <th class="bg-dark text-light text-center ">Rol</th>
                            <th class="bg-dark text-light text-center ">Editar</th>
                            <th class="bg-dark text-light text-center ">Eliminar</th>
                        </tr>
                    </thead>
                    <!-- De aqui, todo ocurre en el script de table.js, este se manda a llamar hasta abajo! -->
                    <tbody id="content_u">
                    </tbody>

                </table>
            </article>
            <!-- termina parte de la tabla -->
            <article class="text-center col-12">
                <h6 id="lbl-total"></h6>
            </article>
            <article class="d-flex justify-content-center col-12">
                <div id="nav-paginacion"></div>
            </article>
        </section>
</body>
</main>
<!-- Esta parte funciona para que muestre en el select de rol -->
<?php
$sqlUsuario =
    "SELECT rol.id_rol, rol.rol
    FROM rol;
    ";
$usuarios = $conn->query($sqlUsuario);
?>
<!-- Fin de parte funciona para que muestre en el select de paradas -->

<!-- Inicia seccion de instancias a modales (INSERT, UPDATE y DROP de paradas) -->
<?php include './modales_usuario/eliminaModal.php'; ?>
<?php include './modales_usuario/nuevoModal.php'; ?>
<?php $usuarios->data_seek(0); ?>
<?php include './modales_usuario/editaModal.php'; ?>

<!-- Termina seccion de instancias a modales (INSERT, UPDATE y DROP de paradas) -->


<!-- Aqui esta el funcionamiento de JS para que se muestre la tabla -->
<script>
    // Este funciona con el segundo video que te mande 

    let paginaActual_u = 1;
    getData(paginaActual_u)

    document.getElementById("campo_u").addEventListener("keyup", function() {
        getData(1)
    }, false)

    document.getElementById("num_registros_u").addEventListener("change", function() {
        getData(paginaActual_u)
    }, false)


    function getData(pagina) {
        let input = document.getElementById("campo_u").value
        let num_registros_u = document.getElementById("num_registros_u").value
        let content = document.getElementById("content_u")

        if (pagina != null) {
            paginaActual_u = pagina;
        }

        let url = "vista_table_u.php";
        let formaData = new FormData();

        formaData.append('campo_u', input)
        formaData.append('registros', num_registros_u)
        formaData.append('pagina', pagina)

        fetch(url, {
                method: 'POST',
                body: formaData
            }).then(response => response.json())
            .then(data => {
                content.innerHTML = data.data
                document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                    ' de ' + data.totalRegistros + ' registros';
                document.getElementById("nav-paginacion").innerHTML = data.paginacion;

            }).catch(err => console.log(err))
    }
</script>

<script>
    let nuevoModal = document.getElementById('nuevoModal_usuarios');
    let eliminaModal = document.getElementById('eliminaModal_usuarios')
    let editarModal = document.getElementById('editaModal_usuarios')

    nuevoModal.addEventListener('shown.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #nombre_usuario').focus()
    })
    editarModal.addEventListener('shown.bs.modal', event => {
        editarModal.querySelector('.modal-body #nombre_usuario').focus()
    })

    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #nombre_usuario').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #apellido_paterno').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #apellido_materno').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #alias_user').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #correo_user').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #contrasenia_user').value = "";
    })
    nuevoModal.addEventListener('hide.bs.modal', event => {
        nuevoModal.querySelector('.modal-body #select_rol').value = "";
    })



    editarModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id');
        let inputId = editarModal.querySelector('.modal-body #id')
        let inputnombre_usuario = editarModal.querySelector('.modal-body #nombre_usuario')
        let inputapellido_paterno = editarModal.querySelector('.modal-body #apellido_paterno')
        let inputapellido_materno = editarModal.querySelector('.modal-body #apellido_materno')
        let inputalias_user = editarModal.querySelector('.modal-body #alias_user')
        let inputcorreo_user = editarModal.querySelector('.modal-body #correo_user')
        let inputcontrasenia_user = editarModal.querySelector('.modal-body #contrasenia_user')
        let inputselect_rol = editarModal.querySelector('.modal-body #select_rol')


        let url = "get_usuario.php"
        let formData = new FormData()

        formData.append('id_usuario', id)

        fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {

                inputId.value = data.id_usuario;
                inputnombre_usuario.value = data.nombre_usuario
                inputapellido_paterno.value = data.apellidoPaterno
                inputapellido_materno.value = data.apellidoMaterno
                inputalias_user.value = data.user
                inputcorreo_user.value = data.correo
                inputcontrasenia_user.value = data.contrasenia
                inputselect_rol.value = data.rol

            }).catch(err => console.log(err))
    })

    eliminaModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #id').value = id

    })
</script>


</body>

</html>
<?php
// } else {
//     header("location: ../error.php");
// }

?>