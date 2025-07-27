<?php
session_start();
require 'conexion.php';

$usuario_que_valora = $_SESSION['usuario'] ?? '';
$usuario_valorado = $_POST['usuario_valorado'] ?? '';
$estrellas = intval($_POST['estrellas'] ?? 0);

if (!$usuario_que_valora || !$usuario_valorado || $estrellas < 1 || $estrellas > 5) {
    echo "Datos inválidos.";
    exit;
}

if ($usuario_que_valora === $usuario_valorado) {
    echo "No puedes valorarte a ti mismo.";
    exit;
}

$stmt = $conn->prepare("SELECT id FROM calificausuario WHERE usuario_que_valora = ? AND usuario_valorado = ?");
$stmt->bind_param("ss", $usuario_que_valora, $usuario_valorado);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE calificausuario SET estrellas = ?, fecha = NOW() WHERE usuario_que_valora = ? AND usuario_valorado = ?");
    $stmt->bind_param("iss", $estrellas, $usuario_que_valora, $usuario_valorado);
} else {
    $stmt = $conn->prepare("INSERT INTO calificausuario (usuario_que_valora, usuario_valorado, estrellas) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $usuario_que_valora, $usuario_valorado, $estrellas);
}

if ($stmt->execute()) {
    echo "¡Gracias por tu valoración!";
} else {
    echo "Error al guardar.";
}


