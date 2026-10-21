<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
require_once 'conexion.php';
$usuario=$_POST['usuario'];
$nombre=$_POST['nombre'];
$contraseña=md5($_POST['contraseña']);
$correo=$_POST['correo'];
$rol = "user";
$status = 1;

$sentencia=$db->prepare("INSERT INTO usuario VALUE(?,?,?,?,?,?)");
$sentencia->bind_param('sssssi',$usuario,$nombre,$contraseña,$correo,$rol,$status);
$resultado=$sentencia->execute();
echo json_encode($resultado,JSON_UNESCAPED_UNICODE);  

$sentencia->close();
$con->close();
?>