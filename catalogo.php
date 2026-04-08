<?php
require_once 'includes/data.php';
$titulo = 'Catálogo';
$rol    = 'publico';

// Filtros
$filtro_prov = $_GET['provincia'] ?? 'todas';
$filtro_tipo = $_GET['tipo'] ?? 'todos';
$filtro_acc  = $_GET['accesible'] ?? 'todos';
$filtro_rat  = floatval($_GET['rating'] ?? 0);
$busqueda    = trim($_GET['q'] ?? '');

$tipos_disponibles = array_unique(array_column($RESTAURANTES, 'tipo'));
sort($tipos_disponibles);

// Aplicar filtros
$resultados = array_filter($RESTAURANTES, function($r) use ($filtro_prov, $filtro_tipo, $filtro_acc, $filtro_rat, $busqueda) {
  if($filtro_prov !== 'todas' && $r['provincia'] !== $filtro_prov) return false;
  if($filtro_tipo !== 'todos' && $r['tipo'] !== $filtro_tipo) return false;
  if($filtro_acc === '1' && !$r['accesible']) return false;
  if($filtro_acc === '0' &&  $r['accesible']) return false;
  if($filtro_rat > 0 && $r['rating'] < $filtro_rat) return false;
  if($busqueda && stripos($r['nombre'].$r['tipo'].$r['descripcion'], $busqueda) === false) return false;
  return true;
});

require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <span>Catálogo</span>
  </div>

  <div class="section-title">
    <h2>🍽️ Catálogo de Restaurantes</h2>
    <span><?= count($resultados) ?> resultado<?= count($resultados) !== 1 ? 's' : '' ?></span>
  </div>

  <!-- Filtros -->
  <form method="GET" action="catalogo.php">
    <div class="panel mb" style="padding:16px;">
      <div class="controls" style="flex-wrap:wrap;gap:10px;">
        <input class="input" name="q" value="<?= htmlspecialchars($busqueda) ?>"
          placeholder="🔍 Buscar por nombre o tipo..." style="flex:1;min-width:180px;" />

        <select class="select" name="provincia" style="flex:1;min-width:140px;">
          <option value="todas">🗺️ Todas las provincias</option>
          <?php foreach($PROVINCIAS as $code => $nombre): ?>
            <option value="<?= $code ?>" <?= $filtro_prov===$code ? 'selected' : '' ?>><?= $nombre ?></option>
          <?php endforeach; ?>
        </select>

        <select class="select" name="tipo" style="flex:1;min-width:140px;">
          <option value="todos">🍛 Todos los tipos</option>
          <?php foreach($tipos_disponibles as $t): ?>
            <option value="<?= htmlspecialchars($t) ?>" <?= $filtro_tipo===$t ? 'selected' : '' ?>><?= $t ?></option>
          <?php endforeach; ?>
        </select>

        <select class="select" name="accesible" style="flex:1;min-width:140px;">
          <option value="todos">♿ Accesibilidad</option>
          <option value="1" <?= $filtro_acc==='1' ? 'selected' : '' ?>>Accesible ✅</option>
          <option value="0" <?= $filtro_acc==='0' ? 'selected' : '' ?>>No accesible ❌</option>
        </select>

        <select class="select" name="rating" style="flex:1;min-width:130px;">
          <option value="0">⭐ Todo rating</option>
          <option value="4.5" <?= $filtro_rat==4.5 ? 'selected' : '' ?>>4.5+ ⭐</option>
          <option value="4.0" <?= $filtro_rat==4.0 ? 'selected' : '' ?>>4.0+ ⭐</option>
          <option value="3.5" <?= $filtro_rat==3.5 ? 'selected' : '' ?>>3.5+ ⭐</option>
        </select>

        <button class="btn btn-primary" type="submit">Filtrar</button>
        <a class="btn" href="catalogo.php">Limpiar</a>
      </div>
    </div>
  </form>

  <!-- Chips de tipo rápido -->
  <div class="filter-chips">
    <a href="catalogo.php" class="chip <?= $filtro_tipo==='todos' ? 'active' : '' ?>">Todos</a>
    <?php foreach($tipos_disponibles as $t): ?>
      <a href="catalogo.php?tipo=<?= urlencode($t) ?>" class="chip <?= $filtro_tipo===$t ? 'active' : '' ?>"><?= $t ?></a>
    <?php endforeach; ?>
  </div>

  <!-- Grid de resultados -->
  <?php if(empty($resultados)): ?>
    <div class="panel" style="text-align:center;padding:40px;">
      <div style="font-size:40px;margin-bottom:12px;">🔍</div>
      <h3>Sin resultados</h3>
      <p class="p">No encontramos restaurantes con esos filtros. Intentá ajustar la búsqueda.</p>
      <a class="btn btn-primary mt" href="catalogo.php">Ver todos</a>
    </div>
  <?php else: ?>
    <section class="grid">
      <?php foreach($resultados as $r): ?>
        <a class="card" href="restaurante.php?id=<?= $r['id'] ?>">
          <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
          <div class="card-body">
            <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
            <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
            <p class="sub" style="font-size:12px;margin-top:4px;">🕐 <?= $r['horario'] ?></p>
            <div class="badges">
              <span class="badge badge-warning">⭐ <?= $r['rating'] ?></span>
              <span class="badge <?= $r['accesible'] ? 'badge-success' : '' ?>"><?= $r['accesible'] ? 'Accesible ✅' : '❌' ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>
