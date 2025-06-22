<?php
session_start();
require 'conexion.php'; // Asegúrate de tener la conexión

// Obtener datos del usuario
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

// Subir imagen de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['nueva_imagen'])) {
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
    } else {
        $error = "No se pudo subir la imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mi Perfil</title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://cdn.boxicons.com/css/boxicons.min.css' rel='stylesheet'>

  

</head>


<header class="register-header">

       <!--Logo-->
     <a href="index.php" class="logo-link" aria-label="Melo Logo">
     
        <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de melo" />
        </a>
</header>    

<body>
<div class="containerprof">
    
<div class="profile-card" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
  
  <!-- Ícono para cambiar fondo -->
  <form method="POST" action="cambiar_fondo.php" enctype="multipart/form-data" class="icon-change-bg">
    <label for="bgUpload"><i class='bx  bx-camera-plus'  ></i> </i></label>
    <input type="file" id="bgUpload" name="fondo" onchange="this.form.submit()" hidden>
  </form>

  <!-- Imagen de perfil -->
  <div class="profile-picture-container">
    <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" alt="Foto de perfil" class="profile-picture">
    <form method="POST" enctype="multipart/form-data" class="icon-change-pic">
      <label for="fileUpload"><i class='bx  bx-camera-plus'  ></i> </i></label>
      <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
    </form>
  </div>

  <!-- Nombre -->
  <h2 class="profile-name"><?php echo htmlspecialchars($datos['Nombre'] ?? 'Usuario'); ?></h2>

  <!-- Estrellas -->
  <div class="stars-rating">
    <?php
      $usuario_actual = $datos['Nombre'];

      // Obtener promedio de estrellas
      $stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio FROM valoraciones WHERE usuario_valorado = ?");
      $stmt->bind_param("s", $usuario_actual);
      $stmt->execute();
      $resultado = $stmt->get_result();
      $prom = $resultado->fetch_assoc();
      $promedio = round($prom['promedio'], 1) ?: 0;
      $stmt->close();

      echo "<p style='color:white; text-shadow: 1px 1px 2px #000;'>Valoración: $promedio / 5</p>";

      // Mostrar estrellas clicables
      for ($i = 1; $i <= 5; $i++) {
          $color = $i <= $promedio ? '#FFD700' : '#ccc';
          echo "<i class='bx bxs-star' style='color: $color;' onclick=\"valorar('$usuario_actual', $i)\"></i>";
      }
    ?>
  </div>
    
</div>
</div>

  <script src="js/script.js"></script>


</body>
</html>
