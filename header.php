<?php
if (!isset($_SESSION)) session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conexion.php';
?>

<!-- Header -->
<header class="main-header">
  <div class="toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
    <span></span><span></span><span></span>
  </div>

  <!-- Logo -->
  <a href="index.php" class="logo-link" aria-label="Melo Logo">
    <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de Melo" />
  </a>

    
<!-- Buscador -->
<div class="Buscador">
  <form method="GET" action="index.php" style="display: flex; flex-direction: column; width: 100%; padding: 5px 10px; position: relative;">
    <div style="display: flex; align-items: center;">
      <input
        type="search"
        name="busqueda"
        class="buscardor-input"
        placeholder="Buscar autos..."
        title="Buscar autos disponibles"
        aria-label="Buscar autos disponibles"
        autocomplete="off"
        id="busquedaInput"
      />
      <button type="submit" style="background: none; border: none; cursor: pointer;">
        <i class='bx bx-search'></i>
      </button>
    </div>
    <ul id="sugerencias" class="sugerencias-lista"></ul>
  </form>
</div>



  <!-- Botón para agregar auto -->
          <a href="agregar_auto.php" class="boton"><i class='bx  bx-plus'  ></i> Agregar Auto a rentar</a>
   

  <!-- Perfil -->
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
      <a href="settings.php"><i class='bx bx-cog'></i> Ajustes</a>
      <a href="contacto.php"><i class='bx  bx-message-dots'  ></i> Contactos</a>
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
