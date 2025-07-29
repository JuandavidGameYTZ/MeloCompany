<?php
session_start();

// --- CONFIGURACIÓN DE CONEXIÓN SEGURA ---
// Reemplaza estos datos con los de tu usuario seguro de MySQL
$host = "localhost";
$usuario = "root"; // ⚠️ NO uses "root"
$contrasena = "";
$basedatos = "Melocompany";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// Verificar conexión sin exponer datos al usuario
if ($conn->connect_error) {
    error_log("Error DB: " . $conn->connect_error); // Log interno
    die("Error de conexión. Intente más tarde.");
}

// --- SEGURIDAD: CSRF y fuerza bruta ---
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
}

if ($_SESSION['intentos_login'] >= 5) {
    die("Demasiados intentos. Intenta más tarde.");
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --- PROCESO DE LOGIN ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Acceso no autorizado.");
    }

    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

    // Validar formato del correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href = 'login.php';</script>";
        exit;
    }

    // Consultar usuario por correo
    $sql = "SELECT ID_Registro, Nombre, Contrasena FROM registro WHERE CorreoElectronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($clave, $usuario["Contrasena"])) {
            // Autenticación exitosa
            $_SESSION['usuario'] = $usuario["Nombre"];
            $_SESSION['id'] = $usuario["ID_Registro"];
            $_SESSION['intentos_login'] = 0;
            header("Location: index.php");
            exit();
        }
    }

    // Falla de autenticación
    $_SESSION['intentos_login']++;
    echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href = 'login.php';</script>";
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>
<body>

  <!-- Logo -->
  <header class="register-header">
    <a href="index.php" class="logo-link" aria-label="Melo Logo">
      <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La página principal de Melo" />
    </a>
  </header>    

  <div class="container">
    <div class="wrapper"> 
      <form method="POST" action="login.php">
        <h1>Iniciar Sesión <i class='bx bx-user'></i></h1>

        <div class="input-container">
          <input type="email" id="email" name="email" placeholder="Correo electrónico" required />
          <i class='bx bx-envelope-alt'></i>
        </div>

        <div class="input-container">
          <input type="password" id="password" name="password" placeholder="Contraseña" required />
          <i class='bx bx-show' id="toggleLoginPassword" style="cursor: pointer;"></i>
        </div>

        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit" class="boton">Iniciar Sesión</button>
        <p class="login-link">¿No tienes una cuenta? <a class="goodhef" href="register.php">Registrarse</a></p>
      </form>   
    </div>
  </div>

  <script>
    const toggleLogin = document.getElementById('toggleLoginPassword');
    const loginPassword = document.getElementById('password');

    toggleLogin?.addEventListener('click', function () {
      const tipo = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      loginPassword.setAttribute('type', tipo);
      this.classList.toggle('bx-show');
      this.classList.toggle('bx-hide');
    });
  </script>

</body>
</html>
