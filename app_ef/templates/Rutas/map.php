<?php
/**
 * @var \App\View\AppView $this
 * @var $loggedInUser
 * @var $rutasDisponibles
 */
$this->layout = 'admin';
$theme = $_COOKIE['theme'] ?? 'dark';
$isDark = $theme !== 'light';
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<style>
.card {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.9)' ?>;
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
}
.card h2 {
    font-size: 20px;
    margin-bottom: 15px;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    border-bottom: 2px solid rgba(79, 172, 254, 0.5);
    padding-bottom: 10px;
}
.card h3 {
    font-size: 16px;
    margin-bottom: 10px;
    color: <?= $isDark ? '#aaa' : '#666' ?>;
}
.map-container {
    margin-bottom: 20px;
}
#map { height: 500px; border-radius: 15px; }
.instructions {
    background: <?= $isDark ? 'rgba(79, 172, 254, 0.15)' : 'rgba(79, 172, 254, 0.1)' ?>;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 2px dashed <?= $isDark ? '#4facfe' : '#2196F3' ?>;
}
.instructions h3 {
    margin: 0 0 10px 0;
    color: <?= $isDark ? '#4facfe' : '#2196F3' ?>;
}
.instructions p {
    margin: 5px 0;
    color: <?= $isDark ? '#e4e4e4' : '#333' ?>;
    font-size: 14px;
}
.instructions .step {
    display: inline-block;
    background: <?= $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)' ?>;
    padding: 5px 12px;
    border-radius: 15px;
    margin-right: 10px;
    font-size: 12px;
    font-weight: 600;
}
.selected-points {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.point-box {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.03)' ?>;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    border: 2px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
}
.point-box.origen { border-color: #4facfe; }
.point-box.destino { border-color: #e94560; }
.point-box h4 {
    margin: 0 0 10px 0;
    color: <?= $isDark ? '#888' : '#666' ?>;
    font-size: 14px;
    text-transform: uppercase;
}
.point-box .city {
    font-size: 24px;
    font-weight: 700;
    color: <?= $isDark ? '#fff' : '#333' ?>;
}
.point-box.origen .city { color: #4facfe; }
.point-box.destino .city { color: #e94560; }
.point-box .coords {
    font-size: 12px;
    color: <?= $isDark ? '#666' : '#999' ?>;
    margin-top: 5px;
}
.ruta-result {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    padding: 25px;
    border-radius: 15px;
    margin-top: 20px;
}
.ruta-result h3 {
    color: #fff;
    margin-bottom: 20px;
}
.ruta-result .info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}
.ruta-result .info-item {
    background: rgba(255, 255, 255, 0.2);
    padding: 15px;
    border-radius: 10px;
    text-align: center;
}
.ruta-result .info-item label {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.8);
}
.ruta-result .info-item span {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    display: block;
    margin-top: 5px;
}
.btn-usar {
    display: block;
    width: 100%;
    padding: 18px;
    margin-top: 25px;
    background: #fff;
    color: #11998e;
    text-align: center;
    border-radius: 12px;
    font-weight: 700;
    font-size: 18px;
    text-decoration: none;
}
.btn-usar:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}
.tag {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}
.tag.nacional { background: #11998e; color: #fff; }
.tag.internacional { background: #667eea; color: #fff; }
.historial-section { margin-top: 30px; }
table {
    width: 100%;
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.9)' ?>;
    border-radius: 15px;
    border-collapse: collapse;
    overflow: hidden;
}
th, td { padding: 16px; text-align: left; border-bottom: 1px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>; }
th {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)' ?>;
    color: <?= $isDark ? '#888' : '#666' ?>;
    font-size: 12px;
    text-transform: uppercase;
}
td { color: <?= $isDark ? '#e4e4e4' : '#333' ?>; }
.empty { text-align: center; padding: 30px; color: <?= $isDark ? '#666' : '#999' ?>; }
.btn-reset {
    display: inline-block;
    padding: 10px 20px;
    background: <?= $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)' ?>;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
}
.btn-reset:hover { background: <?= $isDark ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.2)' ?>; }
</style>

<?= $this->Flash->render() ?>

<div class="card">
    <h2>🗺️ Selecciona tu Ruta en el Mapa</h2>
    
    <div class="instructions">
        <h3>📍 Cómo usar:</h3>
        <p><span class="step">Paso 1</span> Haz clic en el mapa para seleccionar el <strong>PUNTO DE ORIGEN</strong> (marcador azul)</p>
        <p><span class="step">Paso 2</span> Haz clic nuevamente para seleccionar el <strong>PUNTO DE DESTINO</strong> (marcador rojo)</p>
        <p><span class="step">Paso 3</span> ¡Listo! La distancia y tiempo se calculan automáticamente</p>
        <button class="btn-reset" onclick="resetMap()">🔄 Reiniciar selección</button>
    </div>
    
    <div id="map"></div>
    
    <div class="selected-points">
        <div class="point-box origen">
            <h4>📍 Punto de Origen</h4>
            <div class="city" id="origen-display">Haz clic en el mapa</div>
            <div class="coords" id="origen-coords"></div>
        </div>
        <div class="point-box destino">
            <h4>📍 Punto de Destino</h4>
            <div class="city" id="destino-display">Haz clic en el mapa</div>
            <div class="coords" id="destino-coords"></div>
        </div>
    </div>
    
    <div id="ruta-result" class="ruta-result" style="display: none;">
        <h3>🚗 Información de la Ruta</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Distancia</label>
                <span id="distancia-display">- km</span>
            </div>
            <div class="info-item">
                <label>Tiempo Estimado</label>
                <span id="tiempo-display">- horas</span>
            </div>
            <div class="info-item">
                <label>Tipo de Ruta</label>
                <span id="tipo-display">-</span>
            </div>
            <div class="info-item">
                <label>ID Ruta</label>
                <span id="idruta-display">-</span>
            </div>
        </div>
        <a id="btn-usar-ruta" href="#" class="btn-usar">✅ Usar Esta Ruta</a>
    </div>
