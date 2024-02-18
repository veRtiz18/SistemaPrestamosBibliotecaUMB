<?php
session_start();
require './../../conexion/database.php';
$campo = $conn->real_escape_string($_POST['campo']);
$campoUsuarios = $conn->real_escape_string($_POST['campoUsuarios']);
$fecha = $conn->real_escape_string($_POST['fecha']);



$sql = "CALL SP_crearPrestamo('$campo', '$campoUsuarios', '$fecha');";


$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['mensaje'];
    $_SESSION['color'] = $fila['color'];
}

header('Location: ./../index_prestamos.php');
// C:\xampp\htdocs\UMB_biblioteca\modulo_prestamos\app\prestamos\index_prestamos.php