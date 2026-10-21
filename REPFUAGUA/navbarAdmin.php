<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="./menuAdmin.php"><b>REPFUAGUA</b></a>
  </div>

  <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">

        <li class="dropdown">
     <a class="dropdown-toggle" data-toggle="dropdown" href="./ver.php">Reporte <span class="caret"></span></a>
        
       </li>

         
        
          <li><a href="./tabladeregistros.php">Registro</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right" style="padding-left: 200;">
         <li><a href="#"><?php echo $_SESSION['usuario']; ?></a></li> 
          <li><a href="./php/cerrarSesion.php">Salir</a></li>
        </ul>

      </div>
</div>
</nav>