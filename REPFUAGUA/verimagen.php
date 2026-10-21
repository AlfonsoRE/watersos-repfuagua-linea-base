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

$claveReporte= $_GET['clave_Reporte'];



$sql1= "SELECT * FROM foto WHERE clave_Reporte = '$claveReporte'";
$consulta = $db->query($sql1);

$sql2= "SELECT * FROM reporte WHERE clave_Reporte = '$claveReporte'";
$consulta2 = $db->query($sql2);


?>

<?php  ?>

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

<br>
<br>
<br>
<br>
<div class="text-center">
		<h2>Evidencia de fuga</h2>

    <!--<?php  echo '<h1>'.$longitud.'</h1>'?>-->
    </div>
    <?php while ($r=$consulta->fetch_array()):?>
    <div class="col-md-12">
      <center>
       <?php echo '<img src="./'.$r['foto'].'" class="img-responsive" align="center"/>';?>
      
      </center>
     </div>
     <br> 
<?php endwhile;  ?>


</div>


   <br>
   <br>
  
<center>
<?php while ($r=$consulta2->fetch_array()):?>
<div class="row" id="datos1">

<div >
  <Label> Clave </Label>
  <H4><?php echo $claveReporte ?></H3>
</div>

<div  >
  <Label> longitud </Label>
  <H4><?php echo $r["longitud"] ?></H3>
</div>

<div >
  <Label> latitud </Label>
  <H4><?php echo $r["latitud"] ?></H3>
</div>

<div >
  <Label> usuario </Label>
  <H4><?php echo $r["usuario"] ?></H3>
</div>

</div>
</center>

  <br>
 <br>

<div class="row" id="datos2">

  
<div class="col-md-7">
<Label> Dirección </Label>
  <H4><?php echo $r["direccion"] ?></H3>
</div>

<div >
<Label> seguimiento </Label>
  <H4><?php echo $r["seguimiento"] ?></H3>
</div>

</div>

<br>
<br>

<div class="row" id="datos3">

  
<div class="col-md-7">
<Label> descripción </Label>
  <H4><?php echo $r["descripcion"] ?></H3>
</div>

<div >
<Label> fecha y hora</Label>
  <H4><?php echo $r["fecha"] ?></H3>
</div>

</div>
<?php endwhile;  ?>
<style>
  #datos1 div{
    float:left;
    padding-left: 180;
  }
  
  #datos1{
    padding-left: 50;
  }

  #datos2 div{
    float:left;
    padding-left: 230;
  }
  
  #datos2{
    padding-left: 00;
  }

  #datos3 div{
    float:left;
    padding-left: 230;
  }
  
  #datos3{
    padding-left: 00;
  }
    </style>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>