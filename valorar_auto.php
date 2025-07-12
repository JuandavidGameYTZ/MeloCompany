<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit();
}

$usuario = $_SESSION['usuario'];
$id_auto = intval($_POST['id_auto'] ?? 0);
$valor = intval($_POST['valor'] ?? 0);

if ($id_auto <= 0 || $valor < 1 || $valor > 5) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit();
}

// Verificar si ya valoró
$stmt_check = $conn->prepare("SELECT id FROM valorarauto WHERE id_auto = ? AND usuario = ?");
$stmt_check->bind_param("is", $id_auto, $usuario);
$stmt_check->execute();
$res_check = $stmt_check->get_result();

if ($res_check->num_rows > 0) {
    $stmt_update = $conn->prepare("UPDATE valorarauto SET valor = ? WHERE id_auto = ? AND usuario = ?");
    $stmt_update->bind_param("iis", $valor, $id_auto, $usuario);
    $stmt_update->execute();
} else {
    $stmt_insert = $conn->prepare("INSERT INTO valorarauto (id_auto, usuario, valor) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("isi", $id_auto, $usuario, $valor);
    $stmt_insert->execute();
}

// Calcular promedio actualizado
$stmt_prom = $conn->prepare("SELECT AVG(valor) as promedio, COUNT(*) as total FROM valorarauto WHERE id_auto = ?");
$stmt_prom->bind_param("i", $id_auto);
$stmt_prom->execute();
$res_prom = $stmt_prom->get_result();
$datos = $res_prom->fetch_assoc();

echo json_encode([
    'success' => true,
    'promedio' => round($datos['promedio'], 1),
    'total' => intval($datos['total']),
]);
