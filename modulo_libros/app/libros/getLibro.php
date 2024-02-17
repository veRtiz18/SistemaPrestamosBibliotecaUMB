<?php

require './../../../conexion/database.php';
$id = $conn->real_escape_string($_POST['id']); 

$sql = "SELECT id_libro, no_inventario, id_carrera, codigo_barras, 
titulo_libro, autor_libro, editorial_libro, anio_libro, edicion_libro, 
fecha_libro, id_estatus FROM libros where id_libro = $id LIMIT 1";


$resultado = $conn->query($sql);
$rows =$resultado->num_rows;

$libro = [];

if($rows > 0){
    $libro = $resultado->fetch_array();

}

echo json_encode($libro, JSON_UNESCAPED_UNICODE);




?>
