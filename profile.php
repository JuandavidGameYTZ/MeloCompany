<?php
session_start();
require 'conexion.php';

$usuario = $_SESSION['usuario'] ?? '';
$datos = [];
$usuario_valorado = $_GET['nombre'] ?? $usuario;

// 🔁 Procesar imagen de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_imagen']) && $usuario === $usuario_valorado) {
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
        $stmt->bind_param("ss", $rutaDestino, $usuario_valorado);
        $stmt->execute();
        $stmt->close();
    }
}

// 🔁 Procesar valoración
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valoracion']) && $usuario && $usuario_valorado) {
    $valor = intval($_POST['valoracion']);
    if ($valor >= 1 && $valor <= 5) {
        $stmt = $conn->prepare("SELECT id FROM valoraciones WHERE usuario_que_valora = ? AND usuario_valorado = ?");
        $stmt->bind_param("ss", $usuario, $usuario_valorado);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows) {
            $stmt = $conn->prepare("UPDATE valoraciones SET estrellas = ? WHERE usuario_que_valora = ? AND usuario_valorado = ?");
            $stmt->bind_param("iss", $valor, $usuario, $usuario_valorado);
        } else {
            $stmt = $conn->prepare("INSERT INTO valoraciones (usuario_que_valora, usuario_valorado, estrellas) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $usuario, $usuario_valorado, $valor);
        }
        $stmt->execute();
        header("Location: perfil.php?nombre=" . urlencode($usuario_valorado));
        exit();
    }
}

// 🔍 Cargar datos del usuario perfilado
if ($usuario_valorado) {
    $stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
    $stmt->bind_param("s", $usuario_valorado);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();
    $stmt->close();
}

$promedio = 0;
$user_valor = 0;

// Obtener promedio
$stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio FROM valoraciones WHERE usuario_valorado = ?");
$stmt->bind_param("s", $usuario_valorado);
$stmt->execute();
$res = $stmt->get_result();
$prom = $res->fetch_assoc();
$promedio = round($prom['promedio'], 1) ?: 0;
$stmt->close();

// Obtener valor actual del usuario logueado
if ($usuario) {
    $stmt = $conn->prepare("SELECT estrellas FROM valoraciones WHERE usuario_que_valora = ? AND usuario_valorado = ?");
    $stmt->bind_param("ss", $usuario, $usuario_valorado);
    $stmt->execute();
    $res = $stmt->get_result();
    $user_valor = intval($res->fetch_assoc()['estrellas'] ?? 0);
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
<?php include 'header.php'; ?>

<div class="profile-bg-container">
  <div class="background_and_profile">
    <div class="bp_header" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');">
      <?php if ($usuario === $usuario_valorado): ?>
      <form method="POST" action="cambiar_fondo.php" enctype="multipart/form-data" class="change-bg-form">
        <div class="bg-overlay">
          <label for="bgUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="bgUpload" name="fondo" onchange="this.form.submit()" hidden>
        </div>
      </form>
      <?php endif; ?>
    </div>

    <div class="profile-content">
      <div class="profile_icon_big">
        <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
        <?php if ($usuario === $usuario_valorado): ?>
        <form method="POST" enctype="multipart/form-data" class="change-pic-form">
          <label for="fileUpload"><i class='bx bx-camera'></i></label>
          <input type="file" id="fileUpload" name="nueva_imagen" onchange="this.form.submit()" hidden>
        </form>
        <?php endif; ?>
      </div>

      <div class="name_bg">
        <div class="name_and_rating">
          <h2><?php echo htmlspecialchars($usuario_valorado); ?></h2>

          <form id="rating-form" method="post">
            <div
              class="stars estrellas-perfil <?php echo $user_valor > 0 ? 'read-only' : ''; ?>"
              id="rating-stars"
              role="radiogroup"
              aria-label="Valora a este usuario"
              data-user-valued="<?php echo $user_valor > 0 ? '1' : '0'; ?>"
              data-promedio="<?php echo htmlspecialchars(number_format($promedio,2)); ?>"
            >
              <?php 
                $full = floor($promedio);
                for ($i = 1; $i <= 5; $i++) {
                    $cls = ($i <= $full) ? 'bxs-star' : 'bx-star';
                    echo "<i class='bx {$cls}' data-star='{$i}' role='radio' tabindex='0' aria-label='{$i} estrellas' aria-checked='false'></i>";
                }
              ?>
            </div>
            <input type="hidden" name="valoracion" id="valoracion" value="<?php echo $user_valor; ?>" required />
          </form>

          <p class="rating-label"><?php echo number_format($promedio,1); ?> / 5</p>
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
          if ($usuario_valorado) {
    if ($usuario_valorado === $usuario) {
        // Si el dueño está viendo su propio perfil, ve todos los autos
        $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ?");
        $stmt->bind_param("s", $usuario_valorado);
    } else {
        // Si otro usuario lo ve, solo muestra los no ocultos
        $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ? AND oculto = 0");
        $stmt->bind_param("s", $usuario_valorado);
    }

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

<script>
document.addEventListener('DOMContentLoaded', () => {
  const ratingStars = document.getElementById('rating-stars');
  if (!ratingStars) return;

  const userValued = ratingStars.getAttribute('data-user-valued') === '1';
  const promedio = parseFloat(ratingStars.getAttribute('data-promedio')) || 0;
  const inputValor = document.getElementById('valoracion');
  const form = document.getElementById('rating-form');
  const stars = ratingStars.querySelectorAll('i');

  function pintarEstrellas(valor) {
    stars.forEach((star, idx) => {
      if (idx < valor) {
        star.classList.add('bxs-star');
        star.classList.remove('bx-star');
      } else {
        star.classList.add('bx-star');
        star.classList.remove('bxs-star');
      }
    });
  }

  pintarEstrellas(Math.floor(promedio));

  if (!userValued) {
    stars.forEach((star, idx) => {
      star.setAttribute('tabindex', 0);
      star.setAttribute('aria-checked', 'false');

      star.addEventListener('click', () => {
        const val = idx + 1;
        inputValor.value = val;
        pintarEstrellas(val);
        form.submit();
      });

      star.addEventListener('mouseover', () => {
        pintarEstrellas(idx + 1);
      });

      star.addEventListener('mouseout', () => {
        pintarEstrellas(Math.floor(promedio));
      });

      star.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          const val = idx + 1;
          inputValor.value = val;
          pintarEstrellas(val);
          form.submit();
        }
      });
    });
  } else {
    stars.forEach(star => {
      star.setAttribute('tabindex', -1);
      star.setAttribute('aria-checked', 'false');
    });
  }
});
</script>

<script src="js/script.js"></script>
</body>
</html>
