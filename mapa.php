<?php include 'includes/data.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>FoodSpot - Mapa</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
body { margin:0; font-family: Arial; display:flex; }

#map { width:70%; height:100vh; }

.sidebar {
  width:30%;
  background:#1e293b;
  color:white;
  padding:15px;
  overflow-y:auto;
}

.card {
  background:#334155;
  margin:10px 0;
  padding:10px;
  border-radius:10px;
  cursor:pointer;
  transition:0.2s;
}

.card:hover {
  background:#475569;
}

/* MODAL */
.modal {
  position:fixed;
  top:0; left:0;
  width:100%; height:100%;
  background:rgba(0,0,0,0.7);
  display:none;
  align-items:center;
  justify-content:center;
}

.modal-content {
  background:white;
  width:400px;
  border-radius:15px;
  overflow:hidden;
  color:black;
}

.modal img {
  width:100%;
  height:200px;
  object-fit:cover;
}

.modal-body {
  padding:15px;
}

.close {
  position:absolute;
  top:20px;
  right:30px;
  color:white;
  font-size:30px;
  cursor:pointer;
}
</style>
</head>

<body>

<div id="map"></div>

<div class="sidebar">
  <h2>🍽 Restaurantes</h2>

  <select id="filtroProvincia">
    <option value="ALL">Todas</option>
    <?php foreach ($PROVINCIAS as $k => $v): ?>
      <option value="<?= $k ?>"><?= $v ?></option>
    <?php endforeach; ?>
  </select>

  <div id="lista"></div>
</div>

<!-- MODAL -->
<div id="modal" class="modal">
  <div class="close" onclick="cerrarModal()">×</div>
  <div class="modal-content" id="modalContent"></div>
</div>

<script>
const restaurantes = <?= json_encode($RESTAURANTES, JSON_UNESCAPED_UNICODE) ?>;
</script>

<script src="mapa.js"></script>

</body>
</html>