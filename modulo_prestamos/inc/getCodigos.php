
<?php

require('./../../../UMB_biblioteca/conexion/database.php');

$campo = $_POST["campo"];

$sql = "CALL SP_buscarLibros('$campo');";
$query = mysqli_query($conn, $sql);

$html = "";

// Obtener el número de registros
$num_registros = mysqli_num_rows($query);


while ($fila = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    if ($fila["no_inventario"] == "") {
        $html .= "<div class='alert alert-danger' role='alert'>No existe un libro con el valor introducido. Inténtelo nuevamente.

        </div>";
    } else {
        $html .= "
        <div class='card bg-" . $fila["color"] . " text-light'>";
        $html .= "<div class='card-body'>";
        $html .= "<h6><i class='fa-solid fa-circle-info'></i> Información del libro:</h6>";
        $html .= "<li class='list-group-item list-group-item-action list-group-item-" . $fila["color"] . "'>
                <h5 class='ms-2'>" . $fila["titulo_libro"] . "</h5>
                <h6 class='fs-6 ms-2'>" . $fila["no_inventario"] . "</h6>
                <div class='ms-2'>" . $fila["nombre_carrera"] . "</div>
                <div class='fs-6 ms-2'>" . $fila["autor_libro"] . "</div>
                <div class='fs-6 ms-2'>" . $fila["editorial_libro"] . "</div>
                <div class='fs-6 ms-2'>" . $fila["anio"] . "</div>
                <div style='text-align: right;' class='me-2 fw-bold'>" . $fila["estatus"] . "</div> 
            </li>";
        $html .= "</div>";
        $html .= "</div>";
    }
}

// Codificar la respuesta como JSON y enviarla
echo json_encode($html, JSON_UNESCAPED_UNICODE);
