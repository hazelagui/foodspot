<?php
require_once 'includes/data.php';
$titulo = 'Panel Admin';
$rol    = 'admin';

require_once 'includes/header.php';
?>
<main class="container">
  <div class="dash-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-user">
        <div class="avatar avatar-lg" style="background:linear-gradient(135deg,#ef4444,#7c3aed);">SA</div>
        <strong>Super Admin</strong>
        <p class="sub" style="margin-top:4px;">admin@test.com</p>
        <span class="badge badge-danger" style="margin-top:6px;">🛡️ Administrador</span>
      </div>
      <nav class="sidebar-menu">
        <button class="sidebar-item active" onclick="showTab('inicio',this)">📊 Dashboard Admin</button>
        <button class="sidebar-item" onclick="showTab('usuarios',this)">👥 Usuarios</button>
        <button class="sidebar-item" onclick="showTab('restaurantes',this)">🍽️ Restaurantes</button>
        <button class="sidebar-item" onclick="showTab('moderacion',this)">🔍 Moderación</button>
        <button class="sidebar-item" onclick="showTab('reportes',this)">📈 Reportes</button>
        <button class="sidebar-item" onclick="showTab('configuracion',this)">⚙️ Configuración</button>
        <a class="sidebar-item" href="login.php" style="color:var(--danger);margin-top:8px;">🚪 Cerrar sesión</a>
      </nav>
    </aside>

    <!-- Contenido -->
    <main>

      <!-- ── DASHBOARD ADMIN ── -->
      <div id="tab-inicio" class="tab-content active">
        <div class="section-title" style="margin-top:0;">
          <h2>🛡️ Dashboard Administrador</h2>
          <span class="badge badge-danger">Sistema activo</span>
        </div>

        <div class="grid-4 mb">
          <div class="stat-card" style="border-color:rgba(91,140,255,.3);">
            <div class="stat-num" style="color:var(--primary);"><?= count($USUARIOS) ?></div>
            <div class="stat-label">Usuarios registrados</div>
          </div>
          <div class="stat-card" style="border-color:rgba(34,197,94,.3);">
            <div class="stat-num" style="color:var(--success);"><?= count($RESTAURANTES) ?></div>
            <div class="stat-label">Restaurantes</div>
          </div>
          <div class="stat-card" style="border-color:rgba(245,158,11,.3);">
            <div class="stat-num" style="color:var(--warning);"><?= count($RESENAS) ?></div>
            <div class="stat-label">Reseñas totales</div>
          </div>
          <div class="stat-card" style="border-color:rgba(239,68,68,.3);">
            <?php $pendientes = count(array_filter($RESENAS, fn($r)=>$r['estado']==='pendiente')); ?>
            <div class="stat-num" style="color:var(--danger);"><?= $pendientes ?></div>
            <div class="stat-label">Pendientes revisión</div>
          </div>
        </div>

        <?php if($pendientes > 0): ?>
          <div class="alert alert-danger">⚠️ Hay <?= $pendientes ?> reseña(s) pendientes de moderación. <button class="btn btn-sm btn-danger" onclick="showTab('moderacion',document.querySelectorAll('.sidebar-item')[3])">Revisar ahora</button></div>
        <?php endif; ?>

        <div class="two-col">
          <div class="panel">
            <h3 style="margin:0 0 12px;">👥 Últimos usuarios registrados</h3>
            <div class="list">
              <?php foreach($USUARIOS as $u): ?>
              <div style="display:flex;align-items:center;gap:12px;padding:8px;border-radius:var(--radius-sm);background:rgba(255,255,255,.02);">
                <div class="avatar" style="width:36px;height:36px;font-size:13px;"><?= $u['avatar'] ?></div>
                <div style="flex:1;">
                  <b style="font-size:14px;"><?= htmlspecialchars($u['nombre']) ?></b>
                  <p class="sub" style="font-size:12px;"><?= $u['email'] ?> · <?= $u['fecha_registro'] ?></p>
                </div>
                <span class="badge <?= $u['rol']==='Admin'?'badge-danger':($u['rol']==='Propietario'?'badge-warning':($u['rol']==='Creador'?'badge-primary':'')) ?>"><?= $u['rol'] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 12px;">📊 Sistema en números</h3>
            <div class="list">
              <div class="row"><span>Total visitas hoy</span><b>342</b></div>
              <div class="row"><span>Búsquedas realizadas</span><b>128</b></div>
              <div class="row"><span>Provincias más visitadas</span><b>San José</b></div>
              <div class="row"><span>Tipo de comida más buscado</span><b>Típica</b></div>
              <div class="row"><span>Restaurante más visto</span><b>La Esquina Tica</b></div>
              <div class="row"><span>Servidor</span><b style="color:var(--success);">✅ Operativo</b></div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── USUARIOS ── -->
      <div id="tab-usuarios" class="tab-content">
        <div class="section-title" style="margin-top:0;">
          <h2>👥 Gestión de Usuarios</h2>
          <button class="btn btn-primary btn-sm" onclick="alert('Crear usuario (visual)')">+ Nuevo usuario</button>
        </div>

        <div class="panel mb" style="padding:14px;">
          <div class="controls">
            <input class="input" placeholder="🔍 Buscar usuario..." oninput="filtrarTabla(this.value,'tablaUsuarios')" style="max-width:280px;" />
            <select class="select" style="max-width:160px;">
              <option>Todos los roles</option>
              <option>Usuario</option>
              <option>Propietario</option>
              <option>Creador</option>
              <option>Admin</option>
            </select>
            <select class="select" style="max-width:160px;">
              <option>Todos los estados</option>
              <option>Activo</option>
              <option>Suspendido</option>
            </select>
          </div>
        </div>

        <div class="panel">
          <div class="table-wrap">
            <table id="tablaUsuarios">
              <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Registro</th><th>Reseñas</th><th>Acciones</th></tr></thead>
              <tbody>
                <?php foreach($USUARIOS as $u): ?>
                <tr>
                  <td><?= $u['id'] ?></td>
                  <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                      <div class="avatar" style="width:30px;height:30px;font-size:11px;"><?= $u['avatar'] ?></div>
                      <?= htmlspecialchars($u['nombre']) ?>
                    </div>
                  </td>
                  <td style="color:var(--muted);"><?= $u['email'] ?></td>
                  <td><span class="badge <?= $u['rol']==='Creador'?'badge-primary':($u['rol']==='Propietario'?'badge-warning':'') ?>"><?= $u['rol'] ?></span></td>
                  <td style="color:var(--muted);"><?= $u['fecha_registro'] ?></td>
                  <td><?= $u['resenas'] ?></td>
                  <td>
                    <div style="display:flex;gap:4px;">
                      <button class="btn btn-sm" onclick="alert('Editar (visual)')">✏️</button>
                      <button class="btn btn-sm btn-warning" onclick="alert('Suspender (visual)')">⏸️</button>
                      <button class="btn btn-sm btn-danger" onclick="if(confirm('¿Eliminar?')) this.closest('tr').remove()">🗑️</button>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── RESTAURANTES ── -->
      <div id="tab-restaurantes" class="tab-content">
        <div class="section-title" style="margin-top:0;">
          <h2>🍽️ Gestión de Restaurantes</h2>
          <button class="btn btn-primary btn-sm" onclick="alert('Registrar restaurante (visual)')">+ Agregar</button>
        </div>

        <div class="panel mb" style="padding:14px;">
          <div class="controls">
            <input class="input" placeholder="🔍 Buscar restaurante..." oninput="filtrarTabla(this.value,'tablaRests')" style="max-width:250px;" />
            <select class="select" style="max-width:170px;">
              <option>Todas las provincias</option>
              <?php foreach($PROVINCIAS as $c=>$n): ?><option value="<?= $c ?>"><?= $n ?></option><?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="panel">
          <div class="table-wrap">
            <table id="tablaRests">
              <thead><tr><th>ID</th><th>Nombre</th><th>Provincia</th><th>Tipo</th><th>Rating</th><th>Accesible</th><th>Acciones</th></tr></thead>
              <tbody>
                <?php foreach($RESTAURANTES as $r): ?>
                <tr>
                  <td style="color:var(--muted);font-size:12px;"><?= $r['id'] ?></td>
                  <td><b><?= htmlspecialchars($r['nombre']) ?></b></td>
                  <td><?= $PROVINCIAS[$r['provincia']] ?></td>
                  <td style="color:var(--muted);"><?= $r['tipo'] ?></td>
                  <td><span class="stars" style="font-size:12px;">★</span> <?= $r['rating'] ?></td>
                  <td><?= $r['accesible'] ? '<span class="badge badge-success">✅</span>' : '<span class="badge badge-danger">❌</span>' ?></td>
                  <td>
                    <div style="display:flex;gap:4px;">
                      <a href="restaurante.php?id=<?= $r['id'] ?>" class="btn btn-sm">👁️</a>
                      <button class="btn btn-sm" onclick="alert('Editar (visual)')">✏️</button>
                      <button class="btn btn-sm btn-danger" onclick="if(confirm('¿Eliminar restaurante?')) this.closest('tr').remove()">🗑️</button>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── MODERACIÓN ── -->
      <div id="tab-moderacion" class="tab-content">
        <div class="section-title" style="margin-top:0;">
          <h2>🔍 Moderación de Reseñas</h2>
          <span class="badge badge-danger"><?= $pendientes ?> pendiente<?= $pendientes!==1?'s':'' ?></span>
        </div>

        <div class="list">
          <?php foreach($RESENAS as $re):
            $cls = $re['estado']==='aprobada'?'badge-success':'badge-warning';
          ?>
          <div class="panel" style="padding:16px;" id="resena-<?= $re['id'] ?>">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;">
              <div>
                <div style="display:flex;align-items:center;gap:10px;">
                  <div class="avatar" style="width:36px;height:36px;font-size:12px;"><?= substr($re['usuario'],0,2) ?></div>
                  <div>
                    <b><?= htmlspecialchars($re['usuario']) ?></b>
                    <p class="sub" style="font-size:12px;"><?= $re['restaurante_nombre'] ?> · <?= $re['fecha'] ?></p>
                  </div>
                </div>
                <p class="p" style="margin-top:10px;"><?= htmlspecialchars($re['comentario']) ?></p>
              </div>
              <div style="text-align:right;">
                <span class="stars"><?= str_repeat('★',$re['rating']) ?></span><br>
                <span class="badge <?= $cls ?>" style="margin-top:6px;"><?= $re['estado'] ?></span>
              </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:14px;">
              <?php if($re['estado']==='pendiente'): ?>
                <button class="btn btn-sm btn-success" onclick="moderarResena(<?= $re['id'] ?>,'aprobar',this)">✅ Aprobar</button>
                <button class="btn btn-sm btn-danger"  onclick="moderarResena(<?= $re['id'] ?>,'rechazar',this)">❌ Rechazar</button>
              <?php else: ?>
                <span class="badge badge-success" style="font-size:13px;">✅ Ya aprobada</span>
                <button class="btn btn-sm btn-warning" onclick="moderarResena(<?= $re['id'] ?>,'rechazar',this)">⏪ Revocar</button>
              <?php endif; ?>
              <button class="btn btn-sm" onclick="if(confirm('¿Eliminar reseña?')) document.getElementById('resena-<?= $re['id'] ?>').remove()">🗑️ Eliminar</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- ── REPORTES ── -->
      <div id="tab-reportes" class="tab-content">
        <h2 style="margin:0 0 16px;">📈 Reportes del Sistema</h2>

        <div class="grid-2 mb">
          <div class="panel">
            <h3 style="margin:0 0 12px;">🗺️ Restaurantes por provincia</h3>
            <?php
            $count_prov = array_count_values(array_column($RESTAURANTES,'provincia'));
            $max_c = max($count_prov);
            foreach($PROVINCIAS as $c=>$n):
              $cant = $count_prov[$c] ?? 0;
              $pct = round($cant/$max_c*100);
            ?>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
              <span style="min-width:80px;font-size:13px;color:var(--muted);"><?= $n ?></span>
              <div style="flex:1;height:8px;background:rgba(255,255,255,.06);border-radius:99px;overflow:hidden;">
                <div style="width:<?= $pct ?>%;height:100%;background:linear-gradient(90deg,var(--primary),var(--primary-2));border-radius:99px;"></div>
              </div>
              <b style="min-width:14px;"><?= $cant ?></b>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 12px;">🍛 Tipos de cocina</h3>
            <?php
            $tipos_c = array_count_values(array_column($RESTAURANTES,'tipo'));
            arsort($tipos_c);
            foreach($tipos_c as $tipo=>$cant):
              $pct = round($cant/max($tipos_c)*100);
            ?>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
              <span style="min-width:90px;font-size:12px;color:var(--muted);"><?= $tipo ?></span>
              <div style="flex:1;height:8px;background:rgba(255,255,255,.06);border-radius:99px;overflow:hidden;">
                <div style="width:<?= $pct ?>%;height:100%;background:linear-gradient(90deg,#f59e0b,#ef4444);border-radius:99px;"></div>
              </div>
              <b style="min-width:14px;"><?= $cant ?></b>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="panel">
          <h3 style="margin:0 0 12px;">📊 Actividad semanal del sistema</h3>
          <div class="chart-bars" style="height:100px;">
            <?php foreach([85,120,98,145,200,178,220] as $v):
              $pct = round($v/220*100);
            ?>
            <div class="chart-bar" style="height:<?= $pct ?>%;" title="<?= $v ?> acciones"></div>
            <?php endforeach; ?>
          </div>
          <div class="chart-labels">
            <?php foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $d): ?>
              <span><?= $d ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- ── CONFIGURACIÓN ── -->
      <div id="tab-configuracion" class="tab-content">
        <h2 style="margin:0 0 16px;">⚙️ Configuración del Sistema</h2>

        <div class="two-col">
          <div class="panel">
            <h3 style="margin:0 0 14px;">🌐 General</h3>
            <form class="form" onsubmit="alert('Configuración guardada ✅');return false;">
              <div class="group"><label>Nombre del sitio</label><input class="input" value="FOODSPOT" /></div>
              <div class="group"><label>Descripción</label><input class="input" value="Directorio gastronómico de Costa Rica" /></div>
              <div class="group"><label>Email de contacto</label><input class="input" type="email" value="info@foodspot.cr" /></div>
              <div class="group"><label>Restaurantes por página</label>
                <select class="select"><option>6</option><option selected>9</option><option>12</option></select>
              </div>
              <hr>
              <h4 style="margin:0 0 10px;">Moderación automática</h4>
              <div class="checks" style="flex-direction:column;gap:10px;">
                <label><input type="checkbox" checked> Aprobar reseñas automáticamente si rating ≥ 4</label>
                <label><input type="checkbox"> Requiere foto para publicar reseña</label>
                <label><input type="checkbox" checked> Notificar admin por reseñas negativas (1-2★)</label>
              </div>
              <button class="btn btn-primary" type="submit">💾 Guardar configuración</button>
            </form>
          </div>
          <div class="panel">
            <h3 style="margin:0 0 14px;">🛡️ Seguridad y acceso</h3>
            <form class="form" onsubmit="alert('Guardado ✅');return false;">
              <div class="group"><label>Intentos de login máximos</label>
                <select class="select"><option>3</option><option selected>5</option><option>10</option></select>
              </div>
              <div class="group"><label>Tiempo de sesión (minutos)</label>
                <input class="input" type="number" value="60" min="15" max="1440" />
              </div>
              <div class="checks" style="flex-direction:column;gap:10px;margin-top:8px;">
                <label><input type="checkbox" checked> Registro público habilitado</label>
                <label><input type="checkbox"> Verificación de email obligatoria</label>
                <label><input type="checkbox" checked> CAPTCHA en login</label>
              </div>
              <hr>
              <h4 style="margin:0 0 10px;">Mantenimiento</h4>
              <button class="btn btn-warning btn-full" type="button" onclick="alert('Caché limpiado ✅')">🗑️ Limpiar caché del sistema</button>
              <button class="btn btn-danger btn-full" type="button" onclick="if(confirm('¿Activar modo mantenimiento?')) alert('Modo activado (visual)')">🔧 Modo mantenimiento</button>
            </form>
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

function filtrarTabla(q, tablaId){
  const tbody = document.querySelector('#' + tablaId + ' tbody');
  Array.from(tbody.rows).forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
  });
}

function moderarResena(id, accion, btn){
  const panel = document.getElementById('resena-' + id);
  const badge = panel.querySelector('.badge:last-of-type');
  if(accion === 'aprobar'){
    badge.textContent = 'aprobada'; badge.className = 'badge badge-success';
    btn.parentElement.innerHTML = '<span class="badge badge-success" style="font-size:13px;">✅ Ya aprobada</span><button class="btn btn-sm btn-warning" onclick="moderarResena('+id+\',\'rechazar\',this)">⏪ Revocar</button><button class="btn btn-sm" onclick="if(confirm(\'¿Eliminar?\')) document.getElementById(\'resena-'+id+'\').remove()">🗑️ Eliminar</button>';
  } else {
    badge.textContent = 'rechazada'; badge.className = 'badge badge-danger';
    panel.style.opacity = '.5';
    setTimeout(()=> panel.remove(), 1500);
  }
}
</script>
