<?php
// Conexión a MySQL
$conn = new mysqli("localhost", "root", "", "ferramax");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener suscripciones
$result = $conn->query("SELECT ID, EMAIL, FECHA_SUSCRIPCION FROM SUSCRIPCIONES ORDER BY FECHA_SUSCRIPCION DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Suscripciones | FERREMAS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h2>📋 Lista de correos suscritos</h2>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Fecha de suscripción</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row["ID"] ?></td>
            <td><?= htmlspecialchars($row["EMAIL"]) ?></td>
            <td><?= $row["FECHA_SUSCRIPCION"] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">No hay suscripciones aún.</div>
  <?php endif; ?>

  <a href="index.php" class="btn btn-secondary mt-3">Volver al inicio</a>
</div>
</body>
</html>

<?php $conn->close(); ?>
