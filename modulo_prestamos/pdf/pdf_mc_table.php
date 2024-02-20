<?php
// Incluye el archivo principal de FPDF
// require('fpdf/fpdf.php');
require('./../fpdf/fpdf.php');
// Crea una nueva clase que extiende la clase FPDF
class PDF_MC_Table extends FPDF {
    // Propiedades para almacenar anchos, alineaciones y altura de las celdas
    var $widths;
    var $aligns;
    var $lineHeight;

    // Constructor
    function __construct() {
        parent::__construct();
        $this->SetFont('Arial', '', 8); // Establece la fuente Arial, sin negrita, tamaño 12
    }

    // Establece los anchos de las columnas
    function SetWidths($w){
        $this->widths = $w;
    }

    // Establece las alineaciones de las columnas
    function SetAligns($a){
        $this->aligns = $a;
    }

    // Establece la altura de las filas
    function SetLineHeight($h){
        $this->lineHeight = $h;
    }

    // Crea una fila con los datos proporcionados
    function Row($data)
    {
        // Número máximo de líneas
        $nb = 0;

        // Loop para encontrar el número máximo de líneas en una fila
        for($i = 0; $i < count($data); $i++){
            // NbLines calculará cuántas líneas son necesarias para mostrar el texto envuelto en el ancho especificado.
            // La función max comparará el resultado con $nb y devolverá el máximo. Y reasignará $nb.
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        
        // Multiplica el número de líneas por la altura de línea. Esta será la altura de la fila actual
        $h = $this->lineHeight * $nb;

        // Agrega un salto de página si es necesario
        $this->CheckPageBreak($h);

        // Dibuja las celdas de la fila actual
        for($i = 0; $i < count($data); $i++)
        {
            // Ancho de la columna actual
            $w = $this->widths[$i];
            // Alineación de la columna actual. Si no está establecida, la alineación será izquierda.
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Guarda la posición actual
            $x = $this->GetX();
            $y = $this->GetY();
            // Dibuja el borde
            $this->Rect($x, $y, $w, $h);
            // Imprime el texto
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            // Mueve la posición a la derecha de la celda
            $this->SetXY($x + $w, $y);
        }
        // Cambia a la siguiente línea
        $this->Ln($h);
    }

    // Verifica si es necesario un salto de página
    function CheckPageBreak($h)
    {
        // Si la altura h causaría un desbordamiento, agrega una nueva página inmediatamente
        if($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Calcula el número de líneas que ocupará un texto en una celda de ancho w
    function NbLines($w, $txt)
    {
        // Calcula el número de líneas que ocupará un MultiCell de ancho w
        $cw = &$this->CurrentFont['cw'];
        if($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i < $nb)
        {
            $c = $s[$i];
            if($c == "\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if($l > $wmax)
            {
                if($sep == -1)
                {
                    if($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}
?>
