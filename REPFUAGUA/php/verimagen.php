<?php
ob_start();
?>
<html>
<?php
session_start();
if(isset($_SESSION['usuario']) && $_SESSION['rol']=="admin"){
}
else{
  header("Location: ./index.php");
}
include "./php/conexion.php";
$sql1= "select * from foto where idReporte = $_GET['clave_Reporte']";
$query = $db->query($sql1);

?>
	<head>
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
		<title>.: Admin :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "./navbarAdmin.php"; ?>
<div class="container">
<div class="row">
<div class="text-center">
		<h2>Evidencia de fuga</h2>
    </div>
<?php while ($r=$query->fetch_array()):?>

    echo "<img src="./'$r[""]'"/>";
  
<?php endwhile;  mysql_close($db);?>

</div>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>