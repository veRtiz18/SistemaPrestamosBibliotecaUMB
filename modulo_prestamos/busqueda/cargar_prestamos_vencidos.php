<?php

require('./../../conexion/database.php');


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
    DATE_FORMAT(prestamo.fecha, '%e-%M-%Y') AS fecha_prestamo, 
    DATE_FORMAT(prestamo.fecha_entrega, '%e-%M-%Y') AS fecha_entrega,
    libros.no_inventario, 
    libros.titulo_libro, 
    libros.autor_libro, 
    libros.editorial_libro, 
    carrera.nombre_carrera, 
    estudiante.matricula, 
    CONCAT(estudiante.nombre_estudiante, ' ', estudiante.ape_Paterno, ' ', estudiante.ape_Materno) AS nombre_estudiante, 
    carrera.nombre_carrera, 
    semestre.nombre_semestre, 
    prestamo.id_prestamo
FROM
    prestamo
INNER JOIN libros ON prestamo.no_inventario = libros.no_inventario
INNER JOIN estudiante ON prestamo.matricula = estudiante.matricula
INNER JOIN carrera ON estudiante.id_carrera = carrera.id_carrera
INNER JOIN semestre ON estudiante.id_semestre = semestre.id_semestre
WHERE 
    prestamo.fecha_entrega < DATE(NOW()) AND prestamo.estatus = 1
 AND
(libros.no_inventario LIKE '%" . $campo . "%' OR 
libros.titulo_libro LIKE '%" . $campo . "%')
$sLimit;";

$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table WHERE prestamo.fecha_entrega < DATE(NOW()) AND prestamo.estatus = 1";
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

        $output['data'] .= '        <div class="col-4">';
        $output['data'] .= '            <!-- Primer Card -->';
        $output['data'] .= '            <div class="mt-3 mb-3">';
        $output['data'] .= '                <div class="card">';
        $output['data'] .= '                    <div class="card-header bg-danger text-light"><i class="fas fa-info-circle"></i> Préstamo</div>';
        $output['data'] .= '                    <div class="card-body">';
        $output['data'] .= '                        <h6 class="card-title d-inline fw-normal">Fecha de Préstamo: </h6>';
        $output['data'] .= '                        <h6 class="card-text d-inline ml-2 text-danger">';
        $output['data'] .=                             $row['fecha_prestamo'];
        $output['data'] .= '                        </h6>';
        $output['data'] .= '                        <br>';
        $output['data'] .= '                        <h6 class="card-title d-inline fw-normal">Fecha de Entrega: </h6>';
        $output['data'] .= '                        <h6 class="card-text d-inline ml-2 text-danger">';
        $output['data'] .=                             $row['fecha_entrega'];
        $output['data'] .= '                        </h6>';
        $output['data'] .= '                        <br>';
        $output['data'] .= '                        <div class="row">';
        $output['data'] .= '                            <div class="col">';
        $output['data'] .= '                                <ul class="list-group">';
        $output['data'] .= '                                    <li class="list-group-item bg-danger text-light mt-2" aria-current="true">';
        $output['data'] .= '                                        <h6><i class="fas fa-book"></i> Datos del libro</h6>';
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item fw-bolder">';
        $output['data'] .=                                         $row['no_inventario'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item fw-bolder">';
        $output['data'] .=                                         $row['titulo_libro'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item">';
        $output['data'] .=                                         $row['autor_libro'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item">';
        $output['data'] .=                                         $row['editorial_libro'];

        $output['data'] .= '                                </ul>';
        $output['data'] .= '                            </div>';
        $output['data'] .= '                            <div class="col">';
        $output['data'] .= '                                <ul class="list-group">';
        $output['data'] .= '                                    <li class="list-group-item bg-danger text-light mt-2" aria-current="true">';
        $output['data'] .= '                                        <h6><i class="fas fa-user-circle"></i> Datos del usuario</h6>';
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item fw-bolder">';
        $output['data'] .=                                         $row['matricula'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item fw-bolder">';
        $output['data'] .=                                         $row['nombre_estudiante'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item">';
        $output['data'] .=                                         $row['nombre_carrera'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                    <li class="list-group-item">';
        $output['data'] .=                                         $row['nombre_semestre'];
        $output['data'] .= '                                    </li>';
        $output['data'] .= '                                </ul>';
        $output['data'] .= '                            </div>';
        $output['data'] .= '                        </div>';
        $output['data'] .= '                            <div>';
        $output['data'] .= '                                <div class="ms-1 text-end mt-3">
                                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Ver más detalles" data-bs-toggle="modal" data-bs-target="#confirmacionModal" data-bs-id="' . $row['id_prestamo'] . '">
                                                                <i class="fa-regular fa-calendar-check"></i> Concluir Préstamo
                                                                </a>
                                                        </div>';

        $output['data'] .= '                        </div>';

        $output['data'] .= '                    </div><!-- Close card-body -->';
        $output['data'] .= '                </div><!-- Close card -->';
        $output['data'] .= '            </div><!-- Close mt-3 mb-3 -->';
        $output['data'] .= '        </div><!-- Close col-4 -->';

        // Agrega más columnas col-4 según sea necesario para tus otras cards

        //C:\xampp\htdocs\modulo_biblioteca\assets\src
    }
} else {
    $output['data'] .= '<div class="text-center mt-5">';
    $output['data'] .= '    <img src="./img/estanteria.png" alt="Imagen" class="img-fluid mb-4" style="max-width: 150px;">';
    $output['data'] .= '    <h2 class="text-center">¡UPS!</h1>';
    $output['data'] .= '    <h4 class="text-center">No existen registros con los datos de búsqueda o no existen préstamos vencidos en curso...</h3>';
    $output['data'] .= '    <a href="./index_prestamos.php">Volver a el administrador de préstamos.</a>';
    $output['data'] .= '</div>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if (($pagina - 4) > 1) {
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if ($numeroFin > $totalPaginas) {
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
