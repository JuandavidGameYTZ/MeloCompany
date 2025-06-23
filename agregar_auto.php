<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Auto</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<h2>Agregar Auto para Rentar</h2>

<form action="guardar_auto.php" method="POST" enctype="multipart/form-data">
  <label for="nombre">Nombre del auto:</label><br>
  <input type="text" id="nombre" name="nombre" required><br><br>

  <label for="descripcion">Descripción:</label><br>
  <textarea id="descripcion" name="descripcion" rows="4" required></textarea><br><br>

  <label for="precio">Precio (ej. $7/hora):</label><br>
  <input type="text" id="precio" name="precio" required><br><br>

  <label for="estrellas">Valoración (1-5):</label><br>
  <input type="number" id="estrellas" name="estrellas" min="1" max="5" value="5"><br><br>

  <label for="imagen">Imagen del auto:</label><br>
  <input type="file" id="imagen" name="imagen" accept="image/*" required><br><br>

  <input type="submit" value="Agregar Auto">
</form>

</body>
</html>
