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
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de cuenta</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f2f2f2; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; }
        .mensaje { margin-bottom: 15px; color: #333; font-weight: bold; }
    </style>
</head>
<body>

<h2>Crear Cuenta</h2>

<?php if (!empty($mensaje)): ?>
    <div class="mensaje"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" action="registro.php">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="email" name="correo" placeholder="Correo electrónico" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
</form>

</body>
</html>