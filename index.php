<!--No tocar-->
<?php
session_start();
require 'conexion.php';
?>

$usuario = $_SESSION['usuario'] ?? '';


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Renta de autos</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/MeloIcon.png" type="image/png" />
</head>

<body>

<?php include 'header.php'; ?>

<!-- Main content -->
<main>
  <section class="main-content">
    <h2></h2>
  </section>

  <!-- Resultados de búsqueda -->
  <?php
if (!empty($_GET['busqueda'])) {
  $busqueda = $_GET['busqueda'];
  $stmt = $conn->prepare("SELECT * FROM autos WHERE nombre LIKE CONCAT('%', ?, '%') AND (oculto = 0 OR usuario = ?) ORDER BY fecha_creacion DESC");
  $stmt->bind_param("ss", $busqueda, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<section class='marketplace'>";
    echo "<div class='category'><div class='category-title'>Resultados de búsqueda</div><div class='cards scrollable'>";
    while ($auto = $result->fetch_assoc()) {
      echo "<a href='detalle_auto.php?id={$auto['id']}' class='card'>
              <img src='" . htmlspecialchars($auto['imagen']) . "' alt='Auto'>
              <div class='info'>
                <h3>" . htmlspecialchars($auto['nombre']) . "</h3>
                <p>" . htmlspecialchars($auto['ubicacion']) . "</p>
                <span class='price'>" . htmlspecialchars($auto['precio']) . "</span>
                <span class='stars'><i class='bx bxs-star'></i> {$auto['estrellas']}</span>
              </div>
            </a>";
    }
    echo "</div></div></section>";
  }
  ?>

  <!-- Autos por categoría -->
  <section class="marketplace">
    <?php
    $categorias = ["Eléctrico", "SUV", "4x4", "Deportivo", "Económico", "Premium", "Clásico", "Camioneta", "Taxi", "General"];
    foreach ($categorias as $cat):
$stmt = $conn->prepare("SELECT * FROM autos WHERE categoria = ? AND (oculto = 0 OR usuario = ?) ORDER BY fecha_creacion DESC");
$stmt->bind_param("ss", $cat, $usuario);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows > 0):
    ?>
    <div class="category" id="<?php echo strtolower($cat); ?>">
      <div class="category-title"><?php echo htmlspecialchars($cat); ?></div>
      <div class="carousel-wrapper">
        <button class="scroll-btn left" onclick="scrollLeftBtn('scroll-<?php echo $cat; ?>')"><i class='bx bx-caret-left'></i></button>
        <div class="cards scrollable" id="scroll-<?php echo $cat; ?>">
          <?php while ($auto = $res->fetch_assoc()): ?>
          <a href="detalle_auto.php?id=<?php echo $auto['id']; ?>" class="card">
            <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="<?php echo htmlspecialchars($auto['nombre']); ?>">
            <div class="info">
              <h3><?php echo htmlspecialchars($auto['nombre']); ?></h3>
              <p><?php echo htmlspecialchars($auto['ubicacion']); ?></p>
              <span class="price"><?php echo htmlspecialchars($auto['precio']); ?></span>
              <span class="stars"><i class='bx bxs-star'></i> <?php echo $auto['estrellas']; ?></span>
            </div>
          </a>
          <?php endwhile; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollRightBtn('scroll-<?php echo $cat; ?>')"><i class='bx bx-caret-right'></i></button>
      </div>
    </div>
    <?php endif; endforeach; ?>
  </section>
</main>


<!-- JS -->
<script src="js/script.js"></script>

</body>
</html>
