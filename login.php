<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Coloca tu contraseña si tienes
$basedatos = "Melocompany";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

    // Buscar el usuario por correo
    $sql = "SELECT ID_Registro, Nombre, Contrasena FROM registro WHERE CorreoElectronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($clave, $usuario["Contrasena"])) {
            $_SESSION['usuario'] = $usuario["Nombre"];
            $_SESSION['id'] = $usuario["ID_Registro"];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Correo no encontrado.'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>



<!--No tocar-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="img/MeloIcon.png" type="image/png" />

</head>
<body>

  <!--Logo-->
  <header class="register-header">
    <a href="index.php" class="logo-link" aria-label="Melo Logo">
      <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La página principal de Melo" />
    </a>
  </header>    

  <div class="container">
    <div class="wrapper"> 
<form method="POST" action="login.php">
        <h1>Iniciar Sesión</h1>

        <div class="input-container">
          <input type="email" id="email" name="email" placeholder="Correo electrónico" required />
          <i class='bx bx-envelope-alt'></i>
        </div>

        <div class="input-container">
          <input type="password" id="password" name="password" placeholder="Contraseña" required />
          <i class='bx bx-lock'></i> 
        </div>

        <button type="submit" class="boton">Iniciar Sesión</button>

        <p class="login-link">¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>
      </form>   
    </div>
  </div>

</body>
</html>
