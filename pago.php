<?php
session_start();
if (!isset($_SESSION["cliente"])) {
    header("Location: login.php");
    exit;
}

$carrito = $_SESSION["carrito"] ?? [];

// Obtener productos desde API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/api/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$productos = json_decode($response, true);

// Filtrar productos del carrito
$productosEnCarrito = array_filter($productos, function($producto) use ($carrito) {
    return in_array($producto['ID'], $carrito);
});

// Calcular total
$total = array_sum(array_column($productosEnCarrito, 'PRICE'));
$descuento = isset($_SESSION["cliente"]) ? $total * 0.10 : 0;
$totalFinal = $total - $descuento;

// Si se confirmó el pago
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["carrito"] = [];  // Vaciar carrito
    $confirmado = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago | FERREMAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6f9; }
    .webpay-box {
      max-width: 550px;
      margin: auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .webpay-header {
      background-color: #003087;
      color: white;
      padding: 15px;
      border-radius: 10px 10px 0 0;
      text-align: center;
    }
    .btn-webpay {
      background-color: #ff6c00;
      border: none;
      color: white;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="webpay-box">
    <div class="webpay-header">
      <h4>Confirmar pago (simulado)</h4>
    </div>
    <div class="p-3">
      <?php if (isset($confirmado)): ?>
        <div class="alert alert-success text-center">
          ✅ ¡Gracias por tu compra, <strong><?= htmlspecialchars($_SESSION["cliente"]) ?></strong>!
          <br>Tu pedido fue confirmado con éxito.
        </div>
        <a href="productos.php" class="btn btn-primary w-100">Volver a la tienda</a>
      <?php elseif (empty($productosEnCarrito)): ?>
        <div class="alert alert-warning">Tu carrito está vacío.</div>
        <a href="productos.php" class="btn btn-outline-primary w-100">Ir a productos</a>
      <?php else: ?>
        <p><strong>Resumen del pedido:</strong></p>
        <ul class="list-group mb-3">
          <?php foreach ($productosEnCarrito as $p): ?>
            <li class="list-group-item d-flex justify-content-between">
              <?= $p["NOMBRE_PRODUCTO"] ?>
              <span>$<?= number_format($p["PRICE"], 0, ',', '.') ?></span>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between fw-bold text-success">
            Subtotal:
            <span>$<?= number_format($total, 0, ',', '.') ?></span>
          </li>
          <?php if ($descuento > 0): ?>
          <li class="list-group-item d-flex justify-content-between text-danger">
            Descuento (10% cliente):
            <span>- $<?= number_format($descuento, 0, ',', '.') ?></span>
          </li>
          <?php endif; ?>
          <li class="list-group-item d-flex justify-content-between fw-bold text-primary">
            Total a pagar:
            <span>$<?= number_format($totalFinal, 0, ',', '.') ?></span>
          </li>
        </ul>
        <form method="post">
          <button type="submit" class="btn btn-webpay w-100">✅ Confirmar pago</button>
        </form>
      <?php endif; ?>
      <hr>
      <div class="text-center">
        <a href="carrito.php" class="btn btn-sm btn-outline-secondary">← Volver al carrito</a>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Cerrar sesión</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
