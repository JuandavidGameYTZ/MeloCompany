<?php
session_start();
require 'conexion.php';

$emisor = $_SESSION['usuario'] ?? '';
$receptor = $_POST['receptor'] ?? '';
$mensaje = trim($_POST['mensaje'] ?? '');

if ($emisor && $receptor && $mensaje) {
    $stmt = $conn->prepare("INSERT INTO mensajes (emisor, receptor, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $emisor, $receptor, $mensaje);
    $stmt->execute();
}
?>
