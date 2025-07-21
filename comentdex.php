<?php
session_start();
require 'conexion.php';

// --- INICIO: Código para enviar mensaje (integrado) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receptor'], $_POST['mensaje'])) {
  $emisor = $_SESSION['usuario'] ?? '';
  $receptor = $_POST['receptor'] ?? '';
  $mensaje = trim($_POST['mensaje'] ?? '');

  if ($emisor && $receptor && $mensaje) {
    $stmt = $conn->prepare("INSERT INTO mensajes (emisor, receptor, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $emisor, $receptor, $mensaje);
    $stmt->execute();
    $stmt->close();
    // Si quieres que el script termine aquí cuando es POST (AJAX), descomenta la siguiente línea:
    // exit();
  }
}
// --- FIN: Código para enviar mensaje ---

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

$emisor = $_SESSION['usuario'];
$receptor = $_GET['con'] ?? '';

// Validaciones de receptor
if (empty($receptor) || $receptor === $emisor) {
  echo "Chat inválido.";
  exit();
}

// Verifica que el receptor exista
$stmt = $conn->prepare("SELECT 1 FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $receptor);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
  // Elimina todos los mensajes relacionados con el usuario inexistente
  $delStmt = $conn->prepare("DELETE FROM mensajes WHERE emisor = ? OR receptor = ?");
  $delStmt->bind_param("ss", $receptor, $receptor);
  $delStmt->execute();
  $delStmt->close();

  echo "El usuario no existe y ha sido eliminado del chat.";
  exit();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chat con <?php echo htmlspecialchars($receptor); ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<?php include 'header.php'; ?>

<div class="comentdex-wrapper">
  <div class="comentdex-layout">
  <!-- Sidebar de chats -->
  <div class="comentdex-sidebar">
  <h3>Chats <i class='bx bx-message-dots'></i></h3>
  <ul class="comentdex-list">
  <?php
  // Obtiene la lista de chats únicos del usuario
  $stmt = $conn->prepare("
    SELECT DISTINCT IF(emisor = ?, receptor, emisor) AS usuario_chat 
    FROM mensajes 
    WHERE emisor = ? OR receptor = ?
  ");
  $stmt->bind_param("sss", $emisor, $emisor, $emisor);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($chat = $res->fetch_assoc()) {
    $usuarioChat = $chat['usuario_chat'];
    // Obtiene la imagen de perfil del usuario del chat
    $stmt2 = $conn->prepare("SELECT imagen_perfil FROM registro WHERE Nombre = ?");
    $stmt2->bind_param("s", $usuarioChat);
    $stmt2->execute();
    $r2 = $stmt2->get_result();
    $img = $r2->fetch_assoc()['imagen_perfil'] ?? 'img/Profile_Icon.png';
    $stmt2->close();

    echo "<li><a href='comentdex.php?con=" . urlencode($usuarioChat) . "'>
      <img src='$img' class='comentdex-avatar'> 
      <span>$usuarioChat</span>
      </a></li>";
  }
  $stmt->close();
  ?>
  </ul>
  </div>

  <!-- Chat principal -->
  <div class="comentdex-main">
  <h2>Chat con <?php echo htmlspecialchars($receptor); ?></h2>
  <div class="comentdex-box" id="chat-box"></div>
  <form id="form-mensaje" autocomplete="off" method="post">
  <input type="text" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje..." required>
  <input type="hidden" name="receptor" value="<?php echo htmlspecialchars($receptor); ?>">
  <button type="submit" class="comentdex-btn">
    <i class='bx bx-send'></i>
  </button>
  </form>
  </div>
  </div>
</div>

<script>
function cargarMensajes() {
  fetch("obtener.php?con=<?php echo urlencode($receptor); ?>")
  .then(res => res.text())
  .then(data => {
  const box = document.getElementById('chat-box');
  box.innerHTML = data;
  box.scrollTop = box.scrollHeight;
  });
}

// Envía un nuevo mensaje usando AJAX
document.getElementById('form-mensaje').addEventListener('submit', function(e) {
  e.preventDefault();
  const mensaje = document.getElementById('mensaje').value;
  const receptor = "<?php echo htmlspecialchars($receptor); ?>";
  fetch("<?php echo basename(__FILE__); ?>", {
  method: "POST",
  headers: { "Content-Type": "application/x-www-form-urlencoded" },
  body: `receptor=${encodeURIComponent(receptor)}&mensaje=${encodeURIComponent(mensaje)}`
  }).then(() => {
  document.getElementById('mensaje').value = '';
  cargarMensajes();
  });
});

// Actualiza los mensajes cada 2 segundos
let autoScroll = true;

const chatBox = document.getElementById('chat-box');
chatBox.addEventListener('scroll', function() {
  // Si el usuario está cerca del fondo, permitimos el autoscroll
  autoScroll = (chatBox.scrollTop + chatBox.clientHeight >= chatBox.scrollHeight - 20);
});

function cargarMensajes() {
  const prevScrollHeight = chatBox.scrollHeight;
  const prevScrollTop = chatBox.scrollTop;

  fetch("obtener.php?con=<?php echo urlencode($receptor); ?>")
  .then(res => res.text())
  .then(data => {
  chatBox.innerHTML = data;
  if (autoScroll) {
    chatBox.scrollTop = chatBox.scrollHeight;
  } else {
    // Mantiene la posición de scroll relativa al contenido anterior
    chatBox.scrollTop = prevScrollTop + (chatBox.scrollHeight - prevScrollHeight);
  }
  });
}

setInterval(cargarMensajes, 1239000);
cargarMensajes();
</script>
</body>
</html>