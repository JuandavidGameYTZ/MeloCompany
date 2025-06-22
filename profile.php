<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
$datos = [];

if ($usuario) {
    $stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();
    $stmt->close();
}

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
  <title>Perfil de Usuario</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/profile.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<header class="register-header">
  <a href="index.php" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" />
  </a>
</header>

<div class="profile-container">
  <div class="profile-background" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
    <form method="POST" action="cambiar_fondo.php" enctype="multipart/form-data" class="change-bg-form">
      <label for="bgUpload"><i class='bx bx-camera'></i></label>
      <input type="file" id="bgUpload" name="fondo" onchange="this.form.submit()" hidden>
    </form>
  </div>

  <div class="profile-info-box">
    <div class="profile-image-section">
      <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
      <form method="POST" enctype="multipart/form-data" class="change-pic-form">
        <label for="fileUpload"><i class='bx bx-camera'></i></label>
        <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
      </form>
    </div>
    <div class="profile-name-box">
      <h2><?php echo htmlspecialchars($datos['Nombre'] ?? 'Usuario'); ?></h2>
    </div>
  </div>

  <div class="star-rating-section">
    <?php
    $stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio FROM valoraciones WHERE usuario_valorado = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $prom = $resultado->fetch_assoc();
    $promedio = round($prom['promedio'], 1) ?: 0;
    $stmt->close();

    echo "<p>Valoración: $promedio / 5</p>";
    for ($i = 1; $i <= 5; $i++) {
        $color = $i <= $promedio ? '#FFD700' : '#ccc';
        echo "<i class='bx bxs-star' style='color: $color;' onclick=\"valorar('$usuario', $i)\"></i>";
    }
    ?>
  </div>
</div>

<script src="js/profile.js"></script>
</body>
</html>

