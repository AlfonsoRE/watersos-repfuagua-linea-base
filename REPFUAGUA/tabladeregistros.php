<?php
include "./php/conexion.php";
?>
<DOCTYPE html>
<?php include "./navbarAdminN.php"; 
session_start();
if(isset($_SESSION['usuario']) && $_SESSION['rol']=="admin"){
}
else{
  header("Location: ./index.php");
}
    ?>
	<head>
    
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
		<title>.:Administradores :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body background="fondo1.jpg">
    <br>
    <br>
    <br>
    <br>
    <div class="espacio-tabla">
  <table class="table table-bordered border-primary">
  <thead>
    <tr>
      <th scope="col">Usuario</th>
      <th scope="col">Nombre</th>
      
      <th scope="col">Email</th>
      <th scope="col">Rol</th>
      <th scope="col">Estatus</th>
      <th scope="col">Confirma Usuario</th>
     
    </tr>
  </thead>
  <tbody>
<?php

$sql1="SELECT * FROM usuario";

$result = mysqli_query($db , $sql1);

while($mostrar = mysqli_fetch_array($result)){

?>

    <tr>
      <th><?php echo $mostrar['usuario'] ?> </th>
      <th><?php echo $mostrar['nombre'] ?> </th>
      
      <th><?php echo $mostrar['email'] ?> </th>
      <th><?php echo $mostrar['rol'] ?> </th>
      <th><?php echo $mostrar['status'] ?> </th>
    <td>
<!-----eliminar----->
<form action ="eliminar2.php" method="post">
  <input type="text" value="<?php echo $mostrar['usuario'] ?>" name="txtusuario" readonly>
  <td><input class="btn btn-danger" type= "submit" value="Eliminar" name="btnEliminar"></td>
</form>
    </td>

    <td>
<!-----modificar----->
<form action ="editar2.php?id=<?php echo $mostrar['usuario'] ?>" method="post">
  <td><input class="btn btn-warning" type= "submit" value="Editar" name="btnEditar"></td>
</form>
    </td>
    
    </tr>
   
    <?php 
}
?>   
  </tbody>
</table>	
</div>

</body>

</html>