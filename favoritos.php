<?php
require_once 'includes/data.php';
$titulo = 'Mis Favoritos';
$rol    = 'usuario';

// Favoritos simulados del usuario actual
$ids_favoritos = ['SJ-01','CA-02','LI-01','HE-02','GU-01','PU-01','AL-01','SJ-02'];
$favoritos = array_filter($RESTAURANTES, fn($r) => in_array($r['id'], $ids_favoritos));

require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <a href="perfil.php">Mi Perfil</a> › <span>Favoritos</span>
  </div>

  <div class="section-title">
    <h2>❤️ Mis Restaurantes Favoritos</h2>
    <span><?= count($favoritos) ?> guardados</span>
  </div>

  <?php if(empty($favoritos)): ?>
    <div class="panel" style="text-align:center;padding:50px 20px;">
      <div style="font-size:48px;margin-bottom:16px;">💔</div>
      <h3>Aún no tenés favoritos</h3>
      <p class="p">Explorá el catálogo y guardá los restaurantes que más te gusten.</p>
      <a class="btn btn-primary mt" href="catalogo.php">🍽️ Explorar restaurantes</a>
    </div>
  <?php else: ?>
    <!-- Filtro rápido -->
    <div class="filter-chips">
      <span class="chip active" onclick="filtrarFavs('todos',this)">Todos (<?= count($favoritos) ?>)</span>
      <?php
      $tipos_fav = array_unique(array_column(iterator_to_array($favoritos), 'tipo'));
      foreach($tipos_fav as $t):
      ?>
        <span class="chip" onclick="filtrarFavs('<?= htmlspecialchars($t) ?>',this)"><?= $t ?></span>
      <?php endforeach; ?>
    </div>

    <section class="grid" id="favGrid">
      <?php foreach($favoritos as $r): ?>
        <div class="card fav-card" data-tipo="<?= htmlspecialchars($r['tipo']) ?>">
          <div class="thumb">
            <img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy">
            <button onclick="quitarFavorito('<?= $r['id'] ?>',this)"
              style="position:absolute;top:8px;right:8px;background:rgba(239,68,68,.85);border:none;border-radius:50%;width:30px;height:30px;cursor:pointer;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;">✕</button>
          </div>
          <div class="card-body">
            <a href="restaurante.php?id=<?= $r['id'] ?>">
              <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
              <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
              <p class="sub" style="font-size:12px;">🕐 <?= $r['horario'] ?></p>
              <div class="badges">
                <span class="badge badge-warning">⭐ <?= $r['rating'] ?></span>
                <span class="badge <?= $r['accesible']?'badge-success':'' ?>"><?= $r['accesible']?'Accesible ✅':'❌' ?></span>
              </div>
            </a>
            <div style="display:flex;gap:8px;margin-top:12px;">
              <a href="restaurante.php?id=<?= $r['id'] ?>" class="btn btn-primary btn-sm" style="flex:1;">Ver detalle</a>
              <a href="crear-resena.php?id=<?= $r['id'] ?>" class="btn btn-sm">💬 Reseñar</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>

  <!-- Sugerencias -->
  <div class="section-title" style="margin-top:32px;">
    <h2>💡 Te puede interesar</h2>
    <a href="catalogo.php" style="color:var(--primary);font-size:14px;">Ver más →</a>
  </div>
  <section class="grid">
    <?php
    $no_fav = array_filter($RESTAURANTES, fn($r) => !in_array($r['id'], $ids_favoritos));
    usort($no_fav, fn($a,$b) => $b['rating'] <=> $a['rating']);
    foreach(array_slice($no_fav, 0, 3) as $r):
    ?>
    <a class="card" href="restaurante.php?id=<?= $r['id'] ?>">
      <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
      <div class="card-body">
        <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
        <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
        <div class="badges"><span class="badge badge-warning">⭐ <?= $r['rating'] ?></span></div>
      </div>
    </a>
    <?php endforeach; ?>
  </section>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
// Posicionar el botón ✕ correctamente
document.querySelectorAll('.fav-card .thumb').forEach(t => t.style.position = 'relative');

function quitarFavorito(id, btn){
  if(!confirm('¿Quitar de favoritos?')) return;
  const card = btn.closest('.fav-card');
  card.style.transition = 'opacity .3s, transform .3s';
  card.style.opacity = '0';
  card.style.transform = 'scale(.95)';
  setTimeout(()=> card.remove(), 300);
}

function filtrarFavs(tipo, el){
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.fav-card').forEach(card => {
    const show = tipo === 'todos' || card.dataset.tipo === tipo;
    card.style.display = show ? '' : 'none';
  });
}
</script>
