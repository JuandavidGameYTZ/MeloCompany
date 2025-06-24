<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
$datos = [];

// 🔁 PROCESAR CAMBIO DE IMAGEN DE PERFIL
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_imagen']) && isset($_SESSION['usuario'])) {
    $imagenNombre = $_FILES['nueva_imagen']['name'];
    $imagenTmp = $_FILES['nueva_imagen']['tmp_name'];
    $extension = pathinfo($imagenNombre, PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('perfil_') . '.' . $extension;
    $rutaDestino = "uploads/perfiles/" . $nombreArchivo;

    // Validar que la carpeta exista
    if (!is_dir("uploads/perfiles")) {
        mkdir("uploads/perfiles", 0755, true);
    }

    if (move_uploaded_file($imagenTmp, $rutaDestino)) {
        $stmt = $conn->prepare("UPDATE registro SET imagen_perfil = ? WHERE Nombre = ?");
        $stmt->bind_param("ss", $rutaDestino, $_SESSION['usuario']);
        $stmt->execute();
        $stmt->close();

        // Refrescar la variable $datos con la nueva imagen
        $datos['imagen_perfil'] = $rutaDestino;
    }
}

// 🔍 Cargar datos del usuario
if ($usuario) {
    $stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Melo - Perfil de Usuario</title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<!-- HEADER Y BARRA SUPERIOR -->
<header class="main-header">
  <div class="toggle" id="menu-toggle"><span></span><span></span><span></span></div>
  <a href="index.php" class="logo-link">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" />
  </a>


  <!-- Buscador -->

<div class="Buscador">
  <form method="GET" action="index.php" style="display: flex; align-items: center; width: 100%; padding: 5px 10px;">
    <input
      type="search"
      name="busqueda"
      class="buscardor-input"
      placeholder="Buscar autos..."
      value="<?php echo $_GET['busqueda'] ?? ''; ?>"
      title="Buscar autos disponibles"
      aria-label="Buscar autos disponibles"
    />
    <button type="submit" style="background: none; border: none; cursor: pointer;">
      <i class='bx bx-search'></i>
    </button>
  </form>
</div>

  <!-- Icono perfil -->
  <div class="profile-container">
    <?php if ($usuario):
      $sql = "SELECT imagen_perfil FROM registro WHERE Nombre = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $usuario);
      $stmt->execute();
      $res = $stmt->get_result();
      $img = $res->fetch_assoc();
      $stmt->close();

      $rutaPorDefecto = "img/Profile_Icon.png";
      $imagenRuta = (!empty($img['imagen_perfil']) && file_exists($img['imagen_perfil'])) ? $img['imagen_perfil'] : $rutaPorDefecto;
    ?>
      <div class="profile-info" style="display: flex; align-items: center; gap: 10px;">
        <img src="<?php echo htmlspecialchars($imagenRuta); ?>" class="profile-icon" />
        <span class="username"><?php echo htmlspecialchars($usuario); ?></span>
      </div>
    <?php else: ?>
      <div class="auth-buttons">
        <a href="login.php" class="boton">Iniciar sesión</a>
        <a href="register.php" class="boton">Registrarse</a>
      </div>
    <?php endif; ?>
  </div>

  <div id="profile-dropdown" class="profile-dropdown">
    <?php if ($usuario): ?>
      <a href="profile.php"><i class='bx bx-user'></i> Mi perfil</a>
      <a href="#"><i class='bx bx-car'></i> Autos</a>
      <a href="settings.php"><i class='bx bx-cog'></i> Ajustes</a>
      <a href="logout.php"><i class='bx bx-user-x'></i> Salir</a>
    <?php endif; ?>
  </div>
</header>

<!-- SIDEBAR -->
<nav class="slidebar" id="sidebar">
  <h1><i class='bx bx-menu'></i> Menú</h1>
  <ul>
    <li><a href="index.php"><i class='bx bx-home'></i> Inicio</a></li>
    <li><a href="ajustes.php"><i class='bx bx-cog'></i> Ajustes</a></li>
    <li><a href="contacto.html"><i class='bx bx-phone'></i> Contacto</a></li>
  </ul>
</nav>

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
        <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
        <form method="POST" action="cambiar_imagen_perfil.php" enctype="multipart/form-data" class="change-pic-form">
          <label for="fileUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
        </form>
      </div>

      <div class="name_bg">
        <div class="name_and_rating">
          <h2><?php echo htmlspecialchars($datos['Nombre'] ?? 'Usuario'); ?></h2>
          <div class="star-rating" data-usuario="<?php echo $usuario; ?>">
            <?php
              $stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio FROM valoraciones WHERE usuario_valorado = ?");
              $stmt->bind_param("s", $usuario);
              $stmt->execute();
              $resultado = $stmt->get_result();
              $prom = $resultado->fetch_assoc();
              $promedio = round($prom['promedio'], 1) ?: 0;
              $stmt->close();
              for ($i = 1; $i <= 5; $i++) {
                  $active = ($i <= $promedio) ? 'active' : '';
                  echo "<i class='bx bxs-star star $active' data-star='$i'></i>";
              }
              echo "<p class='rating-label'>$promedio / 5</p>";
            ?>
          </div>
        </div>
        <div class="boton_profile">
          <a href="agregar_auto.php" class="boton">Agregar Auto a rentar</a>
        </div>
      </div>
    </div>
  </div>
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
          if ($usuario) {
              $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ?");
              $stmt->bind_param("s", $usuario);
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
          }
          ?>

        </div>
        <button class="scroll-btn right" onclick="scrollRightBtn('electricos-scroll')"><i class='bx bx-caret-right'></i></button>
      </div>
    </div>
  </section>
</div>

<script src="js/script.js"></script>
</body>
</html>

