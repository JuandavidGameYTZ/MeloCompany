<?php
session_start();
require 'conexion.php';

// Validar ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { echo "Auto inválido."; exit(); }

$usuario = $_SESSION['usuario'] ?? null;
$error_comentario = '';


// Procesar eliminación del auto si es el dueño


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_auto']) && $usuario === $auto['usuario']) {


    // Eliminar valoraciones, comentarios, denuncias, etc. relacionadas

    $stmt = $conn->prepare("DELETE FROM valorarauto WHERE id_auto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM comentarios WHERE id_auto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM denuncias WHERE id_auto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // Finalmente, eliminar el auto

    $stmt = $conn->prepare("DELETE FROM autos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirigir a inicio o perfil

    header("Location: perfil_publico.php?nombre=" . urlencode($usuario));

    exit();

}

// Procesar comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_comentario']) && $usuario) {
    $comentario = trim($_POST['nuevo_comentario']);
    if (strlen($comentario) > 250) {
        $error_comentario = "El comentario no puede exceder 250 caracteres.";
    } else {
        $stmt = $conn->prepare("INSERT INTO comentarios (id_auto, usuario, comentario, fecha) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $id, $usuario, $comentario);
        $stmt->execute();
        header("Location: " . $_SERVER['REQUEST_URI']); exit();
    }
}

// Procesar valoración
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valoracion']) && $usuario) {
    $valor = intval($_POST['valoracion']);
    if ($valor >= 1 && $valor <= 5) {
        $stmt = $conn->prepare("SELECT id FROM valorarauto WHERE id_auto = ? AND usuario = ?");
        $stmt->bind_param("is", $id, $usuario);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows) {
            $stmt = $conn->prepare("UPDATE valorarauto SET valor = ? WHERE id_auto = ? AND usuario = ?");
            $stmt->bind_param("iis", $valor, $id, $usuario);
        } else {
            $stmt = $conn->prepare("INSERT INTO valorarauto (id_auto, usuario, valor) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $id, $usuario, $valor);
        }
        $stmt->execute();
        header("Location: " . $_SERVER['REQUEST_URI']); exit();
    }
}

// Obtener datos del auto
$stmt = $conn->prepare("SELECT a.*, r.imagen_perfil, r.Nombre FROM autos a JOIN registro r ON a.usuario = r.Nombre WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$auto = $stmt->get_result()->fetch_assoc();
if (!$auto) { echo "Auto no encontrado."; exit(); }

// Ocultar/mostrar auto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_oculto']) && $usuario === $auto['usuario']) {
    $nuevo_estado = $auto['oculto'] ? 0 : 1;
    $stmt = $conn->prepare("UPDATE autos SET oculto = ? WHERE id = ?");
    $stmt->bind_param("ii", $nuevo_estado, $id);
    $stmt->execute();
    header("Location: " . $_SERVER['REQUEST_URI']); exit();
}

// Procesar renta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rentar_auto']) && $usuario && $usuario !== $auto['usuario']) {
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    if ($fecha_inicio && $fecha_fin && $fecha_fin >= $fecha_inicio) {
        $dias = (new DateTime($fecha_inicio))->diff(new DateTime($fecha_fin))->days + 1;
        $total = $dias * floatval($auto['precio']);
        $stmt = $conn->prepare("INSERT INTO rentas (auto_id, cliente, fecha_inicio, fecha_fin, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $id, $usuario, $fecha_inicio, $fecha_fin, $total);
        $stmt->execute();
        header("Location: rentas_realizadas.php"); exit();
    } else {
        echo "<p style='color:red'>Fechas inválidas.</p>";
    }
}

// Comentarios y valoraciones
$stmt = $conn->prepare("SELECT usuario, comentario, fecha FROM comentarios WHERE id_auto = ? ORDER BY fecha DESC");
$stmt->bind_param("i", $id); $stmt->execute();
$result_comments = $stmt->get_result();

$stmt = $conn->prepare("SELECT AVG(valor) AS promedio, COUNT(*) AS total FROM valorarauto WHERE id_auto = ?");
$stmt->bind_param("i", $id); $stmt->execute();
$datos_prom = $stmt->get_result()->fetch_assoc();
$promedio = floatval($datos_prom['promedio'] ?? 0);
$total_val = intval($datos_prom['total'] ?? 0);

