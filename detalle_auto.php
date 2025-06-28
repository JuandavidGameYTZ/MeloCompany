<?php
session_start();
require 'conexion.php';

$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    echo "Auto inválido.";
    exit();
}

// Procesar nuevo comentario
$error_comentario = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_comentario']) && isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $comentario = trim($_POST['nuevo_comentario']);

    if (strlen($comentario) > 250) {
        $error_comentario = "El comentario no puede exceder 250 caracteres.";
    } else {
        $stmt_insert = $conn->prepare("INSERT INTO comentarios (id_auto, usuario, comentario, fecha) VALUES (?, ?, ?, NOW())");
        $stmt_insert->bind_param("iss", $id, $usuario, $comentario);
        $stmt_insert->execute();
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Procesar valoración
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valoracion']) && isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $valor = intval($_POST['valoracion']);
    if ($valor >= 1 && $valor <= 5) {
        $stmt_check = $conn->prepare("SELECT id FROM valorarauto WHERE id_auto = ? AND usuario = ?");
        $stmt_check->bind_param("is", $id, $usuario);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();

        if ($resultado_check->num_rows > 0) {
            $stmt_update = $conn->prepare("UPDATE valorarauto SET valor = ? WHERE id_auto = ? AND usuario = ?");
            $stmt_update->bind_param("iis", $valor, $id, $usuario);
            $stmt_update->execute();
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO valorarauto (id_auto, usuario, valor) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("isi", $id, $usuario, $valor);
            $stmt_insert->execute();
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Obtener auto
$stmt = $conn->prepare("SELECT a.*, r.imagen_perfil, r.Nombre FROM autos a JOIN registro r ON a.usuario = r.Nombre WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$auto = $resultado->fetch_assoc();

if (!$auto) {
    echo "Auto no encontrado.";
    exit();
}

// Obtener comentarios
$stmt_comments = $conn->prepare("SELECT usuario, comentario, fecha FROM comentarios WHERE id_auto = ? ORDER BY fecha DESC");
$stmt_comments->bind_param("i", $id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

// Obtener promedio de valoraciones
$stmt_prom = $conn->prepare("SELECT AVG(valor) as promedio, COUNT(*) as total FROM valorarauto WHERE id_auto = ?");
$stmt_prom->bind_param("i", $id);
$stmt_prom->execute();
$resultado_prom = $stmt_prom->get_result();
$datos_prom = $resultado_prom->fetch_assoc();
$promedio = round($datos_prom['promedio'] ?? 0, 1);
$total_val = intval($datos_prom['total'] ?? 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Detalle del Auto - <?php echo htmlspecialchars($auto['nombre']); ?></title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<div class="car-detail-card">
  <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del auto" class="car-image">

  <div class="car-info">
    <h1 class="car-title"><?php echo htmlspecialchars($auto['nombre']); ?></h1>

    <p class="car-description">
      <strong>Descripción:</strong><br>
      <?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?>
    </p>

    <p class="car-price"><strong>Precio:</strong> <?php echo htmlspecialchars($auto['precio']); ?></p>

    <p class="car-rating">
      <strong>Valoración:</strong>
      <?php echo str_repeat("⭐", intval($auto['estrellas'])); ?>
    </p>

    <p class="car-location">
      <strong>Ubicación:</strong>
      <?php echo htmlspecialchars($auto['ubicacion'] ?? 'No especificada'); ?>
    </p>

<p class="car-rating">
  <strong>Valoración promedio:</strong>
  <?php echo str_repeat("⭐", floor($promedio)); ?>
  <span style="color: #ccc;">(<?php echo $promedio; ?> / 5, <?php echo $total_val; ?> votos)</span>
</p>

<?php if (isset($_SESSION['usuario'])): ?>
  <form method="post" style="margin-top: 5px;">
    <label for="valoracion">Tu valoración:</label>
    <select name="valoracion" id="valoracion" required style="background-color: #333; color: #fff; border: none; padding: 5px; border-radius: 4px;">
      <option value="">Selecciona</option>
      <option value="5">⭐ 5</option>
      <option value="4">⭐ 4</option>
      <option value="3">⭐ 3</option>
      <option value="2">⭐ 2</option>
      <option value="1">⭐ 1</option>
    </select>
    <button type="submit" style="background-color: #555; color: #eee; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Enviar</button>
  </form>
<?php else: ?>
  <p style="color: #aaa;">Inicia sesión para valorar.</p>
<?php endif; ?>


    <?php if (!empty($auto['ubicacion'])): ?>
      <iframe
        width="100%"
        height="300"
        style="border:0; margin-top: 10px; border-radius: 10px;"
        loading="lazy"
        allowfullscreen
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps?q=<?php echo urlencode($auto['ubicacion']); ?>&output=embed">
      </iframe>
    <?php endif; ?>
  </div>

  <hr class="divider">

  <!-- Ir al perfil público del dueño del auto -->
  <a href="perfil_publico.php?nombre=<?php echo urlencode($auto['Nombre']); ?>" class="user-profile-mini">
    <img src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>" alt="Imagen de perfil" class="profile-pic">
    <p class="username"><?php echo htmlspecialchars($auto['Nombre']); ?></p>
  </a>

  <a href="index.php" class="back-button">Volver al inicio</a>
 <!-- Sección comentarios -->
<div class="comments-section" style="background-color: #222; color: #eee; padding: 15px; border-radius: 8px; margin-top: 20px;">
  <h2>Comentarios</h2>

  <?php if ($result_comments->num_rows === 0): ?>
    <p>No hay comentarios todavía.</p>
  <?php else: ?>
    <?php while($coment = $result_comments->fetch_assoc()): ?>
      <div class="comment" style="border-bottom: 1px solid #444; padding: 8px 0;">
        <p style="margin: 0;"><strong><?php echo htmlspecialchars($coment['usuario']); ?></strong> <small style="color: #999;"><?php echo date('d/m/Y H:i', strtotime($coment['fecha'])); ?></small></p>
        <p style="margin: 5px 0 0;"><?php echo nl2br(htmlspecialchars($coment['comentario'])); ?></p>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['usuario'])): ?>
    <form method="post" style="margin-top: 15px;">
      <label for="nuevo_comentario">Añadir comentario (máximo 250 caracteres):</label><br>
      <textarea
        name="nuevo_comentario"
        id="nuevo_comentario"
        rows="3"
        maxlength="250"
        style="width: 100%; background-color: #333; color: #eee; border: none; padding: 8px; border-radius: 5px; resize: none;"
        required
        oninput="updateCounter()"
      ></textarea>
      <div style="text-align: right; font-size: 0.9em; color: #ccc;" id="charCounter">250 caracteres restantes</div>
      
      <?php if ($error_comentario): ?>
        <p style="color: #ff6666;"><?php echo $error_comentario; ?></p>
      <?php endif; ?>

      <button type="submit" style="margin-top: 8px; background-color: #555; color: #eee; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">Enviar</button>
    </form>
  <?php else: ?>
    <p>Debe <a href="login.php" style="color: #66ccff;">iniciar sesión</a> para comentar.</p>
  <?php endif; ?>
</div>

<script>
function updateCounter() {
  const textarea = document.getElementById('nuevo_comentario');
  const counter = document.getElementById('charCounter');
  const max = 250;
  const remaining = max - textarea.value.length;
  counter.textContent = remaining + " caracteres restantes";
}
</script>

</div>


</body>
</html>
