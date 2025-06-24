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

<!--Logo-->
<header class="register-header">
  <a href="index.php" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de melo" />
  </a>
</header>    

<div class="wrapper">
  <h2>Agregar Auto para Rentar</h2>
  <form action="guardar_auto.php" method="POST" enctype="multipart/form-data">
    
    <label for="nombre">Nombre del auto:</label>
    <div class="input-container">
      <input type="text" id="nombre" name="nombre" placeholder="Ej: Toyota Corolla" required>
    </div>
    
    <label for="descripcion">Descripción:</label>
    <div class="input-container">
      <textarea id="descripcion" name="descripcion" placeholder="Descripción detallada..." required></textarea>
    </div>
    
    <label for="precio">Precio (ej. $7/hora):</label>
    <div class="input-container">
      <input type="text" id="precio" name="precio" placeholder="$7/hora" required>
    </div>
    
    <label for="estrellas">Valoración (1-5):</label>
    <div class="input-container">
      <input type="number" id="estrellas" name="estrellas" min="1" max="5" value="5">
    </div>

    <label for="categoria">Categoría:</label>
    <div class="input-container">
      <select id="categoria" name="categoria" required>
        <option value="Eléctrico">Eléctrico</option>
        <option value="SUV">SUV</option>
        <option value="4x4">4x4</option>
        <option value="Deportivo">Deportivo</option>
        <option value="Económico">Económico</option>
        <option value="Premium">Premium</option>
        <option value="Clásico">Clásico</option>
        <option value="Camioneta">Camioneta</option>
        <option value="Taxi">Taxi</option>
        <option value="General">General</option>
      </select>
    </div>

    <label for="ubicacion">Ubicación:</label>
    <div class="input-container">
      <input type="text" id="ubicacion" name="ubicacion" placeholder="Ej: Av. 27 de Febrero, Santo Domingo" required>
    </div>

    <label for="imagen">Imagen del auto:</label>
    <div class="input-container">
      <input type="file" id="imagen" name="imagen" accept="image/*" required>
    </div>
    
    <input type="submit" value="Agregar Auto">
  </form>
</div>

</body>
</html>

