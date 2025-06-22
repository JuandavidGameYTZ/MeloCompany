<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Coloca aquí tu contraseña si tienes
$basedatos = "Melocompany";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clave = $_POST["clave"];

    // Validar campos obligatorios
    if (!empty($nombre) && !empty($correo) && !empty($clave)) {
        // Encriptar contraseña
        $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $sql = "INSERT INTO registro (nombre, correoelectronico, contrasena) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $correo, $clave_segura);

        if ($stmt->execute()) {
            $mensaje = "✅ Registro exitoso.";
        } else {
            $mensaje = "❌ Error al registrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "⚠ Todos los campos son obligatorios.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Registrarse</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
  <style>
    .mensaje {
      background-color: #f5f5f5;
      border-left: 4px solid #4CAF50;
      padding: 10px;
      margin-bottom: 15px;
      color: #333;
      font-weight: bold;
      border-radius: 5px;
    }
  </style>
</head>

<body>

<header class="register-header">
  <a href="index.html" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de melo" />
  </a>
</header>    

<div class="container">
  <div class="wrapper"> 

    <form method="POST" action="registro.php">
      <h1>Registrarse</h1>

      <?php if (!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
      <?php endif; ?>

      <div class="input-container">
        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required />
        <i class='bx bx-user-id-card'></i>
      </div>

      <div class="input-container">
        <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required />
        <i class='bx bx-envelope-alt'></i>
      </div>

      <div class="input-container">
        <input type="password" id="clave" name="clave" placeholder="Contraseña" required />
        <i class='bx bx-lock'></i> 
      </div>

      <button type="submit" class="boton">Registrarse</button>
      <p class="login-link">¿Ya tienes una cuenta? <a href="login.html">Iniciar sesión</a></p>
    </form>

  </div>
</div>

</body>
</html>
