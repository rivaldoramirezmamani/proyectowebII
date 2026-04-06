<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ruta $ruta
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
.form-container { max-width: 900px; margin: 0 auto; }
.card {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.9)' ?>;
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    border: 1px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
}
.card h2 {
    font-size: 20px;
    margin-bottom: 15px;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    border-bottom: 2px solid rgba(79, 172, 254, 0.5);
    padding-bottom: 10px;
}
.map-section { margin-bottom: 30px; }
#map { height: 450px; border-radius: 15px; }
.instructions {
    background: <?= $isDark ? 'rgba(79, 172, 254, 0.15)' : 'rgba(79, 172, 254, 0.1)' ?>;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 2px dashed <?= $isDark ? '#4facfe' : '#2196F3' ?>;
}
.instructions h3 { margin: 0 0 10px 0; color: <?= $isDark ? '#4facfe' : '#2196F3' ?>; }
.instructions p { margin: 8px 0; color: <?= $isDark ? '#e4e4e4' : '#333' ?>; }
.selected-points {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.point-box {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.03)' ?>;
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    border: 2px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
}
.point-box.origen { border-color: #4facfe; }
.point-box.destino { border-color: #e94560; }
.point-box h4 { margin: 0 0 8px 0; color: <?= $isDark ? '#888' : '#666' ?>; font-size: 13px; text-transform: uppercase; }
.point-box .city { font-size: 22px; font-weight: 700; color: <?= $isDark ? '#fff' : '#333' ?>; }
.point-box.origen .city { color: #4facfe; }
.point-box.destino .city { color: #e94560; }
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.form-group { margin-bottom: 20px; }
label { display: block; margin-bottom: 8px; font-weight: 500; color: <?= $isDark ? '#b8b8b8' : '#666' ?>; }
input[type="text"], input[type="number"], select {
    width: 100%;
    padding: 14px 18px;
    border-radius: 10px;
    border: 2px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : '#fff' ?>;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    font-size: 15px;
}
input[readonly] { background: <?= $isDark ? 'rgba(79, 172, 254, 0.1)' : 'rgba(79, 172, 254, 0.1)' ?>; }
input:focus, select:focus { outline: none; border-color: #4facfe; }
.btn { width: 100%; padding: 16px; border-radius: 10px; border: none; font-size: 16px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
.btn-submit { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; margin-top: 20px; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4); }
.btn-cancel { background: <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>; color: <?= $isDark ? '#fff' : '#333' ?>; margin-top: 10px; }
.btn-cancel:hover { background: <?= $isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.2)' ?>; }
.btn-reset { display: inline-block; padding: 10px 20px; background: rgba(255,255,255,0.1); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; margin-top: 10px; }
</style>

<div class="form-container">
    <div class="card">
        <h2>🗺️ Agregar Nueva Ruta - Selecciona en el Mapa</h2>
        
        <div class="map-section">
            <div class="instructions">
                <h3>📍 Instrucciones:</h3>
                <p>1. <strong>Primer clic</strong> en el mapa = Punto de ORIGEN (azul)</p>
                <p>2. <strong>Segundo clic</strong> = Punto de DESTINO (rojo)</p>
                <p>3. Los datos se filled automáticamente</p>
                <button class="btn-reset" onclick="resetMap()">🔄 Reiniciar</button>
            </div>
            
            <div class="selected-points">
                <div class="point-box origen">
                    <h4>📍 Origen</h4>
                    <div class="city" id="origen-display">Esperando...</div>
                </div>
                <div class="point-box destino">
                    <h4>📍 Destino</h4>
                    <div class="city" id="destino-display">Esperando...</div>
                </div>
            </div>
            
            <div id="map"></div>
        </div>
        
        <?= $this->Form->create($ruta) ?>
        
        <div class="form-grid">
            <div class="form-group">
                <label for="origen">Origen</label>
                <?= $this->Form->text('origen', ['id' => 'origen', 'required' => true, 'readonly' => true, 'placeholder' => 'Selecciona en el mapa']) ?>
            </div>

            <div class="form-group">
                <label for="destino">Destino</label>
                <?= $this->Form->text('destino', ['id' => 'destino', 'required' => true, 'readonly' => true, 'placeholder' => 'Selecciona en el mapa']) ?>
            </div>

            <div class="form-group">
                <label for="distancia_km">Distancia (km)</label>
                <?= $this->Form->number('distancia_km', ['id' => 'distancia_km', 'step' => '0.01', 'required' => true, 'readonly' => true, 'placeholder' => 'Se calcula automáticamente']) ?>
            </div>

            <div class="form-group">
                <label for="tiempo_estimado">Tiempo Estimado (horas)</label>
                <?= $this->Form->number('tiempo_estimado', ['id' => 'tiempo_estimado', 'min' => 0, 'required' => true, 'readonly' => true, 'placeholder' => 'Se calcula automáticamente']) ?>
            </div>
        </div>

        <div class="form-group">
            <label for="tipo_ruta">Tipo de Ruta</label>
            <?= $this->Form->select('tipo_ruta', ['nacional' => 'Nacional', 'internacional' => 'Internacional'], ['id' => 'tipo_ruta', 'empty' => 'Se define automáticamente']) ?>
        </div>

        <?= $this->Form->button('💾 Guardar Ruta', ['class' => 'btn btn-submit']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-cancel']) ?>
        <?= $this->Form->end() ?>
    </div>
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
            
            document.getElementById('origen').value = closestCity;
            document.getElementById('origen-display').textContent = closestCity;
            document.getElementById('destino').value = '';
            document.getElementById('destino-display').textContent = 'Esperando...';
            
            clickCount = 1;
        } else {
            if (destinoMarker) map.removeLayer(destinoMarker);
            if (routeLine) map.removeLayer(routeLine);
            
            destinoMarker = L.marker([e.latlng.lat, e.latlng.lng], {icon: redIcon})
                .addTo(map)
                .bindPopup('🏁 Destino: ' + closestCity).openPopup();
            
            document.getElementById('destino').value = closestCity;
            document.getElementById('destino-display').textContent = closestCity;
            
            calculateRealRoute(origenMarker.getLatLng().lat, origenMarker.getLatLng().lng, e.latlng.lat, e.latlng.lng, closestCity);
            
            clickCount = 0;
        }
    });
}

function findClosestCity(lat, lng) {
    var closest = null;
    var minDist = Infinity;
    for (var city in ciudades) {
        var dist = Math.sqrt(Math.pow(lat - ciudades[city].lat, 2) + Math.pow(lng - ciudades[city].lng, 2));
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

function calculateRealRoute(origenLat, origenLng, destinoLat, destinoLng, destinoNombre) {
    var origenNombre = document.getElementById('origen').value;
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
    
    routeLine = L.polyline(latlngs, {
        color: '#4facfe',
        weight: 6,
        opacity: 0.8
    }).addTo(map);
    
    map.fitBounds(routeLine.getBounds(), {padding: [50, 50]});
    
    document.getElementById('distancia_km').value = dist;
    document.getElementById('tiempo_estimado').value = timeHrs;
    document.getElementById('tipo_ruta').value = tipo;
    
    console.log('Ruta calculada: ' + dist + ' km, ' + timeHrs + ' horas');
}

function calculateDistanceBetween(lat1, lon1, lat2, lon2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function resetMap() {
    if (origenMarker) { map.removeLayer(origenMarker); origenMarker = null; }
    if (destinoMarker) { map.removeLayer(destinoMarker); destinoMarker = null; }
    if (routeLine) { map.removeLayer(routeLine); routeLine = null; }
    
    document.getElementById('origen').value = '';
    document.getElementById('destino').value = '';
    document.getElementById('distancia_km').value = '';
    document.getElementById('tiempo_estimado').value = '';
    document.getElementById('tipo_ruta').value = '';
    document.getElementById('origen-display').textContent = 'Esperando...';
    document.getElementById('destino-display').textContent = 'Esperando...';
    
    clickCount = 0;
    map.setView([-17.0, -65.0], 6);
}

document.addEventListener('DOMContentLoaded', initMap);
</script>
