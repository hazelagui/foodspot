<?php
require_once 'includes/data.php';
$titulo = 'Ayuda';
$rol    = 'publico';
require_once 'includes/header.php';
?>
<main class="container mt">
  <div class="breadcrumb">
    <a href="index.php">🏠 Inicio</a> › <span>Ayuda</span>
  </div>

  <div style="text-align:center;padding:30px 0 20px;">
    <div style="font-size:48px;margin-bottom:10px;">❓</div>
    <h1 class="h1" style="font-size:28px;margin:0 0 8px;">Centro de Ayuda</h1>
    <p class="p">¿Tenés dudas? Encontrá respuestas aquí.</p>
    <div class="search-bar" style="max-width:440px;">
      <input type="text" id="searchFaq" placeholder="Buscar en la ayuda..." oninput="buscarFaq(this.value)" />
      <button>🔍</button>
    </div>
  </div>

  <div class="two-col">
    <!-- FAQ -->
    <div>
      <?php
      $faqs = [
        'Cuenta y registro' => [
          ['¿Cómo creo una cuenta?', 'Hacé clic en "Registrarse" en el menú superior. Completá el formulario con tu nombre, correo y contraseña. Elegí si sos Usuario normal o Propietario de restaurante.'],
          ['¿Cómo cambio mi contraseña?', 'Ingresá a Mi Perfil → Configuración → Cambiar contraseña. Si olvidaste tu contraseña, usá la opción "¿Olvidaste tu contraseña?" en la pantalla de login.'],
          ['¿Qué diferencia hay entre Usuario y Propietario?', 'El Usuario puede explorar, reseñar y guardar favoritos. El Propietario puede además gestionar su restaurante, menú, horarios y galería desde un panel exclusivo.'],
        ],
        'Reseñas' => [
          ['¿Cómo escribo una reseña?', 'Ingresá a la página del restaurante y hacé clic en "Escribir reseña". Seleccioná una calificación del 1 al 5, escribí tu comentario (mínimo 20 caracteres) y opcionalmente subí fotos.'],
          ['¿Cuánto tarda en aparecer mi reseña?', 'Las reseñas pasan por un proceso de moderación. Generalmente se publican en un plazo de 24-48 horas si cumplen las normas de la comunidad.'],
          ['¿Puedo editar o eliminar mi reseña?', 'Sí. Ingresá a Mi Perfil → Mis Reseñas. Allí podés editar o eliminar cualquiera de tus reseñas publicadas.'],
        ],
        'Restaurantes y búsqueda' => [
          ['¿Cómo encuentro restaurantes por provincia?', 'Desde la página principal, seleccioná una provincia y hacé clic en "Explorar". También podés ir a "Provincias" en el menú para ver todas las opciones.'],
          ['¿Cómo uso los filtros de búsqueda?', 'En el Catálogo o en Buscar, podés filtrar por provincia, tipo de comida, accesibilidad y rating mínimo. También hay chips de tipo de comida para filtrado rápido.'],
          ['¿Puedo sugerir un restaurante?', 'Actualmente los restaurantes son registrados por sus propietarios. Podés recomendar a un local que registre su restaurante usando el formulario de registro con el tipo "Propietario".'],
        ],
        'Propietarios' => [
          ['¿Cómo registro mi restaurante?', 'Creá una cuenta como "Propietario de restaurante". Una vez registrado, accedé al Panel del Propietario donde podés completar toda la información de tu local.'],
          ['¿Puedo actualizar el menú y horarios?', 'Sí, desde tu Panel del Propietario tenés secciones dedicadas para gestionar el Menú, Horarios, Servicios y Galería de fotos de tu restaurante.'],
          ['¿Cómo veo las estadísticas de mi restaurante?', 'En el Panel del Propietario → Estadísticas, podés ver visitas, distribución de ratings, reseñas recibidas y fuentes de tráfico.'],
        ],
      ];
      foreach($faqs as $categoria => $preguntas): ?>
      <div class="panel mb">
        <h3 style="margin:0 0 14px;color:var(--primary);"><?= $categoria ?></h3>
        <?php foreach($preguntas as $i => [$pregunta, $respuesta]): ?>
        <div class="faq-item" style="border-bottom:1px solid var(--border);padding:12px 0;<?= $i===count($preguntas)-1?'border-bottom:none;':'' ?>">
          <button onclick="toggleFaq(this)"
            style="width:100%;background:none;border:none;cursor:pointer;text-align:left;
                   color:var(--text);font-weight:700;font-size:14px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
            <span><?= htmlspecialchars($pregunta) ?></span>
            <span class="faq-arrow" style="color:var(--primary);transition:transform .2s;flex-shrink:0;">▼</span>
          </button>
          <div class="faq-resp" style="display:none;margin-top:10px;">
            <p class="p" style="font-size:14px;"><?= htmlspecialchars($respuesta) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Panel lateral -->
    <aside>
      <div class="panel mb">
        <h3 style="margin:0 0 14px;">📋 Categorías</h3>
        <div class="list" style="gap:6px;">
          <?php foreach(array_keys($faqs) as $cat): ?>
            <a href="#" class="sidebar-item" style="padding:10px 12px;border-radius:var(--radius-sm);"><?= $cat ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="panel mb">
        <h3 style="margin:0 0 12px;">📞 Contacto</h3>
        <p class="p" style="font-size:14px;">¿No encontraste respuesta? Contactanos directamente.</p>
        <div class="list" style="margin-top:12px;">
          <div class="row"><span>📧 Email</span><b>info@foodspot.cr</b></div>
          <div class="row"><span>💬 WhatsApp</span><b>+506 2222-3333</b></div>
          <div class="row"><span>🕐 Horario</span><b>Lun-Vie 8am-5pm</b></div>
        </div>
        <hr>
        <form class="form" onsubmit="alert('Mensaje enviado ✅');return false;">
          <div class="group">
            <label>Tu mensaje</label>
            <textarea placeholder="Describí tu problema o consulta..." style="min-height:80px;"></textarea>
          </div>
          <button class="btn btn-primary btn-full" type="submit">📤 Enviar consulta</button>
        </form>
      </div>

      <div class="panel">
        <h3 style="margin:0 0 10px;">🔗 Links útiles</h3>
        <div class="list" style="gap:8px;">
          <a href="catalogo.php" class="btn btn-full">🍽️ Ver catálogo</a>
          <a href="busqueda.php" class="btn btn-full">🔍 Buscar restaurante</a>
          <a href="registro.php" class="btn btn-full">👤 Crear cuenta</a>
        </div>
      </div>
    </aside>
  </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
function toggleFaq(btn){
  const resp  = btn.nextElementSibling;
  const arrow = btn.querySelector('.faq-arrow');
  const open  = resp.style.display !== 'none';
  resp.style.display  = open ? 'none' : 'block';
  arrow.style.transform = open ? '' : 'rotate(180deg)';
}

function buscarFaq(q){
  document.querySelectorAll('.faq-item').forEach(item => {
    const txt = item.textContent.toLowerCase();
    item.style.display = !q || txt.includes(q.toLowerCase()) ? '' : 'none';
  });
}
</script>
