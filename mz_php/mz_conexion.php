<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "mz_conexion";
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

$mz_conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);
if ($mz_conexion->connect_error) {
    die("Error en la conexión: " . $mz_conexion->connect_error);
}
?>
