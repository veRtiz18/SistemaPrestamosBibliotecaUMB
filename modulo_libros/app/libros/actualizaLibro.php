<?php
 session_start();
require './../../../conexion/database.php';

$id = $conn->real_escape_string($_POST['id']);
$no_inv = $conn->real_escape_string($_POST['no_inventario']);
$carrera_libro = $conn->real_escape_string($_POST['carrera']);
$codigo_barras = $conn->real_escape_string($_POST['c_barras']);
$titulo_nombre = $conn->real_escape_string($_POST['n_libro']);
$autor_libro = $conn->real_escape_string($_POST['autor']);
$editorial_libro = $conn->real_escape_string($_POST['editorial']);
$anio = $conn->real_escape_string($_POST['anio']);
$edicion = $conn->real_escape_string($_POST['edicion']);
$fecha_don_rec = $conn->real_escape_string($_POST['fecha_don_rec']);
$estatus_libro = $conn->real_escape_string($_POST['estatus']);

echo $estatus_libro;
echo $id;
echo $no_inv;
$sql = "CALL SP_actualizarLibro($id,
'$no_inv','$carrera_libro','$codigo_barras','$titulo_nombre','$autor_libro',
'$editorial_libro','$anio','$edicion', '$fecha_don_rec');
";



$mensaje = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
    $_SESSION['msg'] = $fila['mensaje'];
    $_SESSION['color'] = $fila['color'];
}
header('Location: index.php');
