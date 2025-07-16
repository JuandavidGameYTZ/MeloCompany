<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuarioActual = $_SESSION['usuario'];
$mensaje = "";

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
$stmt->bind_param("s", $usuarioActual);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();
$stmt->close();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoNombre = trim($_POST['nombre']);
    $nuevoCorreo = trim($_POST['correo']);
    $nuevaContrasena = trim($_POST['contrasena']);

    if ($nuevoNombre === '' || $nuevoCorreo === '') {
        $mensaje = "Nombre y correo no pueden estar vacíos.";
    } else {
        $conn->begin_transaction();

        try {
            // Actualizar tabla registro
            if ($nuevaContrasena !== '') {
                $hash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE registro SET Nombre = ?, CorreoElectronico = ?, Contrasena = ? WHERE Nombre = ?");
                $stmt->bind_param("ssss", $nuevoNombre, $nuevoCorreo, $hash, $usuarioActual);
            } else {
                $stmt = $conn->prepare("UPDATE registro SET Nombre = ?, CorreoElectronico = ? WHERE Nombre = ?");
                $stmt->bind_param("sss", $nuevoNombre, $nuevoCorreo, $usuarioActual);
            }
            $stmt->execute();
            $stmt->close();

            // Tablas donde se debe cambiar el nombre
            $tablasYCampos = [
                ['mensajes', 'emisor'],
                ['mensajes', 'receptor'],
                ['autos', 'usuario'],
                ['valoraciones', 'usuario_valorado'],
                ['valoraciones', 'usuario_que_valora'],
                ['calificausuario', 'usuario_valorado'],
                ['calificausuario', 'usuario_que_valora'],
                ['denuncias', 'usuario'],
                ['comentarios', 'usuario'],
                ['valorarauto', 'usuario']
            ];

            foreach ($tablasYCampos as $item) {
                [$tabla, $campo] = $item;
                $sql = "UPDATE $tabla SET $campo = ? WHERE $campo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $nuevoNombre, $usuarioActual);
                $stmt->execute();
                $stmt->close();
            }

            $conn->commit();
            $_SESSION['usuario'] = $nuevoNombre;
            $usuarioActual = $nuevoNombre;
            $mensaje = "Todos los datos se actualizaron correctamente.";
        } catch (Exception $e) {
            $conn->rollback();
            $mensaje = "Error al actualizar los datos: " . $e->getMessage();
        }

        // Refrescar datos actualizados
        $stmt = $conn->prepare("SELECT * FROM registro WHERE Nombre = ?");
        $stmt->bind_param("s", $nuevoNombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ajustes de cuenta</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    .ajustes-box {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    input, label {
      display: block;
      width: 100%;
      margin-bottom: 10px;
    }
    input[type="submit"] {
      background: #4caf50;
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
    }
    .mensaje {
      color: green;
      font-weight: bold;
      margin-top: 10px;
    }
    .img-perfil {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="ajustes-box">
  <h2>Ajustes de cuenta</h2>

  <?php if (!empty($datos['imagen_perfil'])): ?>
    <img src="<?php echo htmlspecialchars($datos['imagen_perfil']); ?>" class="img-perfil" alt="Perfil">
  <?php else: ?>
    <img src="img/Profile_Icon.png" class="img-perfil" alt="Perfil por defecto">
  <?php endif; ?>

  <form method="POST">
    <label for="nombre">Nombre de usuario:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos['Nombre']); ?>" required>

    <label for="correo">Correo electrónico:</label>
    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($datos['CorreoElectronico']); ?>" required>

    <label for="contrasena">Nueva contraseña (opcional):</label>
    <input type="password" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar">

    <input type="submit" value="Guardar cambios">
  </form>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?php echo $mensaje; ?></div>
  <?php endif; ?>
</div>

</body>
</html>