</div>

<div class="card historial-section">
    <h2>📋 Mi Historial</h2>
    <?php if (empty($misRutas)): ?>
    <div class="empty">No has usado ninguna ruta</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia (km)</th>
                <th>Tiempo (hrs)</th>
                <th>Tipo</th>
                <th>Fecha Uso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($misRutas as $ruta): ?>
            <tr>
                <td><?= h($ruta->origen) ?></td>
                <td><?= h($ruta->destino) ?></td>
                <td><?= h($ruta->distancia_km) ?></td>
                <td><?= h($ruta->tiempo_estimado) ?></td>
                <td><span class="tag <?= h($ruta->tipo_ruta) ?>"><?= h(ucfirst($ruta->tipo_ruta)) ?></span></td>
                <td><?= h($ruta->fecha_uso) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<script>
var map;
var origenMarker = null;
var destinoMarker = null;
var routeLine = null;
var clickCount = 0;

var ciudades = {
    'La Paz': { lat: -16.5, lng: -68.15 },
    'Cochabamba': { lat: -17.3895, lng: -66.1568 },
    'Santa Cruz': { lat: -17.8145, lng: -63.1561 },
    'Oruro': { lat: -17.9833, lng: -67.15 },
    'Sucre': { lat: -19.0195, lng: -65.2619 },
    'Potosí': { lat: -19.5976, lng: -65.7537 },
    'Tarija': { lat: -21.5355, lng: -64.7296 },
    'Beni': { lat: -14.4833, lng: -64.9 },
    'Pando': { lat: -11.5, lng: -67.0 },
    'Cobija': { lat: -11.0266, lng: -68.7690 },
    'Riberalta': { lat: -10.9833, lng: -66.0833 },
    'Guayaramerín': { lat: -10.8876, lng: -65.3558 },
    'San Ignacio de Velasco': { lat: -16.3667, lng: -60.95 },
    'Trinidad': { lat: -14.8333, lng: -64.9 },
    'Uyuni': { lat: -20.4647, lng: -66.2148 },
    'Villazón': { lat: -22.0966, lng: -65.5976 },
    'Yacuiba': { lat: -22.4924, lng: -63.6719 },
    'Lima': { lat: -12.0464, lng: -77.0428 },
    'Arequipa': { lat: -16.4090, lng: -71.5375 },
    'Cusco': { lat: -13.5319, lng: -71.9675 },
    'Iquique': { lat: -20.2315, lng: -70.1693 },
    'Antofagasta': { lat: -23.6703, lng: -70.4001 },
    'Santiago': { lat: -33.4489, lng: -70.6693 },
    'Buenos Aires': { lat: -34.6037, lng: -58.3816 },
    'São Paulo': { lat: -23.5505, lng: -46.6333 },
    'Brasilia': { lat: -15.7801, lng: -47.9292 },
    'Asunción': { lat: -25.2637, lng: -57.5759 },
    'Montevideo': { lat: -34.9011, lng: -56.1645 },
    'Bogotá': { lat: 4.7110, lng: -74.0721 },
    'Medellín': { lat: 6.2476, lng: -75.5658 },
    'Caracas': { lat: 10.4806, lng: -66.9036 }
};

var rutasData = <?= json_encode($rutasDisponibles) ?>;

var blueIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var redIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

