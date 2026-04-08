<?php
// =====================================================
// FOODSPOT - Datos Mock (simulación sin BD)
// Avance 2 - Frontend PHP + JavaScript
// =====================================================

$PROVINCIAS = [
  'SJ' => 'San José',
  'AL' => 'Alajuela',
  'CA' => 'Cartago',
  'HE' => 'Heredia',
  'PU' => 'Puntarenas',
  'LI' => 'Limón',
  'GU' => 'Guanacaste'
];
function coordsRandomPorProvincia($provincia) {
  $rangos = [
    'SJ' => ['lat'=>[9.85, 9.95], 'lng'=>[-84.15, -84.00]],
    'AL' => ['lat'=>[10.00, 10.10], 'lng'=>[-84.30, -84.15]],
    'CA' => ['lat'=>[9.80, 9.90], 'lng'=>[-83.95, -83.80]],
    'HE' => ['lat'=>[9.95, 10.05], 'lng'=>[-84.15, -84.05]],
    'PU' => ['lat'=>[9.90, 10.10], 'lng'=>[-85.00, -84.70]],
    'LI' => ['lat'=>[9.95, 10.10], 'lng'=>[-83.10, -82.90]],
    'GU' => ['lat'=>[10.40, 10.80], 'lng'=>[-85.70, -85.20]],
  ];

  $r = $rangos[$provincia];

  return [
    'lat' => rand($r['lat'][0]*10000, $r['lat'][1]*10000)/10000,
    'lng' => rand($r['lng'][0]*10000, $r['lng'][1]*10000)/10000,
  ];
}

