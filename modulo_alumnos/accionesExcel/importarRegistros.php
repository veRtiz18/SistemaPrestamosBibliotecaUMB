<?php

require('./../vendor/autoload.php');
require('./../../conexion/database.php');


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_excel'])) {


    $archivo = $_FILES['archivo_excel'];

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $archivo['tmp_name'];

        $documento = IOFactory::load($nombreArchivo);
        $totalHojas = $documento->getSheetCount();

        for ($indiceHoja = 0; $indiceHoja < $totalHojas; $indiceHoja++) {
            $hojaActual = $documento->getSheet($indiceHoja);
            $numeroFilas = $hojaActual->getHighestDataRow();
            $letra = $hojaActual->getHighestColumn();
            $numeroLetra = Coordinate::columnIndexFromString($letra);

            for ($indiceFila = 2; $indiceFila <= $numeroFilas; $indiceFila++) {
                // Obtener datos de la hoja de Excel
                $matricula = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
                $nombre = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
                $apellido_paterno = $hojaActual->getCellByColumnAndRow(3, $indiceFila);
                $apellido_materno = $hojaActual->getCellByColumnAndRow(4, $indiceFila);
                $carrera = $hojaActual->getCellByColumnAndRow(5, $indiceFila);
                $semestre = $hojaActual->getCellByColumnAndRow(6, $indiceFila);
                $estatus = $hojaActual->getCellByColumnAndRow(7, $indiceFila);

                // echo $cadena_modificada;
                // exit;
                $sql = "CALL SP_insertaYActualizaEstudiantes
                   (
                    '$matricula', 
                    '$nombre', 
                    '$apellido_paterno', 
                    '$apellido_materno', 
                    '$carrera',
                    '$semestre', 
                    '$estatus'
                    );";

                // echo $sql;
                // exit;
                $conn->query($sql);
            }
        }

        header('Location: ./../index.php');
    } else {
        echo "Error al subir el archivo.";
    }
}
