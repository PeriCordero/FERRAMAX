<?php
session_start();

$currency = isset($_GET['currency']) && $_GET['currency'] === 'usd' ? 'usd' : 'clp';
$currencySymbol = $currency === 'usd' ? 'US$' : '$';

// Obtener tipo de cambio si es USD
$tasaCambio = 1;
if ($currency === 'usd') {
    $cambio = file_get_contents("https://api.exchangerate.host/latest?base=CLP&symbols=USD");
    $dataCambio = json_decode($cambio, true);
    if (isset($dataCambio["rates"]["USD"])) {
        $tasaCambio = $dataCambio["rates"]["USD"];
    }
}

// Obtener productos desde la API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/api/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$productos = json_decode($response, true);

$carrito = $_SESSION['carrito'] ?? [];

if (isset($_GET['remove'])) {
  $idEliminar = intval($_GET['remove']);
  $_SESSION['carrito'] = array_diff($carrito, [$idEliminar]);
  header("Location: carrito.php?currency=$currency");
  exit;
}

$productosEnCarrito = array_filter($productos, function($p) use ($carrito) {
  return in_array($p['ID'], $carrito);
});

$total = array_sum(array_map(function ($p) use ($tasaCambio) {
  return $p['PRICE'] * $tasaCambio;
}, $productosEnCarrito));

$descuento = isset($_SESSION["cliente"]) ? $total * 0.10 : 0;
$totalFinal = $total - $descuento;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de compras | FERREMAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">FERREMAS</a>
    <div class="d-flex align-items-center">
      <?php if (isset($_SESSION["cliente"])): ?>
        <span class="text-white me-3">👤 <?= htmlspecialchars($_SESSION["cliente"]) ?></span>
        <a class="btn btn-outline-light me-3" href="logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="btn btn-outline-light me-3" href="login.php">Iniciar sesión</a>
      <?php endif; ?>
      <a class="btn btn-outline-light" href="carrito.php?currency=<?= $currency ?>">🛒 Ver Carrito</a>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2>🛒 Carrito de compras</h2>

  <?php if (empty($productosEnCarrito)): ?>
    <p>No tienes productos en tu carrito.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Marca</th>
          <th>Precio</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productosEnCarrito as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p["NOMBRE_PRODUCTO"]) ?></td>
          <td><?= htmlspecialchars($p["MARCA"]) ?></td>
          <td><?= $currencySymbol ?><?= number_format($p["PRICE"] * $tasaCambio, 2, ',', '.') ?></td>
          <td><a href="carrito.php?remove=<?= $p["ID"] ?>&currency=<?= $currency ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-end">
      <h4>Total: <?= $currencySymbol ?><?= number_format($total, 2, ',', '.') ?></h4>
      <?php if ($descuento > 0): ?>
        <p class="text-success">Descuento 10% aplicado: -<?= $currencySymbol ?><?= number_format($descuento, 2, ',', '.') ?></p>
        <h4><strong>Total final: <?= $currencySymbol ?><?= number_format($totalFinal, 2, ',', '.') ?></strong></h4>
      <?php endif; ?>
      <a href="pago.php?currency=<?= $currency ?>" class="btn btn-primary mt-3">Proceder al pago</a>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
