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
  </div>

  <hr class="divider">

  <div class="user-profile-mini">
    <img src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" alt="Imagen de perfil" class="profile-pic">
    <p class="username"><?php echo htmlspecialchars($auto['Nombre']); ?></p>
  </div>

  <a href="profile.php" class="back-button">Volver a mi perfil</a>
</div>

</body>
</html>