<?php

require 'config/database.php';

$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT id_estudiante, 
matricula, 
nombre_estudiante, 
ape_Paterno,
ape_Materno,
id_carrera,
id_semestre
FROM estudiante WHERE id_estudiante=$id LIMIT 1";
$resultado = $conn->query($sql);
$rows = $resultado->num_rows;

$estudiante = [];

if ($rows > 0) {
    $estudiante = $resultado->fetch_array();
}

echo json_encode($estudiante, JSON_UNESCAPED_UNICODE);
