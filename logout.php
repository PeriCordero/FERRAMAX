<?php
session_start();
session_destroy(); // Elimina toda la sesión
header("Location: index.php"); // Redirige a la página principal
exit;
