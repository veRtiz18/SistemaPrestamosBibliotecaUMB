<?php

require('./../../../vendor/autoload.php');
require ('./../../../../conexion/database.php');


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
                $no_inventario = $hojaActual->getCellByColumnAndRow(1, $indiceFila);
                $id_carrera = $hojaActual->getCellByColumnAndRow(2, $indiceFila);
                $codigo_barras = $hojaActual->getCellByColumnAndRow(3, $indiceFila);
                $nombre_libro = $hojaActual->getCellByColumnAndRow(4, $indiceFila);
                $autor_libro = $hojaActual->getCellByColumnAndRow(5, $indiceFila);
                $editorial_libro = $hojaActual->getCellByColumnAndRow(6, $indiceFila);
                $anio = $hojaActual->getCellByColumnAndRow(7, $indiceFila);
                $edicion = $hojaActual->getCellByColumnAndRow(8, $indiceFila);

                $fechaExcel = $hojaActual->getCellByColumnAndRow(9, $indiceFila)->getFormattedValue();
                $fechaLegible = date('Y-m-d', strtotime($fechaExcel));

                $estatus = $hojaActual->getCellByColumnAndRow(10, $indiceFila);


                //quita las " ' " de la insercion y les coloca "/" en su lugar
                $nuevo_numero_invenario = str_replace("'", "/", $no_inventario);
                $nuevo_autor = str_replace("'", "", $autor_libro);
                $nuevo_nombre = str_replace("'", "", $nombre_libro);

                // echo $cadena_modificada;
                // exit;
                $sql = "CALL SP_importarLibros
                   (
                    '$nuevo_numero_invenario', 
                    (SELECT id_carrera FROM carrera WHERE nombre_carrera = '$id_carrera'), 
                    '$codigo_barras', 
                    '$nuevo_nombre', 
                    '$nuevo_autor',
                    '$editorial_libro', 
                    '$anio', 
                    '$edicion', 
                    '$fechaLegible', 
                    (SELECT estatus_libro.id_estatus FROM estatus_libro WHERE estatus_libro.nombre_estatus = '$estatus')
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
