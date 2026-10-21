<?php
$dbConnect = array (
    'server' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbname' => 'repwatoriginal'
);
$db = new mysqli(
    $dbConnect ['server'],
    $dbConnect ['user'],
    $dbConnect ['pass'],
    $dbConnect ['dbname']
);
if ($db-> connect_errno> 0) {
    echo "Error de conexión de la base de datos". $db-> connect_error;
    exit;
}
$acentos = $db-> query ("SET NAMES 'utf8'");
?>