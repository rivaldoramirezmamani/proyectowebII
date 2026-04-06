<h1>Iniciar Sesión</h1>

<?= $this->Flash->render() ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'Login', 'action' => 'login']]) ?>
<div class="form-group">
    <label for="username">Usuario</label>
    <?= $this->Form->text('username', ['id' => 'username', 'placeholder' => 'Ingresa tu usuario', 'required' => true]) ?>
</div>

<div class="form-group">
    <label for="password">Contraseña</label>
    <?= $this->Form->password('password', ['id' => 'password', 'placeholder' => 'Ingresa tu contraseña', 'required' => true]) ?>
</div>

<?= $this->Form->button('Iniciar Sesión') ?>
<?= $this->Form->end() ?>
