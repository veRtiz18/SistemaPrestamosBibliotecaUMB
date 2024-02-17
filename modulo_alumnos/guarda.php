<?php
session_start();
require 'config/database.php';

$matricula = $conn->real_escape_string($_POST['matricula']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$apellidoPa = $conn->real_escape_string($_POST['apellidoP']);
$apellidoMa = $conn->real_escape_string($_POST['apellidoM']);
$carreraA = $conn->real_escape_string($_POST['carrera']);
$semestreA = $conn->real_escape_string($_POST['semestre']);

$sql = "CALL SP_insertarEstudiante('$matricula','$nombre', '$apellidoPa', '$apellidoMa', $carreraA, $semestreA)";

$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['mensaje'];
    $_SESSION['color'] = $fila['color'];
}

header('Location: index.php');
