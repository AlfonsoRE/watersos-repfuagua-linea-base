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
?>
	<head>
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Admin :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	</head>
	<body background="fondo1.jpg">
	<?php include "./navbarAdmin.php"; ?>
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="text-center">
  
  <br>
  <br>

		<h2>LISTA DE REPORTES </h2>
    </div>
<!-- Button trigger modal -->
<form class="form-inline" role="search" id="buscar">
      <div class="form-group">
        <input type="text" name="s" class="form-control" placeholder="Buscar">
      </div>
      <button type="submit" class="btn btn-primary">&nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;</button>
  <!--<a data-toggle="modal" href="#newModal" class="btn btn-default">Agregar</a>-->
    </form>


 

  <!--<Fecha Formulario2>-->
<div class="row">
<div class="col-md-5">
				<h3 class = "text-primary">Búsqueda por fechas </h3>
				<label>Desde:</label>
				<input type = "text" class = "form-control" placeholder = "Inicio" name="from_date"  id ="from_date"/>
				<label>Hasta</label>
				<input type = "text" class = "form-control" placeholder = "Final" name="to_date"  id ="to_date"/>
				<button type = "button" class = "btn btn-primary" name="filter" id = "filter">
        <span class = "glyphicon glyphicon-search"></span></button> 
        <button type = "button" id = "reset" class = "btn btn-success"><span class = "glyphicon glyphicon-refresh"><span></button>
			</div>

<br>
  <!-- Modal -->
  <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar</h4>
        </div>
        <div class="modal-body">
<form role="form" method="post" id="agregar">
  <div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" name="name" required>
  </div>
  <div class="form-group">
    <label for="lastname">Apellido</label>
    <input type="text" class="form-control" name="lastname" required>
  </div>
  <div class="form-group">
    <label for="address">Domicilio</label>
    <input type="text" class="form-control" name="address" required>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" >
  </div>
  <div class="form-group">
    <label for="phone">Telefono</label>
    <input type="text" class="form-control" name="phone" >
  </div>

  <button type="submit" class="btn btn-default">Agregar</button>
</form>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<div id="tabla"></div>


</div>
</div>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php
include "./php/tabla.php";
?>
<script>


$("#buscar").submit(function(e){
  e.preventDefault();
  $.post("./php/busqueda.php",$("#buscar").serialize(),function(data){
    $("#tabla").html(data);
  $("#buscar")[0].reset();
  });
});




$('#reset').click(function(e){
  location.reload();
});


  $("#agregar").submit(function(e){
    e.preventDefault();
    $.post("./php/agregar.php",$("#agregar").serialize(),function(data){
    });
    //alert("Agregado exitosamente!");
    $("#agregar")[0].reset();
    $('#newModal').modal('hide');
  });
  $(document).ready(function(){
    $.datepicker.setDefaults({
      dateFormat:'yy-mm-dd'
    });
    $(function(){
      $("#from_date").datepicker();
      $("#to_date").datepicker();
    });
    $('#filter').click(function(){
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      if(from_date != '' && to_date != ''){
        $.ajax({
          url:"filtro.php",
          method:"POST",
          data:{from_date:from_date, to_date:to_date},
          success:function(data){
            $('#tabla_fecha').html(data);
          }
        })
      }else{
        alert("Seleccione fecha");
      }
    });
  });
</script>

	</body>
</html>