<?php
session_start();
require 'conexion.php';

$emisor = $_SESSION['usuario'] ?? '';
$receptor = $_POST['receptor'] ?? '';
$mensaje = trim($_POST['mensaje'] ?? '');

// Nueva funcionalidad: Redirigir con mensaje de éxito o error
if ($emisor && $receptor && $mensaje) {
    $stmt = $conn->prepare("INSERT INTO mensajes (emisor, receptor, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $emisor, $receptor, $mensaje);
    if ($stmt->execute()) {
        // Mensaje enviado correctamente
        header("Location: mensajes.php?status=success");
        exit();
    } else {
        // Error al enviar mensaje
        header("Location: mensajes.php?status=error");
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si se intentó enviar pero faltan datos
    header("Location: mensajes.php?status=empty");
    exit();
}
?>