function initMap() {
    map = L.map('map').setView([-17.0, -65.0], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    
    for (var city in ciudades) {
        L.marker([ciudades[city].lat, ciudades[city].lng])
            .addTo(map)
            .bindPopup(city);
    }
    
    map.on('click', function(e) {
        var closestCity = findClosestCity(e.latlng.lat, e.latlng.lng);
        
        if (clickCount === 0) {
            if (origenMarker) map.removeLayer(origenMarker);
            if (routeLine) map.removeLayer(routeLine);
            
            origenMarker = L.marker([e.latlng.lat, e.latlng.lng], {icon: blueIcon})
                .addTo(map)
                .bindPopup('📍 Origen: ' + closestCity).openPopup();
            
            document.getElementById('origen-display').textContent = closestCity;
            document.getElementById('origen-coords').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);
            document.getElementById('destino-display').textContent = 'Haz clic en el mapa';
            document.getElementById('destino-coords').textContent = '';
            document.getElementById('ruta-result').style.display = 'none';
            
            clickCount = 1;
        } else {
            if (destinoMarker) map.removeLayer(destinoMarker);
            if (routeLine) map.removeLayer(routeLine);
            
            destinoMarker = L.marker([e.latlng.lat, e.latlng.lng], {icon: redIcon})
                .addTo(map)
                .bindPopup('🏁 Destino: ' + closestCity).openPopup();
            
            document.getElementById('destino-display').textContent = closestCity;
            document.getElementById('destino-coords').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);
            
            calculateRealRoute(origenMarker.getLatLng().lat, origenMarker.getLatLng().lng, 
                       e.latlng.lat, e.latlng.lng,
                       closestCity);
            
            clickCount = 0;
        }
    });
}

function findClosestCity(lat, lng) {
    var closest = null;
    var minDist = Infinity;
    
    for (var city in ciudades) {
        var dist = Math.sqrt(
            Math.pow(lat - ciudades[city].lat, 2) + 
            Math.pow(lng - ciudades[city].lng, 2)
        );
        if (dist < minDist) {
            minDist = dist;
            closest = city;
        }
    }
    if (minDist > 1.5) {
        return lat.toFixed(2) + ', ' + lng.toFixed(2);
    }
    return closest;
}

var routingControl = null;

function calculateRealRoute(origenLat, origenLng, destinoLat, destinoLng, destinoNombre) {
    var origenNombre = document.getElementById('origen-display').textContent;
    var destinoNom = destinoNombre;
    
    var dist = calculateDistanceBetween(origenLat, origenLng, destinoLat, destinoLng);
    dist = Math.round(dist);
    var timeHrs = Math.max(1, Math.round(dist / 60));
    
    var tipo = 'internacional';
    var ciudadesBolivia = ['La Paz', 'Cochabamba', 'Santa Cruz', 'Oruro', 'Sucre', 'Potosí', 'Tarija', 'Beni', 'Pando', 'Cobija', 'Riberalta', 'Guayaramerín', 'San Ignacio de Velasco', 'Trinidad', 'Uyuni', 'Villazón', 'Yacuiba'];
    if (ciudadesBolivia.includes(origenNombre) && ciudadesBolivia.includes(destinoNom)) {
        tipo = 'nacional';
    }
    
    var latlngs = [
        [origenLat, origenLng],
        [destinoLat, destinoLng]
    ];
    
    if (routeLine) {
        map.removeLayer(routeLine);
    }
    
    routeLine = L.polyline(latlngs, {
        color: '#4facfe',
        weight: 6,
        opacity: 0.8
    }).addTo(map);
    
    map.fitBounds(routeLine.getBounds(), {padding: [50, 50]});
    
    document.getElementById('ruta-result').style.display = 'block';
    document.getElementById('distancia-display').textContent = dist + ' km';
    document.getElementById('tiempo-display').textContent = timeHrs + ' horas';
    document.getElementById('tipo-display').textContent = tipo.charAt(0).toUpperCase() + tipo.slice(1);
    document.getElementById('idruta-display').textContent = 'Nueva';
    
    var rutaEncontrada = null;
    rutasData.forEach(function(r) {
        if ((r.origen === origenNombre && r.destino === destinoNom) ||
            (r.origen === destinoNom && r.destino === origenNombre)) {
            rutaEncontrada = r;
        }
    });
    
    if (rutaEncontrada) {
        document.getElementById('distancia-display').textContent = rutaEncontrada.distancia_km + ' km';
        document.getElementById('tiempo-display').textContent = rutaEncontrada.tiempo_estimado + ' horas';
        document.getElementById('tipo-display').textContent = rutaEncontrada.tipo_ruta.charAt(0).toUpperCase() + rutaEncontrada.tipo_ruta.slice(1);
        document.getElementById('idruta-display').textContent = '#' + rutaEncontrada.idruta;
        document.getElementById('btn-usar-ruta').href = '/rutas/usar/' + rutaEncontrada.idruta;
        document.getElementById('btn-usar-ruta').style.display = 'block';
    } else {
        document.getElementById('btn-usar-ruta').style.display = 'none';
    }
}
      
function calculateDistanceBetween(lat1, lon1, lat2, lon2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function resetMap() {
    if (origenMarker) { map.removeLayer(origenMarker); origenMarker = null; }
    if (destinoMarker) { map.removeLayer(destinoMarker); destinoMarker = null; }
    if (routeLine) { map.removeLayer(routeLine); routeLine = null; }
    
    document.getElementById('origen-display').textContent = 'Haz clic en el mapa';
    document.getElementById('origen-coords').textContent = '';
    document.getElementById('destino-display').textContent = 'Haz clic en el mapa';
    document.getElementById('destino-coords').textContent = '';
    document.getElementById('ruta-result').style.display = 'none';
    
    clickCount = 0;
    map.setView([-17.0, -65.0], 6);
}

document.addEventListener('DOMContentLoaded', initMap);
</script>
