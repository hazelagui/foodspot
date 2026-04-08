<?php
require_once 'includes/data.php';
$titulo = 'Panel Creador';
$rol    = 'creador';

require_once 'includes/header.php';
?>
<main class="container">
  <div class="dash-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-user">
        <div class="avatar avatar-lg" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">KM</div>
        <strong>Kevin Mora</strong>
        <p class="sub" style="margin-top:4px;">creador@test.com</p>
        <span class="badge badge-warning" style="margin-top:6px;">⭐ Creador</span>
      </div>
      <nav class="sidebar-menu">
        <button class="sidebar-item active" onclick="showTab('inicio',this)">📊 Dashboard</button>
        <button class="sidebar-item" onclick="showTab('destacadas',this)">🌟 Reseñas Destacadas</button>
        <button class="sidebar-item" onclick="showTab('multimedia',this)">📸 Multimedia</button>
        <button class="sidebar-item" onclick="showTab('historial',this)">📋 Historial</button>
        <a class="sidebar-item" href="login.php" style="color:var(--danger);margin-top:8px;">🚪 Cerrar sesión</a>
      </nav>
    </aside>

    <!-- Contenido -->
    <main>

      <!-- ── INICIO ── -->
      <div id="tab-inicio" class="tab-content active">
        <div class="section-title" style="margin-top:0;">
          <h2>⭐ Panel del Creador</h2>
          <span class="badge badge-warning">Contenido Verificado</span>
        </div>

        <div class="alert alert-info">
          💡 Como Creador verificado, podés destacar reseñas de calidad y gestionar contenido multimedia para enriquecer la plataforma.
        </div>

        <div class="grid-4 mb">
          <div class="stat-card"><div class="stat-num">30</div><div class="stat-label">Reseñas escritas</div></div>
          <div class="stat-card"><div class="stat-num">8</div><div class="stat-label">Destacadas</div></div>
          <div class="stat-card"><div class="stat-num">47</div><div class="stat-label">Fotos subidas</div></div>
          <div class="stat-card"><div class="stat-num">4.9</div><div class="stat-label">Rating promedio</div></div>
        </div>

        <div class="two-col">
          <div class="panel">
            <h3 style="margin:0 0 12px;">🌟 Mis reseñas destacadas recientes</h3>
            <div class="list">
              <?php foreach(array_slice($RESENAS,0,3) as $re): ?>
              <div style="padding:12px;border-radius:var(--radius-sm);border:1px solid var(--border);background:rgba(245,158,11,.05);">
                <div class="row">
                  <div>
                    <b><?= htmlspecialchars($re['restaurante_nombre']) ?></b>
                    <p class="sub" style="font-size:12px;"><?= $re['fecha'] ?></p>
                  </div>
                  <span class="stars"><?= str_repeat('★',$re['rating']) ?></span>
                </div>
                <p class="p" style="margin-top:8px;font-size:13px;"><?= mb_substr(htmlspecialchars($re['comentario']),0,90) ?>...</p>
                <span class="badge badge-warning" style="margin-top:6px;">⭐ Destacada</span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 12px;">📈 Impacto de contenido</h3>
            <div class="list">
              <div class="row"><span>Vistas a mis reseñas</span><b>2,840</b></div>
              <div class="row"><span>Likes recibidos</span><b>312</b></div>
              <div class="row"><span>Compartidos</span><b>89</b></div>
              <div class="row"><span>Restaurantes visitados</span><b>22</b></div>
              <div class="row"><span>Provincias cubiertas</span><b>6/7</b></div>
            </div>
            <hr>
            <h4 style="margin:0 0 8px;">Cobertura por provincia</h4>
            <?php foreach($PROVINCIAS as $c=>$n): $cubierta = ($c!=='GU'); ?>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
              <span style="font-size:12px;"><?= $cubierta?'✅':'⬜' ?></span>
              <span style="font-size:13px;color:var(--muted);"><?= $n ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- ── RESEÑAS DESTACADAS ── -->
      <div id="tab-destacadas" class="tab-content">
        <div class="section-title" style="margin-top:0;">
          <h2>🌟 Gestionar Reseñas Destacadas</h2>
          <a href="crear-resena.php" class="btn btn-primary btn-sm">+ Nueva reseña</a>
        </div>

        <div class="panel mb" style="padding:16px;">
          <p class="p" style="margin-bottom:12px;">Seleccioná las reseñas que merecen ser destacadas por su calidad y aporte a la comunidad.</p>
          <div class="controls">
            <select class="select" style="max-width:200px;">
              <option>Todas las provincias</option>
              <?php foreach($PROVINCIAS as $c=>$n): ?><option><?= $n ?></option><?php endforeach; ?>
            </select>
            <select class="select" style="max-width:160px;">
              <option>Todos los ratings</option>
              <option>⭐⭐⭐⭐⭐ 5 estrellas</option>
              <option>⭐⭐⭐⭐ 4+ estrellas</option>
            </select>
            <select class="select" style="max-width:160px;">
              <option>Todas</option>
              <option>Destacadas ✅</option>
              <option>No destacadas</option>
            </select>
          </div>
        </div>

        <div class="list">
          <?php foreach($RESENAS as $i => $re):
            $destacada = ($i < 2);
          ?>
          <div class="panel" style="padding:16px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;">
              <div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                  <div class="avatar" style="width:36px;height:36px;font-size:13px;"><?= substr($re['usuario'],0,2) ?></div>
                  <div>
                    <b><?= htmlspecialchars($re['usuario']) ?></b>
                    <p class="sub" style="font-size:12px;"><?= $re['restaurante_nombre'] ?> · <?= $re['fecha'] ?></p>
                  </div>
                </div>
                <p class="p" style="margin-top:10px;"><?= htmlspecialchars($re['comentario']) ?></p>
              </div>
              <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
                <span class="stars"><?= str_repeat('★',$re['rating']) ?></span>
                <span class="badge <?= $destacada?'badge-warning':'' ?>"><?= $destacada?'⭐ Destacada':'Sin destacar' ?></span>
              </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:12px;">
              <?php if($destacada): ?>
                <button class="btn btn-sm btn-warning" onclick="toggleDestacada(this)">⭐ Quitar destaque</button>
              <?php else: ?>
                <button class="btn btn-sm btn-primary" onclick="toggleDestacada(this)">🌟 Destacar reseña</button>
              <?php endif; ?>
              <button class="btn btn-sm" onclick="this.closest('.panel').style.opacity='.5'">🔕 Ignorar</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- ── MULTIMEDIA ── -->
      <div id="tab-multimedia" class="tab-content">
        <div class="section-title" style="margin-top:0;">
          <h2>📸 Gestión Multimedia</h2>
          <button class="btn btn-primary btn-sm" onclick="document.getElementById('uploadMulti').click()">+ Subir contenido</button>
        </div>
        <input type="file" id="uploadMulti" accept="image/*,video/*" multiple style="display:none" onchange="previewMulti(this)" />

        <div id="previewMultiZone" style="margin-bottom:16px;"></div>

        <div class="panel mb" style="padding:14px;">
          <div class="filter-chips" style="margin:0;">
            <span class="chip active" onclick="filtrarMedia('todos',this)">Todos (47)</span>
            <span class="chip" onclick="filtrarMedia('fotos',this)">📷 Fotos (40)</span>
            <span class="chip" onclick="filtrarMedia('videos',this)">🎥 Videos (7)</span>
            <span class="chip" onclick="filtrarMedia('san-jose',this)">San José</span>
            <span class="chip" onclick="filtrarMedia('destacado',this)">⭐ Destacados</span>
          </div>
        </div>

        <div class="gallery-grid" id="mediaGrid">
          <?php foreach($RESTAURANTES as $i => $r): ?>
          <div class="gallery-item media-item" data-tipo="fotos" data-prov="<?= strtolower($r['provincia']) ?>" style="position:relative;">
            <img src="<?= $r['img'] ?>" alt="Media <?= $i+1 ?>" loading="lazy">
            <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.6);padding:6px;display:flex;justify-content:space-between;align-items:center;">
              <span style="font-size:11px;color:#fff;"><?= htmlspecialchars($r['nombre']) ?></span>
              <button onclick="this.closest('.gallery-item').remove()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:14px;">🗑️</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- ── HISTORIAL ── -->
      <div id="tab-historial" class="tab-content">
        <h2 style="margin:0 0 16px;">📋 Historial de Actividad</h2>
        <div class="panel">
          <div class="table-wrap">
            <table>
              <thead><tr><th>Fecha</th><th>Acción</th><th>Restaurante</th><th>Estado</th></tr></thead>
              <tbody>
                <?php
                $acciones = [
                  ['2025-04-02','Reseña destacada','La Esquina Tica','Publicado'],
                  ['2025-04-01','Foto subida','Ramen Niebla','Aprobado'],
                  ['2025-03-30','Reseña creada','Caribbean Spice','Aprobado'],
                  ['2025-03-28','Foto subida','Verde Bowl','Aprobado'],
                  ['2025-03-25','Reseña destacada','Parrilla Volcán','Publicado'],
                  ['2025-03-22','Video subido','Mar y Limón','Pendiente'],
                  ['2025-03-20','Reseña creada','Burgers 10/10','Aprobado'],
                  ['2025-03-18','Reseña destacada','Ramen Niebla','Publicado'],
                ];
                foreach($acciones as [$fecha,$accion,$rest,$estado]):
                  $clsBadge = $estado==='Publicado'?'badge-warning':($estado==='Aprobado'?'badge-success':'badge-primary');
                ?>
                <tr>
                  <td><?= $fecha ?></td>
                  <td><?= $accion ?></td>
                  <td><?= $rest ?></td>
                  <td><span class="badge <?= $clsBadge ?>"><?= $estado ?></span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function showTab(id, el){
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
  const t = document.getElementById('tab-' + id);
  if(t) t.classList.add('active');
  if(el) el.classList.add('active');
}
function toggleDestacada(btn){
  const panel = btn.closest('.panel');
  const badge = panel.querySelector('.badge:last-of-type');
  if(btn.textContent.includes('Quitar')){
    btn.textContent = '🌟 Destacar reseña'; btn.className = 'btn btn-sm btn-primary';
    badge.textContent = 'Sin destacar'; badge.className = 'badge';
  } else {
    btn.textContent = '⭐ Quitar destaque'; btn.className = 'btn btn-sm btn-warning';
    badge.textContent = '⭐ Destacada'; badge.className = 'badge badge-warning';
  }
}
function filtrarMedia(tipo, el){
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
}
function previewMulti(input){
  const zone = document.getElementById('previewMultiZone');
  zone.innerHTML = '<div class="alert alert-success">✅ ' + input.files.length + ' archivo(s) listo(s) para subir.</div>';
}
</script>
