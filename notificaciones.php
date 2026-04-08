<?php
require_once 'includes/data.php';
$titulo = 'Notificaciones';
$rol    = 'usuario';

// Notificaciones adicionales para mostrar más contenido
$todas_notifs = array_merge($NOTIFICACIONES, [
  ['id'=>5,'tipo'=>'resena','mensaje'=>'"Ramen Niebla" respondió tu reseña: "¡Gracias por visitarnos!"','fecha'=>'hace 3 días','leida'=>true],
  ['id'=>6,'tipo'=>'sistema','mensaje'=>'FOODSPOT agregó 3 nuevos restaurantes en Limón','fecha'=>'hace 4 días','leida'=>true],
  ['id'=>7,'tipo'=>'favorito','mensaje'=>'"Mar y Limón" tiene nueva promoción de temporada','fecha'=>'hace 5 días','leida'=>true],
]);

$iconos = ['resena'=>'💬','favorito'=>'❤️','sistema'=>'🔔'];

require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <span>Notificaciones</span>
  </div>

  <div style="max-width:700px;margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
      <div>
        <h2 style="margin:0;">🔔 Notificaciones</h2>
        <?php $no_leidas = count(array_filter($todas_notifs, fn($n)=>!$n['leida'])); ?>
        <?php if($no_leidas > 0): ?>
          <p class="sub"><?= $no_leidas ?> sin leer</p>
        <?php endif; ?>
      </div>
      <div style="display:flex;gap:8px;">
        <button class="btn btn-sm" onclick="marcarTodas()">✅ Marcar todas como leídas</button>
        <button class="btn btn-sm btn-danger" onclick="if(confirm('¿Limpiar historial?')) document.getElementById('listNotif').innerHTML='<p class=p style=text-align:center;padding:30px;>No tenés notificaciones.</p>'">🗑️ Limpiar</button>
      </div>
    </div>

    <!-- Filtros -->
    <div class="filter-chips mb">
      <span class="chip active" onclick="filtrarNotifs('todos',this)">Todas (<?= count($todas_notifs) ?>)</span>
      <span class="chip" onclick="filtrarNotifs('no-leidas',this)">Sin leer (<?= $no_leidas ?>)</span>
      <span class="chip" onclick="filtrarNotifs('resena',this)">💬 Reseñas</span>
      <span class="chip" onclick="filtrarNotifs('favorito',this)">❤️ Favoritos</span>
      <span class="chip" onclick="filtrarNotifs('sistema',this)">🔔 Sistema</span>
    </div>

    <div class="list" id="listNotif">
      <?php foreach($todas_notifs as $n): ?>
        <div class="notif-item <?= !$n['leida']?'unread':'' ?>"
             id="notif-<?= $n['id'] ?>"
             data-tipo="<?= $n['tipo'] ?>"
             data-leida="<?= $n['leida']?'1':'0' ?>">
          <div class="notif-icon"><?= $iconos[$n['tipo']] ?? '🔔' ?></div>
          <div class="notif-body">
            <p class="notif-msg"><?= htmlspecialchars($n['mensaje']) ?></p>
            <p class="notif-time"><?= $n['fecha'] ?></p>
          </div>
          <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
            <?php if(!$n['leida']): ?>
              <div style="width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0;"></div>
            <?php endif; ?>
            <button onclick="leerNotif(<?= $n['id'] ?>)"
              style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:18px;line-height:1;"
              title="Marcar como leída">✓</button>
            <button onclick="document.getElementById('notif-<?= $n['id'] ?>').remove()"
              style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:16px;line-height:1;"
              title="Eliminar">✕</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function leerNotif(id){
  const el = document.getElementById('notif-' + id);
  if(el){ el.classList.remove('unread'); el.dataset.leida = '1'; }
}

function marcarTodas(){
  document.querySelectorAll('.notif-item.unread').forEach(el => {
    el.classList.remove('unread'); el.dataset.leida = '1';
  });
}

function filtrarNotifs(tipo, el){
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.notif-item').forEach(item => {
    let show = false;
    if(tipo === 'todos')       show = true;
    else if(tipo === 'no-leidas') show = item.dataset.leida === '0';
    else                       show = item.dataset.tipo === tipo;
    item.style.display = show ? '' : 'none';
  });
}
</script>
