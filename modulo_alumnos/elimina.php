<?php
session_start();
require 'config/database.php';

$idE = $conn->real_escape_string($_POST['id']);

$sql = "CALL SP_eliminarEstudiante($idE)";


$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['mensaje'];
    $_SESSION['color'] = $fila['color'];
}


header('Location: index.php');