$user_valor = 0;
if ($usuario) {
    $stmt = $conn->prepare("SELECT valor FROM valorarauto WHERE id_auto = ? AND usuario = ?");
    $stmt->bind_param("is", $id, $usuario); $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $user_valor = intval($row['valor'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <title>Detalle del Auto - <?php echo htmlspecialchars($auto['nombre']); ?></title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<?php include 'header.php'; ?>

<div class="car-detail-card">
  <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del auto" class="car-image" />

  <div class="car-info">
    <h1 class="car-title"><?php echo htmlspecialchars($auto['nombre']); ?></h1>
    <p class="car-price"><?php echo htmlspecialchars($auto['precio']); ?></p>

    <?php if ($usuario): ?>
    <form id="rating-form" method="post" style="display:inline;">
      <div
        class="stars estrellas-auto-detalle <?php echo $user_valor > 0 ? 'read-only' : ''; ?>"
        id="rating-stars"
        role="radiogroup"
        aria-label="Valora este auto"
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
    <?php else: ?>
    <div class="stars read-only estrellas-auto-detalle" aria-label="Valoración promedio">
      <?php
        $full = floor($promedio);
        for ($i = 1; $i <= 5; $i++) {
          $cls = $i <= $full ? 'bxs-star' : 'bx-star';
          echo "<i class='bx {$cls}'></i>";
        }
      ?>
    </div>
    <?php endif; ?>

    <a href="perfil_publico.php?nombre=<?php echo urlencode($auto['Nombre']); ?>" class="public-profile-link">
      <div class="public-profile-bubble">
        <div class="public-profile-pic">
          <img src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" alt="Perfil del dueño" />
        </div>
        <p class="public-username"><?php echo htmlspecialchars($auto['Nombre']); ?></p>
      </div>
    </a>

    <div class="description-bubble" id="description-bubble">
      <p id="car-description"><?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?></p>
      <span class="show-more">ver más</span>
    </div>

    <?php if (!empty($auto['ubicacion'])): ?>
      <iframe class="car-map" width="100%" height="300" loading="lazy" allowfullscreen src="https://www.google.com/maps?q=<?php echo urlencode($auto['ubicacion']); ?>&output=embed"></iframe>
    <?php endif; ?>
  </div>

  <p class="car-location"><?php echo htmlspecialchars($auto['ubicacion'] ?? 'No especificada'); ?></p>

  <a href="denuncias.php?id=<?php echo $auto['id']; ?>" class="boton">Denunciar</a>

  <?php if ($usuario === $auto['usuario']): ?>
  <form method="post" style="display:inline;">
    <input type="hidden" name="toggle_oculto" value="1">
    <button type="submit" class="boton">
      <?php echo $auto['oculto'] ? 'Mostrar auto' : 'Ocultar auto'; ?>
    </button>
  </form>
  <?php endif; ?>


  <div class="comentarios">
    <h2>Comentarios</h2>

    <?php if ($result_comments->num_rows === 0): ?>
      <p class="sin-comentarios">No hay comentarios todavía.</p>
    <?php else: ?>
      <?php while ($coment = $result_comments->fetch_assoc()): ?>
        <div class="comentario">
          <p class="comentario-cabecera">
            <strong><?php echo htmlspecialchars($coment['usuario']); ?></strong>
            <small><?php echo date('d/m/Y H:i', strtotime($coment['fecha'])); ?></small>
          </p>
          <p class="comentario-texto"><?php echo nl2br(htmlspecialchars($coment['comentario'])); ?></p>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>

<?php if ($usuario === $auto['usuario']): ?>
  <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este auto? Esta acción no se puede deshacer.');" style="display:inline;">
    <input type="hidden" name="eliminar_auto" value="1">
    <button type="submit" class="boton rojo">Eliminar auto</button>
  </form>
<?php endif; ?>


    <?php if ($usuario): ?>
    <form method="post" class="formulario-comentario">
      <label for="nuevo_comentario">Añadir comentario</label>
      <textarea id="nuevo_comentario" name="nuevo_comentario" maxlength="250" required oninput="updateCounter()"></textarea>
      <div id="charCounter">250 caracteres restantes</div>

      <?php if ($error_comentario): ?>
        <p class="error"><?php echo $error_comentario; ?></p>
      <?php endif; ?>

      <button type="submit" class="boton">Enviar</button>
    </form>
    <?php endif; ?>
  </div>
</div>

<script src="js/script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const txt = document.getElementById('nuevo_comentario');
  const cnt = document.getElementById('charCounter');
  if (txt && cnt) {
    txt.addEventListener('input', () => {
      cnt.textContent = (250 - txt.value.length) + " caracteres restantes";
    });
  }

  const desc = document.getElementById('car-description');
  const showMore = document.querySelector('.show-more');
  if (desc && showMore && desc.scrollHeight > desc.clientHeight + 1) {
    showMore.style.display = 'inline';
    showMore.addEventListener('click', () => {
      desc.style.maxHeight = 'none';
      desc.style.overflow = 'visible';
      showMore.style.display = 'none';
    });
  }

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

</body>
</html>
