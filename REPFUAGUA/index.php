<?php
require_once "./navbarLogin.php";
?>

<head>
		<title>.: Inicio :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>

<body background="fondo.jpeg">
  <div class="container">
    <div id="content">
      
    <br>
    <br>
    <br>
    <div class="col-md-6">
         <img src="./fuga.jpg" class="img-responsive">
        </div>
      
      <div class="text-center ">
      <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <h2><b>INICIAR SESION</b></h2>
        <form class="form-vertical" action="./php/logueo.php" method="POST">
          <h1> </h1>
          <div class="form-group">
            <div class="col-md-5">
            <div class="input-group">
       <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Nombre de Usuario"
                required>
            </div>
          </div>
          <br>
    <br>
          <div class="form-group">
            <div class="col-md-5">
            <div class="input-group">
       <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input id="pass" type="password" class="form-control" name="pass"
                placeholder="Contraseña" required>
            </div>
          </div>
            <div class="form-group">
              <div class="col-md-4">
              <br>
    <br>
                <button type="submit"  class="btn btn-primary"><span
                    class="glyphicon glyphicon-edit"></span> Entrar</button>
              </div>
              
            </div>
            
       
      </div>
    </div>
  </div>
</body>

<?php ?>
</html>
