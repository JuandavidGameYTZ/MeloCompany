<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$emisor = $_SESSION['usuario'];
$receptor = $_GET['con'] ?? '';

if (empty($receptor) || $receptor === $emisor) {
    echo "Chat inválido.";
    exit();
}

// Verificamos que el receptor exista
$stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $receptor);
$stmt->execute();
$resultado = $stmt->get_result();

if (!$resultado->fetch_assoc()) {
    echo "El usuario no existe.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chat con <?php echo htmlspecialchars($receptor); ?></title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #1e1e1e;
      color: #f1f1f1;
    }
    .chat-layout {
      display: flex;
      height: 100vh;
    }
    .chat-sidebar {
      width: 260px;
      background-color: #121212;
      padding: 20px;
      border-right: 1px solid #333;
      overflow-y: auto;
    }
    .chat-sidebar h3 {
      color: #4caf50;
      margin-bottom: 20px;
    }
    .chat-list {
      list-style: none;
      padding: 0;
    }
    .chat-list li {
      margin-bottom: 15px;
    }
    .chat-list a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #4caf50;
      transition: 0.3s;
    }
    .chat-list a:hover {
      opacity: 0.8;
    }
    .chat-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }
    .chat-main {
      flex: 1;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    h2 {
      margin-bottom: 15px;
      color: #4caf50;
    }
    .chat-box {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
      background-color: #2a2a2a;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      border: 1px solid #444;
    }
    .message {
      max-width: 60%;
      padding: 12px 15px;
      border-radius: 15px;
      font-size: 15px;
      line-height: 1.4;
    }
    .message.user {
      background-color: #4caf50;
      color: white;
      align-self: flex-end;
      border-bottom-right-radius: 0;
    }
    .message.other {
      background-color: #3a3a3a;
      color: #ddd;
      align-self: flex-start;
      border-bottom-left-radius: 0;
    }
    form {
      display: flex;
      margin-top: 15px;
    }
    form input[type="text"] {
      flex: 1;
      padding: 12px;
      background-color: #2a2a2a;
      color: #f1f1f1;
      border: 1px solid #555;
      border-radius: 5px 0 0 5px;
      font-size: 14px;
      outline: none;
    }
    form input[type="submit"] {
      background-color: #4caf50;
      color: white;
      padding: 0 20px;
      border: none;
      font-size: 14px;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
    }
    form input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
  
</head>

<body>
  
<div class="chat-layout">
  
  <!-- Sidebar -->
  <div class="chat-sidebar">
    
  <a href="contacto.php" class="volver" style="
  display: inline-block;
  padding: 8px 16px;
  background-color: #007BFF;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  font-weight: bold;
">← Volver</a>

    <h3>Chats</h3>
    <ul class="chat-list">
      <?php
      $stmt = $conn->prepare("SELECT DISTINCT IF(emisor = ?, receptor, emisor) AS usuario_chat FROM mensajes WHERE emisor = ? OR receptor = ?");
      $stmt->bind_param("sss", $emisor, $emisor, $emisor);
      $stmt->execute();
      $res = $stmt->get_result();

      while ($chat = $res->fetch_assoc()) {
        $usuarioChat = $chat['usuario_chat'];
        $stmt2 = $conn->prepare("SELECT imagen_perfil FROM registro WHERE Nombre = ?");
        $stmt2->bind_param("s", $usuarioChat);
        $stmt2->execute();
        $r2 = $stmt2->get_result();
        $img = $r2->fetch_assoc()['imagen_perfil'] ?? 'img/Profile_Icon.png';
        $stmt2->close();

        echo "<li><a href='comentdex.php?con=" . urlencode($usuarioChat) . "'><img src='$img' class='chat-avatar'> <span>$usuarioChat</span></a></li>";
      }
      ?>
    </ul>
  </div>

  <!-- Chat principal -->
  <div class="chat-main">
    <h2>Chat con <?php echo htmlspecialchars($receptor); ?></h2>

    <div class="chat-box" id="chat-box">
      <!-- Mensajes cargados desde JS -->
    </div>

    <form id="form-mensaje">
      <input type="text" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje..." autocomplete="off" required>
      <input type="submit" value="Enviar">
    </form>
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

document.getElementById('form-mensaje').addEventListener('submit', function(e) {
  e.preventDefault();
  const mensaje = document.getElementById('mensaje').value;
  fetch("enviar.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `receptor=<?php echo urlencode($receptor); ?>&mensaje=${encodeURIComponent(mensaje)}`
  }).then(() => {
    document.getElementById('mensaje').value = '';
    cargarMensajes();
  });
});

setInterval(cargarMensajes, 2000);
cargarMensajes();
</script>
</body>
</html>

