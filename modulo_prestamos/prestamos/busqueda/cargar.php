<?php

require('./../../../conexion/database.php');


$table = "prestamo";
$id = 'id_prestamo';
$campo = isset($_POST['campoBusqueda']) ? $conn->real_escape_string($_POST['campoBusqueda']) : null;
$where = '';
//parte del limit
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;


if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}
$sLimit = "LIMIT $inicio , $limit";

$sql = "SELECT SQL_CALC_FOUND_ROWS 
prestamo.id_prestamo, 
prestamo.no_inventario, 
libros.titulo_libro as titulo_libro, 
prestamo.matricula, 
estudiante.nombre_estudiante as nombre_estudiante,
estudiante.ape_Paterno, 
estudiante.ape_Materno,
prestamo.fecha, 
prestamo.fecha_entrega,
CASE prestamo.estatus
    WHEN 1 THEN 'ADEUDO'
    WHEN 0 THEN 'CONCLUIDO'
    ELSE 'DESCONOCIDO'
END AS descripcion_estatus
FROM prestamo
INNER JOIN libros ON prestamo.no_inventario = libros.no_inventario
INNER JOIN estudiante ON prestamo.matricula = estudiante.matricula
WHERE  
    prestamo.id_prestamo LIKE '%" . $campo . "%' OR 
    prestamo.no_inventario LIKE '%" . $campo . "%' OR 
    titulo_libro LIKE '%" . $campo . "%' OR 
    prestamo.matricula LIKE '%" . $campo . "%' OR 
    nombre_estudiante LIKE '%" . $campo . "%' OR 
    prestamo.fecha LIKE '%" . $campo . "%' OR 
    prestamo.fecha_entrega LIKE '%" . $campo . "%' 
$sLimit;";


$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];


/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

//  echo $sql;
//  exit;

$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

$html = '';
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td class="text-center small">' . $row['id_prestamo'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['matricula'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['nombre_estudiante'] . ' ' . $row['ape_Paterno'] . ' ' . $row['ape_Materno'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['titulo_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['no_inventario'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['fecha'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['fecha_entrega'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['descripcion_estatus'] . '</td>';
        
        $output['data'] .=
            '<td>
            <div class="d-flex justify-content-center align-items-center">
                <div class="ms-1">
                    <a href="#" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Terminar préstamo" data-bs-toggle="modal" data-bs-target="#confirmacionModal" data-bs-id="' . $row['id_prestamo'] . '">
                        <i class="fa-regular fa-calendar-check"></i>
                    </a>
                </div>
        
                <div class="ms-1">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver más detalles" data-bs-toggle="modal" data-bs-target="#verModal" data-bs-id="' . $row['id_prestamo'] . '">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </div>
        
                <div class="ms-1">
                    <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Generar PDF" data-bs-toggle="modal" data-bs-target="#verModal" data-bs-id="' . $row['id_prestamo'] . '">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                </div>
        
                <div class="ms-1">
                    <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Editar datos del préstamo" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="' . $row['id_prestamo'] . '">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </div>
        
               
            </div>
        </td>
        ';
        $html .= '</tr>';
        //C:\xampp\htdocs\modulo_biblioteca\assets\src
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="11">No hay resultados acorde a tu búsqueda</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if(($pagina - 4) > 1){
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if($numeroFin > $totalPaginas){
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
