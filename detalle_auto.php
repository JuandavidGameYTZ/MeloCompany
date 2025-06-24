<?php
session_start();
require 'conexion.php';

$id = $_GET['id'] ?? 0;

if ($id <= 0) {
    echo "Auto inválido.";
    exit();
}

$stmt = $conn->prepare("SELECT a.*, r.imagen_perfil, r.Nombre FROM autos a JOIN registro r ON a.usuario = r.Nombre WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$auto = $resultado->fetch_assoc();

if (!$auto) {
    echo "Auto no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Detalle del Auto - <?php echo htmlspecialchars($auto['nombre']); ?></title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<div class="car-detail-card">
  <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del auto" class="car-image">

  <div class="car-info">
    <h1 class="car-title"><?php echo htmlspecialchars($auto['nombre']); ?></h1>

    <p class="car-description">
      <strong>Descripción:</strong><br>
      <?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?>
    </p>

    <p class="car-price"><strong>Precio:</strong> <?php echo htmlspecialchars($auto['precio']); ?></p>

    <p class="car-rating">
      <strong>Valoración:</strong>
      <?php echo str_repeat("⭐", intval($auto['estrellas'])); ?>
    </p>

    <p class="car-location">
      <strong>Ubicación:</strong>
      <?php echo htmlspecialchars($auto['ubicacion'] ?? 'No especificada'); ?>
    </p>

    <?php if (!empty($auto['ubicacion'])): ?>
      <iframe
        width="100%"
        height="300"
        style="border:0; margin-top: 10px; border-radius: 10px;"
        loading="lazy"
        allowfullscreen
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps?q=<?php echo urlencode($auto['ubicacion']); ?>&output=embed">
      </iframe>
    <?php endif; ?>
  </div>

  <hr class="divider">

  <!-- Ir al perfil público del dueño del auto -->
  <a href="perfil_publico.php?nombre=<?php echo urlencode($auto['Nombre']); ?>" class="user-profile-mini">
    <img src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" alt="Imagen de perfil" class="profile-pic">
    <p class="username"><?php echo htmlspecialchars($auto['Nombre']); ?></p>
  </a>

  <a href="index.php" class="back-button">Volver al inicio</a>
</div>

</body>
</html>
