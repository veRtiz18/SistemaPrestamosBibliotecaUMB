<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
*/


require 'config/database.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['id_estudiante', 'matricula', 'nombre_estudiante', 'ape_Paterno','ape_Materno','nombre_carrera', 'nombre_semestre'];

/* Nombre de la tabla */
$table = "estudiante";
$table1 = "carrera";
$table2 = "semestre";

$id = 'id_estudiante';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "AND (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

/* Limit */
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";

/**
 * Ordenamiento
 */

 $sOrder = "";
 if(isset($_POST['orderCol'])){
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
    
    $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType;
 }


/* Consulta */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table
INNER JOIN $table1 ON estudiante.id_carrera = carrera.id_carrera
INNER JOIN $table2 ON estudiante.id_semestre = semestre.id_semestre
WHERE (estudiante.id_estatus = 1 OR estudiante.id_estatus = 2) $where
$sOrder
$sLimit";
$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;


/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table where (estudiante.id_estatus = 1 OR estudiante.id_estatus = 2)";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];

/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . $row['matricula'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre_estudiante'] . '</td>';
        $output['data'] .= '<td>' . $row['ape_Paterno'] . '</td>';
        $output['data'] .= '<td>' . $row['ape_Materno'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre_carrera'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre_semestre'] . '</td>';
        $output['data'] .= '<td><a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"  data-bs-target="#editaModal" data-bs-id=' . $row['id_estudiante'] . '><i class="fa-solid fa-pen-to-square fa-lg"></i></a></td>';
        $output['data'] .= "<td><a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#eliminaModal' data-bs-id=" . $row['id_estudiante'] . "><i class='fa-solid fa-trash-can fa-lg'></i></a></td>";
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="8">Sin resultados</td>';
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