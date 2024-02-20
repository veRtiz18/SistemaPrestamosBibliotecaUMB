<?php

require('./../../../UMB_biblioteca/conexion/database.php');

// $campo = $_POST["campoUsuarios"];
$campo = '202023097';

$sql = "CALL SP_buscarUsuarios('$campo');";
$query = mysqli_query($conn, $sql);

$html = "";

// Obtener el número de registros
$num_registros = mysqli_num_rows($query);

while ($fila = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    // echo $fila["v_matricula"];
    if ($fila["v_matricula"] == "") {
        $html .= "<div class='alert alert-danger' role='alert'>No existe un usuario con el valor introducido. Inténtelo nuevamente.
            </div>";
    } else {
        $html .= "
        <div class='card bg-" . $fila["v_color"] . " text-light'>";

        $html .= "<div class='card-body'>";

        $html .= "<h6><i class='fa-solid fa-circle-info'></i> Información del usuario:</h6>";
        
        $html .= "<li class='list-group-item list-group-item-action list-group-item-" . $fila["v_color"] . "'>
               
                <h3 class='fs-5 ms-2'>" . $fila["v_nombre_estudiante"] . " " . $fila["v_ape_Paterno"] . " " . $fila["v_ape_Materno"] . "</h3>
                <h6 class='ms-2'>" . $fila["v_matricula"] . "</h6>
                <div class='ms-2'>" . $fila["v_nombre_carrera"] . "</div>
                <div class='ms-2'>" . $fila["v_nombre_semestre"] . "</div>
                <div style='text-align: right;' class='me-2 fw-bold'>" . $fila["v_nombre_estatus_estudiante"] . "</div>
                </li>";
        $html .= "</div>";
        $html .= "</div>";
    }
}




// Codificar la respuesta como JSON y enviarla
echo json_encode($html, JSON_UNESCAPED_UNICODE);
