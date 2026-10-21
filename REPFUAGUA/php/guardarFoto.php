<?php
header("Access-Control-Allow-Origin: *");  
header("Content-Type: application/json");
error_reporting(E_ALL);
require_once 'conexion.php';
$archivo = $_POST['foto'];
$clave = $_POST["clave"];
$nombreImagen=$_POST['nombreImagen'];

    $path = "imagenes/$nombreImagen";
    $path2 ="../$path";
    
    file_put_contents($path2,base64_decode($archivo));
    $bytesArchivo = file_get_contents($path2);

    $sentencia=$db->prepare("INSERT INTO foto(clave_Reporte,foto) VALUE('$clave','$path')");
    $resultado=$sentencia->execute();
    echo json_encode($resultado,JSON_UNESCAPED_UNICODE);  

?>