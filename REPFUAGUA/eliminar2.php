<?php
include "./php/conexion.php";
$usu=$_POST['txtusuario'];
mysqli_query($db ,"DELETE FROM usuario where usuario='$usu'") or die ("error al eliminar");
mysqli_close($db);
header("location:tabladeregistros.php")

?>