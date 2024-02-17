<?php
require('./../../fpdf/fpdf.php');
require('./../../../conexion/database.php');


$consul = "CALL SP_pruebaReporte('202023097')";
$resul = mysqli_query($conn, $consul);
$mostrarAlum = mysqli_fetch_array($resul);


$pdf = new FPDF('P','mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$imagePathLeft = './../../../assets/img/logo_umb.png';
$pdf->Image($imagePathLeft, 10, 10, 20, 10);

// Agregar la imagen en la esquina derecha
$imagePathRight = './../../../assets/img/logo_edomex.png';
$pdf->Image($imagePathRight, $pdf->GetPageWidth() - 40, 10, 35, 10);

$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(110, 8, '', 0);
// Centrar la celda horizontalmente
$pdf->SetX($pdf->GetPageWidth() / 2 - 50); // 50 es la mitad del ancho de la celda (100/2)

// Agregar la celda
$pdf->Cell(100, 8, 'UNIDAD DE ESTUDIOS SUPERIORES: JILOTEPEC', 0);

$pdf->Ln(15);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 10, 'Fecha Prestamo: '. $mostrarAlum[0],0 , 0, 'R');

$pdf->Ln(5);

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 10, 'Datos del alumno:', 0, 1, 'L');



$pdf->Ln(0);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, $mostrarAlum[8], 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $mostrarAlum[7], 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $mostrarAlum[9], 0, 0, 'L');

$pdf->Ln(6);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $mostrarAlum[10], 0, 1, 'L');

mysqli_close($conn);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'DATOS DEL LIBRO', 0, 1, 'C');  // 'C' centra el texto

// Configurar las columnas de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(240, 240, 240);  // Color de fondo gris claro
$pdf->SetTextColor(0);  // Color del texto

 

require('./../../../conexion/database.php');


$consulta = "CALL SP_pruebaReporte(202023097)";
$resultados = mysqli_query($conn, $consulta);

// Llenar la tabla con los datos de la consulta
    $pdf->SetFont('Arial', '', 8, 'C');
    while ($fila = mysqli_fetch_array($resultados)) {
        // Encabezados de columna
        $pdf->Cell(100, 6, '', 0);
        $pdf->Cell(45, 6, 'Fecha de Entega:', 1, 0, 'C', 1);
        $pdf->Cell(45, 6, $fila[1], 1);
        $pdf->Ln(6);

        $pdf->Cell(45, 6, 'No Inventario', 1, 0, 'C', 1);
        $pdf->Cell(145, 6, 'Titulo', 1, 0, 'C', 1);
        $pdf->Ln(6);

        $pdf->Cell(45, 5, $fila[2], 1);
        $pdf->Cell(145, 5, $fila[3], 1);

        $pdf->Ln(5);

        $pdf->Cell(80, 6, 'Autor', 1, 0, 'C', 1);
        $pdf->Cell(80, 6, 'Editorial', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Carrera', 1, 1, 'C', 1);

        $pdf->Cell(80, 5, $fila[4], 1);
        $pdf->Cell(80, 5, $fila[5], 1);
        $pdf->Cell(30, 5, $fila[6], 1, 1); 
        
        $pdf->Ln(6);


    }
mysqli_close($conn);

require('./../../../conexion/database.php');


// Cerrar la conexión a la base de datos
mysqli_close($conn);

$pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 10, '____________________________________                  __________________________________', 0, 1, 'C');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 10, '                             Nombre y Firma del                                                     Nombre y Firma del', 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 10, '                                       Alumno                                                             Encargado de Biblioteca', 0, 0, 'L');
// Salida del PDF (puede ser directamente en el navegador o guardar en un archivo)
//$pdf->Output('datos_libro.pdf', 'D');
$pdf->Output();
?>