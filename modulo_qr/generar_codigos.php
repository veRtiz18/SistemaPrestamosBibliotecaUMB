<?php
$valor = isset($_POST['inputValor']) ? $_POST['inputValor'] : '';
$inputFecha = isset($_POST['inputFecha']) ? $_POST['inputFecha'] : '';
$inicio = isset($_POST['inicio']) ? $_POST['inicio'] : '';
$final = isset($_POST['final']) ? $_POST['final'] : '';

$fecha = $inputFecha;
$nuevaFecha = date('dmy', strtotime($fecha));

require "phpqrcode/qrlib.php";

function generarCodigoQR($contenido, $dir)
{
    $tamaño = 4;
    $level = 'H';
    $framSize = 3;
    $filename = $dir . $contenido . '_a.png';

    QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

    return $filename;
}
$directorioQR = 'codigos_qr/';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Códigos en PDF | UMB Jilotepec</title>

    <link href="./../assets/css/styles.css" rel="stylesheet">
    <link href="./../assets/css/all.min.css" rel="stylesheet">
    <script src="./../assets/js/bootstrap.bundle.min.js"></script>
    <script src="./../assets/js/jquery-3.7.1.min.js"></script>

    <link href="./../assets/css/header.css" rel="stylesheet">
    <link href="./../assets/css/footer.css" rel="stylesheet">

</head>

<div class="container-fluid mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="mb-1 mt-1">
            <img src="./../modulo_prestamos/img/logo_edomex.png" alt="Gobierno del Estado de México" width="170px" height="50px">

        </div>
        <div class="mb-1 mt-1 text-right text-light">
            <!-- Imágenes a la derecha -->
            <img src="./../modulo_prestamos/img/logo_umb.png" alt="Universidad Mexiquense Del Bicentenario" width="100px" height="50px">
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
                    <a href="./index.html" class="nav-link fs-6 active">Códigos QR</a>
                </li>
                <li>
                    <a href="./../modulo_usuarios/index_usuarios.php" class="nav-link fs-6">Usuarios</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark">

                <h5 class="text-light ms-3 mt-2"><i class="fas fa-question-circle"></i> Información</h5>
                <p class="text-light ms-3">¡Los códigos se han generado correctamente!, Genera el archivo PDF:</p>
                <form action="generar_pdf.php" method="POST" class="w-100">
                    <input name="valor" value='<?php echo $valor ?>' type="hidden">
                    <input name="fecha" value='<?php echo $nuevaFecha ?>' type="hidden">
                    <input name="inicio" value='<?php echo $inicio ?>' type="hidden">
                    <input name="final" value='<?php echo $final ?>' type="hidden" id="final" class="form-control form-control-lg fs-1" maxlength="4">
                    <div class='d-flex justify-content-end'>
                        <button type="submit" class="btn btn-light btn-block me-3 mb-2"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>
                    </div>
                </form>
            </div>
        </div>
        <div class='d-flex justify-content-center'>
            <a href="./index.html" class="mt-2"> Volver al Menú Principal</a>
        </div>
    </div>
</div>
</div>

<footer class="bg-light text-center py-3">
    <p> <img src="./../modulo_prestamos/img/tesji_logo.jpeg" alt="TESJI" width="50px" height="50px">
        Tecnológico de Estudios Superiores de Jilotepec, <a href="./acemv.html" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Ingeniería en
            Sistemas Computacionales 2020-2024</a></p>
</footer>
</body>
<?php
for ($i = $inicio; $i <= $final; $i++) {
    $numero = sprintf("%05d", $i);
    $contenidoDos = $valor . $nuevaFecha . '-' . $numero;

    $filename = generarCodigoQR($contenidoDos, $directorioQR);

    $nuevoDirectorio = 'UMB_biblioteca/modulo_qr/codigos_qr';  // Cambia esto al directorio donde deseas guardar los archivos
    $nuevoPath = $nuevoDirectorio . '/' . basename($filename);
}
?>

</html>