$RESTAURANTES = [
  ['id'=>'SJ-01','provincia'=>'SJ','nombre'=>'La Esquina Tica','tipo'=>'Comida típica','horario'=>'11:00 - 21:00','accesible'=>true,'rating'=>4.6,'img'=>'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/04/18/d2/photo1jpg.jpg?w=900&h=500&s=1','descripcion'=>'Un lugar tradicional con los mejores casados de San José. Ambiente familiar y porciones generosas.','propietario'=>'Carlos Méndez','telefono'=>'+506 2222-1111','direccion'=>'Barrio Escalante, San José'],
  ['id'=>'SJ-02','provincia'=>'SJ','nombre'=>'Pasta & Punto','tipo'=>'Italiana','horario'=>'12:00 - 22:00','accesible'=>false,'rating'=>4.4,'img'=>'https://mercadoventas.es/wp-content/uploads/2024/09/receta-de-pasta.jpg','descripcion'=>'La mejor pasta artesanal de la capital. Masa fresca hecha cada día.','propietario'=>'Lucía Vargas','telefono'=>'+506 2233-4455','direccion'=>'Paseo Colón, San José'],
  ['id'=>'AL-01','provincia'=>'AL','nombre'=>'Parrilla Volcán','tipo'=>'Parrilla','horario'=>'12:00 - 21:30','accesible'=>true,'rating'=>4.5,'img'=>'https://resizer.glanacion.com/resizer/v2/parrillada-completa-BCMNCK4U35CBNHAHVLKS3S2R5Y.jpg?auth=9a156e897b2f058181cf11dcf105762dc445b59640712d42824718870f2f897f&width=1200&height=800&quality=70&smart=true','descripcion'=>'Carnes a las brasas con vista al Volcán Poás.','propietario'=>'Jorge Alvarado','telefono'=>'+506 2441-7788','direccion'=>'Centro, Alajuela'],
  ['id'=>'AL-02','provincia'=>'AL','nombre'=>'Café Central','tipo'=>'Cafetería','horario'=>'07:00 - 19:00','accesible'=>true,'rating'=>4.3,'img'=>'https://backend.shaio.org/sites/default/files/blog/blog-shaio-beneficios-tomar-caf%C3%A9_1.jpg','descripcion'=>'El mejor café costarricense de altura. Desayunos y repostería local.','propietario'=>'Andrea Solís','telefono'=>'+506 2442-3300','direccion'=>'Parque Central, Alajuela'],
  ['id'=>'CA-01','provincia'=>'CA','nombre'=>'Sazón de la Vieja','tipo'=>'Casera','horario'=>'10:30 - 20:30','accesible'=>false,'rating'=>4.2,'img'=>'https://comedera.com/wp-content/uploads/sites/9/2022/10/Casado-costarricense-shutterstock_638209654.jpg','descripcion'=>'Comida casera como la hacía la abuela. Recetas tradicionales cartaginesas.','propietario'=>'Rosa Quesada','telefono'=>'+506 2551-6600','direccion'=>'Cartago Centro'],
  ['id'=>'CA-02','provincia'=>'CA','nombre'=>'Ramen Niebla','tipo'=>'Japonesa','horario'=>'13:00 - 21:00','accesible'=>true,'rating'=>4.7,'img'=>'https://www.cocinadelirante.com/sites/default/files/images/2025/02/recetas-de-comida-japonesa-super-faciles-para-hacer-en-casa.jpg','descripcion'=>'Ramen auténtico con caldos de 12 horas. Ambiente perfecto para la frialdad de Cartago.','propietario'=>'Kenji Nakamura','telefono'=>'+506 2552-8899','direccion'=>'Zona Centro, Cartago'],
  ['id'=>'HE-01','provincia'=>'HE','nombre'=>'Burgers 10/10','tipo'=>'Comida rápida','horario'=>'12:00 - 23:00','accesible'=>true,'rating'=>4.1,'img'=>'https://www.recetasnestle.com.ec/sites/default/files/srh_recipes/4e4293857c03d819e4ae51de1e86d66a.jpg','descripcion'=>'Las hamburguesas más jugosas de Heredia. Ingredientes frescos y salsas secretas.','propietario'=>'Fabián Castro','telefono'=>'+506 2261-5544','direccion'=>'Heredia Centro'],
  ['id'=>'HE-02','provincia'=>'HE','nombre'=>'Verde Bowl','tipo'=>'Saludable','horario'=>'09:00 - 20:00','accesible'=>true,'rating'=>4.5,'img'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0vTdNruNNi8HOmrwEGPm39U0zyN5awI_8-A&s','descripcion'=>'Bowls nutritivos con ingredientes orgánicos. Sin gluten, opciones veganas.','propietario'=>'Daniela Mora','telefono'=>'+506 2262-7711','direccion'=>'Santo Domingo, Heredia'],
  ['id'=>'PU-01','provincia'=>'PU','nombre'=>'Mar y Limón','tipo'=>'Mariscos','horario'=>'11:00 - 21:00','accesible'=>false,'rating'=>4.6,'img'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROJDBrsn7-ZLrDBFNpEJpiOtjM2Qijqrl7Tg&s','descripcion'=>'Mariscos fresquísimos del Pacífico. Vista al mar, brisa costeña y ceviche incomparable.','propietario'=>'Manuel Jiménez','telefono'=>'+506 2661-3322','direccion'=>'Malecón, Puntarenas'],
  ['id'=>'PU-02','provincia'=>'PU','nombre'=>'Taco Ola','tipo'=>'Mexicana','horario'=>'12:00 - 22:00','accesible'=>true,'rating'=>4.4,'img'=>'https://offloadmedia.feverup.com/cdmxsecreta.com/wp-content/uploads/2023/08/31174612/restaurantes-comida-mexicana-cdmx-1024x683.jpg','descripcion'=>'Tacos auténticos con tortillas hechas a mano. Salsas picantes para todos los niveles.','propietario'=>'Sofía López','telefono'=>'+506 2663-9988','direccion'=>'Calle Central, Puntarenas'],
  ['id'=>'LI-01','provincia'=>'LI','nombre'=>'Caribbean Spice','tipo'=>'Caribeña','horario'=>'11:00 - 20:30','accesible'=>true,'rating'=>4.7,'img'=>'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2e/cb/06/ae/nuestro-clasico-rice.jpg?w=900&h=500&s=1','descripcion'=>'Sabores caribeños auténticos. Rice & Beans, patacones y mucho sabor de Limón.','propietario'=>'Ingrid Williams','telefono'=>'+506 2758-4466','direccion'=>'Puerto Limón Centro'],
  ['id'=>'LI-02','provincia'=>'LI','nombre'=>'Coco & Rice','tipo'=>'Caribeña','horario'=>'12:00 - 21:00','accesible'=>false,'rating'=>4.3,'img'=>'https://www.thefork.es/blog/s3/files/styles/lightbox_content/public/body-images/ceviche-caribeno.jpg?itok=HR3hp1Np','descripcion'=>'Cocina afrocaribeña con amor. El secreto es la leche de coco en cada plato.','propietario'=>'Derek Brown','telefono'=>'+506 2759-2255','direccion'=>'Barrio Colón, Limón'],
  ['id'=>'GU-01','provincia'=>'GU','nombre'=>'Brasa Guanaca','tipo'=>'Parrilla','horario'=>'12:00 - 21:30','accesible'=>true,'rating'=>4.5,'img'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp2U_IljWfRaV7-DV2P0YSyltKSwgaRjjL9g&s','descripcion'=>'La mejor parrilla de Guanacaste. Carne guanacasteca de libre pastoreo.','propietario'=>'Esteban Fonseca','telefono'=>'+506 2685-1122','direccion'=>'Liberia Centro, Guanacaste'],
  ['id'=>'GU-02','provincia'=>'GU','nombre'=>'Helados del Sol','tipo'=>'Postres','horario'=>'10:00 - 19:00','accesible'=>true,'rating'=>4.2,'img'=>'https://chango.com.ar/wp-content/uploads/2025/01/image-5.jpg','descripcion'=>'Helados artesanales de frutas tropicales. La parada perfecta después de la playa.','propietario'=>'Paula Herrera','telefono'=>'+506 2686-3344','direccion'=>'Playa Tamarindo, Guanacaste'],
];

foreach ($RESTAURANTES as &$r) {
  $coords = coordsRandomPorProvincia($r['provincia']);
  $r['lat'] = $coords['lat'];
  $r['lng'] = $coords['lng'];
}
unset($r);

$USUARIOS = [
  ['id'=>1,'nombre'=>'María Fernández','email'=>'maria@gmail.com','rol'=>'Usuario','avatar'=>'MF','fecha_registro'=>'2024-03-15','resenas'=>5,'favoritos'=>8],
  ['id'=>2,'nombre'=>'Carlos Ramírez','email'=>'carlos@gmail.com','rol'=>'Usuario','avatar'=>'CR','fecha_registro'=>'2024-01-20','resenas'=>12,'favoritos'=>4],
  ['id'=>3,'nombre'=>'Ana Solís','email'=>'ana@gmail.com','rol'=>'Propietario','avatar'=>'AS','fecha_registro'=>'2023-11-08','resenas'=>0,'favoritos'=>2],
  ['id'=>4,'nombre'=>'Kevin Mora','email'=>'kevin@gmail.com','rol'=>'Creador','avatar'=>'KM','fecha_registro'=>'2024-02-28','resenas'=>30,'favoritos'=>15],
];

$RESENAS = [
  ['id'=>1,'restaurante_id'=>'SJ-01','restaurante_nombre'=>'La Esquina Tica','usuario'=>'María F.','rating'=>5,'comentario'=>'Excelente comida típica, el casado es increíble. El servicio muy amable y las porciones son súper.','fecha'=>'2025-03-20','estado'=>'aprobada'],
  ['id'=>2,'restaurante_id'=>'SJ-02','restaurante_nombre'=>'Pasta & Punto','usuario'=>'Carlos R.','rating'=>4,'comentario'=>'La pasta fresca es deliciosa. Un poco cara pero vale la pena para una ocasión especial.','fecha'=>'2025-03-18','estado'=>'aprobada'],
  ['id'=>3,'restaurante_id'=>'CA-02','restaurante_nombre'=>'Ramen Niebla','usuario'=>'Kevin M.','rating'=>5,'comentario'=>'El mejor ramen que he probado en Costa Rica. El caldo es increíblemente sabroso.','fecha'=>'2025-03-15','estado'=>'pendiente'],
  ['id'=>4,'restaurante_id'=>'HE-02','restaurante_nombre'=>'Verde Bowl','usuario'=>'Ana S.','rating'=>3,'comentario'=>'Buena idea pero muy pequeñas las porciones para el precio que cobran.','fecha'=>'2025-03-10','estado'=>'pendiente'],
  ['id'=>5,'restaurante_id'=>'LI-01','restaurante_nombre'=>'Caribbean Spice','usuario'=>'Luis P.','rating'=>5,'comentario'=>'Auténtico sabor caribeño, me recordó a mis viajes por el Caribe. Imperdible el rondón.','fecha'=>'2025-03-05','estado'=>'aprobada'],
];

$NOTIFICACIONES = [
  ['id'=>1,'tipo'=>'resena','mensaje'=>'Tu reseña de "La Esquina Tica" fue aprobada','fecha'=>'hace 2 horas','leida'=>false],
  ['id'=>2,'tipo'=>'favorito','mensaje'=>'"Ramen Niebla" actualizó su menú','fecha'=>'hace 5 horas','leida'=>false],
  ['id'=>3,'tipo'=>'sistema','mensaje'=>'Bienvenido a FOODSPOT. ¡Explorá los mejores restaurantes!','fecha'=>'hace 1 día','leida'=>true],
  ['id'=>4,'tipo'=>'resena','mensaje'=>'Nuevo comentario en tu restaurante favorito','fecha'=>'hace 2 días','leida'=>true],
];

// Estadísticas mock para propietario
$ESTADISTICAS = [
  'visitas_mes' => 1240,
  'resenas_total' => 38,
  'rating_promedio' => 4.6,
  'favoritos' => 95,
  'visitas_semana' => [120, 98, 145, 200, 178, 220, 190],
];
