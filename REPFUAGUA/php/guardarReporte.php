<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
error_reporting(E_ALL);
require_once 'conexion.php';
$clave_Reporte= $_POST['clave_Reporte'];
$No_Contrato=$_POST['No_Contrato'];
$No_Ext=$_POST['No_Ext'];
$direccion=$_POST['direccion'];
$latitud= $_POST['latitud'];
$longitud= $_POST['longitud'];
$fecha =$_POST['fecha'];
$descripcion=$_POST['descripcion'];
$seguimiento=$_POST['seguimiento'];
$usuario=$_POST['usuario'];

$sentencia=$db->prepare("INSERT INTO reporte VALUE('$clave_Reporte','$No_Contrato','$No_Ext','$direccion','$latitud','$longitud','$fecha','$descripcion','$seguimiento','$usuario')");

$resultado=$sentencia->execute();
echo json_encode($resultado,JSON_UNESCAPED_UNICODE);  
?>


