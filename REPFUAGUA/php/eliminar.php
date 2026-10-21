<?php
if(!empty($_GET)){
			include "conexion.php";
			
			$clave= $_GET["clave_Reporte"];

			$sql = "DELETE FROM reporte WHERE clave_Reporte=".$clave;
			$query = $db->query($sql);

			$sql2 ="SELECT * FROM foto WHERE clave_Reporte=".$clave;
			$query2= $db->query($sql2);

			while ($r=$query2->fetch_array()){
				unlink("../".$r["foto"]);


			}

			$sql3 = "DELETE FROM foto WHERE clave_Reporte=".$clave;
			$query3 = $db->query($sql3);

} 
			?>

			


