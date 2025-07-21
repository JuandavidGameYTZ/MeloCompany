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

    // Formatea la fecha/hora a formato 12 horas con AM/PM
    $fecha_formateada = date("h:i A", strtotime($row['fecha']));

    echo "<div class='message $clase' style='position: relative; padding-right: 50px;'>";
    echo "<strong>" . htmlspecialchars($row['emisor']) . ":</strong> " . htmlspecialchars($row['mensaje']);
    echo "<span class='hora'>$fecha_formateada</span>";
    echo "</div>";
}
?>
