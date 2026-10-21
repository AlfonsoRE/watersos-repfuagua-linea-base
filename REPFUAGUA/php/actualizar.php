<?php

	$seguimiento =$_POST["seguimiento"];
	$clave =$_POST["id"];


	if(isset($seguimiento) 
	){
		if($_POST["seguimiento"]!=""){
			include "conexion.php";
			
			$sql = "update reporte set seguimiento='$_POST[seguimiento]' where clave_Reporte='$clave'";
			$query = $db->query($sql);
			if($query!=null){
				print "<script>alert(\"Eliminado exitosamente.\");window.location='../ver.php';</script>";
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../ver.php';</script>";

			}
		}
	}




?>