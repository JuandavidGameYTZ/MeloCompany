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
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <title>Chat con <?php echo htmlspecialchars($receptor); ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>

<body class="no-scroll">

<?php include 'header.php'; ?>

<div class="comentdex-wrapper">
  <div class="comentdex-layout">
  <div class="comentdex-sidebar">

  <h3>Chats <i class='bx bx-message-dots'></i></h3>

<ul id="sidebar-chat-list" class="comentdex-list"></ul>

  </div>

  <!-- Chat principal -->
  <div class="comentdex-main">
      <?php

// Obtener imagen del receptor
$stmt3 = $conn->prepare("SELECT imagen_perfil FROM registro WHERE Nombre = ?");
$stmt3->bind_param("s", $receptor);
$stmt3->execute();
$r3 = $stmt3->get_result();
$imgReceptor = $r3->fetch_assoc()['imagen_perfil'] ?? 'img/Profile_Icon.png';
$stmt3->close();



// Mostrar al receptor como si fuera un item de lista
echo "<li class='comentdex-list2'>
  <a href='perfil_publico.php?nombre=" . urlencode($receptor) . "'>
    <img src='$imgReceptor' class='comentdex-avatar'> 
    <span>$receptor</span>
  </a>
</li>";
?>


  <div class="comentdex-box" id="chat-box"></div>

  
  <form id="form-mensaje" autocomplete="on" method="post" title="Escribe un mensaje">
  <input type="text" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje..." title="Escribe un mensaje" required>
  <input type="hidden" name="receptor" value="<?php echo htmlspecialchars($receptor); ?>" title="Escribe un mensaje">
  <button type="submit" class="comentdex-btn" title="Escribe un mensaje">
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

setInterval(cargarMensajes, 2000);
cargarMensajes();
</script>

<script>
function actualizarSidebar() {
    fetch('actualizar_sidebar.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('sidebar-chat-list').innerHTML = html;
        });
}

// Actualiza cada 5 segundos
setInterval(actualizarSidebar, 5000);

// También al cargar la página
document.addEventListener('DOMContentLoaded', actualizarSidebar);
</script>

</body>
</html>