<?php

session_start();
require './../../../conexion/database.php';


$no_inventario = $conn->real_escape_string($_POST['id']);



$sql = "CALL EliminarLibroSiNoInventarioNoEnPrestamo('$no_inventario')";

if ($mensaje = mysqli_query($conn, $sql)) {
    while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
        $_SESSION['msg'] = $fila['mensaje'];
        $_SESSION['color'] = $fila['color'];
    }
}



// echo $sql;
// exit;
header('Location: index.php');
