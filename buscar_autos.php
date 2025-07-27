<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexion.php';

$termino = $_GET['q'] ?? '';

if (empty($termino)) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT nombre FROM autos WHERE nombre LIKE CONCAT('%', ?, '%') LIMIT 10");
$stmt->bind_param("s", $termino);
$stmt->execute();
$resultado = $stmt->get_result();

$autos = [];
while ($fila = $resultado->fetch_assoc()) {
    $autos[] = $fila['nombre'];
}

echo json_encode($autos);
