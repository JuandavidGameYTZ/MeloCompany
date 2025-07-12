<?php
session_start();
require 'conexion.php';

$emisor = $_SESSION['usuario'] ?? '';
$receptor = $_GET['con'] ?? '';

if (!$emisor || !$receptor) {
    exit();
}

$stmt = $conn->prepare("SELECT * FROM mensajes 
    WHERE (emisor = ? AND receptor = ?) OR (emisor = ? AND receptor = ?)
    ORDER BY fecha ASC");
$stmt->bind_param("ssss", $emisor, $receptor, $receptor, $emisor);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $clase = $row['emisor'] === $emisor ? 'user' : 'other';
    echo "<div class='message $clase'><strong>{$row['emisor']}:</strong> " . htmlspecialchars($row['mensaje']) . "</div>";
}

?>
