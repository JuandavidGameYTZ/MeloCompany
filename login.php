<!--No tocar-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Melo - Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="img/MeloIcon.png" type="image/png" />

</head>
<body>

  <!--Logo-->
  <header class="register-header">
    <a href="index.html" class="logo-link" aria-label="Melo Logo">
      <img src="img/MeloFrontPagetext.png" alt="Melo Logo" class="titulo-img" title="La página principal de Melo" />
    </a>
  </header>    

  <div class="container">
    <div class="wrapper"> 
      <form action="">
        <h1>Iniciar Sesión</h1>

        <div class="input-container">
          <input type="email" id="email" name="email" placeholder="Correo electrónico" required />
          <i class='bx bx-envelope-alt'></i>
        </div>

        <div class="input-container">
          <input type="password" id="password" name="password" placeholder="Contraseña" required />
          <i class='bx bx-lock'></i> 
        </div>

        <button type="submit" class="boton">Iniciar Sesión</button>

        <p class="login-link">¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>
      </form>   
    </div>
  </div>

</body>
</html>
