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
    $nombre = trim($_POST["name"]);
    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

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
        $mensaje = "⚠️ Todos los campos son obligatorios.";
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
</head>

<body>

<header class="register-header">
  <a href="index.html" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de melo" />
  </a>
</header>    

<div class="container">
  <div class="wrapper"> 

    <?php if (!empty($mensaje)): ?>
      <div class="mensaje" style="text-align:center; margin-bottom:10px; font-weight:bold;"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST" action="registro.php">
        <h1>Registrarse</h1>

        <div class="input-container">
            <input type="text" id="name" name="name" placeholder="Nombre" required />
            <i class='bx bx-user-id-card'></i>
        </div>

        <div class="input-container">
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required />
            <i class='bx bx-envelope-alt'></i>
        </div>

        <div class="input-container">
            <input type="password" id="password" name="password" placeholder="Contraseña" required />
            <i class='bx bx-lock'></i> 
        </div>

        <button type="submit" class="boton">Registrarse</button>
        <p class="login-link">¿Ya tienes una cuenta? <a href="login.html">Iniciar sesión</a></p>
    </form>

  </div>
</div>
</body>
</html>
<?php
// No tocar