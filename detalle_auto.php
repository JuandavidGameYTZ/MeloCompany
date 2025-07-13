<?php
session_start();
require 'conexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "Auto inválido.";
    exit();
}

$error_comentario = '';
$usuario = $_SESSION['usuario'] ?? null;

// Procesar comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_comentario']) && $usuario) {
    $comentario = trim($_POST['nuevo_comentario']);
    if (strlen($comentario) > 250) {
        $error_comentario = "El comentario no puede exceder 250 caracteres.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO comentarios (id_auto, usuario, comentario, fecha) VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("iss", $id, $usuario, $comentario);
        $stmt->execute();
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Procesar valoración
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valoracion']) && $usuario) {
    $valor = intval($_POST['valoracion']);
    if ($valor >= 1 && $valor <= 5) {
        $stmt = $conn->prepare(
            "SELECT id FROM valorarauto WHERE id_auto = ? AND usuario = ?"
        );
        $stmt->bind_param("is", $id, $usuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows) {
            $stmt = $conn->prepare(
                "UPDATE valorarauto SET valor = ? WHERE id_auto = ? AND usuario = ?"
            );
            $stmt->bind_param("iis", $valor, $id, $usuario);
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO valorarauto (id_auto, usuario, valor) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("isi", $id, $usuario, $valor);
        }
        $stmt->execute();
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Datos del auto y dueño
$stmt = $conn->prepare(
    "SELECT a.*, r.imagen_perfil, r.Nombre
     FROM autos a
     JOIN registro r ON a.usuario = r.Nombre
     WHERE a.id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$auto = $stmt->get_result()->fetch_assoc();
if (!$auto) {
    echo "Auto no encontrado.";
    exit();
}

// Comentarios
$stmt = $conn->prepare(
    "SELECT usuario, comentario, fecha
     FROM comentarios
     WHERE id_auto = ?
     ORDER BY fecha DESC"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$result_comments = $stmt->get_result();

// Promedio y total de valoraciones
$stmt = $conn->prepare(
    "SELECT AVG(valor) AS promedio, COUNT(*) AS total
     FROM valorarauto
     WHERE id_auto = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$datos_prom = $stmt->get_result()->fetch_assoc();
$promedio = floatval($datos_prom['promedio'] ?? 0);
$total_val = intval($datos_prom['total'] ?? 0);

// Valoración del usuario actual
$user_valor = 0;
if ($usuario) {
    $stmt = $conn->prepare(
        "SELECT valor FROM valorarauto WHERE id_auto = ? AND usuario = ?"
    );
    $stmt->bind_param("is", $id, $usuario);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $user_valor = intval($row['valor'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
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
            <img
              src="<?php echo !empty($auto['imagen_perfil']) ? htmlspecialchars($auto['imagen_perfil']) : 'img/Profile_Icon.png'; ?>"
              alt="Perfil del dueño"
            />
          </div>
          <p class="public-username"><?php echo htmlspecialchars($auto['Nombre']); ?></p>
        </div>
      </a>

      <div class="description-bubble" id="description-bubble">
        <p id="car-description"><?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?></p>
        <span class="show-more">ver más</span>
      </div>

      <?php if (!empty($auto['ubicacion'])): ?>
        <iframe
        class="car-map"
          title="Ubicación del auto"
          width="100%"
          height="300"
          loading="lazy"
          allowfullscreen
          src="https://www.google.com/maps?q=<?php echo urlencode($auto['ubicacion']); ?>&output=embed"
        ></iframe>
      <?php endif; ?>
    </div>

    <p class="car-location"><?php echo htmlspecialchars($auto['ubicacion'] ?? 'No especificada'); ?></p>

    <a href="denuncias.php?id=<?php echo $auto['id']; ?>" class="boton">Denunciar</a>

    <hr class="divider" />
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


  <script src="js/script.js"></script>

</body>
</html>

