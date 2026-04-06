<?php
/**
 * @var \App\View\AppView $this
 * @var $loggedInUser
 * @var $rutas
 * @var $misRutas
 * @var $rutasDisponibles
 */
$this->layout = 'admin';
$theme = $_COOKIE['theme'] ?? 'dark';
$isDark = $theme !== 'light';
?>
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
    border-bottom: 2px solid <?= $isDark ? 'rgba(79, 172, 254, 0.5)' : 'rgba(79, 172, 254, 0.5)' ?>;
    padding-bottom: 10px;
}
.card h3 {
    font-size: 16px;
    margin-bottom: 10px;
    color: <?= $isDark ? '#aaa' : '#666' ?>;
}
.search-box {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.search-box input, .search-box select {
    padding: 10px 15px;
    border-radius: 8px;
    border: 2px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : '#fff' ?>;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    font-size: 14px;
}
.search-box button {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}
.ruta-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 15px;
}
.ruta-item {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.03)' : 'rgba(0, 0, 0, 0.03)' ?>;
    padding: 15px;
    border-radius: 10px;
}
.ruta-item label {
    display: block;
    font-size: 12px;
    color: <?= $isDark ? '#888' : '#666' ?>;
    margin-bottom: 5px;
}
.ruta-item span {
    font-size: 16px;
    color: <?= $isDark ? '#fff' : '#333' ?>;
    font-weight: 500;
}
.historial-section {
    margin-top: 20px;
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
.tag.usada { background: #f39c12; color: #fff; }
</style>

<?= $this->Flash->render() ?>

<?php if ($loggedInUser['correo'] === 'admin@example.com'): ?>
<div class="actions">
    <?= $this->Html->link('Agregar Ruta', ['action' => 'add'], ['class' => 'btn btn-add']) ?>
</div>

<div class="card">
    <h2>Buscar Historial</h2>
    <form method="get" action="/rutas">
        <div class="search-box">
            <select name="searchType">
                <option value="idruta" <?= (isset($searchType) && $searchType === 'idruta') ? 'selected' : '' ?>>Por ID Ruta</option>
                <option value="usuario" <?= (isset($searchType) && $searchType === 'usuario') ? 'selected' : '' ?>>Por Usuario</option>
            </select>
            <input type="text" name="search" placeholder="Buscar..." value="<?= h($search ?? '') ?>">
            <button type="submit">Buscar</button>
        </div>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Distancia (km)</th>
            <th>Tiempo (hrs)</th>
            <th>Tipo</th>
            <th>Usuario</th>
            <th>Fecha Uso</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rutas as $ruta): ?>
        <tr>
            <td><?= $ruta->idruta ?></td>
            <td><?= h($ruta->origen) ?></td>
            <td><?= h($ruta->destino) ?></td>
            <td><?= h($ruta->distancia_km) ?></td>
            <td><?= h($ruta->tiempo_estimado) ?></td>
            <td><span class="tag <?= h($ruta->tipo_ruta) ?>"><?= h(ucfirst($ruta->tipo_ruta)) ?></span></td>
            <td><?= $ruta->user ? h($ruta->user->nombre) : '-' ?></td>
            <td><?= $ruta->fecha_uso ? h($ruta->fecha_uso) : '-' ?></td>
            <td>
                <div class="actions-cell">
                    <?= $this->Html->link('Editar', ['action' => 'edit', $ruta->idruta], ['class' => 'edit']) ?>
                    <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $ruta->idruta], ['confirm' => '¿Eliminar esta ruta?', 'class' => 'delete']) ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($rutas)): ?>
<div class="empty">No hay rutas registradas</div>
<?php endif; ?>

<?php else: ?>

<div class="card">
    <h2>Rutas Disponibles</h2>
    <p style="margin-bottom: 15px;">
        <?= $this->Html->link('🗺️ Ver en el Mapa', ['action' => 'map'], ['class' => 'btn', 'style' => 'display:inline-block; width:auto;']) ?>
    </p>
    <?php if (empty($rutasDisponibles)): ?>
    <div class="empty">No hay rutas disponibles</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia (km)</th>
                <th>Tiempo (hrs)</th>
                <th>Tipo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rutasDisponibles as $ruta): ?>
            <tr>
                <td><?= h($ruta->origen) ?></td>
                <td><?= h($ruta->destino) ?></td>
                <td><?= h($ruta->distancia_km) ?></td>
                <td><?= h($ruta->tiempo_estimado) ?></td>
                <td><span class="tag <?= h($ruta->tipo_ruta) ?>"><?= h(ucfirst($ruta->tipo_ruta)) ?></span></td>
                <td>
                    <?= $this->Html->link('Usar Ruta', ['action' => 'usar', $ruta->idruta], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<div class="card historial-section">
    <h2>Mi Historial</h2>
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

<?php endif; ?>
