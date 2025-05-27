<?php
session_start();

// Simulación de usuario registrado
$usuario_valido = "admin";
$contrasena_valida = "clave123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = trim($_POST["nombre"]);
  $clave = trim($_POST["clave"]);

  if ($nombre === $usuario_valido && $clave === $contrasena_valida) {
    $_SESSION["cliente"] = $nombre;
    header("Location: index.php");
    exit;
  } else {
    $error = "⚠️ Nombre o contraseña incorrectos.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión | FERREMAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">FERREMAS</a>
  </div>
</nav>

<div class="container my-5" style="max-width: 500px;">
  <h2 class="mb-4">Iniciar sesión</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre de usuario</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
      <label for="clave" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="clave" name="clave" required>
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
  </form>
</div>

</body>
</html>
