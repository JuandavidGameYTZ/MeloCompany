<!--No tocar-->
<?php
session_start();
require 'conexion.php';
?>

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

<!-- Header -->
<header class="main-header">
  <div class="toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
    <span></span><span></span><span></span>
  </div>

  <!-- Logo -->
  <a href="index.php" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de Melo" />
  </a>

<div class="Buscador">
  <form method="GET" action="index.php" style="display: flex; align-items: center; width: 100%; padding: 5px 10px;">
    <input
      type="search"
      name="busqueda"
      class="buscardor-input"
      placeholder="Buscar autos..."
      value="<?php echo $_GET['busqueda'] ?? ''; ?>"
      title="Buscar autos disponibles"
      aria-label="Buscar autos disponibles"
    />
    <button type="submit" style="background: none; border: none; cursor: pointer;">
      <i class='bx bx-search'></i>
    </button>
  </form>
</div>

 <div class="profile-container">
  <?php if (isset($_SESSION['usuario'])): ?>
    <?php
    $conexion = new mysqli("localhost", "root", "", "melocompany");
    $usuario = $_SESSION['usuario'];
    $sql = "SELECT imagen_perfil FROM registro WHERE Nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $img = $res->fetch_assoc();
    $rutaPorDefecto = "img/Profile_Icon.png";
    $imagenRuta = (!empty($img['imagen_perfil']) && file_exists($img['imagen_perfil'])) ? $img['imagen_perfil'] : $rutaPorDefecto;
    ?>
    <div class="profile-info" style="display: flex; align-items: center; gap: 10px;">
      <img src="<?php echo htmlspecialchars($imagenRuta); ?>" alt="Imagen de perfil" class="profile-icon" />
      <span class="username"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
    </div>
  <?php else: ?>
    <div class="auth-buttons">
      <a href="login.php" class="boton">Iniciar sesión</a>
      <a href="register.php" class="boton">Registrarse</a>
    </div>
  <?php endif; ?>
</div>


  <!-- Menú desplegable -->
  <div id="profile-dropdown" class="profile-dropdown">
    <?php if (isset($_SESSION['usuario'])): ?>
      <a href="profile.php"><i class='bx bx-user'></i> Mi perfil</a>
      <a href="#"><i class='bx bx-car'></i> Autos</a>
      <a href="settings.php"><i class='bx bx-cog'></i> Ajustes</a>
      <a href="logout.php"><i class='bx bx-user-x'></i> Salir</a>
    <?php endif; ?>
  </div>
</header>

<!-- Sidebar -->
<nav class="slidebar" id="sidebar">
  <h1><i class='bx bx-menu'></i> Menú</h1>
  <ul>
    <li><a href="index.php"><i class='bx bx-home'></i> Inicio</a></li>
    <li><a href="ajustes.php"><i class='bx bx-cog'></i> Ajustes</a></li>
    <li><a href="contacto.html"><i class='bx bx-phone'></i> Contacto</a></li>
  </ul>
</nav>

<!-- Main content -->
<main>
  <section class="main-content">
    <h2></h2>
  </section>

  <!-- Resultados de búsqueda -->
  <?php
  if (!empty($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
    $stmt = $conn->prepare("SELECT * FROM autos WHERE nombre LIKE CONCAT('%', ?, '%') ORDER BY fecha_creacion DESC");
    $stmt->bind_param("s", $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<section class='marketplace'>";
    echo "<div class='category'><div class='category-title'>Resultados de búsqueda</div><div class='cards scrollable'>";
    while ($auto = $result->fetch_assoc()) {
      echo "<a href='detalle_auto.php?id={$auto['id']}' class='card'>
              <img src='" . htmlspecialchars($auto['imagen']) . "' alt='Auto'>
              <div class='info'>
                <h3>" . htmlspecialchars($auto['nombre']) . "</h3>
                <p>" . htmlspecialchars($auto['descripcion']) . "</p>
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
      $stmt = $conn->prepare("SELECT * FROM autos WHERE categoria = ? ORDER BY fecha_creacion DESC");
      $stmt->bind_param("s", $cat);
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
              <p><?php echo htmlspecialchars($auto['descripcion']); ?></p>
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
