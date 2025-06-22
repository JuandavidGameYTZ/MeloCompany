<!--No tocar-->
<?php
session_start();
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

  <!--Menu-->
  <header class="main-header">
    <div class="toggle" id="menu-toggle" aria-label="Toggle menu" role="button" tabindex="0">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!--Logo-->
    <a href="index.php" class="logo-link" aria-label="Melo Logo">
      <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La pagina principal de Melo" />
    </a>

    <!--Buscador-->
    <div class="Buscador">
      <input
        type="search"
        id="search-input"
        class="buscardor-input"
        placeholder="Buscar autos..."
        title="Buscar autos disponibles"
        aria-label="Buscar autos disponibles"
        aria-describedby="search-button"
      />
      <i class='bx bx-search'></i>
    </div>

<!-- Profile Icon -->
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

    // Usar directamente la ruta si ya está guardada completa
    if (!empty($img['imagen_perfil']) && file_exists($img['imagen_perfil'])) {
      $imagenRuta = $img['imagen_perfil'];
    } else {
      $imagenRuta = $rutaPorDefecto;
    }
    ?>

    <div class="profile-info" style="display: flex; align-items: center; gap: 10px;">
      <img src="<?php echo htmlspecialchars($imagenRuta); ?>" alt="Imagen de perfil" class="profile-icon" id="profile-icon" />
      <span class="username"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
    </div>
  <?php else: ?>
    <div class="auth-buttons">
      <a href="login.php" class="boton">Iniciar sesión</a>
      <a href="register.php" class="boton">Registrarse</a>
    </div>
  <?php endif; ?>
</div>


    <div id="profile-dropdown" class="profile-dropdown">
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="profile.php"><i class='bx bx-user-circle'></i> Mi perfil</a>
        <a href="#"><i class='bx bx-car'></i> Autos</a>
        <a href="settings.php"><i class='bx bx-cog'></i> Ajustes</a>
        <a href="logout.php"><i class='bx bx-arrow-out-left-square-half'></i> Salir</a>
      <?php endif; ?>
    </div>

  </header>


    <!--Sidebar-->
<nav class="slidebar" id="sidebar">
  <h1><i class='bx bx-menu'></i> Menú</h1>
  <ul>
    <li>
      <a href="index.php"><i class='bx bx-home'></i> Inicio</a>
    </li>
    <li>
      <a href="ajustes.php"><i class='bx bx-cog'></i> Ajustes</a>
    </li>

 
    <li>
      <a href="contacto.html"><i class='bx bx-phone'></i> Contacto</a>
    </li>
  </ul>
</nav>



    <!--Contenido principal-->

  <main>
    <section class="main-content">
      <h2></h2>

      
    </section>

<!-- Marketplace -->
<section class="marketplace">
  <h2></h2>

  <!-- Categoria 1: Eléctricos -->
  <div class="category" id="Electricos">
    <div class="category-title">Eléctricos</div>
    <div class="carousel-wrapper">
      <button class="scroll-btn left" onclick="scrollLeftBtn('electricos-scroll')"><i class='bx  bx-caret-left' ></i></button>
      <div class="cards scrollable" id="electricos-scroll">


<a href="carprofile.html" class="card" onclick="openDetail(event, 'Eco Compact A', 'Pequeño y ágil, ideal para el tráfico urbano.', '$7/hora', '5', 'img/Carplaceholder.png')">
  <img src="img/Carplaceholder.png" alt="Eco Compact A">
  <div class="info">
    <h3>Eco test  A</h3>
    <p>Pequeño y ágil, ideal para el tráfico urbano.</p>
    <span class="price">$7/hora</span>
    <span class="stars"><i class='bx  bxs-star'></i> 5 </span>
  </div>
