<?php
require('./pdf_mc_table.php');
require('./../../conexion/database.php');

$pdf = new PDF_MC_Table('');
$pdf->AddPage();
$imagePathLeft = './../../assets/img/umb-logo.png';
$pdf->Image($imagePathLeft, 10, 10, 35, 10);

$imagePathRight = './../../assets/img/umb-jilotepec.png';
$pdf->Image($imagePathRight, $pdf->GetPageWidth() - 40, 10, 35, 10);

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(110, 8, '', 0);
$pdf->SetX($pdf->GetPageWidth() / 2 - 50);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(120, 8, 'UNIDAD DE ESTUDIOS SUPERIORES: JILOTEPEC', 0);
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 10, 'Fecha de Generacion: '.date('d/m/Y').'', 0);
$pdf->Ln(5);
$pdf->Cell(0, 8, 'Motivo: Libros en adeudo vigente', 0);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);

$widths = array(41, 35, 25, 25, 25, 20, 20);
$pdf->SetWidths($widths);

$aligns = array('C', 'C', 'C', 'C', 'C', 'C', 'C');
$pdf->SetAligns($aligns);   
$pdf->SetLineHeight(10);

$consulta = "CALL SP_PDFVigentes('vigentes')";
$resultados = mysqli_query($conn, $consulta);

$data = array(
    array('No. Inventario', 'Titulo', 'Codigo de Barras', 'Alumno', 'Carrera', 'Semestre', 'Estado')
);

while ($fila = mysqli_fetch_array($resultados)) {
    $data[] = array(
        $fila[0],
        $fila[1],
        $fila[2],
        $fila[3],
        $fila[4],
        $fila[5],
        'Adeudo Vigente'
    );
}

mysqli_close($conn);

foreach($data as $row) {
    $pdf->Row($row);
}

$pdf->Output('D', 'ReportePDFVigentes.pdf');
?>
