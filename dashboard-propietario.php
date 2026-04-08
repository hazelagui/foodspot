<?php
require_once 'includes/data.php';
$titulo = 'Panel Propietario';
$rol    = 'propietario';

// Restaurante del propietario (mock: el primero de SJ)
$mi_rest = $RESTAURANTES[0]; // La Esquina Tica

$tab_activa = $_GET['tab'] ?? 'inicio';

$menu_mock = [
  ['Casado completo','₡3,500','Plato fuerte'],
  ['Arroz con pollo','₡3,200','Plato fuerte'],
  ['Sopa negra','₡1,800','Entrada'],
  ['Fresco natural','₡800','Bebida'],
  ['Gallo pinto','₡2,500','Desayuno'],
  ['Tamales','₡1,500','Antojo'],
];

require_once 'includes/header.php';
?>
<main class="container">
  <div class="dash-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-user">
        <div class="avatar avatar-lg">CP</div>
        <strong>Carlos Propietario</strong>
        <p class="sub" style="margin-top:4px;">propietario@test.com</p>
        <span class="badge badge-warning" style="margin-top:6px;">🏪 Propietario</span>
      </div>
      <nav class="sidebar-menu">
        <button class="sidebar-item <?= $tab_activa==='inicio'?'active':'' ?>"     onclick="showTab('inicio',this)">📊 Inicio</button>
        <button class="sidebar-item <?= $tab_activa==='info'?'active':'' ?>"       onclick="showTab('info',this)">📝 Info Restaurante</button>
        <button class="sidebar-item <?= $tab_activa==='menu'?'active':'' ?>"       onclick="showTab('menu',this)">🍽️ Menú</button>
        <button class="sidebar-item <?= $tab_activa==='horarios'?'active':'' ?>"   onclick="showTab('horarios',this)">🕐 Horarios</button>
        <button class="sidebar-item <?= $tab_activa==='servicios'?'active':'' ?>"  onclick="showTab('servicios',this)">⚙️ Servicios</button>
        <button class="sidebar-item <?= $tab_activa==='galeria'?'active':'' ?>"    onclick="showTab('galeria',this)">📸 Galería</button>
        <button class="sidebar-item <?= $tab_activa==='estadisticas'?'active':'' ?>" onclick="showTab('estadisticas',this)">📈 Estadísticas</button>
        <a class="sidebar-item" href="login.php" style="color:var(--danger);margin-top:8px;">🚪 Cerrar sesión</a>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main>

      <!-- ── TAB INICIO ── -->
      <div id="tab-inicio" class="tab-content <?= $tab_activa==='inicio'?'active':'' ?>">
        <div class="section-title" style="margin-top:0;">
          <h2>📊 Resumen de <?= htmlspecialchars($mi_rest['nombre']) ?></h2>
          <a href="restaurante.php?id=<?= $mi_rest['id'] ?>" class="btn btn-sm">👁️ Ver público</a>
        </div>

        <div class="grid-4 mb">
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['visitas_mes'] ?></div><div class="stat-label">Visitas este mes</div></div>
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['resenas_total'] ?></div><div class="stat-label">Reseñas totales</div></div>
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['rating_promedio'] ?></div><div class="stat-label">Rating promedio</div></div>
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['favoritos'] ?></div><div class="stat-label">En favoritos</div></div>
        </div>

        <div class="two-col">
          <div class="panel">
            <h3 style="margin:0 0 12px;">💬 Últimas reseñas recibidas</h3>
            <div class="list">
              <?php foreach(array_slice($RESENAS,0,3) as $re): ?>
              <div style="padding:12px;border-radius:var(--radius-sm);border:1px solid var(--border);background:rgba(255,255,255,.02);">
                <div class="row" style="align-items:center;">
                  <b><?= htmlspecialchars($re['usuario']) ?></b>
                  <div style="display:flex;gap:6px;align-items:center;">
                    <span class="stars" style="font-size:12px;"><?= str_repeat('★',$re['rating']) ?></span>
                    <span class="badge <?= $re['estado']==='aprobada'?'badge-success':'badge-warning' ?>"><?= $re['estado'] ?></span>
                  </div>
                </div>
                <p class="p" style="margin-top:6px;font-size:13px;"><?= mb_substr(htmlspecialchars($re['comentario']),0,100) ?>...</p>
                <p class="sub"><?= $re['fecha'] ?></p>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 12px;">⚡ Acciones rápidas</h3>
            <div class="list">
              <button class="btn btn-primary btn-full" onclick="showTab('info',document.querySelector('.sidebar-item:nth-child(2)'))">✏️ Editar información</button>
              <button class="btn btn-full" onclick="showTab('menu',document.querySelector('.sidebar-item:nth-child(3)'))">🍽️ Actualizar menú</button>
              <button class="btn btn-full" onclick="showTab('galeria',document.querySelector('.sidebar-item:nth-child(6)'))">📸 Subir fotos</button>
              <button class="btn btn-full" onclick="showTab('horarios',document.querySelector('.sidebar-item:nth-child(4)'))">🕐 Cambiar horarios</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ── TAB INFO RESTAURANTE ── -->
      <div id="tab-info" class="tab-content <?= $tab_activa==='info'?'active':'' ?>">
        <h2 style="margin:0 0 16px;">📝 Información del Restaurante</h2>
        <?php
        $posted = $_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_info']);
        if($posted): ?>
          <div class="alert alert-success">✅ Información actualizada correctamente.</div>
        <?php endif; ?>
        <div class="panel">
          <form class="form" method="POST">
            <div class="two-col" style="gap:12px;">
              <div class="group">
                <label>Nombre del restaurante *</label>
                <input class="input" name="nombre" value="<?= htmlspecialchars($mi_rest['nombre']) ?>" required />
              </div>
              <div class="group">
                <label>Provincia *</label>
                <select class="select" name="provincia">
                  <?php foreach($PROVINCIAS as $c=>$n): ?>
                    <option value="<?= $c ?>" <?= $mi_rest['provincia']===$c?'selected':'' ?>><?= $n ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="group">
                <label>Tipo de cocina</label>
                <input class="input" name="tipo" value="<?= htmlspecialchars($mi_rest['tipo']) ?>" />
              </div>
              <div class="group">
                <label>Teléfono</label>
                <input class="input" name="telefono" value="<?= htmlspecialchars($mi_rest['telefono']) ?>" />
              </div>
            </div>
            <div class="group">
              <label>Dirección completa</label>
              <input class="input" name="direccion" value="<?= htmlspecialchars($mi_rest['direccion']) ?>" />
            </div>
            <div class="group">
              <label>Descripción</label>
              <textarea name="descripcion"><?= htmlspecialchars($mi_rest['descripcion']) ?></textarea>
            </div>
            <div class="group">
              <label>URL Instagram</label>
              <input class="input" name="instagram" placeholder="@mi_restaurante" />
            </div>
            <div class="group">
              <label>Sitio web</label>
              <input class="input" name="web" type="url" placeholder="https://mi-restaurante.cr" />
            </div>
            <button class="btn btn-primary" name="save_info" type="submit">💾 Guardar información</button>
          </form>
        </div>
      </div>

      <!-- ── TAB MENÚ ── -->
      <div id="tab-menu" class="tab-content <?= $tab_activa==='menu'?'active':'' ?>">
        <div class="section-title" style="margin-top:0;">
          <h2>🍽️ Gestión del Menú</h2>
          <button class="btn btn-primary btn-sm" onclick="agregarPlato()">+ Agregar plato</button>
        </div>

        <div id="alertMenu"></div>

        <div class="panel">
          <div class="table-wrap">
            <table id="tablaMenu">
              <thead>
                <tr>
                  <th>#</th><th>Plato</th><th>Precio</th><th>Categoría</th><th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($menu_mock as $i => [$plato,$precio,$cat]): ?>
                <tr id="row-<?= $i ?>">
                  <td><?= $i+1 ?></td>
                  <td><input class="input" style="padding:6px 10px;" value="<?= htmlspecialchars($plato) ?>" /></td>
                  <td><input class="input" style="padding:6px 10px;max-width:110px;" value="<?= $precio ?>" /></td>
                  <td>
                    <select class="select" style="padding:6px 10px;">
                      <?php foreach(['Plato fuerte','Entrada','Bebida','Postre','Desayuno','Antojo'] as $cat_op): ?>
                        <option <?= $cat_op===$cat?'selected':'' ?>><?= $cat_op ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td><button class="btn btn-sm btn-danger" onclick="elimFila(<?= $i ?>)">🗑️</button></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div style="margin-top:16px;">
            <button class="btn btn-primary" onclick="guardarMenu()">💾 Guardar menú</button>
          </div>
        </div>
      </div>

      <!-- ── TAB HORARIOS ── -->
      <div id="tab-horarios" class="tab-content <?= $tab_activa==='horarios'?'active':'' ?>">
        <h2 style="margin:0 0 16px;">🕐 Horarios de Atención</h2>
        <div class="panel">
          <form class="form" onsubmit="alert('Horarios guardados ✅');return false;">
            <?php
            $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
            $abiertos = [true,true,true,true,true,true,false];
            foreach($dias as $i => $dia):
            ?>
            <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding:10px 0;border-bottom:1px solid var(--border);">
              <div style="min-width:90px;font-weight:700;"><?= $dia ?></div>
              <label style="display:flex;align-items:center;gap:8px;color:var(--muted);">
                <input type="checkbox" <?= $abiertos[$i]?'checked':'' ?> class="toggle-dia" data-dia="<?= $i ?>">
                Abierto
              </label>
              <div style="display:flex;gap:8px;align-items:center;" id="horas-<?= $i ?>" <?= !$abiertos[$i]?'style="opacity:.3;pointer-events:none;"':'' ?>>
                <input class="input" type="time" value="11:00" style="max-width:120px;padding:8px 10px;" />
                <span style="color:var(--muted);">a</span>
                <input class="input" type="time" value="21:00" style="max-width:120px;padding:8px 10px;" />
              </div>
            </div>
            <?php endforeach; ?>
            <button class="btn btn-primary" type="submit">💾 Guardar horarios</button>
          </form>
        </div>
      </div>

      <!-- ── TAB SERVICIOS ── -->
      <div id="tab-servicios" class="tab-content <?= $tab_activa==='servicios'?'active':'' ?>">
        <h2 style="margin:0 0 16px;">⚙️ Servicios Ofrecidos</h2>
        <div class="panel">
          <form class="form" onsubmit="alert('Servicios guardados ✅');return false;">
            <h4 style="margin:0 0 10px;">Comodidades</h4>
            <div class="checks" style="gap:14px;">
              <label><input type="checkbox" checked> 📶 WiFi gratis</label>
              <label><input type="checkbox" checked> 🅿️ Parqueo</label>
              <label><input type="checkbox" checked> ♿ Accesibilidad</label>
              <label><input type="checkbox"> 🌳 Área al aire libre</label>
              <label><input type="checkbox" checked> 🐶 Pet friendly</label>
              <label><input type="checkbox"> 🎶 Música en vivo</label>
            </div>
            <hr>
            <h4 style="margin:0 0 10px;">Métodos de pago</h4>
            <div class="checks" style="gap:14px;">
              <label><input type="checkbox" checked> 💵 Efectivo</label>
              <label><input type="checkbox" checked> 💳 Tarjeta débito</label>
              <label><input type="checkbox" checked> 💳 Tarjeta crédito</label>
              <label><input type="checkbox"> 📱 SINPE Móvil</label>
              <label><input type="checkbox"> 💻 Transferencia</label>
            </div>
            <hr>
            <h4 style="margin:0 0 10px;">Tipo de servicio</h4>
            <div class="checks" style="gap:14px;">
              <label><input type="checkbox" checked> 🥡 Para llevar</label>
              <label><input type="checkbox" checked> 🍽️ Comer en el lugar</label>
              <label><input type="checkbox"> 🛵 Delivery propio</label>
              <label><input type="checkbox"> 📱 Uber Eats / Rappi</label>
              <label><input type="checkbox"> 🎉 Reservaciones</label>
              <label><input type="checkbox"> 🎂 Eventos privados</label>
            </div>
            <hr>
            <h4 style="margin:0 0 10px;">Opciones de menú</h4>
            <div class="checks" style="gap:14px;">
              <label><input type="checkbox"> 🥗 Opciones veganas</label>
              <label><input type="checkbox"> 🌾 Sin gluten</label>
              <label><input type="checkbox"> 🥛 Sin lácteos</label>
              <label><input type="checkbox" checked> 👨‍👩‍👧 Menú infantil</label>
            </div>
            <button class="btn btn-primary" type="submit">💾 Guardar servicios</button>
          </form>
        </div>
      </div>

      <!-- ── TAB GALERÍA ── -->
      <div id="tab-galeria" class="tab-content <?= $tab_activa==='galeria'?'active':'' ?>">
        <div class="section-title" style="margin-top:0;">
          <h2>📸 Galería de Fotos</h2>
          <button class="btn btn-primary btn-sm" onclick="document.getElementById('inputFoto').click()">+ Subir foto</button>
        </div>
        <input type="file" id="inputFoto" accept="image/*" multiple style="display:none" onchange="previewFotos(this)" />

        <div id="previewZone"></div>

        <div class="gallery-grid" id="galeriaGrid">
          <?php for($i=0;$i<9;$i++): $r2=$RESTAURANTES[$i%count($RESTAURANTES)]; ?>
          <div class="gallery-item" style="position:relative;">
            <img src="<?= $r2['img'] ?>" alt="Foto <?= $i+1 ?>" loading="lazy">
            <button onclick="this.parentElement.remove()"
              style="position:absolute;top:4px;right:4px;background:rgba(239,68,68,.85);border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;color:#fff;font-size:12px;">✕</button>
          </div>
          <?php endfor; ?>
        </div>
        <div style="margin-top:16px;">
          <button class="btn btn-primary" onclick="alert('Galería guardada ✅')">💾 Guardar cambios</button>
        </div>
      </div>

      <!-- ── TAB ESTADÍSTICAS ── -->
      <div id="tab-estadisticas" class="tab-content <?= $tab_activa==='estadisticas'?'active':'' ?>">
        <h2 style="margin:0 0 16px;">📈 Estadísticas del Restaurante</h2>

        <div class="grid-4 mb">
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['visitas_mes'] ?></div><div class="stat-label">Visitas este mes</div></div>
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['resenas_total'] ?></div><div class="stat-label">Reseñas totales</div></div>
          <div class="stat-card"><div class="stat-num">⭐ <?= $ESTADISTICAS['rating_promedio'] ?></div><div class="stat-label">Rating promedio</div></div>
          <div class="stat-card"><div class="stat-num"><?= $ESTADISTICAS['favoritos'] ?></div><div class="stat-label">En favoritos</div></div>
        </div>

        <div class="two-col">
          <div class="panel">
            <h3 style="margin:0 0 12px;">📊 Visitas esta semana</h3>
            <div class="chart-bars" id="chartVisitas">
              <?php foreach($ESTADISTICAS['visitas_semana'] as $vis):
                $pct = round($vis / max($ESTADISTICAS['visitas_semana']) * 100);
              ?>
              <div class="chart-bar" style="height:<?= $pct ?>%;" title="<?= $vis ?> visitas"></div>
              <?php endforeach; ?>
            </div>
            <div class="chart-labels">
              <?php foreach(['L','M','X','J','V','S','D'] as $d): ?>
                <span><?= $d ?></span>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 12px;">⭐ Distribución de ratings</h3>
            <?php
            $dist = [5=>20, 4=>12, 3=>4, 2=>1, 1=>1];
            $total_rat = array_sum($dist);
            foreach(array_reverse(array_keys($dist), true) as $n):
              $pct_r = round($dist[$n] / $total_rat * 100);
            ?>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
              <span style="min-width:20px;color:#f59e0b;font-weight:700;"><?= $n ?>★</span>
              <div style="flex:1;height:10px;background:rgba(255,255,255,.06);border-radius:99px;overflow:hidden;">
                <div style="width:<?= $pct_r ?>%;height:100%;background:linear-gradient(90deg,var(--primary),var(--primary-2));border-radius:99px;"></div>
              </div>
              <span style="min-width:28px;color:var(--muted);font-size:12px;"><?= $dist[$n] ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="panel" style="margin-top:16px;">
          <h3 style="margin:0 0 12px;">🔍 Fuentes de tráfico</h3>
          <div class="list">
            <div class="row"><span>Búsqueda directa</span><b>45%</b></div>
            <div class="row"><span>Catálogo por provincia</span><b>30%</b></div>
            <div class="row"><span>Filtro por tipo de comida</span><b>15%</b></div>
            <div class="row"><span>Favoritos de usuarios</span><b>10%</b></div>
          </div>
        </div>
      </div>

    </main><!-- /content -->
  </div><!-- /dash-layout -->
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function showTab(id, el){
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
  const tabEl = document.getElementById('tab-' + id);
  if(tabEl) tabEl.classList.add('active');
  if(el) el.classList.add('active');
}

