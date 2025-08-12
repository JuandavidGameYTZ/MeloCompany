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
<meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
  <title>Agregar Auto</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</head>
<body>

<?php include 'header.php'; ?>


<div class="wrapper">
  <h2>Agregar Auto para Rentar</h2>
  <form action="guardar_auto.php" method="POST" enctype="multipart/form-data">
    
    <label for="nombre">Nombre del auto:</label>
    <div class="input-container">
      <input type="text" id="nombre" name="nombre" placeholder="Ej: Toyota Corolla" required>
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
    
    <label for="precio">Precio (ej. $7/hora):</label>
    <div class="input-container">
      <input type="" id="number" name="precio" placeholder="$7/hora" required>
    </div>


<label for="ubicacion">Ubicación:</label>
<div class="input-container">
  <input type="text" id="ubicacion" name="ubicacion" placeholder="Haz clic en el mapa para seleccionar ubicación" required readonly>
</div>
<div id="mapa" style="height: 400px; width: 100%; border-radius: 10px; margin-top: 10px;"></div>


    <label for="descripcion">Descripción:</label>
    <div class="input-container">
      <textarea id="descripcion" name="descripcion" placeholder="Descripción detallada del veiculo" required></textarea>
    </div>

    <label for="imagen">Imagen del auto:</label>
    <div class="input-container">
      <input type="file" id="imagen" name="imagen" accept="image/*" required>
    </div>
    
    <input type="submit" value="Agregar Auto">
  </form>
</div>

</body>
<script src="js/script.js"></script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const centro = [18.4861, -69.9312]; 

    const mapa = L.map("mapa").setView(centro, 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "© OpenStreetMap",
    }).addTo(mapa);

    let marcador = L.marker(centro, { draggable: true }).addTo(mapa);

    mapa.on("click", function (e) {
      marcador.setLatLng(e.latlng);
      obtenerDireccion(e.latlng);
    });

    marcador.on("dragend", function () {
      obtenerDireccion(marcador.getLatLng());
    });

    function obtenerDireccion(latlng) {
      const lat = latlng.lat;
      const lng = latlng.lng;

      fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
          const direccion = data.display_name || `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
          document.getElementById("ubicacion").value = direccion;
        })
        .catch(error => {
          console.error("Error al obtener dirección:", error);
          document.getElementById("ubicacion").value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        });
    }

    // Inicializa con dirección desde centro
    obtenerDireccion({ lat: centro[0], lng: centro[1] });
  });
</script>
</html>