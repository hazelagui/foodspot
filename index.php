<?php
require_once 'includes/data.php';
$titulo = 'Inicio';
$rol    = 'publico';
require_once 'includes/header.php';
?>
<main class="container hero">
  <div class="hero-grid">
    <section class="hero-card">
      <div class="kicker">🍽️ Descubrí Costa Rica a través de su gastronomía</div>
      <h1 class="h1">Encontrá los mejores restaurantes de Costa Rica, rápido y fácil.</h1>
      <p class="p">Explorá por provincia, tipo de comida o buscá directamente el lugar que querés visitar. Reseñas reales de usuarios reales.</p>
      <div class="controls">
        <input class="input" id="searchHome" placeholder="🔍 Buscar restaurante..." style="max-width:300px;" />
        <select class="select" id="provinceSelect" style="max-width:180px;">
          <?php foreach($PROVINCIAS as $code => $nombre): ?>
            <option value="<?= $code ?>"><?= $nombre ?></option>
          <?php endforeach; ?>
        </select>
        <a class="btn btn-primary" id="btnIrProv" href="provincia.php?p=SJ">Explorar</a>
      </div>
    </section>
    <aside class="hero-card">
      <div class="kicker">Filtros rápidos</div>
      <div class="controls" style="flex-direction:column;">
        <select class="select">
          <option>🍛 Tipo de comida</option>
          <option>Comida típica</option>
          <option>Italiana</option>
          <option>Caribeña</option>
          <option>Mariscos</option>
          <option>Japonesa</option>
          <option>Parrilla</option>
          <option>Saludable</option>
        </select>
        <select class="select">
          <option>♿ Accesibilidad</option>
          <option>Accesible ✅</option>
          <option>No accesible ❌</option>
        </select>
        <select class="select">
          <option>⭐ Rating mínimo</option>
          <option>4.5+</option>
          <option>4.0+</option>
          <option>3.5+</option>
        </select>
        <a class="btn btn-primary" href="busqueda.php">Ver todos con filtros</a>
      </div>
    </aside>
  </div>

  <!-- Stats -->
  <div class="grid-4 mt">
    <div class="stat-card"><div class="stat-num">14</div><div class="stat-label">Restaurantes</div></div>
    <div class="stat-card"><div class="stat-num">7</div><div class="stat-label">Provincias</div></div>
    <div class="stat-card"><div class="stat-num">38</div><div class="stat-label">Reseñas</div></div>
    <div class="stat-card"><div class="stat-num">4.4</div><div class="stat-label">Rating Promedio</div></div>
  </div>

  <!-- Provincias -->
  <div class="section-title">
    <h2>Explorar por Provincia</h2>
    <a href="catalogo.php" style="color:var(--primary);font-size:14px;">Ver catálogo completo →</a>
  </div>
  <section class="grid">
    <?php
    $prov_imgs = [
      'SJ' => 'https://s7g10.scene7.com/is/image/barcelo/que-ver-en-costa-rica-correos-portada?&&fmt=webp-alpha&qlt=75&wid=1300&fit=crop,1',
      'AL' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Alajuela_likeluis.jpg/500px-Alajuela_likeluis.jpg',
      'CA' => 'https://es.visitcostarica.com/sites/default/files/2024-09/grid-cartago.jpg',
      'HE' => 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Ciudad_de_Heredia.JPG',
      'PU' => 'https://wpapi.larepublica.net/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/05/20200514085112.puntarenas-inversiones.jpg.webp',
      'LI' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/04/4f/d9/49/gandoca-manzanillo-wildlife.jpg?w=1200&h=700&s=1',
      'GU' => 'https://www.latamairlines.com/content/dam/latamxp/sites/vamos-latam/news-costa-rica/lista-latam/Lista3.png',
    ];
    $count_prov = array_count_values(array_column($RESTAURANTES, 'provincia'));
    foreach($PROVINCIAS as $code => $nombre):
      $total = $count_prov[$code] ?? 0;
    ?>
    <a class="card" href="provincia.php?p=<?= $code ?>">
      <div class="thumb"><img src="<?= $prov_imgs[$code] ?>" alt="<?= $nombre ?>" loading="lazy"></div>
      <div class="card-body">
        <p class="title"><?= $nombre ?></p>
        <p class="sub"><?= $total ?> restaurante<?= $total !== 1 ? 's' : '' ?></p>
      </div>
    </a>
    <?php endforeach; ?>
  </section>

  <!-- Restaurantes destacados -->
  <div class="section-title">
    <h2>Mejor valorados</h2>
    <a href="catalogo.php" style="color:var(--primary);font-size:14px;">Ver todos →</a>
  </div>
  <section class="grid">
    <?php
    $top = array_filter($RESTAURANTES, fn($r) => $r['rating'] >= 4.6);
    usort($top, fn($a,$b) => $b['rating'] <=> $a['rating']);
    foreach(array_slice($top, 0, 3) as $r):
    ?>
    <a class="card" href="restaurante.php?id=<?= $r['id'] ?>">
      <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
      <div class="card-body">
        <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
        <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
        <div class="badges">
          <span class="badge badge-warning">⭐ <?= $r['rating'] ?></span>
          <?php if($r['accesible']): ?><span class="badge badge-success">Accesible ✅</span><?php endif; ?>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>

<script>
document.getElementById('btnIrProv')?.addEventListener('click', function(e){
  e.preventDefault();
  const p = document.getElementById('provinceSelect').value;
  window.location.href = `provincia.php?p=${p}`;
});
document.getElementById('searchHome')?.addEventListener('keydown', function(e){
  if(e.key === 'Enter') window.location.href = `busqueda.php?q=${encodeURIComponent(this.value)}`;
});
</script>
