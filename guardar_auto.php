<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_SESSION['usuario'];
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $estrellas = intval($_POST['estrellas'] ?? 5);
    $categoria = $_POST['categoria'] ?? 'General';

    // Manejar la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $directorio = "img/autos/";
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);

        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $rutaFinal = $directorio . $usuario . "_" . time() . "_" . $nombreArchivo;

        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
            // Guardar en la base de datos con categoría incluida
            $stmt = $conn->prepare("INSERT INTO autos (usuario, nombre, descripcion, precio, estrellas, imagen, categoria) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssdss", $usuario, $nombre, $descripcion, $precio, $estrellas, $rutaFinal, $categoria);
            
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: profile.php");
                exit();
            } else {
                echo "Error al guardar el auto en la base de datos.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se subió ninguna imagen o hubo un error.";
    }
} else {
    echo "Método no permitido.";
}
?>
