<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo "Debes iniciar sesión.";
    exit();
}

$valorado = $_POST['usuario_valorado'] ?? '';
$estrellas = intval($_POST['estrellas']);
$quien_valora = $_SESSION['usuario'];

if ($valorado && $estrellas >= 1 && $estrellas <= 5) {
    $stmt = $conn->prepare("INSERT INTO valoraciones (usuario_valorado, usuario_que_valora, estrellas) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $valorado, $quien_valora, $estrellas);
    $stmt->execute();
    $stmt->close();
    echo "Valoración guardada correctamente.";
} else {
    echo "Datos inválidos.";
}
?>
