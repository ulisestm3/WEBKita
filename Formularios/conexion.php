<?php
// conexion.php

// Configuración de la base de datos
$server = "localhost";
$usuario = "root";
$password = "";
$database = "u120947202_dbkita";

// Crear la conexión
$enlace = mysqli_connect($server, $usuario, $password, $database);

// Verificar la conexión
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>