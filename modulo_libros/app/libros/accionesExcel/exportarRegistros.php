<?php
require('./../../../vendor/autoload.php');
require ('./../../../../conexion/database.php');

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};


$fecha_don = $_POST['fecha_don'];

if ($fecha_don == 'TODOS LOS LIBROS') {
    $sql = "SELECT 
    libros.no_inventario, 
    carrera.nombre_carrera as 'nombre_carrera', 
    libros.codigo_barras, 
    libros.titulo_libro, 
    libros.autor_libro, 
    libros.editorial_libro, 
    libros.anio_libro, 
    libros.edicion_libro, 
    CASE 
        WHEN libros.fecha_libro = '1970-01-01' THEN 'SIN FECHA' 
        ELSE libros.fecha_libro 
    END as 'fecha_libro', 
    estatus_libro.nombre_estatus as 'estatus'
FROM libros
INNER JOIN estatus_libro ON libros.id_estatus = estatus_libro.id_estatus
INNER JOIN carrera ON libros.id_carrera = carrera.id_carrera;
";
} else if ($fecha_don == 'SIN FECHA') {

    $sql = "SELECT libros.no_inventario, carrera.nombre_carrera as 'nombre_carrera',
    libros.codigo_barras, libros.titulo_libro,
    libros.autor_libro, libros.editorial_libro, 
    libros.anio_libro, libros.edicion_libro,
    IF(libros.fecha_libro = '1970-01-01', 'SIN FECHA', libros.fecha_libro) as 'fecha_libro',
    estatus_libro.nombre_estatus as 'estatus'
    FROM libros
    INNER JOIN estatus_libro ON libros.id_estatus = estatus_libro.id_estatus
    INNER JOIN carrera ON libros.id_carrera = carrera.id_carrera
    WHERE fecha_libro = '1970-01-01';
    ";
} else {


    $sql = "SELECT libros.no_inventario, carrera.nombre_carrera as 'nombre_carrera',
    libros.codigo_barras, libros.titulo_libro,
   libros.autor_libro, libros.editorial_libro, 
  libros.anio_libro, libros.edicion_libro, libros.fecha_libro, estatus_libro.nombre_estatus as 'estatus'
  FROM libros
  INNER JOIN estatus_libro ON libros.id_estatus = estatus_libro.id_estatus
  INNER JOIN carrera ON libros.id_carrera = carrera.id_carrera WHERE fecha_libro = '$fecha_don'";
}


$resultado = $conn->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("UESJILOTEPEC");

// Configurar el estilo para la celda 'A1'
$hojaActiva->setAutoFilter('A1:J1'); // Esto establece un filtro en la fila 1, columnas A a J

$hojaActiva->getStyle('A1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('B1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('C1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('D1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('E1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('F1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('G1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('H1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('I1')->getFont()->setBold(true); // Negritas
$hojaActiva->getStyle('J1')->getFont()->setBold(true); // Negritas

$hojaActiva->getColumnDimension('A')->setWidth(30);
$hojaActiva->setCellValue('A1', 'NO. INVENTARIO');
$hojaActiva->getColumnDimension('B')->setWidth(30);
$hojaActiva->setCellValue('B1', 'CODIGO DE BARRAS');
$hojaActiva->getColumnDimension('C')->setWidth(40);
$hojaActiva->setCellValue('C1', 'CARRERA');
$hojaActiva->getColumnDimension('D')->setWidth(40);
$hojaActiva->setCellValue('D1', 'NOMBRE DEL LIBRO');
$hojaActiva->getColumnDimension('E')->setWidth(40);
$hojaActiva->setCellValue('E1', 'AUTOR DEL LIBRO');
$hojaActiva->getColumnDimension('F')->setWidth(20);
$hojaActiva->setCellValue('F1', 'EDITORIAL DEL LIBRO');
$hojaActiva->getColumnDimension('G')->setWidth(5);
$hojaActiva->setCellValue('G1', 'ANIO');
$hojaActiva->getColumnDimension('H')->setWidth(15);
$hojaActiva->setCellValue('H1', 'EDICION');
$hojaActiva->getColumnDimension('I')->setWidth(40);
$hojaActiva->setCellValue('I1', 'FECHA DE DONACION');
$hojaActiva->getColumnDimension('J')->setWidth(40);
$hojaActiva->setCellValue('J1', 'ESTATUS');

$fila = 2;
while ($rows = $resultado->fetch_assoc()) {
    $hojaActiva->setCellValue('A' . $fila, $rows['no_inventario']);
    $hojaActiva->setCellValue('B' . $fila, $rows['codigo_barras']);
    $hojaActiva->setCellValue('C' . $fila, $rows['nombre_carrera']);
    $hojaActiva->setCellValue('D' . $fila, $rows['titulo_libro']);
    $hojaActiva->setCellValue('E' . $fila, $rows['autor_libro']);
    $hojaActiva->setCellValue('F' . $fila, $rows['editorial_libro']);
    $hojaActiva->setCellValue('G' . $fila, $rows['anio_libro']);
    $hojaActiva->setCellValue('H' . $fila, $rows['edicion_libro']);
    $hojaActiva->setCellValue('I' . $fila, $rows['fecha_libro']);
    $hojaActiva->setCellValue('J' . $fila, $rows['estatus']);
    $fila++;
}
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="UMB_LIBROS.xlsx');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');

exit;
