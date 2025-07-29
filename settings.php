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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">

</head>

<?php include 'header.php'; ?>

<body>


<a href="profile.php " class="ajustes-link"> 
  <div class="ajustes-contenedor">
    <div class="ajuste-ctn">
      <div class="ajustes-titulo"><h2>Ajustes de cuenta</h2></div>
      <?php if (!empty($datos['imagen_perfil'])): ?>
        <img src="<?php echo htmlspecialchars($datos['imagen_perfil']); ?>" class="ajustes-imagen-perfil" alt="Perfil">
      <?php else: ?>
        <img src="img/Profile_Icon.png" class="ajustes-imagen-perfil" alt="Perfil por defecto">
      <?php endif; ?>
    </div>
</a>
  <form method="POST">
    <label for="nombre" class="ajustes-label">Nombre de usuario:</label>
    <input type="text" id="nombre" name="nombre" class="input-container" value="<?php echo htmlspecialchars($datos['Nombre']); ?>" required>

    <label for="correo" class="ajustes-label">Correo electrónico:</label>
    <input type="email" id="correo" name="correo" class="input-container" value="<?php echo htmlspecialchars($datos['CorreoElectronico']); ?>" required>

    <label for="contrasena" class="ajustes-label">Nueva contraseña (opcional):</label>
    <input type="password" id="contrasena" name="contrasena" class="input-container" placeholder="Dejar en blanco para no cambiar">

    <input type="submit" class="boton" value="Guardar cambios">
  </form>

  <?php if ($mensaje): ?>
    <div class="ajustes-mensaje"><?php echo $mensaje; ?></div>
  <?php endif; ?>
</div>

</body>
</html>



