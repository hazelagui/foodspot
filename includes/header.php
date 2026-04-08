<?php
// includes/header.php
// Parámetros: $titulo (string), $rol (string: publico|usuario|propietario|creador|admin)
$titulo_pagina = isset($titulo) ? "FOODSPOT | $titulo" : "FOODSPOT";
$rol_actual = isset($rol) ? $rol : 'publico';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($titulo_pagina) ?></title>
  <link rel="stylesheet" href="css/styles.css" />
  <?php if(isset($estilos_extra)) echo $estilos_extra; ?>
</head>
<body>
  <header class="nav">
    <div class="container nav-inner">
      <a class="brand" href="index.php">
        <span class="logo-icon">🍽️</span>
        <span>FOODSPOT</span>
      </a>
      <nav class="nav-links">
        <a href="index.php">Inicio</a>
        <a href="catalogo.php">Catálogo</a>
        <a href="busqueda.php">🔍 Buscar</a>
        <a href="mapa.php">Mapa de Restaurantes</a>

        <?php if($rol_actual === 'publico'): ?>
          <a href="login.php">Iniciar sesión</a>
          <a class="btn btn-primary" href="registro.php">Registrarse</a>

        <?php elseif($rol_actual === 'usuario'): ?>
          <a href="notificaciones.php">🔔</a>
          <a href="favoritos.php">❤️ Favoritos</a>
          <a href="perfil.php">👤 Mi Perfil</a>
          <a class="btn" href="login.php">Salir</a>

        <?php elseif($rol_actual === 'propietario'): ?>
          <a href="notificaciones.php">🔔</a>
          <a class="btn btn-primary" href="dashboard-propietario.php">⚙️ Mi Panel</a>
          <a class="btn" href="login.php">Salir</a>

        <?php elseif($rol_actual === 'creador'): ?>
          <a href="notificaciones.php">🔔</a>
          <a class="btn btn-primary" href="dashboard-creador.php">⭐ Panel Creador</a>
          <a class="btn" href="login.php">Salir</a>

        <?php elseif($rol_actual === 'admin'): ?>
          <a href="notificaciones.php">🔔</a>
          <a class="btn btn-primary" href="dashboard-admin.php">🛡️ Admin</a>
          <a class="btn" href="login.php">Salir</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
