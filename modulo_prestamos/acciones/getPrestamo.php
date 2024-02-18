<?php

require('./../../../UMB_biblioteca/conexion/database.php');
$id = $conn->real_escape_string($_POST['id']);

$sql = "SELECT 
prestamo.id_prestamo, 
    libros.no_inventario,
    libros.titulo_libro,
    libros.codigo_barras,
    libros.editorial_libro,
    libros.autor_libro,
    libros.anio_libro,

estudiante.nombre_estudiante, 
estudiante.ape_Paterno,
estudiante.ape_Materno,
estudiante.matricula, 
carrera.nombre_carrera AS carrera_alumno,
    semestre.nombre_semestre AS carrera_semestre,
prestamo.fecha,
prestamo.fecha_entrega,
CASE prestamo.estatus
    WHEN 1 THEN 'ADEUDO'
    WHEN 0 THEN 'CONCLUIDO'
    ELSE 'DESCONOCIDO'
END AS descripcion_estatus
FROM prestamo
INNER JOIN estudiante ON estudiante.matricula = prestamo.matricula
INNER JOIN libros ON libros.no_inventario = prestamo.no_inventario
INNER JOIN semestre ON estudiante.id_semestre = semestre.id_semestre
INNER JOIN carrera ON estudiante.id_carrera = carrera.id_carrera
WHERE prestamo.id_prestamo = $id;
";

// echo $sql;
// exit;
$resultado = $conn->query($sql);
$rows = $resultado->num_rows;

$estudiante = [];

if ($rows > 0) {
    $estudiante = $resultado->fetch_array();
}
echo json_encode($estudiante, JSON_UNESCAPED_UNICODE);
