<?php
session_start();
require 'conexion.php';

$nombreUsuario = $_GET['nombre'] ?? '';
$usuarioSesion = $_SESSION['usuario'] ?? '';

if ($nombreUsuario === $usuarioSesion) {
    header("Location: profile.php");
    exit();
}

if (empty($nombreUsuario)) {
    echo "Usuario no especificado.";
    exit();
}

// Procesar valoración si viene por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valoracion'], $_POST['usuario_valorado']) && $usuarioSesion) {
    $val = intval($_POST['valoracion']);
    $valorado = $_POST['usuario_valorado'];
    if ($val >= 1 && $val <= 5 && $valorado !== $usuarioSesion) {
        $stmt = $conn->prepare("SELECT id FROM calificausuario WHERE usuario_valorado = ? AND usuario_que_valora = ?");
        $stmt->bind_param("ss", $valorado, $usuarioSesion);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows) {
            $stmt = $conn->prepare("UPDATE calificausuario SET estrellas = ? WHERE usuario_valorado = ? AND usuario_que_valora = ?");
            $stmt->bind_param("iss", $val, $valorado, $usuarioSesion);
        } else {
            $stmt = $conn->prepare("INSERT INTO calificausuario (usuario_valorado, usuario_que_valora, estrellas) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $valorado, $usuarioSesion, $val);
        }
        $stmt->execute();
        header("Location: perfil_publico.php?nombre=" . urlencode($valorado));
        exit();
    }
}

// Obtener datos del perfil
$stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$datos = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$datos) {
    echo "Usuario no encontrado.";
    exit();
}

// Obtener promedio de estrellas y si el usuario ya votó
$stmt = $conn->prepare("SELECT AVG(estrellas) AS promedio, COUNT(*) AS total FROM calificausuario WHERE usuario_valorado = ?");
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$valInfo = $stmt->get_result()->fetch_assoc();
$promedio = round($valInfo['promedio'] ?? 0, 2);
$total_val = $valInfo['total'] ?? 0;

$user_valor = 0;
if ($usuarioSesion && $usuarioSesion !== $nombreUsuario) {
    $stmt = $conn->prepare("SELECT estrellas FROM calificausuario WHERE usuario_valorado = ? AND usuario_que_valora = ?");
    $stmt->bind_param("ss", $nombreUsuario, $usuarioSesion);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $user_valor = intval($row['estrellas'] ?? 0);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9">
  <title>Melo - Perfil de <?php echo htmlspecialchars($nombreUsuario); ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<?php include 'header.php'; ?>

<div class="profile-bg-container">
  <div class="background_and_profile">


  
    <div class="bp_header" style="background-image: url('<?php echo $datos['imagen_fondo'] ?? 'img/default-bg.jpg'; ?>');"></div>

    <div class="profile-content">
      
      <div class="profile_icon_big">
        <img src="<?php echo !empty($datos['imagen_perfil']) ? $datos['imagen_perfil'] : 'img/Profile_Icon.png'; ?>" class="profile-img">
      </div>

      
      <div class="name_bg">
        <h2><?php echo htmlspecialchars($datos['Nombre']); ?></h2>

        <!-- VALORACIÓN DE USUARIO -->
        <div class="stars estrellas-auto-detalle <?php echo $user_valor > 0 ? 'read-only' : ''; ?>"
             id="rating-stars"
             role="radiogroup"
             aria-label="Valora este usuario"
             data-user-valued="<?php echo $user_valor > 0 ? '1' : '0'; ?>"
             data-promedio="<?php echo htmlspecialchars(number_format($promedio, 2)); ?>">
          <?php
            $full = floor($promedio);
            for ($i = 1; $i <= 5; $i++) {
                $cls = ($i <= $full) ? 'bxs-star' : 'bx-star';
                echo "<i class='bx {$cls}' data-star='{$i}' role='radio' tabindex='0' aria-label='{$i} estrellas' aria-checked='false'></i>";
            }
          ?>


        </div>

                                          <div class ="boton_chatp">
            <a href="comentdex.php?con=<?php echo urlencode($nombreUsuario); ?>" class = boton> chatear con  <?php echo htmlspecialchars($datos['Nombre']); ?>     <i class='bx bx-message-dots'></i></a>
          </div>
        <?php if (!empty($datos['CorreoElectronico']) && $usuarioSesion && $usuarioSesion !== $nombreUsuario): ?>

        <?php elseif (!$usuarioSesion): ?>
          <p><a class = boton href="login.php">Inicia sesión para enviar mensajes</a></p>
          <p><a class = boton href="register.php">Registrarse para enviar mensajes</a></p>
        <?php endif; ?>



        <!-- <p class="rating-label"><?php echo "$promedio / 5 ($total_val votos)"; ?></p>-->

        <form id="rating-form" method="post" style="display:none;">
          <input type="hidden" name="valoracion" id="valoracion" value="<?php echo $user_valor; ?>" />
          <input type="hidden" name="usuario_valorado" value="<?php echo htmlspecialchars($nombreUsuario); ?>" />
        </form>

        <?php if ($usuarioSesion === $nombreUsuario): ?>

          <div class="boton_profile">

           <!--  <a href="agregar_auto.php" class="boton">Agregar Auto a rentar</a>-->

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
            if ($usuarioSesion === $nombreUsuario) {
                $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ?");
            } else {
                $stmt = $conn->prepare("SELECT * FROM autos WHERE usuario = ? AND oculto = 0");
            }
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            while ($auto = $resultado->fetch_assoc()) {
              echo "<a href='detalle_auto.php?id={$auto['id']}' class='card'>
                      <img src='" . htmlspecialchars($auto['imagen']) . "' alt='" . htmlspecialchars($auto['nombre']) . "'>
                      <div class='info'>
                        <h3>" . htmlspecialchars($auto['nombre']) . "</h3>
                        <p>" . htmlspecialchars($auto['descripcion']) . "</p>
                        <span class='price'>" . htmlspecialchars($auto['precio']) . "</span>
                        <span class='stars'><i class='bx bxs-star'></i> " . intval($auto['estrellas']) . "</span>
                      </div>
                    </a>";
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

      star.addEventListener('mouseover', () => pintarEstrellas(idx + 1));
      star.addEventListener('mouseout', () => pintarEstrellas(Math.floor(promedio)));
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
  }
});
</script>

<?php if (!$usuarioSesion): ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#rating-stars i');

    stars.forEach(star => {
      star.addEventListener('click', () => {
        window.location.href = 'login.php';
      });
    });
  });
</script>
<?php endif; ?>

</body>
</html>

