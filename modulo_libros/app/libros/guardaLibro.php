<?php 
require './../../../conexion/database.php';
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

    $sql = "INSERT INTO libros (no_inventario, id_carrera, codigo_barras, titulo_libro, autor_libro, editorial_libro, anio_libro, edicion_libro, fecha_libro, id_estatus)
    VALUES ('$no_inv', '$carrera_libro', '$codigo_barras', '$titulo_nombre', 
    '$autor_libro', '$editorial_libro', '$anio', '$edicion', '$fecha_don_rec', '$estatus_libro')";

    if($conn->query($sql)){
        $id = $conn->insert_id;
    }
    // echo $_SESSION['registro_exitoso'];
    // exit;
    header('Location: index.php');
    ?>