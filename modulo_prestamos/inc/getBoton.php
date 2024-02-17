<?php
require('./../../../UMB_biblioteca/conexion/database.php');

$matricula =  $_POST["campo"];
$no_inventario =   $_POST["campoUsuarios"];



$sql = "CALL SP_validarCamposBusquedaPrestamo('$matricula', '$no_inventario')";
$query = mysqli_query($conn, $sql);

$html = "";

$num_registros = mysqli_num_rows($query);

while ($fila = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    if ($fila["bandera"] == "verdadero") {
        $html .= "
         <button type='submit' class='btn btn-success'><i class='fa-solid fa-floppy-disk'></i> Registrar</button>";

    } else {
        $html .= "
        <div class='alert alert-" . $fila["color"] . "' role='alert'>
        " . $fila["mensaje"] . "
        </div>";
    }
}

// Codificar la respuesta como JSON y enviarla
echo json_encode($html, JSON_UNESCAPED_UNICODE);
