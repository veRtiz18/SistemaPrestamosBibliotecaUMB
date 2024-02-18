<?php
session_start();
require './../../../conexion/database.php';

$id = $conn->real_escape_string($_POST['id']);
$no_inventario = $conn->real_escape_string($_POST['no_inventario']);
$matricula = $conn->real_escape_string($_POST['matricula']);


$sql = "CALL SP_devolucion($id, '$no_inventario', $matricula)";


$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['msg'];
    $_SESSION['color'] = $fila['color'];
}


header('Location: ./../index_prestamos.php');
