<?php
 session_start();
// if ($_SESSION['acceso'] == 'acceso') {

    require './../conexion/database.php';

$id_usuario = $conn->real_escape_string($_POST['id']);
$nombre_usuario = $conn->real_escape_string($_POST['nombre_usuario']);
$apellido_paterno = $conn->real_escape_string($_POST['apellido_paterno']);
$apellido_materno = $conn->real_escape_string($_POST['apellido_materno']);
$usuario = $conn->real_escape_string($_POST['alias_user']);
$correo = $conn->real_escape_string($_POST['correo_user']);
$contrasenia = $conn->real_escape_string($_POST['contrasenia_user']);
$id_rol = $conn->real_escape_string($_POST['select_rol']);
// $foto = $conectar->real_escape_string($_POST['perfil']);


$sql = "
CALL SP_actualizarUsuarioAdmin($id_usuario,'$nombre_usuario', '$apellido_paterno', '$apellido_materno', '$usuario', '$correo', '$contrasenia',$id_rol, 1);";

$mensaje = mysqli_query($conn, $sql);

    while ($fila = mysqli_fetch_array($mensaje, MYSQLI_ASSOC)) {
        $_SESSION['msg'] = $fila['mensaje'];
        $_SESSION['color'] = $fila['color'];
        
    }

    $id = $conn->insert_id;





header('Location: index_usuarios.php');

// } else {
//     header("location: ../error.php");
// }
?>