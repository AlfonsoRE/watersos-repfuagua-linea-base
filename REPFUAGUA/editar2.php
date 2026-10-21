<head>
		<title>.: Actualizar :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
        
	<?php include "./navbarAdminN.php"; 
    ?>
 <br>
   <br>
   <br>
 <div class="col-md-4">
         <img src="./edit.jpg" class="img-responsive">
        </div>
	

<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- 
            Esta es una practica para un formulario de registro básico usando HTML, CSS, Bootstrap 4 y JavaScript
            Autor: Elvis Briceño
        -->
        <title>Formulario de registro</title>
        <meta charset="utf-8">
        
        <!-- Bootstrap 4 -->  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
   
   
    </head>
    <body background="fondo1.jpg">
        <article>
            
            <section class="container mt-4">
                <h1 class="h2 text-center my-3">ACTUALIZAR REGISTRO ADMINISTRADOR</h1>
                <?php

                    include "./php/conexion.php";
                    $id = $_GET["id"];
                    $sql1="SELECT * FROM usuario WHERE usuario = '$id'";

                    $result = mysqli_query($db , $sql1);

                    while($mostrar = mysqli_fetch_array($result)){

                ?>
                <form action="./php/procederEditar.php" method="post">
                    <fieldset>
                        <legend class="h4 text-center">
                           <b> Actualizar Datos del Administrador </b>
                        </legend>
                        <div class="form-group">
                        <label>Actualizar Nombre de Usuario</label>
                        <input type="text" name="nombreUser2" class="form-control" value="<?php echo $mostrar['usuario']?>" readonly>
                        </div>
                        <div class="form-group">
                        <label>Actualizar Nombre</label>
                        <input type="text" name="nombre2" class="form-control" value="<?php echo $mostrar['nombre']?>">
                        </div>
                        <div class="form-group">
                        <label>Actualizar Correo Electronico</label>
                        <input type="email" name="email2" class="form-control" value="<?php echo $mostrar['email']?>">
                        </div>
                        <div class="form-group">
                        <label>Estatus</label>
                        <input type="text" name="status2" class="form-control" value="<?php echo $mostrar['status']?>">
                        </div>
                        <div class="form-group text-center">
                        <input type="submit" id="envio" value="Modificar" class="btn btn-primary ">
                        </div>
                    </fieldset>
                </form>
                <?php }?>
            </section>
        </article>
        
        
        
        <!-- Script para bootstrap -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>