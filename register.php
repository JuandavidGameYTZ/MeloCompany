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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["name"]);
    $correo = trim($_POST["email"]);
    $clave = $_POST["password"];

    if (!empty($nombre) && !empty($correo) && !empty($clave)) {
        // Verificar si el correo ya existe
        $check_sql = "SELECT ID_Registro FROM registro WHERE CorreoElectronico = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $correo);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "<script>alert('Este correo electrónico ya está registrado. Intenta iniciar sesión o usar otro.'); window.location.href = 'register.php';</script>";
        } else {
            // Insertar nuevo usuario
            $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

            $sql = "INSERT INTO registro (Nombre, CorreoElectronico, Contrasena) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $clave_segura);

            if ($stmt->execute()) {
                $_SESSION['usuario'] = $nombre;
                header("Location: index.php");
                exit();
            } else {
                echo "Error al registrar: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    } else {
        echo "Por favor, completa todos los campos.";
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
    <div class="input-container">
        <input type="text" name="name" placeholder="Nombre" required />
        <i class='bx bx-user-id-card'></i>
    </div>
    <div class="input-container">
        <input type="email" name="email" placeholder="Correo electrónico" required />
        <i class='bx bx-envelope-alt'></i>
    </div>
    <div class="input-container">
        <input type="password" name="password" placeholder="Contraseña" required />
        <i class='bx bx-lock'></i>
    </div>
    <button type="submit" class="boton">Registrarse</button>
</form>
        <p class="login-link">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>


    </form>

    


</div>
</div>
</body>





</html>
    