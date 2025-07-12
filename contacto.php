<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

$stmt = $conn->prepare("
    SELECT r.Nombre AS contacto, r.imagen_perfil, MAX(m.fecha) AS ultima_fecha
    FROM mensajes m
    JOIN registro r ON r.Nombre = CASE 
        WHEN m.emisor = ? THEN m.receptor 
        ELSE m.emisor 
    END
    WHERE m.emisor = ? OR m.receptor = ?
    GROUP BY contacto
    ORDER BY ultima_fecha DESC
");
$stmt->bind_param("sss", $usuario, $usuario, $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Chats</title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>
    <?php include 'header.php'; ?>





<div class="chat-list-container">
  <h2 class="chat-title">Mis chats</h2>
  <ul class="chat-list">
    <?php while ($row = $resultado->fetch_assoc()): ?>
      <li class="chat-item">
        <img src="<?php echo $row['imagen_perfil'] ? htmlspecialchars($row['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" 
             alt="Perfil" class="chat-avatar">
        <a href="comentdex.php?con=<?php echo urlencode($row['contacto']); ?>" class="chat-name">
          <?php echo htmlspecialchars($row['contacto']); ?>
        </a>
      </li>
    <?php endwhile; ?>
  </ul>
</div>
      