</a>



        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Eco Compact A">
          <div class="info">
            <h3>Eco Compact A</h3>
            <p>Pequeño y ágil, ideal para el tráfico urbano.</p>
            <span class="price">$7/hora</span>
            <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Electro City B">
          <div class="info">
            <h3>Electro City B</h3>
            <p>Batería duradera y diseño moderno.</p>
            <span class="price">$9/hora</span>
            <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Volt Runner C">
          <div class="info">
            <h3>Volt Runner C</h3>
            <p>Perfecto para viajes cortos en la ciudad.</p>
            <span class="price">$8/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 4 </span>

          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="NeoDrive D">
          <div class="info">
            <h3>NeoDrive D</h3>
            <p>Comodidad, estilo y cero emisiones.</p>
            <span class="price">$10/hora</span>
            <span class="stars"><i class='bx  bxs-star'  ></i> 3.5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Urban Spark E">
          <div class="info">
            <h3>Urban Spark E</h3>
            <p>Silencioso y económico para la ciudad.</p>
            <span class="price">$8/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="GreenMotion F">
          <div class="info">
            <h3>GreenMotion F</h3>
            <p>Eficiencia energética con buen espacio.</p>
            <span class="price">$9/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Mini EV G">
          <div class="info">
            <h3>Mini EV G</h3>
            <p>Tamaño compacto, gran desempeño.</p>
            <span class="price">$7/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>

          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Silent Cruiser H">
          <div class="info">
            <h3>Silent Cruiser H</h3>
            <p>Conducción suave con carga rápida.</p>
            <span class="price">$10/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>

          </div>
        </a>

      </div>
      <button class="scroll-btn right" onclick="scrollRightBtn('electricos-scroll')"><i class='bx  bx-caret-right'></i></button>
    </div>
  </div>

  <!-- Categoria 2: SUVs -->
  <div class="category" id="SUV">
    <div class="category-title">SUVs</div>
    <div class="carousel-wrapper">
      <button class="scroll-btn left" onclick="scrollLeftBtn('suv-scroll')"><i class='bx  bx-caret-left'  ></i></button>
      <div class="cards scrollable" id="suv-scroll">

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="SUV Familiar">
          <div class="info">
            <h3>SUV Familiar</h3>
            <p>Espacio para toda la familia y equipaje.</p>
            <span class="price">$18/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>

          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Explorer X">
          <div class="info">
            <h3>Explorer X</h3>
            <p>Conquista cualquier terreno con facilidad.</p>
            <span class="price">$20/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Mountain Drive">
          <div class="info">
            <h3>Mountain Drive</h3>
            <p>Aventura y potencia en cada viaje.</p>
            <span class="price">$22/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Safari Pro">
          <div class="info">
            <h3>Safari Pro</h3>
            <p>Ideal para caminos largos y difíciles.</p>
            <span class="price">$21/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Urban Trail">
          <div class="info">
            <h3>Urban Trail</h3>
            <p>Diseño moderno y tracción total.</p>
            <span class="price">$19/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Family Wagon">
          <div class="info">
            <h3>Family Wagon</h3>
            <p>Seguridad y confort para los niños.</p>
            <span class="price">$18/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="AllRoad Max">
          <div class="info">
            <h3>AllRoad Max</h3>
            <p>Versatilidad para ciudad y campo.</p>
            <span class="price">$21/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Venture Z">
          <div class="info">
            <h3>Venture Z</h3>
            <p>Potente, elegante y espacioso.</p>
            <span class="price">$23/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

      </div>
      <button class="scroll-btn right" onclick="scrollRightBtn('suv-scroll')"><i class='bx  bx-caret-right'></i></button>
    </div>
  </div>

  <!-- Categoria 3: Premium -->
  <div class="category" id="Premium">
    <div class="category-title">Carros Premium</div>
    <div class="carousel-wrapper">
      <button class="scroll-btn left" onclick="scrollLeftBtn('premium-scroll')"><i class='bx  bx-caret-left'  ></i></button>
      <div class="cards scrollable" id="premium-scroll">

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Sedán de Lujo">
          <div class="info">
            <h3>Sedán de Lujo</h3>
            <p>Viaja con estilo y confort premium.</p>
            <span class="price">$28/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Executive Drive">
          <div class="info">
            <h3>Executive Drive</h3>
            <p>Elegancia y tecnología de punta.</p>
            <span class="price">$30/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Elite Cruiser">
          <div class="info">
            <h3>Elite Cruiser</h3>
            <p>Experiencia de manejo superior.</p>
            <span class="price">$32/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Luxury Star">
          <div class="info">
            <h3>Luxury Star</h3>
            <p>Diseño sofisticado y acabados de lujo.</p>
            <span class="price">$35/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Royal Sedan">
          <div class="info">
            <h3>Royal Sedan</h3>
            <p>Clase y exclusividad en cada curva.</p>
            <span class="price">$33/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Platinum Ride">
          <div class="info">
            <h3>Platinum Ride</h3>
            <p>Conducción suave con detalles premium.</p>
            <span class="price">$34/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Zenith X">
          <div class="info">
            <h3>Zenith X</h3>
            <p>Lo mejor de la ingeniería automotriz.</p>
            <span class="price">$36/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

        <a href="#" class="card">
          <img src="img/Carplaceholder.png" alt="Infinity GT">
          <div class="info">
            <h3>Infinity GT</h3>
            <p>Potencia, lujo y presencia en la carretera.</p>
            <span class="price">$38/hora</span>
                        <span class="stars"><i class='bx  bxs-star'  ></i> 5 </span>
          </div>
        </a>

      </div>
      <button class="scroll-btn right" onclick="scrollRightBtn('premium-scroll')"><i class='bx  bx-caret-right'  ></i> </i> </button>
    </div>
  </div>
</section>

    <!--Footer-->
  <script src="js/script.js"></script>


</body>
</html>

