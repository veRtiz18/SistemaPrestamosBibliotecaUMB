<?php
session_start();
require './../../conexion/database.php';
$folio = $conn->real_escape_string($_POST['folio']);
$fecha_final = $conn->real_escape_string($_POST['fecha_final']);


$sql = "CALL SP_actualizarPrestamo($folio, '$fecha_final');";

$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['msg'];
    $_SESSION['color'] = $fila['color'];
}

header('Location: ./index_prestamos.php');
// C:\xampp\htdocs\UMB_biblioteca\modulo_prestamos\app\prestamos\index_prestamos.php