<?php
include 'conexion.php';

$usu_clave = $_GET['clave']; 

$consulta = "SELECT * FROM foto where clave_Reporte = '$usu_clave'";
$resultado = $db ->query($consulta);

$producto = array();

while($fila =$resultado ->fetch_array()){
   
    $producto[]= $fila;
}

echo json_encode($producto, JSON_UNESCAPED_UNICODE);
$resultado ->close();
?>