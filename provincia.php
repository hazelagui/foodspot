<?php
require_once 'includes/data.php';
$code   = isset($_GET['p']) ? strtoupper(trim($_GET['p'])) : 'SJ';
$code   = array_key_exists($code, $PROVINCIAS) ? $code : 'SJ';
$nombre = $PROVINCIAS[$code];
$titulo = $nombre;
$rol    = 'publico';

$lista = array_filter($RESTAURANTES, fn($r) => $r['provincia'] === $code);
require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <a href="catalogo.php">Catálogo</a> › <span><?= $nombre ?></span>
  </div>

  <div class="hero-card mb">
    <div class="kicker">Provincia</div>
    <h1 class="h1" style="font-size:28px;margin:6px 0 12px;"><?= $nombre ?></h1>
    <div class="controls" style="align-items:center;">
      <select class="select" id="provinceSelect" style="max-width:200px;">
        <?php foreach($PROVINCIAS as $c => $n): ?>
          <option value="<?= $c ?>" <?= $c===$code ? 'selected' : '' ?>><?= $n ?></option>
        <?php endforeach; ?>
      </select>
      <a class="btn" href="catalogo.php">Ver catálogo completo</a>
    </div>
  </div>

  <div class="section-title">
    <h2>Restaurantes en <?= $nombre ?></h2>
    <span><?= count($lista) ?> encontrado<?= count($lista) !== 1 ? 's' : '' ?></span>
  </div>

  <section class="grid">
    <?php foreach($lista as $r): ?>
      <a class="card" href="restaurante.php?id=<?= $r['id'] ?>">
        <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
        <div class="card-body">
          <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
          <p class="sub"><?= $r['tipo'] ?> · 🕐 <?= $r['horario'] ?></p>
          <div class="badges">
            <span class="badge badge-warning">⭐ <?= $r['rating'] ?></span>
            <span class="badge <?= $r['accesible'] ? 'badge-success' : '' ?>"><?= $r['accesible'] ? 'Accesible ✅' : '❌ No accesible' ?></span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </section>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
document.getElementById('provinceSelect').addEventListener('change', function(){
  window.location.href = 'provincia.php?p=' + this.value;
});
</script>
