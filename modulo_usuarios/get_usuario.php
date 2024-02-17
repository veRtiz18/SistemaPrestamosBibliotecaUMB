<?php 
 session_start();
// if ($_SESSION['acceso'] == 'acceso') {
    require './../conexion/database.php';

$id_usuario = $conn->real_escape_string($_POST['id_usuario']);



$consulta = " SELECT id_usuario,
nombre_usuario,
apellidoPaterno,
apellidoMaterno, 
user,
correo, 
contrasenia,
rol 
 FROM usuario WHERE id_usuario = $id_usuario LIMIT 1";
$resultado = $conn ->query($consulta);
$rows = $resultado->num_rows;

$usuario = [];
if($rows > 0){
    $usuario = $resultado->fetch_array();

}
echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
// } else {
//     header("location: ../error.php");
// }
?>

