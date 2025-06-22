<?php
session_start();
require 'conexion.php'; // Asegúrate de que este archivo conecta correctamente

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Verifica que el archivo haya sido subido correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['fondo'])) {
    $nombreArchivo = $_FILES['fondo']['name'];
    $rutaTemporal = $_FILES['fondo']['tmp_name'];

    $directorio = "img/perfiles/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Ruta final del archivo
    $rutaFinal = $directorio . "fondo_" . $usuario . "_" . basename($nombreArchivo);

    // Mover el archivo a la carpeta
    if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
        // Actualizar la ruta en la base de datos
        $stmt = $conn->prepare("UPDATE registro SET imagen_fondo = ? WHERE Nombre = ?");
        $stmt->bind_param("ss", $rutaFinal, $usuario);
        $stmt->execute();
        $stmt->close();

        header("Location: profile.php");
        exit();
    } else {
        echo "No se pudo subir la imagen de fondo.";
    }
} else {
    echo "No se recibió ninguna imagen.";
}
?>
