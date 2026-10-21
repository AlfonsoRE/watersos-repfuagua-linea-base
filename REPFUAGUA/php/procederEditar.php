<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
include 'conexion.php';
$usuario2=$_POST['nombreUser2'];
$nombre2=$_POST['nombre2'];
$email2=$_POST['email2'];
$status2=$_POST['status2'];
$sentencia="UPDATE usuario SET nombre = '$nombre2',email = '$email2', status ='$status2' WHERE usuario='$usuario2'";
$resultado = mysqli_query($db, $sentencia);

	if ($resultado === TRUE) {
		header('Location: ../tabladeregistros.php');
	}else{
		echo "Error";
	}
?>