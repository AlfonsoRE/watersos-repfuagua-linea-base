<?php
include 'conexion.php';
$usu_usuario=$_POST['usuario'];
$usu_password=md5($_POST['password']);

//$usu_usuario="cruoch01";
//$usu_password="1234";
$sentencia=$db->prepare("SELECT * FROM usuario WHERE usuario=? AND contraseña=?");
$sentencia->bind_param('ss',$usu_usuario,$usu_password);
$sentencia->execute();

$resultado = $sentencia->get_result();
if ($fila = $resultado->fetch_assoc()) {
         echo json_encode($fila,JSON_UNESCAPED_UNICODE);     
}

$sentencia->close();
$db->close();

?>