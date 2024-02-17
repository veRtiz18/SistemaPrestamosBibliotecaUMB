<?php 
// session_start();
// if ($_SESSION['acceso'] == 'acceso') {
    require './../conexion/database.php';

$columns = ['id_parada', 'nombre_parada'];
$table = "usuario";
$id = 'id_usuario';
$campo = isset($_POST['campo_u']) ? $conn->real_escape_string($_POST['campo_u']) : null; 
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

//parte del limit
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
// $pagina = isset($_POST['pagina']) ? $conectar->real_escape_string($_POST['pagina']) : 0;

if(!$pagina){
    $inicio = 0;
    $pagina = 1;

}else{
    $inicio = ($pagina -1) * $limit;
}
$sLimit = "LIMIT $inicio , $limit";


//consulta principal
$sql = "
    SELECT SQL_CALC_FOUND_ROWS id_usuario,
    CONCAT(nombre_usuario, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombre,
    correo, contrasenia, user, rol.rol AS nombre_rol
    FROM usuario
    INNER JOIN rol ON usuario.rol = rol.id_rol
WHERE (id_usuario LIKE '%".$campo."%' OR
user LIKE '%".$campo."%' OR
nombre_usuario LIKE '%".$campo."%' OR
apellidoPaterno LIKE '%".$campo."%' OR
apellidoMaterno LIKE '%".$campo."%' OR
correo LIKE '%".$campo."%' OR
contrasenia LIKE '%".$campo."%' OR
rol.rol LIKE '%".$campo."%') AND usuario.estatus = 1
$sLimit";
 $resultado = $conn ->query($sql);
 $num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table WHERE estatus = 1";
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
    while($row =$resultado->fetch_assoc()){
       $output['data'].= '<tr>';
       $output['data'].= '<td class="text-center">'.$row['id_usuario'].'</td> ';
       $output['data'].= '<td class="text-center">'.$row['nombre'].'</td> ';
       $output['data'].= '<td class="text-center">'.$row['user'].'</td> ';
       $output['data'].= '<td class="text-center">'.$row['correo'].'</td> ';
       $output['data'].= '<td class="text-center">'.$row['contrasenia'].'</td> ';
       $output['data'].= '<td class="text-center">'.$row['nombre_rol'].'</td> ';
       
       $output['data'].= '<td><div class="text-center"><a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal_usuarios" data-bs-id="'.$row['id_usuario'] .'"><i class="fa-solid fa-pen-to-square"></i></a></div></td> ';
       $output['data'].= '<td><div class="text-center"><a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal_usuarios" data-bs-id="'. $row['id_usuario'] .'"><i class="fa-solid fa-trash-can"></i></a></td>';
       $output['data'].= '</tr>';
    }
}else{
   $output['data'].='<tr>';
   $output['data'].='<td class="text-center" colspan="9">Sin resultados</td>';
   $output['data'].='</tr>';
}


if($output['totalRegistros']>0){
    $totalPaginas =ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .='<nav>';
    $output['paginacion'] .='<ul class="pagination">';

    $numeroInicio = 1;
    
    if(($pagina -4 )>1){
        $numeroInicio =$pagina -4; 
    }
    $numeroFin = $numeroInicio + 9;
    if ($numeroFin > $totalPaginas) {
        $numeroFin = $totalPaginas;
    }
    for ($i=$numeroInicio; $i <=$totalPaginas ; $i++) { 
        if($pagina == $i){
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#" >'.$i.'</a></li>';

        }else{
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData('.$i.')">'.$i.'</a></li>';
        }
     
    }

    $output['paginacion'] .='</ul">';
    $output['paginacion'] .='</nav>';


}

echo json_encode($output, JSON_UNESCAPED_UNICODE);

// } else {
//     header("location: ../error.php");
// }
