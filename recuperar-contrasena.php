<?php
require_once 'includes/data.php';
$titulo = 'Recuperar Contraseña';
$rol    = 'publico';

$paso    = intval($_GET['paso'] ?? 1);
$success = '';
$error   = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if($paso === 1){
    $email = trim($_POST['email'] ?? '');
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error = 'Ingresá un correo electrónico válido.';
    } else {
      header('Location: recuperar-contrasena.php?paso=2&email=' . urlencode($email));
      exit;
    }
  } elseif($paso === 2){
    $codigo = trim($_POST['codigo'] ?? '');
    if($codigo !== '123456'){
      $error = 'Código incorrecto. Usá el código de prueba: 123456';
    } else {
      header('Location: recuperar-contrasena.php?paso=3');
      exit;
    }
  } elseif($paso === 3){
    $nueva  = trim($_POST['nueva'] ?? '');
    $nueva2 = trim($_POST['nueva2'] ?? '');
    if(strlen($nueva) < 6){
      $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif($nueva !== $nueva2){
      $error = 'Las contraseñas no coinciden.';
    } else {
      $success = '¡Contraseña actualizada con éxito! Podés iniciar sesión.';
    }
  }
}

require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <a href="login.php">Login</a> › <span>Recuperar contraseña</span>
  </div>

  <div style="max-width:460px;margin:0 auto;">
    <div class="panel">
      <!-- Pasos -->
      <div style="display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:24px;">
        <?php
        $pasos_labels = ['Correo','Código','Nueva clave'];
        foreach($pasos_labels as $i => $lbl):
          $num = $i + 1;
          $activo  = $num === $paso;
          $done    = $num < $paso;
          $colorBg = $done||$activo ? 'var(--primary)' : 'rgba(255,255,255,.08)';
          $colorTx = $done||$activo ? '#fff' : 'var(--muted)';
        ?>
        <div style="display:flex;align-items:center;gap:0;">
          <div style="width:34px;height:34px;border-radius:50%;background:<?= $colorBg ?>;color:<?= $colorTx ?>;
                      display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;">
            <?= $done ? '✓' : $num ?>
          </div>
          <span style="margin:0 8px;font-size:13px;color:<?= $activo?'var(--text)':'var(--muted)' ?>;font-weight:<?= $activo?'700':'400' ?>;"><?= $lbl ?></span>
          <?php if($num < 3): ?>
            <div style="width:30px;height:2px;background:<?= $num<$paso?'var(--primary)':'rgba(255,255,255,.1)' ?>;margin-right:8px;"></div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if($error):   ?><div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>
      <?php if($success): ?>
        <div class="alert alert-success">✅ <?= $success ?></div>
        <a class="btn btn-primary btn-full" href="login.php">Ir a iniciar sesión</a>
      <?php elseif($paso === 1): ?>
        <div style="text-align:center;margin-bottom:20px;">
          <div style="font-size:36px;margin-bottom:8px;">📧</div>
          <h2 style="margin:0 0 6px;">¿Olvidaste tu contraseña?</h2>
          <p class="p">Ingresá tu correo y te enviaremos un código de recuperación.</p>
        </div>
        <form class="form" method="POST" action="recuperar-contrasena.php?paso=1">
          <div class="group">
            <label>Correo electrónico</label>
            <input class="input" type="email" name="email" placeholder="correo@ejemplo.com" required />
          </div>
          <button class="btn btn-primary btn-full" type="submit">📤 Enviar código</button>
          <a class="btn btn-full" href="login.php">← Volver al login</a>
        </form>

      <?php elseif($paso === 2): ?>
        <div style="text-align:center;margin-bottom:20px;">
          <div style="font-size:36px;margin-bottom:8px;">🔑</div>
          <h2 style="margin:0 0 6px;">Código de verificación</h2>
          <p class="p">Ingresá el código de 6 dígitos enviado a <strong style="color:var(--text);"><?= htmlspecialchars($_GET['email']??'tu correo') ?></strong></p>
          <p class="p" style="font-size:12px;margin-top:6px;">(Demo: usá el código <strong style="color:var(--primary);">123456</strong>)</p>
        </div>
        <form class="form" method="POST" action="recuperar-contrasena.php?paso=2">
          <div class="group">
            <label>Código de 6 dígitos</label>
            <input class="input" name="codigo" maxlength="6" placeholder="123456"
                   style="text-align:center;font-size:24px;font-weight:900;letter-spacing:8px;" required />
          </div>
          <button class="btn btn-primary btn-full" type="submit">✅ Verificar código</button>
          <button class="btn btn-full" type="button" onclick="alert('Código reenviado (visual)')">🔄 Reenviar código</button>
        </form>

      <?php elseif($paso === 3): ?>
        <div style="text-align:center;margin-bottom:20px;">
          <div style="font-size:36px;margin-bottom:8px;">🔒</div>
          <h2 style="margin:0 0 6px;">Nueva contraseña</h2>
          <p class="p">Elegí una contraseña segura para tu cuenta.</p>
        </div>
        <form class="form" method="POST" action="recuperar-contrasena.php?paso=3">
          <div class="group">
            <label>Nueva contraseña *</label>
            <input class="input" type="password" name="nueva" placeholder="Mínimo 6 caracteres" required />
          </div>
          <div class="group">
            <label>Confirmar nueva contraseña *</label>
            <input class="input" type="password" name="nueva2" placeholder="Repetí la contraseña" required />
          </div>
          <button class="btn btn-primary btn-full" type="submit">🔒 Cambiar contraseña</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
