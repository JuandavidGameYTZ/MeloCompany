<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
$datos = [];

// Obtener datos del usuario
if ($usuario) {
    $stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();
    $stmt->close();
}

// Guardar nueva imagen de perfil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['nueva_imagen'])) {
    $nombreArchivo = $_FILES['nueva_imagen']['name'];
    $rutaTemporal = $_FILES['nueva_imagen']['tmp_name'];
    $directorio = "img/perfiles/";

    if (!is_dir($directorio)) mkdir($directorio, 0777, true);

    $rutaFinal = $directorio . $usuario . "_" . basename($nombreArchivo);

    if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
        $stmt = $conn->prepare("UPDATE registro SET imagen_perfil = ? WHERE Nombre = ?");
        $stmt->bind_param("ss", $rutaFinal, $usuario);
        $stmt->execute();
        $stmt->close();
        header("Location: profile.php");
        exit();
    }
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

   <!--Menu-->
  <header class="main-header">
    <div class="toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!--Logo-->
    <a href="index.php" class="logo-link" aria-label="Melo Logo">
      <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de Melo" />
    </a>

    <!--Buscador-->
    <div class="Buscador">
      <input
        type="search"
        id="search-input"
        class="buscardor-input"
        placeholder="Buscar autos..."
        title="Buscar autos disponibles"
        aria-label="Buscar autos disponibles"
        aria-describedby="search-button"
      />
      <i class='bx bx-search'></i>
    </div>

<!-- Profile Icon -->
<div class="profile-container">
  <?php if (isset($_SESSION['usuario'])): ?>
    <?php
    $conexion = new mysqli("localhost", "root", "", "melocompany");
    $usuario = $_SESSION['usuario'];
    $sql = "SELECT imagen_perfil FROM registro WHERE Nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $img = $res->fetch_assoc();

    $rutaPorDefecto = "img/Profile_Icon.png";

    // Usar directamente la ruta si ya está guardada completa
    if (!empty($img['imagen_perfil']) && file_exists($img['imagen_perfil'])) {
      $imagenRuta = $img['imagen_perfil'];
    } else {
      $imagenRuta = $rutaPorDefecto;
    }
    ?>

    <div class="profile-info" style="display: flex; align-items: center; gap: 10px;">
      <img src="<?php echo htmlspecialchars($imagenRuta); ?>" alt="Imagen de perfil" class="profile-icon" id="profile-icon" />
      <span class="username"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
    </div>
  <?php else: ?>
    <div class="auth-buttons">
      <a href="login.php" class="boton">Iniciar sesión</a>
      <a href="register.php" class="boton">Registrarse</a>
    </div>
  <?php endif; ?>
</div>


    <div id="profile-dropdown" class="profile-dropdown">
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="profile.php"><i class='bx  bx-user'  ></i> Mi perfil</a>
        <a href="#"><i class='bx bx-car'></i> Autos</a>
        <a href="settings.php"><i class='bx bx-cog'></i> Ajustes</a>
        <a href="logout.php"><i class='bx  bx-user-x'  ></i> Salir</a>
      <?php endif; ?>
    </div>

  </header>


    <!--Sidebar-->
<nav class="slidebar" id="sidebar">
  <h1><i class='bx bx-menu'></i> Menú</h1>
  <ul>
    <li>
      <a href="index.php"><i class='bx bx-home'></i> Inicio</a>
    </li>
    <li>
      <a href="ajustes.php"><i class='bx bx-cog'></i> Ajustes</a>
    </li>

 
    <li>
      <a href="contacto.html"><i class='bx bx-phone'></i> Contacto</a>
    </li>
  </ul>
</nav>


<div class="profile-bg-container">
  <div class="background_and_profile">

    <!-- Encabezado con imagen de fondo -->
    <div class="bp_header" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
      <form method="POST" action="cambiar_fondo.php" enctype="multipart/form-data" class="change-bg-form">
        <div class="bg-overlay">
          <label for="bgUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="bgUpload" name="fondo" onchange="this.form.submit()" hidden>
        </div>
      </form>
    </div>

    <!-- Sección de imagen de perfil, nombre y valoración -->
    <div class="profile-content">
      <!-- Imagen de perfil -->
      <div class="profile_icon_big">
        <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
        <form method="POST" enctype="multipart/form-data" class="change-pic-form">
          <label for="fileUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
        </form>
      </div>

      <!-- Nombre de usuario + estrellas -->
<div class="name_bg">
  <div class="name_and_rating">
    <!-- Nombre del usuario -->
    <h2><?php echo htmlspecialchars($datos['Nombre'] ?? 'Usuario'); ?></h2>

    <!-- Estrellas de valoración -->
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

  <!-- Botón extra -->
  <div class="boton_profile">
    <button class="boton">Agregar Auto a rentar</button>
  </div>
</div>






  <script src="js/script.js"></script>
</body>
</html>
