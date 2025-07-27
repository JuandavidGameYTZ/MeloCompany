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
        $mensaje = "Denuncia enviada correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Denuncia de Vehículo</title>
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>


<?php include 'header.php'; ?>


<body>

    <h2 class="autoinfoh2">Formulario de Denuncia de Vehículo</h2>

  <form method="post">
    <div class="auto-info1">
      <h3>Información del Vehículo</h3>
    <div class="auto-info">
      <p><strong>Vendedor:</strong> <?php echo htmlspecialchars(string: $auto['usuario']); ?></p>
      <p><strong>Nombre del vehículo:</strong> <?php echo htmlspecialchars($auto['nombre']); ?></p>
      <p><strong>Descripción:</strong><br><?php echo nl2br(htmlspecialchars($auto['descripcion'])); ?></p>
      <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del vehículo">
    



    <?php if ($mensaje): ?>
      <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>
</div>

    <?php if (!isset($_SESSION['usuario'])): ?>
      <p class="error"> Debes <a href="login.php">iniciar sesión</a> para enviar una denuncia.</p>
    <?php else: ?>
  <label for="descripcion">Descripción de la Denuncia:</label>
  <div class="input-container">
    <textarea class="transparent" id="descripcion" name="descripcion" rows="4" required></textarea>
  </div>

      <input type="hidden" name="id_auto" value="<?php echo $id; ?>">
      <button class= boton type="submit">Enviar Denuncia</button>
    <?php endif; ?>


  </form>
</body>
</html>
