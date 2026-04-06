<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->layout = 'admin';
?>
<style>
    .form-container { max-width: 600px; margin: 0 auto; }
    .card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 35px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    h2 { margin-bottom: 25px; color: #fff; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 500; color: #b8b8b8; }
    input[type="text"], input[type="password"], input[type="email"] {
        width: 100%;
        padding: 14px 18px;
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        font-size: 15px;
    }
    input:focus { outline: none; border-color: #4facfe; background: rgba(255, 255, 255, 0.1); }
    .btn { width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 16px; font-weight: 600; cursor: pointer; }
    .btn-submit { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4); }
    .btn-cancel { background: rgba(255, 255, 255, 0.1); color: #fff; margin-top: 10px; }
    .btn-cancel:hover { background: rgba(255, 255, 255, 0.2); }
</style>

<div class="form-container">
    <div class="card">
        <h2>Agregar Usuario</h2>
        
        <?= $this->Form->create($user) ?>
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <?= $this->Form->text('nombre', ['id' => 'nombre', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido</label>
            <?= $this->Form->text('apellido', ['id' => 'apellido', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="correo">Correo</label>
            <?= $this->Form->email('correo', ['id' => 'correo', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <?= $this->Form->password('password', ['id' => 'password', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label for="language">Idioma</label>
            <?= $this->Form->text('language', ['id' => 'language', 'value' => 'es']) ?>
        </div>

        <div class="form-group">
            <label for="edad">Edad</label>
            <?= $this->Form->number('edad', ['id' => 'edad', 'min' => 0, 'max' => 150]) ?>
        </div>

        <?= $this->Form->button('Guardar Usuario', ['class' => 'btn btn-submit']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-cancel']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
