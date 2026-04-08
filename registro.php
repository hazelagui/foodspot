<?php
require_once 'includes/data.php';
$titulo = 'Registro';
$rol    = 'publico';

$error = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  $pass   = trim($_POST['password'] ?? '');
  $pass2  = trim($_POST['password2'] ?? '');
  $tipo   = trim($_POST['tipo'] ?? '');

  if(empty($nombre)||empty($email)||empty($pass)||empty($tipo)) {
    $error = 'Todos los campos son obligatorios.';
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'El correo no tiene un formato válido.';
  } elseif(strlen($pass) < 6) {
    $error = 'La contraseña debe tener al menos 6 caracteres.';
  } elseif($pass !== $pass2) {
    $error = 'Las contraseñas no coinciden.';
  } else {
    $success = "¡Cuenta creada con éxito! Bienvenido/a, " . htmlspecialchars($nombre) . ". Podés iniciar sesión ahora.";
  }
}
require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <a href="login.php">Login</a> › <span>Registro</span>
  </div>

  <div style="max-width:520px;margin:0 auto;">
    <div class="panel">
      <div style="text-align:center;margin-bottom:20px;">
        <div style="font-size:40px;margin-bottom:8px;">👤</div>
        <h2 style="margin:0;">Crear cuenta</h2>
        <p class="p" style="margin-top:6px;">Unite a la comunidad FOODSPOT</p>
      </div>

      <?php if($error):   ?><div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>
      <?php if($success): ?><div class="alert alert-success">✅ <?= $success ?> <a href="login.php" style="color:inherit;text-decoration:underline;">Iniciar sesión</a></div><?php endif; ?>

      <?php if(!$success): ?>
      <form class="form" method="POST" action="registro.php">
        <div class="group">
          <label>Nombre completo *</label>
          <input class="input" name="nombre" placeholder="Tu nombre completo"
                 value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required />
        </div>
        <div class="group">
          <label>Correo electrónico *</label>
          <input class="input" type="email" name="email" placeholder="correo@ejemplo.com"
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
        </div>
        <div class="group">
          <label>Contraseña * (mínimo 6 caracteres)</label>
          <input class="input" type="password" name="password" placeholder="••••••••" required />
        </div>
        <div class="group">
          <label>Confirmar contraseña *</label>
          <input class="input" type="password" name="password2" placeholder="••••••••" required />
        </div>
        <div class="group">
          <label>Tipo de cuenta *</label>
          <select class="select" name="tipo" required>
            <option value="">Seleccioná un tipo...</option>
            <option value="usuario"     <?= ($_POST['tipo']??'')==='usuario'     ?'selected':'' ?>>👤 Usuario (explorar y reseñar)</option>
            <option value="propietario" <?= ($_POST['tipo']??'')==='propietario' ?'selected':'' ?>>🏪 Propietario (gestionar restaurante)</option>
          </select>
        </div>
        <div class="group">
          <label>Fecha de nacimiento</label>
          <input class="input" type="date" name="fecha_nac" />
        </div>
        <div class="checks">
          <label><input type="checkbox" name="terminos" required> Acepto los términos y condiciones</label>
        </div>
        <button class="btn btn-primary btn-full" type="submit">Crear cuenta</button>
        <hr>
        <a class="btn btn-full" href="login.php">¿Ya tenés cuenta? Iniciá sesión</a>
      </form>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
