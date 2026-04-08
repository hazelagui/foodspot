<?php
require_once 'includes/data.php';
$titulo = 'Búsqueda';
$rol    = 'publico';
$q      = trim($_GET['q'] ?? '');

$resultados = [];
if($q !== '') {
  $resultados = array_filter($RESTAURANTES, fn($r) =>
    stripos($r['nombre'],    $q) !== false ||
    stripos($r['tipo'],      $q) !== false ||
    stripos($r['descripcion'],$q) !== false ||
    stripos($PROVINCIAS[$r['provincia']], $q) !== false
  );
}
require_once 'includes/header.php';
?>
<main class="container">
  <div class="search-hero">
    <div class="kicker">Búsqueda Global</div>
    <h1 class="h1" style="font-size:28px;">¿Qué querés comer hoy?</h1>
    <div class="search-bar">
      <input type="text" id="searchInput" value="<?= htmlspecialchars($q) ?>"
             placeholder="Nombre, tipo de comida, provincia..." />
      <button onclick="doSearch()">🔍</button>
    </div>
  </div>

  <!-- Sugerencias rápidas -->
  <?php if($q === ''): ?>
  <div style="text-align:center;margin-bottom:20px;">
    <p class="p" style="margin-bottom:12px;">Búsquedas frecuentes:</p>
    <div class="filter-chips" style="justify-content:center;">
      <?php $sugerencias = ['Mariscos','Ramen','Típica','Parrilla','Saludable','Italiana','Caribeña']; ?>
      <?php foreach($sugerencias as $s): ?>
        <a href="busqueda.php?q=<?= urlencode($s) ?>" class="chip"><?= $s ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="section-title"><h2>Todos los restaurantes</h2></div>
  <section class="grid">
    <?php foreach($RESTAURANTES as $r): ?>
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

  <?php else: ?>
  <div class="section-title">
    <h2>Resultados para "<?= htmlspecialchars($q) ?>"</h2>
    <span><?= count($resultados) ?> resultado<?= count($resultados)!==1?'s':'' ?></span>
  </div>

  <?php if(empty($resultados)): ?>
    <div class="panel" style="text-align:center;padding:40px;">
      <div style="font-size:48px;margin-bottom:12px;">🔍</div>
      <h3>Sin resultados</h3>
      <p class="p">No encontramos restaurantes que coincidan con "<?= htmlspecialchars($q) ?>".</p>
      <a class="btn btn-primary mt" href="busqueda.php">Nueva búsqueda</a>
    </div>
  <?php else: ?>
    <section class="grid">
      <?php foreach($resultados as $r): ?>
      <a class="card" href="restaurante.php?id=<?= $r['id'] ?>">
        <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
        <div class="card-body">
          <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
          <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
          <div class="badges">
            <span class="badge badge-warning">⭐ <?= $r['rating'] ?></span>
            <span class="badge <?= $r['accesible']?'badge-success':'' ?>"><?= $r['accesible']?'Accesible ✅':'❌' ?></span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function doSearch(){
  const q = document.getElementById('searchInput').value.trim();
  if(q) window.location.href = 'busqueda.php?q=' + encodeURIComponent(q);
}
document.getElementById('searchInput').addEventListener('keydown', e => { if(e.key==='Enter') doSearch(); });
</script>
