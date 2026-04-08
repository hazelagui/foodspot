<?php
require_once 'includes/data.php';
$id = $_GET['id'] ?? 'SJ-01';
$r  = null;
foreach($RESTAURANTES as $item) {
  if($item['id'] === $id) { $r = $item; break; }
}
if(!$r) { header('Location: catalogo.php'); exit; }

$titulo = $r['nombre'];
$rol    = 'publico';

$resenas_rest = array_filter($RESENAS, fn($re) => $re['restaurante_id'] === $id && $re['estado'] === 'aprobada');
require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> ›
    <a href="provincia.php?p=<?= $r['provincia'] ?>"><?= $PROVINCIAS[$r['provincia']] ?></a> ›
    <span><?= htmlspecialchars($r['nombre']) ?></span>
  </div>

  <div class="two-col">
    <!-- Columna principal -->
    <section>
      <div class="card mb">
        <div class="thumb thumb-lg">
          <img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>">
        </div>
        <div class="card-body">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;">
            <div>
              <h1 style="margin:0;font-size:24px;"><?= htmlspecialchars($r['nombre']) ?></h1>
              <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
            </div>
            <div class="badges">
              <span class="badge badge-warning" style="font-size:16px;">⭐ <?= $r['rating'] ?></span>
            </div>
          </div>

          <div class="badges" style="margin-top:14px;">
            <span class="badge badge-primary">🕐 <?= $r['horario'] ?></span>
            <span class="badge <?= $r['accesible'] ? 'badge-success' : 'badge-danger' ?>"><?= $r['accesible'] ? '♿ Accesible' : '♿ No accesible' ?></span>
            <span class="badge">📞 <?= $r['telefono'] ?></span>
            <span class="badge">📍 <?= htmlspecialchars($r['direccion']) ?></span>
          </div>

          <hr>
          <h3 style="margin:0 0 8px;">📝 Descripción</h3>
          <p class="p"><?= htmlspecialchars($r['descripcion']) ?></p>

          <hr>
          <h3 style="margin:0 0 8px;">🍽️ Menú</h3>
          <div class="list">
            <?php
            $menus_mock = [
              'SJ-01' => [['Casado completo','₡3,500'],['Arroz con pollo','₡3,200'],['Sopa negra','₡1,800'],['Fresco natural','₡800']],
              'SJ-02' => [['Spaghetti Carbonara','₡5,200'],['Fettuccine Alfredo','₡4,800'],['Lasagna','₡5,500'],['Tiramisú','₡2,500']],
              'AL-01' => [['Churrasco','₡8,000'],['Costillas BBQ','₡7,500'],['Pollo a la brasa','₡5,000'],['Chorizo artesanal','₡3,500']],
              'AL-02' => [['Desayuno completo','₡3,800'],['Café chorreado','₡1,200'],['Sandwich gourmet','₡3,200'],['Queque de zanahoria','₡1,500']],
              'CA-01' => [['Olla de carne','₡4,200'],['Picadillo de papa','₡2,800'],['Gallo pinto completo','₡2,500'],['Chifrijo','₡3,000']],
              'CA-02' => [['Tonkotsu Ramen','₡6,500'],['Shoyu Ramen','₡6,000'],['Gyozas (6u)','₡3,500'],['Edamame','₡1,800']],
              'HE-01' => [['Burger Clásica','₡4,500'],['Double Smash','₡6,000'],['Fries crocantes','₡2,000'],['Shake de vainilla','₡2,500']],
              'HE-02' => [['Bowl Tropical','₡5,500'],['Acai Bowl','₡5,000'],['Ensalada César vegana','₡4,200'],['Jugo verde detox','₡2,200']],
              'PU-01' => [['Ceviche de camarón','₡5,800'],['Corvina al ajillo','₡8,500'],['Pulpo a la parrilla','₡9,000'],['Limonada con sal','₡1,500']],
              'PU-02' => [['Taco de carnitas (3u)','₡4,000'],['Burrito especial','₡5,500'],['Quesadilla mixta','₡4,200'],['Agua de jamaica','₡1,200']],
              'LI-01' => [['Rice & Beans completo','₡4,500'],['Rondón de pescado','₡7,000'],['Patacones con natilla','₡2,800'],['Agua de coco','₡1,800']],
              'LI-02' => [['Ceviche caribeño','₡5,200'],['Pollo en salsa de coco','₡6,500'],['Plátano en tentación','₡2,500'],['Jugo de maracuyá','₡1,500']],
              'GU-01' => [['Lomito a la brasa','₡9,500'],['Costilla de res','₡8,000'],['Chorizo guanacasteco','₡4,000'],['Cerveza fría','₡2,000']],
              'GU-02' => [['Helado de cas (2 bolas)','₡2,500'],['Sundae tropical','₡3,500'],['Batido de guanábana','₡3,000'],['Granizado de tamarindo','₡2,000']],
            ];
            foreach(($menus_mock[$id] ?? []) as [$plato, $precio]):
            ?>
            <div class="row"><span><?= htmlspecialchars($plato) ?></span><b><?= $precio ?></b></div>
            <?php endforeach; ?>
          </div>

          <hr>
          <h3 style="margin:0 0 12px;">📸 Galería</h3>
          <div class="gallery-grid">
            <?php for($i=0;$i<6;$i++): ?>
            <div class="gallery-item">
              <img src="<?= $r['img'] ?>" alt="Foto <?= $i+1 ?>" loading="lazy">
            </div>
            <?php endfor; ?>
          </div>

          <hr>
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;">💬 Reseñas (<?= count($resenas_rest) ?>)</h3>
            <a class="btn btn-primary btn-sm" href="crear-resena.php?id=<?= $id ?>">+ Escribir reseña</a>
          </div>
          <div class="list" style="margin-top:14px;">
            <?php if(empty($resenas_rest)): ?>
              <p class="p">Aún no hay reseñas aprobadas. ¡Sé el primero en opinar!</p>
            <?php else: ?>
              <?php foreach($resenas_rest as $re): ?>
              <div class="panel" style="padding:14px;">
                <div class="row" style="align-items:center;">
                  <div style="display:flex;align-items:center;gap:10px;">
                    <div class="avatar" style="width:36px;height:36px;font-size:13px;"><?= substr($re['usuario'],0,2) ?></div>
                    <b><?= htmlspecialchars($re['usuario']) ?></b>
                  </div>
                  <span class="stars"><?= str_repeat('★', $re['rating']) ?><?= str_repeat('☆', 5-$re['rating']) ?></span>
                </div>
                <p class="p" style="margin-top:10px;"><?= htmlspecialchars($re['comentario']) ?></p>
                <p class="sub"><?= $re['fecha'] ?></p>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Sidebar -->
    <aside>
      <div class="panel mb">
        <h3 style="margin:0 0 14px;">📍 Información</h3>
        <div class="list">
          <div class="row"><span>Propietario</span><b><?= htmlspecialchars($r['propietario']) ?></b></div>
          <div class="row"><span>Teléfono</span><b><?= $r['telefono'] ?></b></div>
          <div class="row"><span>Dirección</span><b><?= htmlspecialchars($r['direccion']) ?></b></div>
          <div class="row"><span>Horario</span><b><?= $r['horario'] ?></b></div>
          <div class="row"><span>Rating</span><b>⭐ <?= $r['rating'] ?>/5</b></div>
          <div class="row"><span>Accesible</span><b><?= $r['accesible'] ? '✅ Sí' : '❌ No' ?></b></div>
        </div>
        <hr>
        <div class="badges">
          <span class="badge">📶 WiFi</span>
          <span class="badge">🅿️ Parqueo</span>
          <span class="badge">🥡 Para llevar</span>
          <span class="badge">💳 Tarjeta</span>
        </div>
      </div>

      <div class="panel mb">
        <h3 style="margin:0 0 10px;">⭐ Calificar</h3>
        <div class="rating-input" id="ratingInput">
          <span data-v="1">★</span><span data-v="2">★</span><span data-v="3">★</span>
          <span data-v="4">★</span><span data-v="5">★</span>
        </div>
        <p class="sub" id="ratingLabel" style="margin-top:8px;">Seleccioná una calificación</p>
        <button class="btn btn-primary btn-full mt-sm" onclick="alert('Calificación guardada (visual)')">Enviar calificación</button>
      </div>

      <div class="panel">
        <h3 style="margin:0 0 10px;">❤️ Favoritos</h3>
        <button class="btn btn-full" id="btnFav" onclick="toggleFav()">❤️ Agregar a favoritos</button>
        <hr>
        <a class="btn btn-full" href="javascript:history.back()">← Volver</a>
      </div>
    </aside>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
// Rating interactivo
const stars = document.querySelectorAll('#ratingInput span');
const labels = ['','Muy malo 😞','Malo 😕','Regular 😐','Bueno 😊','Excelente 🤩'];
let selected = 0;
stars.forEach(s => {
  s.addEventListener('click', () => {
    selected = parseInt(s.dataset.v);
    stars.forEach(x => x.classList.toggle('active', parseInt(x.dataset.v) <= selected));
    document.getElementById('ratingLabel').textContent = labels[selected];
  });
  s.addEventListener('mouseenter', () => stars.forEach(x => x.style.color = parseInt(x.dataset.v) <= parseInt(s.dataset.v) ? '#f59e0b' : 'rgba(255,255,255,.2)'));
  s.addEventListener('mouseleave', () => stars.forEach(x => x.style.color = parseInt(x.dataset.v) <= selected ? '#f59e0b' : 'rgba(255,255,255,.2)'));
});

function toggleFav(){
  const btn = document.getElementById('btnFav');
  const active = btn.classList.toggle('btn-primary');
  btn.textContent = active ? '❤️ En favoritos' : '❤️ Agregar a favoritos';
}
</script>
