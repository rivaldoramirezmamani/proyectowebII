<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ruta $ruta
 */
$this->layout = 'admin';
$theme = $_COOKIE['theme'] ?? 'dark';
$isDark = $theme !== 'light';
?>
<style>
.form-container { max-width: 600px; margin: 0 auto; }
.card {
    background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.9)' ?>;
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 35px;
    border: 1px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
}
h2 { margin-bottom: 25px; color: <?= $isDark ? '#fff' : '#333' ?>; }
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
input:focus, select:focus { outline: none; border-color: #4facfe; background: <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : '#fff' ?>; }
.btn { width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 16px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
.btn-submit { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4); }
.btn-cancel { background: <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>; color: <?= $isDark ? '#fff' : '#333' ?>; margin-top: 10px; }
.btn-cancel:hover { background: <?= $isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.2)' ?>; }
</style>

<div class="form-container">
    <div class="card">
        <h2>Editar Ruta</h2>
        
        <?= $this->Form->create($ruta) ?>
        
        <div class="form-group">
            <label for="origen">Origen</label>
            <?= $this->Form->text('origen', ['id' => 'origen', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="destino">Destino</label>
            <?= $this->Form->text('destino', ['id' => 'destino', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="distancia_km">Distancia (km)</label>
            <?= $this->Form->number('distancia_km', ['id' => 'distancia_km', 'step' => '0.01', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="tiempo_estimado">Tiempo Estimado (horas)</label>
            <?= $this->Form->number('tiempo_estimado', ['id' => 'tiempo_estimado', 'min' => 0, 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="tipo_ruta">Tipo de Ruta</label>
            <?= $this->Form->select('tipo_ruta', ['nacional' => 'Nacional', 'internacional' => 'Internacional'], ['id' => 'tipo_ruta', 'empty' => 'Seleccionar tipo']) ?>
        </div>

        <?= $this->Form->button('Actualizar Ruta', ['class' => 'btn btn-submit']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-cancel']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
