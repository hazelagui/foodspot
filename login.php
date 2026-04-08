<?php
require_once 'includes/data.php';
$titulo = 'Iniciar Sesión';
$rol    = 'publico';

// Manejo de POST (simulado)
$error = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = trim($_POST['password'] ?? '');
  if(empty($email) || empty($pass)) {
    $error = 'Por favor completá todos los campos.';
  } else {
    // Simulación: cualquier credencial válida redirige según rol
    $roles_demo = [
      'usuario@test.com'      => ['perfil.php',              'Usuario'],
      'propietario@test.com'  => ['dashboard-propietario.php','Propietario'],
      'creador@test.com'      => ['dashboard-creador.php',   'Creador'],
      'admin@test.com'        => ['dashboard-admin.php',     'Administrador'],
    ];
    if(isset($roles_demo[$email])) {
      header('Location: ' . $roles_demo[$email][0]);
      exit;
    } else {
      // Login genérico: va a perfil
      header('Location: perfil.php');
      exit;
    }
  }
}
require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <span>Iniciar sesión</span>
  </div>

  <div style="max-width:480px;margin:0 auto;">
    <div class="panel">
      <div style="text-align:center;margin-bottom:20px;">
        <div style="font-size:40px;margin-bottom:8px;">🍽️</div>
        <h2 style="margin:0;">Iniciar sesión</h2>
        <p class="p" style="margin-top:6px;">Accedé a tu cuenta FOODSPOT</p>
      </div>

      <?php if($error): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="alert alert-info" style="font-size:12px;margin-bottom:16px;">
        💡 Demo: usuario@test.com / propietario@test.com / creador@test.com / admin@test.com (cualquier contraseña)
      </div>

      <form class="form" method="POST" action="login.php">
        <div class="group">
          <label for="email">Correo electrónico</label>
          <input class="input" type="email" id="email" name="email"
                 placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
        </div>
        <div class="group">
          <label for="password">Contraseña</label>
          <input class="input" type="password" id="password" name="password" placeholder="••••••••" required />
        </div>
        <div style="display:flex;justify-content:flex-end;">
          <a href="recuperar-contrasena.php" style="color:var(--primary);font-size:13px;">¿Olvidaste tu contraseña?</a>
        </div>
        <button class="btn btn-primary btn-full" type="submit">Ingresar</button>
        <hr>
        <a class="btn btn-full" href="registro.php">¿No tenés cuenta? Registrate</a>
      </form>
    </div>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
