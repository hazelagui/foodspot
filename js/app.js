/**
 * FOODSPOT - app.js  |  Avance 2 - Semana 9
 * JavaScript global del frontend PHP
 */

const PROVINCIAS = {SJ:'San José',AL:'Alajuela',CA:'Cartago',HE:'Heredia',PU:'Puntarenas',LI:'Limón',GU:'Guanacaste'};

const RESTAURANTES = [
  {id:'SJ-01',provincia:'SJ',nombre:'La Esquina Tica',tipo:'Comida típica',horario:'11:00 - 21:00',accesible:true,rating:4.6,img:'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/04/18/d2/photo1jpg.jpg?w=900&h=500&s=1'},
  {id:'SJ-02',provincia:'SJ',nombre:'Pasta & Punto',tipo:'Italiana',horario:'12:00 - 22:00',accesible:false,rating:4.4,img:'https://mercadoventas.es/wp-content/uploads/2024/09/receta-de-pasta.jpg'},
  {id:'AL-01',provincia:'AL',nombre:'Parrilla Volcán',tipo:'Parrilla',horario:'12:00 - 21:30',accesible:true,rating:4.5,img:'https://resizer.glanacion.com/resizer/v2/parrillada-completa-BCMNCK4U35CBNHAHVLKS3S2R5Y.jpg?auth=9a156e897b2f058181cf11dcf105762dc445b59640712d42824718870f2f897f&width=1200&height=800&quality=70&smart=true'},
  {id:'AL-02',provincia:'AL',nombre:'Café Central',tipo:'Cafetería',horario:'07:00 - 19:00',accesible:true,rating:4.3,img:'https://backend.shaio.org/sites/default/files/blog/blog-shaio-beneficios-tomar-caf%C3%A9_1.jpg'},
  {id:'CA-01',provincia:'CA',nombre:'Sazón de la Vieja',tipo:'Casera',horario:'10:30 - 20:30',accesible:false,rating:4.2,img:'https://comedera.com/wp-content/uploads/sites/9/2022/10/Casado-costarricense-shutterstock_638209654.jpg'},
  {id:'CA-02',provincia:'CA',nombre:'Ramen Niebla',tipo:'Japonesa',horario:'13:00 - 21:00',accesible:true,rating:4.7,img:'https://www.cocinadelirante.com/sites/default/files/images/2025/02/recetas-de-comida-japonesa-super-faciles-para-hacer-en-casa.jpg'},
  {id:'HE-01',provincia:'HE',nombre:'Burgers 10/10',tipo:'Comida rápida',horario:'12:00 - 23:00',accesible:true,rating:4.1,img:'https://www.recetasnestle.com.ec/sites/default/files/srh_recipes/4e4293857c03d819e4ae51de1e86d66a.jpg'},
  {id:'HE-02',provincia:'HE',nombre:'Verde Bowl',tipo:'Saludable',horario:'09:00 - 20:00',accesible:true,rating:4.5,img:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0vTdNruNNi8HOmrwEGPm39U0zyN5awI_8-A&s'},
  {id:'PU-01',provincia:'PU',nombre:'Mar y Limón',tipo:'Mariscos',horario:'11:00 - 21:00',accesible:false,rating:4.6,img:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROJDBrsn7-ZLrDBFNpEJpiOtjM2Qijqrl7Tg&s'},
  {id:'PU-02',provincia:'PU',nombre:'Taco Ola',tipo:'Mexicana',horario:'12:00 - 22:00',accesible:true,rating:4.4,img:'https://offloadmedia.feverup.com/cdmxsecreta.com/wp-content/uploads/2023/08/31174612/restaurantes-comida-mexicana-cdmx-1024x683.jpg'},
  {id:'LI-01',provincia:'LI',nombre:'Caribbean Spice',tipo:'Caribeña',horario:'11:00 - 20:30',accesible:true,rating:4.7,img:'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2e/cb/06/ae/nuestro-clasico-rice.jpg?w=900&h=500&s=1'},
  {id:'LI-02',provincia:'LI',nombre:'Coco & Rice',tipo:'Caribeña',horario:'12:00 - 21:00',accesible:false,rating:4.3,img:'https://www.thefork.es/blog/s3/files/styles/lightbox_content/public/body-images/ceviche-caribeno.jpg?itok=HR3hp1Np'},
  {id:'GU-01',provincia:'GU',nombre:'Brasa Guanaca',tipo:'Parrilla',horario:'12:00 - 21:30',accesible:true,rating:4.5,img:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp2U_IljWfRaV7-DV2P0YSyltKSwgaRjjL9g&s'},
  {id:'GU-02',provincia:'GU',nombre:'Helados del Sol',tipo:'Postres',horario:'10:00 - 19:00',accesible:true,rating:4.2,img:'https://chango.com.ar/wp-content/uploads/2025/01/image-5.jpg'},
];

function qs(n){ return new URLSearchParams(window.location.search).get(n); }
function goProvincia(c){ window.location.href=`provincia.php?p=${c}`; }
function goRestaurante(id){ window.location.href=`restaurante.php?id=${id}`; }

// Render provincia (legado HTML)
function renderProvincia(){
  const code=qs('p')||'SJ', titleEl=document.getElementById('provTitle'), gridEl=document.getElementById('provGrid');
  if(!titleEl||!gridEl) return;
  titleEl.textContent=`Restaurantes en ${PROVINCIAS[code]||'Provincia'}`;
  const items=RESTAURANTES.filter(r=>r.provincia===code);
  gridEl.innerHTML=items.map(r=>`<article class="card">
    <div class="thumb"><img src="${r.img}" alt="${r.nombre}" loading="lazy"></div>
    <div class="card-body">
      <p class="title">${r.nombre}</p>
      <p class="sub">${r.tipo} · ${r.horario}</p>
      <div class="badges"><span class="badge">⭐ ${r.rating}</span>
        <span class="badge">${r.accesible?'Accesible ✅':'No accesible ❌'}</span></div>
      <button class="btn btn-primary" onclick="goRestaurante('${r.id}')">Ver detalle</button>
    </div></article>`).join('');
}

// Render restaurante (legado HTML)
function renderRestaurante(){
  const id=qs('id')||'SJ-01', r=RESTAURANTES.find(x=>x.id===id);
  if(!r) return;
  const nameEl=document.getElementById('resName'), metaEl=document.getElementById('resMeta'), imgEl=document.getElementById('resImg');
  if(nameEl) nameEl.textContent=r.nombre;
  if(metaEl) metaEl.textContent=`${PROVINCIAS[r.provincia]} · ${r.tipo} · ${r.horario} · ⭐ ${r.rating}`;
  if(imgEl)  imgEl.src=r.img;
  const srv=document.getElementById('resServicios');
  if(srv) srv.innerHTML=`<span class="badge">${r.accesible?'Accesible ✅':'No accesible ❌'}</span><span class="badge">WiFi</span><span class="badge">Parqueo</span><span class="badge">Para llevar</span>`;
}

function initProvinceSelector(){
  const sel=document.getElementById('provinceSelect');
  if(!sel) return;
  sel.value=qs('p')||'SJ';
  sel.addEventListener('change',e=>goProvincia(e.target.value));
}

// Rating stars
function initRatingStars(cId,iId,lId){
  const container=document.getElementById(cId);
  if(!container) return;
  const input=document.getElementById(iId), label=document.getElementById(lId);
  const tags=['','Muy malo 😞','Malo 😕','Regular 😐','Bueno 😊','¡Excelente! 🤩'];
  const stars=container.querySelectorAll('span');
  let sel=parseInt(input?.value)||0;
  const paint=n=>stars.forEach(s=>s.style.color=parseInt(s.dataset.v)<=n?'#f59e0b':'rgba(255,255,255,.2)');
  paint(sel);
  stars.forEach(s=>{
    s.addEventListener('click',()=>{ sel=parseInt(s.dataset.v); if(input)input.value=sel; if(label)label.textContent=tags[sel]; paint(sel); });
    s.addEventListener('mouseenter',()=>paint(parseInt(s.dataset.v)));
    s.addEventListener('mouseleave',()=>paint(sel));
  });
}

// Favoritos con sessionStorage
function getFavs(){ try{return JSON.parse(sessionStorage.getItem('favs')||'[]')}catch{return[]} }
function setFavs(f){ try{sessionStorage.setItem('favs',JSON.stringify(f))}catch{} }
function toggleFavorito(id,btn){
  let favs=getFavs(), idx=favs.indexOf(id);
  if(idx>=0){ favs.splice(idx,1); if(btn){btn.textContent='❤️ Agregar a favoritos';btn.classList.remove('btn-primary');} }
  else{ favs.push(id); if(btn){btn.textContent='❤️ En favoritos';btn.classList.add('btn-primary');} }
  setFavs(favs);
}

// Filtrar tabla
function filtrarTabla(q,tablaId){
  const tbody=document.querySelector('#'+tablaId+' tbody');
  if(!tbody) return;
  Array.from(tbody.rows).forEach(r=>r.style.display=r.textContent.toLowerCase().includes(q.toLowerCase())?'':'none');
}

// Global showTab
function showTab(id,el){
  document.querySelectorAll('.tab-content').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.sidebar-item,.tab-btn').forEach(s=>s.classList.remove('active'));
  const t=document.getElementById('tab-'+id);
  if(t) t.classList.add('active');
  if(el) el.classList.add('active');
}

document.addEventListener('DOMContentLoaded',()=>{
  initProvinceSelector();
  renderProvincia();
  renderRestaurante();
  initRatingStars('ratingStars','ratingVal','ratingText');
  initRatingStars('ratingInput',null,'ratingLabel');

  // Favorito en detalle restaurante
  const btnFav=document.getElementById('btnFav');
  if(btnFav){
    const id=qs('id');
    if(id&&getFavs().includes(id)){btnFav.textContent='❤️ En favoritos';btnFav.classList.add('btn-primary');}
    btnFav.addEventListener('click',()=>toggleFavorito(id,btnFav));
  }

  // Contadores de caracteres
  document.querySelectorAll('textarea[maxlength]').forEach(ta=>{
    const max=ta.getAttribute('maxlength');
    const cc=ta.parentElement.querySelector('[id$="Count"],.char-count');
    if(cc){ const u=()=>cc.textContent=`${ta.value.length} / ${max} caracteres`; ta.addEventListener('input',u); u(); }
  });
});
