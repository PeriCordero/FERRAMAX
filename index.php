<?php
session_start();

$categorias = [
  'Herramientas manuales',
  'Materiales básicos',
  'Equipos de seguridad',
  'Tornillos y fijaciones',
  'Equipos de medición'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>FERREMAS - Categorías</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .category-btn {
      margin: 0.5rem;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">FERREMAS</a>
    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION["cliente"])): ?>
        <span class="text-white me-3">👤 <?= htmlspecialchars($_SESSION["cliente"]) ?></span>
        <a class="btn btn-outline-light me-2" href="logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="btn btn-outline-light me-2" href="login.php">Iniciar sesión</a>
      <?php endif; ?>
      <a class="btn btn-outline-light" href="carrito.php">🛒 Ver Carrito</a>
    </div>
  </div>
</nav>

<!-- CATEGORÍAS -->
<div class="container my-5">
  <h2 class="mb-4">Explora por Categorías</h2>
  <div class="d-flex flex-wrap">
    <?php foreach ($categorias as $categoria): ?>
      <a href="productos.php?categoria=<?= urlencode($categoria) ?>" class="btn btn-outline-primary category-btn">
        <?= $categoria ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>



<form action="suscribirse.php" method="post" class="my-4">
  <h4>📬 Suscríbete para recibir novedades</h4>
  <div class="input-group">
    <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
    <button type="submit" class="btn btn-primary">Suscribirse</button>
  </div>
</form>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3 mt-5">
  © 2025 FERREMAS. Todos los derechos reservados.
</footer>

</body>
</html>