// Toggle días horario
document.querySelectorAll('.toggle-dia').forEach(cb => {
  cb.addEventListener('change', function(){
    const zona = document.getElementById('horas-' + this.dataset.dia);
    if(zona){
      zona.style.opacity = this.checked ? '1' : '.3';
      zona.style.pointerEvents = this.checked ? '' : 'none';
    }
  });
});

// Menú: agregar fila
let filaCount = <?= count($menu_mock) ?>;
function agregarPlato(){
  const tbody = document.querySelector('#tablaMenu tbody');
  const tr = document.createElement('tr');
  tr.id = 'row-' + filaCount;
  tr.innerHTML = `<td>${filaCount+1}</td>
    <td><input class="input" style="padding:6px 10px;" placeholder="Nombre del plato" /></td>
    <td><input class="input" style="padding:6px 10px;max-width:110px;" placeholder="₡0" /></td>
    <td><select class="select" style="padding:6px 10px;">
      <option>Plato fuerte</option><option>Entrada</option><option>Bebida</option><option>Postre</option><option>Desayuno</option><option>Antojo</option>
    </select></td>
    <td><button class="btn btn-sm btn-danger" onclick="elimFila(${filaCount})">🗑️</button></td>`;
  tbody.appendChild(tr);
  filaCount++;
}
function elimFila(i){
  const row = document.getElementById('row-' + i);
  if(row) row.remove();
}
function guardarMenu(){
  document.getElementById('alertMenu').innerHTML = '<div class="alert alert-success">✅ Menú guardado correctamente.</div>';
  setTimeout(()=> document.getElementById('alertMenu').innerHTML = '', 3000);
}

// Preview fotos
function previewFotos(input){
  const zone = document.getElementById('previewZone');
  zone.innerHTML = '';
  Array.from(input.files).forEach(file => {
    const url = URL.createObjectURL(file);
    const d = document.createElement('div');
    d.className = 'gallery-item';
    d.style.cssText='display:inline-block;width:80px;height:80px;margin:4px;border-radius:8px;overflow:hidden;';
    d.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover;">`;
    zone.appendChild(d);
  });
}
</script>
