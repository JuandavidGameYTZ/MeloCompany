<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Añade tu contraseña si tienes
$basedatos = "Melocompany";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["name"]);
    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

    if (!empty($nombre) && !empty($correo) && !empty($clave)) {

        // Verificar si el nombre o el correo ya existen
        $verificar_sql = "SELECT * FROM registro WHERE nombre = ? OR correoelectronico = ?";
        $stmt_verificar = $conn->prepare($verificar_sql);
        $stmt_verificar->bind_param("ss", $nombre, $correo);
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "⚠️ El nombre o el correo ya están registrados.";
        } else {
            // Encriptar y guardar
            $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

            $sql = "INSERT INTO registro (nombre, correoelectronico, contrasena) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $clave_segura);

            if ($stmt->execute()) {
                $_SESSION['usuario'] = $nombre;
                header("Location: index.php");
                exit();
            } else {
                $mensaje = "❌ Error al registrar: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmt_verificar->close();
    } else {
        $mensaje = "⚠️ Por favor, completa todos los campos.";
    }
}

$conn->close();
?>



<!--No tocar-->
<!DOCTYPE html>
<html lang="es">
<head>
 
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Registrarse</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="icon" href="img/MeloIcon.png" type="image/png" />

</head>

<body>

    <!--Logo-->
<header class="register-header">

       <!--Logo-->
     <a href="index.php" class="logo-link" aria-label="Melo Logo">
     
        <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de melo" />
        </a>
</header>    


<div class="container">


<div class="wrapper"> 

<form method="POST" action="">

    <h1>Registrarse</h1>
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

  <div>

      <button type="submit" class="boton">Registrarse</button>

  </div>

    </div>
</form>
        <p class="login-link">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>


    


</div>
</div>
<script>
  const toggleLogin = document.getElementById('toggleLoginPassword');
  const loginPassword = document.getElementById('password');

  toggleLogin.addEventListener('click', function () {
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
    