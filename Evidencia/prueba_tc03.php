<?php
echo "<h2>TC-03 PoC - WaterSOS/REPFUAGUA</h2>";
echo "<p>Este archivo PHP fue subido a traves del endpoint guardarFoto.php, ";
echo "disenado para aceptar unicamente imagenes. Su ejecucion exitosa confirma ";
echo "la ausencia de validacion de tipo de archivo (CWE-434).</p>";
echo "<p>Fecha de prueba: " . date("Y-m-d H:i:s") . "</p>";
phpinfo();
?>