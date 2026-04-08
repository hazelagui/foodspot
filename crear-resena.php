<?php
require_once 'includes/data.php';
$titulo = 'Crear Reseña';
$rol    = 'usuario';

$rest_id = $_GET['id'] ?? 'SJ-01';
$restaurante = null;
foreach($RESTAURANTES as $r) { if($r['id'] === $rest_id) { $restaurante = $r; break; } }

$success = '';
$error   = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rating     = intval($_POST['rating'] ?? 0);
  $comentario = trim($_POST['comentario'] ?? '');
  $titulo_res = trim($_POST['titulo_res'] ?? '');
  if($rating < 1 || $rating > 5) {
    $error = 'Seleccioná una calificación del 1 al 5.';
  } elseif(strlen($comentario) < 20) {
    $error = 'El comentario debe tener al menos 20 caracteres.';
  } else {
    $success = '✅ ¡Reseña enviada! Será revisada y publicada en breve.';
  }
}

require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> ›
    <?php if($restaurante): ?>
      <a href="restaurante.php?id=<?= $rest_id ?>"><?= htmlspecialchars($restaurante['nombre']) ?></a> ›
    <?php endif; ?>
    <span>Crear Reseña</span>
  </div>

  <div class="two-col">
    <div class="panel">
      <h2 style="margin:0 0 6px;">💬 Escribir Reseña</h2>
      <?php if($restaurante): ?>
        <p class="p" style="margin-bottom:20px;">Opinando sobre: <strong style="color:var(--text);"><?= htmlspecialchars($restaurante['nombre']) ?></strong></p>
      <?php endif; ?>

      <?php if($error):   ?><div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>
      <?php if($success): ?><div class="alert alert-success"><?= $success ?> <a href="perfil.php" style="color:inherit;text-decoration:underline;">Ver mis reseñas</a></div><?php endif; ?>

      <?php if(!$success): ?>
      <form class="form" method="POST">
        <?php if(!$restaurante): ?>
        <div class="group">
          <label>Restaurante *</label>
          <select class="select" name="rest_id" required onchange="window.location.href='crear-resena.php?id='+this.value">
            <option value="">Seleccioná un restaurante...</option>
            <?php foreach($RESTAURANTES as $r): ?>
              <option value="<?= $r['id'] ?>" <?= $r['id']===$rest_id?'selected':'' ?>><?= htmlspecialchars($r['nombre']) ?> (<?= $PROVINCIAS[$r['provincia']] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <?php endif; ?>

        <div class="group">
          <label>Calificación *</label>
          <div class="rating-input" id="ratingStars">
            <span data-v="1">★</span><span data-v="2">★</span><span data-v="3">★</span>
            <span data-v="4">★</span><span data-v="5">★</span>
          </div>
          <input type="hidden" name="rating" id="ratingVal" value="<?= intval($_POST['rating'] ?? 0) ?>" />
          <p id="ratingText" class="sub">Clic para calificar</p>
        </div>

        <div class="group">
          <label>Título de la reseña</label>
          <input class="input" name="titulo_res" placeholder="Ej: Excelente experiencia gastronómica"
                 value="<?= htmlspecialchars($_POST['titulo_res'] ?? '') ?>" maxlength="100" />
        </div>

        <div class="group">
          <label>Comentario * (mínimo 20 caracteres)</label>
          <textarea name="comentario" placeholder="Contá tu experiencia: comida, servicio, ambiente, precio..."
                    maxlength="1000"><?= htmlspecialchars($_POST['comentario'] ?? '') ?></textarea>
          <span class="sub" id="charCount">0 / 1000 caracteres</span>
        </div>

        <div class="group">
          <label>Aspectos (opcional)</label>
          <div class="checks">
            <label><input type="checkbox" name="asp[]" value="comida"> 🍽️ Comida</label>
            <label><input type="checkbox" name="asp[]" value="servicio"> 👨‍🍳 Servicio</label>
            <label><input type="checkbox" name="asp[]" value="ambiente"> 🏠 Ambiente</label>
            <label><input type="checkbox" name="asp[]" value="precio"> 💰 Precio/Calidad</label>
            <label><input type="checkbox" name="asp[]" value="limpieza"> ✨ Limpieza</label>
            <label><input type="checkbox" name="asp[]" value="ubicacion"> 📍 Ubicación</label>
          </div>
        </div>

        <div class="group">
          <label>Subir fotos (opcional)</label>
          <input class="input" type="file" accept="image/*" multiple style="padding:10px;" />
          <p class="sub">Máximo 5 fotos · JPG, PNG · hasta 5MB c/u</p>
        </div>

        <button class="btn btn-primary btn-full" type="submit">📤 Publicar reseña</button>
        <?php if($restaurante): ?>
          <a class="btn btn-full" href="restaurante.php?id=<?= $rest_id ?>">← Cancelar</a>
        <?php endif; ?>
      </form>
      <?php endif; ?>
    </div>

    <!-- Panel informativo -->
    <aside>
      <?php if($restaurante): ?>
      <div class="card mb">
        <div class="thumb"><img src="<?= $restaurante['img'] ?>" alt="<?= htmlspecialchars($restaurante['nombre']) ?>"></div>
        <div class="card-body">
          <p class="title"><?= htmlspecialchars($restaurante['nombre']) ?></p>
          <p class="sub"><?= $PROVINCIAS[$restaurante['provincia']] ?> · <?= $restaurante['tipo'] ?></p>
          <div class="badges"><span class="badge badge-warning">⭐ <?= $restaurante['rating'] ?></span></div>
        </div>
      </div>
      <?php endif; ?>

      <div class="panel">
        <h3 style="margin:0 0 10px;">💡 Tips para una buena reseña</h3>
        <div class="list">
          <div class="row"><span>✅</span><b>Sé específico sobre tu experiencia</b></div>
          <div class="row"><span>✅</span><b>Mencioná platos que probaste</b></div>
          <div class="row"><span>✅</span><b>Comentá el ambiente y servicio</b></div>
          <div class="row"><span>✅</span><b>Agregá fotos para mayor impacto</b></div>
          <div class="row"><span>❌</span><b>Evitá lenguaje ofensivo</b></div>
          <div class="row"><span>❌</span><b>No incluyas información personal</b></div>
        </div>
      </div>
    </aside>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
const labels = ['','Muy malo 😞','Malo 😕','Regular 😐','Bueno 😊','¡Excelente! 🤩'];
const stars  = document.querySelectorAll('#ratingStars span');
let sel = parseInt(document.getElementById('ratingVal').value) || 0;

function paintStars(n){
  stars.forEach(s => s.style.color = parseInt(s.dataset.v) <= n ? '#f59e0b' : 'rgba(255,255,255,.2)');
}
paintStars(sel);

stars.forEach(s => {
  s.addEventListener('click', ()=>{
    sel = parseInt(s.dataset.v);
    document.getElementById('ratingVal').value = sel;
    document.getElementById('ratingText').textContent = labels[sel];
    paintStars(sel);
  });
  s.addEventListener('mouseenter', ()=> paintStars(parseInt(s.dataset.v)));
  s.addEventListener('mouseleave', ()=> paintStars(sel));
});

// Contador de caracteres
const ta = document.querySelector('textarea[name="comentario"]');
const cc = document.getElementById('charCount');
if(ta && cc){
  cc.textContent = ta.value.length + ' / 1000 caracteres';
  ta.addEventListener('input', ()=> cc.textContent = ta.value.length + ' / 1000 caracteres');
}
</script>
