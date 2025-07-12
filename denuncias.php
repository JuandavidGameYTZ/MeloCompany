<?php
session_start();
require 'conexion.php';

$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    echo "ID de auto no válido.";
    exit();
}

// Obtener información del auto
$stmt = $conn->prepare("SELECT * FROM autos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$auto = $result->fetch_assoc();

if (!$auto) {
    echo "Vehículo no encontrado.";
    exit();
}

// Procesar envío
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $descripcion = trim($_POST['descripcion']);

    if (strlen($descripcion) < 10) {
        $mensaje = "La denuncia debe tener al menos 10 caracteres.";
    } else {
        $stmt = $conn->prepare("INSERT INTO denuncias (id_auto, usuario, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $usuario, $descripcion);
        $stmt->execute();
        $mensaje = "✅ Denuncia enviada correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Denuncia de Vehículo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background-color: #f9f9f9;
    }
    form {
      max-width: 600px;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #fff;
    }
    label {
      display: block;
      margin-bottom: 10px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #45a049;
    }
    .mensaje {
      text-align: center;
      color: green;
      margin-bottom: 10px;
    }
    .error {
      color: red;
    }
    .auto-info {
      background-color: #f4f4f4;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .auto-info img {
      max-width: 70%;
      border-radius: 8px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <center>
    <h2>Formulario de Denuncia de Vehículo</h2>

  <form method="post">
    
    <div class="auto-info">
      <p><strong>Vendedor:</strong> <?php echo htmlspecialchars($auto['usuario']); ?></p>
      <p><strong>Nombre del vehículo:</strong> <?php echo htmlspecialchars($auto['nombre']); ?></p>
      <p><strong>Descripción:</strong><br><?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?></p>
      <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del vehículo">
    </div>

    <?php if (!isset($_SESSION['usuario'])): ?>
      <p class="error">⚠️ Debes <a href="login.php">iniciar sesión</a> para enviar una denuncia.</p>
    <?php else: ?>
      <label for="descripcion">Descripción de la Denuncia:</label>
      <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
      <input type="hidden" name="id_auto" value="<?php echo $id; ?>">
      <button type="submit">Enviar Denuncia</button>
    <?php endif; ?>

    <?php if ($mensaje): ?>
      <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <p><a href="index.php">← Ir a la página de inicio</a></p>
  </form>
</center>
</body>
</html>
