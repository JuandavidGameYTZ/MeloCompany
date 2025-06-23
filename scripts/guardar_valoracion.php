<?php
require '../conexion.php';
session_start();

$usuario_que_valora = $_SESSION['usuario'] ?? null;
$usuario_valorado = $_POST['usuario_valorado'] ?? null;
$estrellas = isset($_POST['estrellas']) ? intval($_POST['estrellas']) : null;

if (!$usuario_que_valora || !$usuario_valorado || !$estrellas) {
    http_response_code(400);
    echo "Faltan datos";
    exit;
}

// Verificar si ya valoró antes
$stmt = $conn->prepare("SELECT id FROM valoraciones WHERE usuario_que_valora = ? AND usuario_valorado = ?");
$stmt->bind_param("ss", $usuario_que_valora, $usuario_valorado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Actualizar valoración existente
    $stmt = $conn->prepare("UPDATE valoraciones SET estrellas = ?, fecha = NOW() WHERE usuario_que_valora = ? AND usuario_valorado = ?");
    $stmt->bind_param("iss", $estrellas, $usuario_que_valora, $usuario_valorado);
} else {
    // Insertar nueva valoración
    $stmt = $conn->prepare("INSERT INTO valoraciones (usuario_valorado, usuario_que_valora, estrellas) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $usuario_valorado, $usuario_que_valora, $estrellas);
}

if ($stmt->execute()) {
    echo "Valoración guardada correctamente.";
} else {
    http_response_code(500);
    echo "Error al guardar valoración.";
}

$stmt->close();
$conn->close();
?>
