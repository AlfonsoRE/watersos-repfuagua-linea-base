<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
error_reporting(E_ALL);
require_once './php/conexion.php';
$obj = json_decode(file_get_contents("php://input"));
$stmt = $con->prepare("INSERT INTO usuario(usuario,nombre,contraseña,email,rol,status)
	VALUES(?,?,?,?,?,?)");
$pass = md5($obj->contraseña);
$stmt->bind_param('ssssss',$obj->usuario,$obj->nombre,$obj->contraseña,$obj->email,$obj->rol,$obj->status);
$stmt->execute();
echo "Registro almacenado";
?>

 
