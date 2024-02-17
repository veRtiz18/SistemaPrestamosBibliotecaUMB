<?php 
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
$sql = "UPDATE libros
SET no_inventario = '$no_inv', 
    id_carrera = '$carrera_libro', 
    codigo_barras = '$codigo_barras', 
    titulo_libro = '$titulo_nombre', 
    autor_libro = '$autor_libro', 
    editorial_libro = '$editorial_libro', 
    anio_libro = '$anio', 
    edicion_libro = '$edicion', 
    fecha_libro = '$fecha_don_rec', 
    id_estatus = $estatus_libro
    WHERE id_libro = $id";

    if($conn->query($sql)){
        $id = $conn->insert_id;
    }
    header('Location: index.php');
?>