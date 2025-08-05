<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
$usuarioSesion = $usuario;
$nombreUsuario = $usuario;
$datos = [];

if (!$usuario) {
    header("Location: login.php");
    exit();
}

// Procesar cambio de imagen de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_imagen'])) {
    $imagenNombre = $_FILES['nueva_imagen']['name'];
    $imagenTmp = $_FILES['nueva_imagen']['tmp_name'];
    $extension = pathinfo($imagenNombre, PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('perfil_') . '.' . $extension;
    $rutaDestino = "uploads/perfiles/" . $nombreArchivo;

    if (!is_dir("uploads/perfiles")) {
        mkdir("uploads/perfiles", 0755, true);
    }

    if (move_uploaded_file($imagenTmp, $rutaDestino)) {
        $stmt = $conn->prepare("UPDATE registro SET imagen_perfil = ? WHERE Nombre = ?");
        $stmt->bind_param("ss", $rutaDestino, $usuario);
        $stmt->execute();
        $stmt->close();
    }
}

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$datos = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Obtener promedio de estrellas del usuario
$stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio, COUNT(*) AS total FROM calificausuario WHERE usuario_valorado = ?");
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$valInfo = $stmt->get_result()->fetch_assoc();
$promedio = round($valInfo['promedio'] ?? 0, 2);
$total_val = $valInfo['total'] ?? 0;
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Melo - Perfil de Usuario</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<?php include 'header.php'; ?>

<!-- PERFIL -->
<div class="profile-bg-container">
  <div class="background_and_profile">
    <div class="bp_header" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
      <form method="POST" action="cambiar_fondo.php" enctype="multipart/form-data" class="change-bg-form">
        <div class="bg-overlay">
          <label for="bgUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="bgUpload" name="fondo" onchange="this.form.submit()" hidden>
        </div>
      </form>
    </div>

    <div class="profile-content">
      <div class="profile_icon_big">
        <img src="<?php echo !empty($datos['imagen_perfil']) ? htmlspecialchars($datos['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" class="profile-img">
        <form method="POST" enctype="multipart/form-data" class="change-pic-form">
          <label for="fileUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
        </form>
      </div>

      <div class="name_bg">
        <h1 class="profile-name"><?php echo htmlspecialchars($datos['Nombre']); ?></h1>
          <div class="stars estrellas-auto-detalle read-only" aria-label="Tu puntuación" data-promedio="<?php echo $promedio; ?>">
        <?php
          $full = floor($promedio);
          for ($i = 1; $i <= 5; $i++) {
              $cls = ($i <= $full) ? 'bxs-star' : 'bx-star';
              echo "<i class='bx {$cls}' aria-hidden='true'></i>";
          }
        ?>
      </div>

    
          <!-- <p class="rating-label"><?php echo "$promedio / 5 ($total_val valoraciones)"; ?></p> -->
      </div>
    </div>
  </div>
</div>



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
              <span class="price"><?php echo htmlspecialchars($auto['precio']); ?></span>
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


<!-- AUTOS DEL USUARIO -->
<div class="profilecar">
  <section class="marketplace">
    <div class="category" id="Electricos">
      <div class="category-title">Mis carros <i class='bx bx-car'></i></div>
      <div class="carousel-wrapper">
        <button class="scroll-btn left" onclick="scrollLeftBtn('electricos-scroll')"><i class='bx bx-caret-left'></i></button>
        <div class="cards scrollable" id="electricos-scroll">
          <?php
          $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ?");
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
              <span class="price"><?php echo htmlspecialchars($auto['precio']); ?></span>
              <span class="stars"><i class='bx bxs-star'></i> <?php echo intval($auto['estrellas']); ?> </span>
            </div>
          </a>
          <?php endwhile; $stmt->close(); ?>
        </div>
        <button class="scroll-btn right" onclick="scrollRightBtn('electricos-scroll')"><i class='bx bx-caret-right'></i></button>
      </div>
    </div>
  </section>
</div>


<script src="js/script.js"></script>
</body>
</html>
