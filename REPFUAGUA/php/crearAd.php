<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
require_once 'conexion.php';
$usuario=$_POST['nombreUser'];
$nombre=$_POST['nombre'];
$contraseña=md5($_POST['contra']);
$correo=$_POST['email'];
$rol = "admin";
$status = 1;
$sentencia=$db->prepare("INSERT INTO usuario VALUE(?,?,?,?,?,?)");
$sentencia->bind_param('sssssi',$usuario,$nombre,$contraseña,$correo,$rol,$status);
$resultado=$sentencia->execute();
$sentencia->close();
die ("ADMINISTRADOR GUARDADO CORRECTAMENTE");


?>
