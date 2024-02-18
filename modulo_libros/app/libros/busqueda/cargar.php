<?php

require('./../../../../conexion/database.php');


$table = "libros";
$id = 'id_libro';
$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;
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

$sql = "SELECT SQL_CALC_FOUND_ROWS libros.id_libro, libros.no_inventario, carrera.nombre_carrera as 'nombre_carrera', libros.codigo_barras, libros.titulo_libro, libros.autor_libro, libros.editorial_libro, libros.anio_libro, libros.edicion_libro, CASE WHEN libros.fecha_libro = '1970-01-01' THEN 'SIN FECHA' ELSE libros.fecha_libro END as 'fecha_libro', estatus_libro.nombre_estatus as 'estatus' 
FROM libros 
INNER JOIN estatus_libro ON libros.id_estatus = estatus_libro.id_estatus 
INNER JOIN carrera ON libros.id_carrera = carrera.id_carrera 
WHERE 
    (libros.no_inventario LIKE '%%' 
    OR carrera.nombre_carrera LIKE '%%' 
    OR libros.codigo_barras LIKE '%%' 
    OR libros.titulo_libro LIKE '%%' 
    OR libros.autor_libro LIKE '%%' 
    OR libros.editorial_libro LIKE '%%' 
    OR libros.anio_libro LIKE '%%' 
    OR libros.edicion_libro LIKE '%%' 
    OR (CASE WHEN libros.fecha_libro = '1970-01-01' THEN 'SIN FECHA' ELSE libros.fecha_libro END) LIKE '%%' 
    OR estatus_libro.nombre_estatus LIKE '%%')
    AND (libros.id_estatus = 1 OR libros.id_estatus = 2)
$sLimit;";


$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table WHERE (libros.id_estatus = 1 OR libros.id_estatus = 2)";
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
        $output['data'] .= '<td class="text-center small">' . $row['no_inventario'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['nombre_carrera'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['codigo_barras'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['titulo_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['autor_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['editorial_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['anio_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['edicion_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['fecha_libro'] . '</td>';
        $output['data'] .= '<td class="text-center small">' . $row['estatus'] . '</td>';
        $output['data'] .=
            '<td>
            <div class="d-flex align-items-center">
            <div class="ml-1">
                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="' . $row['id_libro'] . '">
                <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </div>
            <p class="text-light">a</p>
            <div>
                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="' . $row['id_libro'] . '">
                <i class="fa-solid fa-trash-can"></i>
                </a>
            </div>
        </div>
        
        
        </td>';
        $html .= '</tr>';
        //C:\xampp\htdocs\modulo_biblioteca\assets\src
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="11" class="text-center" >No hay resultados acorde a tu búsqueda</td>';
    $output['data'] .= '</tr>';
}
if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    if ($pagina > 1) {
        $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(1)">Primera</a></li>';
        $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . ($pagina - 1) . ')">Anterior</a></li>';
    }

    for ($i = max(1, $pagina - 2); $i <= min($totalPaginas, $pagina + 2); $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#" >' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . $i . ')">' . $i . '</a></li>';
        }
    }

    if ($pagina < $totalPaginas) {
        $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . ($pagina + 1) . ')">Siguiente</a></li>';
        $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . $totalPaginas . ')">Última</a></li>';
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
