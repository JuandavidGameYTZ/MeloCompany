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

<h1><?php echo htmlspecialchars($auto['nombre']); ?></h1>
<img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="<?php echo htmlspecialchars($auto['nombre']); ?>" style="max-width: 400px;">
<p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?></p>
<p><strong>Precio:</strong> <?php echo htmlspecialchars($auto['precio']); ?></p>
<p><strong>Valoración:</strong> <?php echo intval($auto['estrellas']); ?> estrellas</p>

<hr>

<h2>Perfil del usuario que agregó el auto</h2>
<img src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" alt="Imagen de perfil" style="width:100px; border-radius:50%;">
<p><strong>Usuario:</strong> <?php echo htmlspecialchars($auto['Nombre']); ?></p>

<a href="profile.php">Volver a mi perfil</a>

</body>
</html>
