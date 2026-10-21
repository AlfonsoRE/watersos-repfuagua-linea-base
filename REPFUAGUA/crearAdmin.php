<head>
		<title>.: Registro :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
        
	<?php include "./navbarAdmin3.php"; 
    ?>
   <br>
   <br>
   <br>
   <div class="col-md-10">
         <h3 class="text-justify"> 
         <br>
 <div class="col-md-5">
         <img src="./usuario.png" class="img-responsive">
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
            <section class="container">
                <h1 class="h2 text-center my-3">FORMULARIO DE REGISTRO ADMINISTRADOR</h1>
                <form action="./php/crearAd.php" method="post" name="formulario" id="formulario" autocomplete="off">
                    <fieldset>
                        <legend class="h4 text-center">
                           <b> Datos del Administrador </b>
                        </legend>
                        <div class="form-group">
                        <label>Nombre de Usuario</label>
                        <input type="text" id="nombreUser" name="nombreUser" class="form-control" placeholder="Escribe tu nombre de usuario" required>
                        </div>
                        <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Escribe tu nombre completo"required>
                        </div>
                        <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" id="contra" name="contra" class="form-control"placeholder="Escribe tu contraseña"required>
                        </div>
                       
                        <div class="form-group">
                        <label>Correo Electronico</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com"required>
                        </div>

                        <div class="form-group">
                        <label>Estatus</label>
                        <input type="text" name="status" class="form-control" placeholder="."required>
                        </div>
                        
                        <div class="form-group text-center">
                        <input type="submit" id="envio" value="Registrarse" class="btn btn-primary ">
                        </div>
                    </fieldset>
                </form>
            </section>
        </article>
        
        
        
        <!-- Script para bootstrap -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>
    