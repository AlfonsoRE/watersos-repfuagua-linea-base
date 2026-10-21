<?php
error_reporting(E_ALL);
require_once 'conexion.php';
$stmt = $db->prepare("SELECT * FROM usuario where usuario=? and contraseña=?");
$pass = md5($_POST['pass']);
$stmt->bind_param('ss',$_POST['nombre'],$pass);
$stmt->bind_result($usuario,$nombre,$contraseña,$email,$rol,$status);
$stmt->execute();
if($stmt->fetch()){
  session_start();
  $_SESSION['usuario']=$usuario;
  $_SESSION['rol']=$rol;

   if($status=="1"){
      header("Location: ../menuAdmin.php");
   }else{ 
      header("Location: ../index.php");
  }
 
    
}
else{
	 header("Location: ../index.php");
}

$stmt->close();
?>