<?php
session_start();

// --- Conexión segura a la base de datos ---
$host = "localhost";
$usuario = "root"; // NO uses 'root' en producción
$contrasena = "";
$basedatos = "Melocompany";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// Verificar conexión sin mostrar errores al usuario
if ($conn->connect_error) {
    error_log("Error DB: " . $conn->connect_error);
    die("Error de conexión. Intente más tarde.");
}

// Crear token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Acceso no autorizado.");
    }

    $nombre = trim($_POST["name"]);
    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

    if (!empty($nombre) && !empty($correo) && !empty($clave)) {

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensaje = "⚠️ Correo electrónico inválido.";
        } else {
            // Verificar si el nombre o el correo ya existen
            $verificar_sql = "SELECT ID_Registro FROM registro WHERE nombre = ? OR correoelectronico = ?";
            $stmt_verificar = $conn->prepare($verificar_sql);
            $stmt_verificar->bind_param("ss", $nombre, $correo);
            $stmt_verificar->execute();
            $resultado = $stmt_verificar->get_result();

            if ($resultado->num_rows > 0) {
                $mensaje = "⚠️ El nombre o el correo ya están registrados.";
            } else {
                // Guardar usuario con contraseña encriptada
                $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

                $sql = "INSERT INTO registro (nombre, correoelectronico, contrasena) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $nombre, $correo, $clave_segura);

                if ($stmt->execute()) {
                    $_SESSION['usuario'] = $nombre;
                    $_SESSION['id'] = $conn->insert_id;
                    header("Location: index.php");
                    exit();
                } else {
                    $mensaje = "❌ Error al registrar. Intenta más tarde.";
                    error_log("Error al registrar: " . $stmt->error);
                }

                $stmt->close();
            }

            $stmt_verificar->close();
        }
    } else {
        $mensaje = "⚠️ Por favor, completa todos los campos.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <title>Melo - Registrarse</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

<header class="register-header">
  <a href="index.php" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La página principal de Melo" />
  </a>
</header>

<div class="container">
  <div class="wrapper">
    <form method="POST" action="">
      <h1>Registrarse <i class='bx bx-user-plus'></i></h1>

      <?php if (!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
      <?php endif; ?>

      <div class="input-container">
        <input type="text" name="name" placeholder="Nombre" required />
        <i class='bx bx-user-id-card'></i>
      </div>

      <div class="input-container">
        <input type="email" name="email" placeholder="Correo electrónico" required />
        <i class='bx bx-envelope-alt'></i>
      </div>

      <div class="input-container" style="position: relative;">
        <input type="password" id="password" name="password" placeholder="Contraseña" required />
        <i class='bx bx-show' id="toggleLoginPassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
      </div>

      <!-- CSRF Token -->
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

      <button type="submit" class="boton">Registrarse</button>

      <p class="login-link">¿Ya tienes una cuenta? <a class="goodhef" href="login.php">Iniciar sesión</a></p>

      <p class="terms">
        Al registrarte, aceptas nuestros 
        <a class="goodhef" href="terms.php">Términos de Servicio</a> y 
        <a class="goodhef" href="privacy.php">Política de Privacidad</a>.
      </p>
    </form>
  </div>
</div>

<script>
  const toggleLogin = document.getElementById('toggleLoginPassword');
  const loginPassword = document.getElementById('password');

  toggleLogin?.addEventListener('click', function () {
    const tipo = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    loginPassword.setAttribute('type', tipo);

    if (tipo === 'text') {
      this.classList.remove('bx-show');
      this.classList.add('bx-hide');
    } else {
      this.classList.remove('bx-hide');
      this.classList.add('bx-show');
    }
  });
</script>

</body>
</html>
