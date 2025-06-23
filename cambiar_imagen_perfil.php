<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_imagen']) && isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $imagenNombre = $_FILES['nueva_imagen']['name'];
    $imagenTmp = $_FILES['nueva_imagen']['tmp_name'];
    $extension = pathinfo($imagenNombre, PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('perfil_') . '.' . $extension;
    $rutaDestino = "uploads/perfiles/" . $nombreArchivo;

    if (move_uploaded_file($imagenTmp, $rutaDestino)) {
        $stmt = $conn->prepare("UPDATE registro SET imagen_perfil = ? WHERE Nombre = ?");
        $stmt->bind_param("ss", $rutaDestino, $usuario);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: profile.php");
exit;
