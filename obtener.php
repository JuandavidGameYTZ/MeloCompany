<?php
session_start();
require 'conexion.php';

$emisor = $_SESSION['usuario'] ?? ''; // Tú
$receptor = $_GET['con'] ?? '';       // El otro

if (!$emisor || !$receptor) {
    exit();
}

// Marcar como leídos los mensajes que el otro te envió a ti
$update = $conn->prepare("UPDATE mensajes SET leido = 1 WHERE emisor = ? AND receptor = ?");
$update->bind_param("ss", $receptor, $emisor);
$update->execute();
$update->close();

// Obtener mensajes del chat entre ambos
$stmt = $conn->prepare("SELECT * FROM mensajes 
    WHERE (emisor = ? AND receptor = ?) OR (emisor = ? AND receptor = ?)
    ORDER BY fecha ASC");
$stmt->bind_param("ssss", $emisor, $receptor, $receptor, $emisor);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $clase = $row['emisor'] === $emisor ? 'user' : 'other';

    $fecha_formateada = date("h:i A", strtotime($row['fecha']));

    echo "<div class='message $clase' style='position: relative; padding-right: 50px;'>";

    if ($row['emisor'] !== $emisor) {
        echo "<strong>" . htmlspecialchars($row['emisor']) . ":</strong> ";
    }

    echo htmlspecialchars($row['mensaje']);
    echo "<span class='hora'>$fecha_formateada</span>";
    echo "</div>";
}
?>
