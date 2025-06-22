<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Auto</title>
  <style>
    body {
      font-family: Arial;
      padding: 20px;
      max-width: 800px;
      margin: auto;
    }
    img {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 10px;
    }
    .price, .stars {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }
  </style>
</head>
<body>
  <h1 id="title">Título</h1>
  <img id="image" src="" alt="Imagen del auto">
  <p id="desc">Descripción</p>
  <span class="price" id="price"></span>
  <span class="stars" id="stars"></span>

  <script>
    const params = new URLSearchParams(window.location.search);
    document.getElementById('title').textContent = params.get('title') || 'Sin título';
    document.getElementById('desc').textContent = params.get('desc') || 'Sin descripción';
    document.getElementById('price').textContent = params.get('price') || '';
    document.getElementById('stars').textContent = '★ ' + (params.get('stars') || '');
    document.getElementById('image').src = params.get('img') || '';
  </script>
</body>
</html>
