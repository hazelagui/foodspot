<?php
require_once 'includes/data.php';
$titulo = 'Mi Perfil';
$rol    = 'usuario';

// Usuario simulado (sesión mock)
$usuario = $USUARIOS[0];
$mis_resenas = array_filter($RESENAS, fn($r) => $r['usuario'] === 'María F.');

require_once 'includes/header.php';
?>
<main class="container">
  <div class="dash-layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-user">
        <div class="avatar avatar-lg"><?= $usuario['avatar'] ?></div>
        <strong><?= htmlspecialchars($usuario['nombre']) ?></strong>
        <p class="sub" style="margin-top:4px;"><?= $usuario['email'] ?></p>
        <span class="badge badge-primary" style="margin-top:6px;"><?= $usuario['rol'] ?></span>
      </div>
      <nav class="sidebar-menu">
        <button class="sidebar-item active" onclick="showTab('perfil')">👤 Mi Perfil</button>
        <button class="sidebar-item" onclick="showTab('resenas')">💬 Mis Reseñas</button>
        <button class="sidebar-item" onclick="showTab('favoritos-tab')">❤️ Favoritos</button>
        <button class="sidebar-item" onclick="showTab('fotos')">📸 Mis Fotos</button>
        <button class="sidebar-item" onclick="showTab('config')">⚙️ Configuración</button>
        <a class="sidebar-item" href="login.php" style="color:var(--danger);">🚪 Cerrar sesión</a>
      </nav>
    </aside>

    <!-- Contenido -->
    <main>
      <!-- Tab: Perfil -->
      <div id="tab-perfil" class="tab-content active">
        <div class="grid-4 mb">
          <div class="stat-card"><div class="stat-num"><?= $usuario['resenas'] ?></div><div class="stat-label">Reseñas</div></div>
          <div class="stat-card"><div class="stat-num"><?= $usuario['favoritos'] ?></div><div class="stat-label">Favoritos</div></div>
          <div class="stat-card"><div class="stat-num">4.8</div><div class="stat-label">Rating dado</div></div>
          <div class="stat-card"><div class="stat-num">12</div><div class="stat-label">Fotos subidas</div></div>
        </div>

        <div class="panel">
          <h3 style="margin:0 0 16px;">✏️ Editar información</h3>
          <form class="form" onsubmit="alert('Perfil actualizado (visual)');return false;">
            <div class="two-col" style="gap:12px;">
              <div class="group">
                <label>Nombre completo</label>
                <input class="input" value="<?= htmlspecialchars($usuario['nombre']) ?>" />
              </div>
              <div class="group">
                <label>Correo electrónico</label>
                <input class="input" type="email" value="<?= $usuario['email'] ?>" />
              </div>
              <div class="group">
                <label>Teléfono</label>
                <input class="input" placeholder="+506 0000-0000" />
              </div>
              <div class="group">
                <label>Provincia</label>
                <select class="select">
                  <?php foreach($PROVINCIAS as $c => $n): ?>
                    <option><?= $n ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="group">
              <label>Biografía</label>
              <textarea placeholder="Contanos sobre vos y tus preferencias gastronómicas..."></textarea>
            </div>
            <button class="btn btn-primary" type="submit">💾 Guardar cambios</button>
          </form>
        </div>
      </div>

      <!-- Tab: Reseñas -->
      <div id="tab-resenas" class="tab-content">
        <div class="section-title">
          <h2>💬 Mis Reseñas</h2>
          <a href="catalogo.php" class="btn btn-primary btn-sm">+ Nueva reseña</a>
        </div>
        <div class="list">
          <?php foreach($mis_resenas as $re): ?>
          <div class="panel" style="padding:16px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:8px;">
              <div>
                <a href="restaurante.php?id=<?= $re['restaurante_id'] ?>" style="font-weight:800;font-size:16px;color:var(--primary);"><?= htmlspecialchars($re['restaurante_nombre']) ?></a>
                <p class="sub"><?= $re['fecha'] ?></p>
              </div>
              <div style="display:flex;gap:8px;align-items:center;">
                <span class="stars"><?= str_repeat('★', $re['rating']) ?></span>
                <span class="badge <?= $re['estado']==='aprobada'?'badge-success':'badge-warning' ?>"><?= $re['estado'] ?></span>
              </div>
            </div>
            <p class="p" style="margin-top:10px;"><?= htmlspecialchars($re['comentario']) ?></p>
            <div style="display:flex;gap:8px;margin-top:12px;">
              <a href="crear-resena.php?id=<?= $re['restaurante_id'] ?>" class="btn btn-sm">✏️ Editar</a>
              <button class="btn btn-sm btn-danger" onclick="if(confirm('¿Eliminar reseña?')) alert('Eliminada (visual)')">🗑️ Eliminar</button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Tab: Favoritos -->
      <div id="tab-favoritos-tab" class="tab-content">
        <div class="section-title"><h2>❤️ Restaurantes Favoritos</h2></div>
        <section class="grid">
          <?php foreach(array_slice($RESTAURANTES, 0, $usuario['favoritos'] > 6 ? 6 : $usuario['favoritos']) as $r): ?>
          <div class="card" style="position:relative;">
            <button onclick="this.parentElement.remove()" style="position:absolute;top:8px;right:8px;z-index:2;background:rgba(239,68,68,.8);border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;color:#fff;font-size:14px;">✕</button>
            <a href="restaurante.php?id=<?= $r['id'] ?>">
              <div class="thumb"><img src="<?= $r['img'] ?>" alt="<?= htmlspecialchars($r['nombre']) ?>" loading="lazy"></div>
              <div class="card-body">
                <p class="title"><?= htmlspecialchars($r['nombre']) ?></p>
                <p class="sub"><?= $PROVINCIAS[$r['provincia']] ?> · <?= $r['tipo'] ?></p>
                <div class="badges"><span class="badge badge-warning">⭐ <?= $r['rating'] ?></span></div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </section>
      </div>

      <!-- Tab: Fotos -->
      <div id="tab-fotos" class="tab-content">
        <div class="section-title">
          <h2>📸 Mis Fotos Subidas</h2>
          <button class="btn btn-primary btn-sm" onclick="alert('Subir foto (visual)')">+ Subir foto</button>
        </div>
        <div class="gallery-grid">
          <?php foreach(array_slice($RESTAURANTES, 0, 9) as $r): ?>
          <div class="gallery-item">
            <img src="<?= $r['img'] ?>" alt="Foto de <?= htmlspecialchars($r['nombre']) ?>" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Tab: Configuración -->
      <div id="tab-config" class="tab-content">
        <div class="panel">
          <h3 style="margin:0 0 16px;">⚙️ Configuración de cuenta</h3>
          <form class="form" onsubmit="alert('Guardado (visual)');return false;">
            <div class="group">
              <label>Contraseña actual</label>
              <input class="input" type="password" placeholder="••••••••" />
            </div>
            <div class="group">
              <label>Nueva contraseña</label>
              <input class="input" type="password" placeholder="••••••••" />
            </div>
            <div class="group">
              <label>Confirmar nueva contraseña</label>
              <input class="input" type="password" placeholder="••••••••" />
            </div>
            <hr>
            <h4 style="margin:0 0 10px;">Notificaciones</h4>
            <div class="checks" style="flex-direction:column;gap:10px;">
              <label><input type="checkbox" checked> Notificar cuando aprueban mis reseñas</label>
              <label><input type="checkbox" checked> Notificar actualizaciones de favoritos</label>
              <label><input type="checkbox"> Boletín semanal de restaurantes</label>
            </div>
            <hr>
            <button class="btn btn-primary" type="submit">💾 Guardar configuración</button>
            <button class="btn btn-danger" type="button" onclick="if(confirm('¿Eliminar cuenta?')) alert('(Visual)')">🗑️ Eliminar cuenta</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function showTab(id){
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
  document.getElementById('tab-' + id).classList.add('active');
  event.target.classList.add('active');
}
</script>
