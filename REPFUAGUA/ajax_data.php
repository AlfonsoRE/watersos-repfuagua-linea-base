<?php
$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));
 echo $date1." ".$date2."fechassssssssssssssssssssss";
if (!empty($_POST['date1']) and  !empty($_POST['date1'])){
	list($dia,$mes,$anio)=explode("/",$_POST['date1']);
	$date1="$anio-$mes-$dia";
	list($dia,$mes,$anio)=explode("/",$_POST['date2']);
	$date2="$anio-$mes-$dia";
	
	$sWhere= "SELECT * FROM `reporte` WHERE fecha BETWEEN "2020-07-30 00:00:00" AND "2020-07-31 23:59:59";

	
} else {
	$sWhere="";	
}
 
#Conectare a la base de datos
include("./php/conexion.php");
	
$q_book = $db->query("SELECT * FROM 'usuario' $sWhere ORDER BY 'idReporte' ASC") or die(mysqli_error());
$v_book = $q_book->num_rows;
if($v_book > 0){
	while($r = $q_book->fetch_array()){
	?>
	<tr>
    <td><?php echo $r["idReporte"]; ?></td>
	<td><?php echo $r["No_Contrato"]; ?></td>
	<td><?php echo $r["No_Ext"]; ?></td>
	<td><?php echo $r["direccion"]; ?></td>
	<td><a href="https://www.google.es/maps/place/<?php echo $r["latitud"];?>,<?php echo $r["longitud"]; ?>" target="_blank">Localización</a> </td>
	<td><a href="./verimagen.php?idReporte=<?php echo $r["idReporte"];?>" target="_blank">fotos</a> </td>
	<td><?php echo $r["fecha"]; ?></td>
	<td><?php echo $r["descripcion"]; ?></td>
	<td><?php echo $r["seguimiento"]; ?></td>
	<td><?php echo $r["usuario"]; ?></td>
		<td><?php echo date("d/m/Y", strtotime($r['fecha']))?></td>
	</tr>
	<?php
	}
}else{
		echo '
		<tr>
			<td colspan = "4" class="text-center">No se encontraron registros</td>
		</tr>
		';
}
	?>