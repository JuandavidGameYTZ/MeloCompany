<?php
session_start();
require 'conexion.php';

$nombreUsuario = $_GET['nombre'] ?? '';
$usuarioSesion = $_SESSION['usuario'] ?? '';

if (empty($nombreUsuario)) {
    echo "Usuario no especificado.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();
$stmt->close();

if (!$datos) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Melo - Perfil de <?php echo htmlspecialchars($nombreUsuario); ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<header class="main-header">
  <a href="index.php" class="logo-link">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" />
  </a>
</header>

<div class="profile-bg-container">
  <div class="background_and_profile">
    <div class="bp_header" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
    </div>

    <div class="profile-content">
      <div class="profile_icon_big">
        <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
      </div>

      <div class="name_bg">
        <div class="name_and_rating">
          <h2><?php echo htmlspecialchars($datos['Nombre']); ?></h2>
          <div class="star-rating">
            <?php
              $stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio FROM valoraciones WHERE usuario_valorado = ?");
              $stmt->bind_param("s", $nombreUsuario);
              $stmt->execute();
              $resultado = $stmt->get_result();
              $prom = $resultado->fetch_assoc();
              $promedio = round($prom['promedio'], 1) ?: 0;
              $stmt->close();
              for ($i = 1; $i <= 5; $i++) {
                  $active = ($i <= $promedio) ? 'active' : '';
                  echo "<i class='bx bxs-star star $active'></i>";
              }
              echo "<p class='rating-label'>$promedio / 5</p>";
            ?>
          </div>
        </div>

        <?php if ($usuarioSesion === $nombreUsuario): ?>
          <div class="boton_profile">
            <a href="agregar_auto.php" class="boton">Agregar Auto a rentar</a>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<!-- AUTOS DEL USUARIO -->
<div class="profilecar">
  <section class="marketplace">
    <div class="category">
      <div class="category-title">Autos de <?php echo htmlspecialchars($datos['Nombre']); ?> <i class='bx bx-car'></i></div>
      <div class="carousel-wrapper">
        <button class="scroll-btn left" onclick="scrollLeftBtn('user-autos-scroll')"><i class='bx bx-caret-left'></i></button>
        <div class="cards scrollable" id="user-autos-scroll">

          <?php
          $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ?");
          $stmt->bind_param("s", $nombreUsuario);
          $stmt->execute();
          $resultado = $stmt->get_result();

          while ($auto = $resultado->fetch_assoc()) {
              ?>
              <a href="detalle_auto.php?id=<?php echo $auto['id']; ?>" class="card">
                <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="<?php echo htmlspecialchars($auto['nombre']); ?>">
                <div class="info">
                  <h3><?php echo htmlspecialchars($auto['nombre']); ?></h3>
                  <p><?php echo htmlspecialchars($auto['descripcion']); ?></p>
                  <span class="price"><?php echo htmlspecialchars($auto['precio']); ?></span>
                  <span class="stars"><i class='bx bxs-star'></i> <?php echo intval($auto['estrellas']); ?> </span>
                </div>
              </a>
              <?php
          }
          $stmt->close();
          ?>

        </div>
        <button class="scroll-btn right" onclick="scrollRightBtn('user-autos-scroll')"><i class='bx bx-caret-right'></i></button>
      </div>
    </div>
  </section>
</div>

<script src="js/script.js"></script>
</body>
</html>