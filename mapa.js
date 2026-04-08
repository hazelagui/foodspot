document.addEventListener("DOMContentLoaded", () => {

  const map = L.map('map').setView([9.9281, -84.0907], 8);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(map);

  let markers = [];

  function render(data) {

    markers.forEach(m => map.removeLayer(m));
    markers = [];

    const lista = document.getElementById("lista");
    lista.innerHTML = "";

    data.forEach(r => {

      const marker = L.marker([r.lat, r.lng]).addTo(map);
      marker.bindPopup(`<b>${r.nombre}</b><br>${r.tipo}<br>⭐ ${r.rating}`);

      markers.push(marker);

      // CARD
      const div = document.createElement("div");
      div.className = "card";
      div.innerHTML = `
        <b>${r.nombre}</b><br>
        ${r.tipo}<br>
        ⭐ ${r.rating}
      `;

      div.onclick = () => {
        map.setView([r.lat, r.lng], 13);
        marker.openPopup();
        abrirModal(r);
      };

      lista.appendChild(div);
    });
  }

  // FILTRO
  document.getElementById("filtroProvincia").addEventListener("change", e => {
    const val = e.target.value;

    if (val === "ALL") {
      render(restaurantes);
    } else {
      render(restaurantes.filter(r => r.provincia === val));
    }
  });

  render(restaurantes);

});

// MODAL
function abrirModal(r) {
  const modal = document.getElementById("modal");
  const content = document.getElementById("modalContent");

  content.innerHTML = `
    <img src="${r.img}" alt="${r.nombre}">
    <div class="modal-body">
      <h2>${r.nombre}</h2>
      <p><b>Tipo:</b> ${r.tipo}</p>
      <p><b>⭐ Rating:</b> ${r.rating}</p>
      <p><b>Horario:</b> ${r.horario}</p>
      <p><b>📍 Dirección:</b> ${r.direccion}</p>
      <p>${r.descripcion}</p>
      <p><b>📞 ${r.telefono}</b></p>
    </div>
  `;

  modal.style.display = "flex";
}

function cerrarModal() {
  document.getElementById("modal").style.display = "none";
}

// cerrar al hacer click fuera
window.onclick = function(e) {
  const modal = document.getElementById("modal");
  if (e.target === modal) {
    cerrarModal();
  }
};