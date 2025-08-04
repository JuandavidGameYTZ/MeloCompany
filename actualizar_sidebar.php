<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
if (!$usuario) exit();

// 🔁 Consulta principal: obtener el usuario, fecha del último mensaje y cantidad de no leídos
$sql = "
  SELECT 
    IF(emisor = ?, receptor, emisor) AS otro_usuario,
    MAX(fecha) AS ultima_fecha,
    SUM(CASE WHEN receptor = ? AND leido = 0 THEN 1 ELSE 0 END) AS no_leidos
  FROM mensajes
  WHERE emisor = ? OR receptor = ?
  GROUP BY otro_usuario
  ORDER BY ultima_fecha DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $usuario, $usuario, $usuario, $usuario);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $otro = $row['otro_usuario'];
  $no_leidos = (int)$row['no_leidos'];
  $badge = $no_leidos > 0 ? "<span class='badge'>$no_leidos</span>" : "";

  // Obtener imagen de perfil solo una vez
  $stmt2 = $conn->prepare("SELECT imagen_perfil FROM registro WHERE Nombre = ?");
  $stmt2->bind_param("s", $otro);
  $stmt2->execute();
  $res2 = $stmt2->get_result();
  $imagen = $res2->fetch_assoc()['imagen_perfil'] ?? 'img/Profile_Icon.png';
  $stmt2->close();

  // HTML final
  echo "<li>
    <a href='comentdex.php?con=" . urlencode($otro) . "'>
      <img src='$imagen' class='comentdex-avatar'> 
      <span>$otro</span> $badge
    </a>
  </li>";
}
?>
