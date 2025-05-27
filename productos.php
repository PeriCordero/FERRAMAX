<?php
session_start();

// 1. Capturar moneda deseada
$currency = isset($_GET['currency']) && $_GET['currency'] === 'usd' ? 'usd' : 'clp';
$currencySymbol = $currency === 'usd' ? 'US$' : '$';

// 2. Agregar producto al carrito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["producto_id"])) {
    $idProducto = intval($_POST["producto_id"]);

    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = [];
    }

    $_SESSION["carrito"][] = $idProducto;

    // Redirigir manteniendo filtros
    $redirect = "productos.php?currency=$currency";
    if (isset($_GET['categoria'])) {
        $redirect .= "&categoria=" . urlencode($_GET['categoria']);
    }
    header("Location: $redirect");
    exit;
}

// 3. Obtener productos desde la API
$categoriaSeleccionada = $_GET["categoria"] ?? null;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/api/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$productos = json_decode($response, true);

// 4. Obtener tipo de cambio si es necesario
$tasaCambio = 1;
if ($currency === 'usd') {
    $apiCambio = file_get_contents("https://api.exchangerate.host/latest?base=CLP&symbols=USD");
    $datosCambio = json_decode($apiCambio, true);
    if (isset($datosCambio["rates"]["USD"])) {
        $tasaCambio = $datosCambio["rates"]["USD"];
    }
}

// 5. Filtrar por categoría
if ($categoriaSeleccionada) {
    $productos = array_filter($productos, function ($producto) use ($categoriaSeleccionada) {
        return isset($producto["CATEGORIA"]) && $producto["CATEGORIA"] === $categoriaSeleccionada;
    });
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos | FERREMAS</title>
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
      <a class="btn btn-outline-light" href="carrito.php">🛒 Ver Carrito</a>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2>Productos <?= $categoriaSeleccionada ? "de " . htmlspecialchars($categoriaSeleccionada) : "" ?></h2>

  <div class="mb-4">
    <span class="me-2">Ver precios en:</span>
    <a href="productos.php?currency=clp<?= $categoriaSeleccionada ? '&categoria=' . urlencode($categoriaSeleccionada) : '' ?>" class="btn btn-sm <?= $currency === 'clp' ? 'btn-primary' : 'btn-outline-primary' ?>">CLP</a>
    <a href="productos.php?currency=usd<?= $categoriaSeleccionada ? '&categoria=' . urlencode($categoriaSeleccionada) : '' ?>" class="btn btn-sm <?= $currency === 'usd' ? 'btn-primary' : 'btn-outline-primary' ?>">USD</a>
  </div>

  <?php if (empty($productos)): ?>
    <div class="alert alert-warning">No hay productos disponibles en esta categoría.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($productos as $producto): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($producto["NOMBRE_PRODUCTO"]) ?></h5>
              <p class="card-text">
                Marca: <?= htmlspecialchars($producto["MARCA"]) ?><br>
                Precio: <?= $currencySymbol ?><?= number_format($producto["PRICE"] * $tasaCambio, 2, ',', '.') ?><br>
                Categoría: <?= htmlspecialchars($producto["CATEGORIA"]) ?>
              </p>
              <form method="post">
                <input type="hidden" name="producto_id" value="<?= $producto["ID"] ?>">
                <button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
