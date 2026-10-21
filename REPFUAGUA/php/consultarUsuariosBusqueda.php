<?php
error_reporting(E_ALL);
require_once 'conexion.php';
$obj = json_decode(file_get_contents("php://input"));
$param = "%".$obj->texto."%";
$stmt = $db->prepare("SELECT * FROM usuario where  usuario like ? or nombre like ? or rol like ? order by usuario, nombre, rol");
$stmt->bind_param('sss', $param,$param,$param);
$stmt->bind_result($usuario,$nombre,$contraseña,$email,$rol,$status);
$stmt->execute();
$arr = array();
while($stmt->fetch()){
$arr[] = array('usuario' =>$usuario,
	'nombre' =>$nombre,
	'rol' =>$rol,
	'pass' =>$contraseña);
}
$stmt->close();
echo json_encode($arr);
?>