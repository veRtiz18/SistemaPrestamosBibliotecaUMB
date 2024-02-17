<?php
require('fpdf/fpdf.php');

$valor = $_POST['valor'];
$inputFecha = $_POST['fecha'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];

// Crear una clase personalizada que herede de FPDF
class PDF extends FPDF
{
  private $currentPageWidth;
  private $currentPageHeight;
  private $currentX;
  private $currentY;
  private $maxImagesPerLine;
  private $maxLinesPerPage;

  function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
  {
    parent::__construct($orientation, $unit, $size);
    $this->currentPageWidth = $this->GetPageWidth();
    $this->currentPageHeight = $this->GetPageHeight();
    $this->currentX = 10;
    $this->currentY = 25;
    $this->maxImagesPerLine = 6; // Número máximo de imágenes por línea
    $this->maxLinesPerPage = 8; // Número máximo de líneas por página
  }

  function PrintImage($file, $width, $height, $imageName)
  {
    if ($this->currentX + $width > $this->currentPageWidth) {
      // Si la imagen excede el ancho disponible en la línea actual, realizar un salto de línea
      $this->currentX = 10;
      $this->currentY += $height + 35;
    }

    if ($this->currentY + $height + 35 > $this->currentPageHeight) {
      // Si la imagen excede el espacio disponible en la página actual, añadir una nueva página
      $this->AddPage();
      $this->currentX = 10;
      $this->currentY = 25;
    }

    $this->Image($file, $this->currentX, $this->currentY, $width, $height);
    $textY = $this->currentY + $height - 4;
    $this->SetFont('Arial', '', 6);
    $this->SetXY($this->currentX, $textY);
    $this->Cell($width, 10, $imageName, 0, 0, 'C');

    $this->currentX += $width + 10; // Incrementar la posición X para la siguiente imagen

    if (($this->currentX - 10) / $width >= $this->maxImagesPerLine) {
      // Si se alcanza la cantidad máxima de imágenes por línea, realizar un salto de línea
      $this->currentX = 10;
      $this->currentY += $height + 5;
    }

    if (($this->currentY - 10) / $height >= $this->maxLinesPerPage) {
      // Si se alcanza la cantidad máxima de líneas por página, añadir una nueva página
      $this->AddPage();
      $this->currentX = 10;
      $this->currentY = 35;
    }
  }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Ln(100);

for ($i = $inicio; $i <= $final; $i++) {
  $numero = sprintf("%05d", $i);
  $imageFile = 'codigos_qr/' . $valor . $inputFecha . '-' . $numero . '_a.png';

  $imageWidth = 30;

  list($width, $height) = getimagesize($imageFile);
  $imageHeight = $height * $imageWidth / $width;

  $imageName = basename($imageFile);
  $imageName = str_replace('_a.png', '', $imageName);

  $pdf->PrintImage($imageFile, $imageWidth, $imageHeight, $imageName);
}

$pdfFilename = 'codigos_qr_' . $inputFecha . '.pdf';
$pdf->Output($pdfFilename, 'F');

// Borrar la imagen después de generar el PDF
for ($i = $inicio; $i <= $final; $i++) {
  $numero = sprintf("%05d", $i);
  $imageFile = 'codigos_qr/' . $valor . $inputFecha . '-' . $numero . '_a.png';
  unlink($imageFile);
}

// Descargar el PDF
header('Content-Disposition: attachment; filename="' . $pdfFilename . '"');
readfile($pdfFilename);

// Redireccionar a otra página después de descargar el PDF
// Redireccionar a otra página después de descargar el PDF
header("Location: otra_pagina.php");
exit;
?>
