<html>
    <head>
<?php

include "conexion.php";
    

$f1=$_POST["f1"]"00:00:00";
$f2=$_POST["f2"]"23:59:59";
?>
<title>Consulta</title>
</head>
<body>
<form method="POST" action="consulta_fechas.php">
  <input type="date" name="f1" required>
  <input type="date" name="f2" requiered>
  <input type= "submit">
</form>
</br>
<?php

$v=mysqli_query("SELECT * FROM reporte WHERE fecha BETWEEN 'f1' AND 'f2'  ");
while($sistemas=mysqli_fetch_row($v)){

?>
<?php echo$sistemas[0] ?> <?php echo$sistemas[2] ?> .Fecha: <?php echo$sistemas[3] ?></br></br>
<?php} ?>
</body>
</html>
