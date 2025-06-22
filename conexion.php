<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // tu contraseña si tienes una
$basedatos = "melocompany";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
