<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario) {
    header("Location: login.php"); // o donde tengas la página de login
    exit();
}

// Consulta para obtener las rentas del usuario con datos del auto
$stmt = $conn->prepare(
    "SELECT r.*, a.nombre AS nombre_auto, a.imagen AS imagen_auto
     FROM rentas r
     JOIN autos a ON r.auto_id = a.id
     WHERE r.cliente = ?
     ORDER BY r.fecha_inicio DESC"
);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Melo - Rentas realizadas</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>
<?php include 'header.php'; ?>

<!-- AUTOS RENTADOS POR EL USUARIO -->
<div class="profilecar">
  <section class="marketplace">
    <div class="category" id="Rentas">
      <div class="category-title">Rentando <i class='bx bx-key'></i></div>
      <div class="carousel-wrapper">
        <button class="scroll-btn left" onclick="scrollLeftBtn('rentas-scroll')"><i class='bx bx-caret-left'></i></button>
        <div class="cards scrollable" id="rentas-scroll">
          <?php
          $stmt = $conn->prepare("
            SELECT a.*, r.fecha_inicio, r.fecha_fin 
            FROM rentas r 
            INNER JOIN autos a ON r.auto_id = a.id 
            WHERE r.cliente = ?
          ");
          $stmt->bind_param("s", $usuario);
          $stmt->execute();
          $resultado = $stmt->get_result();
          while ($auto = $resultado->fetch_assoc()):
          ?>
          <a href="detalle_auto.php?id=<?php echo $auto['id']; ?>" class="card">
            <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="<?php echo htmlspecialchars($auto['nombre']); ?>">
            <div class="info">
              <h3><?php echo htmlspecialchars($auto['nombre']); ?></h3>
              <p><?php echo htmlspecialchars($auto['descripcion']); ?></p>
              <p><strong>Desde:</strong> <?php echo htmlspecialchars($auto['fecha_inicio']); ?></p>
              <p><strong>Hasta:</strong> <?php echo htmlspecialchars($auto['fecha_fin']); ?></p>
            </div>
          </a>
          <?php endwhile; $stmt->close(); ?>
        </div>
        <button class="scroll-btn right" onclick="scrollRightBtn('rentas-scroll')"><i class='bx bx-caret-right'></i></button>
      </div>
    </div>
  </section>
</div>


</body>
</html>