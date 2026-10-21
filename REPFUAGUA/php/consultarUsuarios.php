<?php
error_reporting(E_ALL);
require_once "conexion.php";
$stmt = $db->prepare("SELECT *FROM usuario");
$stmt->bind_result($usuario,$nombre,$contraseña,$email,$rol,$status);
$stmt -> execute();
$arr = array();
while($stmt ->fetch()){
$arr[] = array('usuario'=> $usuario,
               'nombre' => $nombre,
               'rol'    =>$rol    ,
               'pass'  => $contraseña);

}
  $stmt ->close();
   echo json_encode($arr);


?>