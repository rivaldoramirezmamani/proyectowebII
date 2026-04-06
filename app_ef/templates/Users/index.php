<?php
/**
 * @var \App\View\AppView $this
 * @var $loggedInUser
 * @var $users
 * @var $user
 */
$this->layout = 'admin';
?>
<style>
<?php if ($loggedInUser['correo'] !== 'admin@example.com'): ?>
.profile-container { max-width: 900px; margin: 40px auto; }
.profile-container .card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.profile-container h2 {
    font-size: 22px;
    margin-bottom: 20px;
    color: #fff;
    border-bottom: 2px solid rgba(79, 172, 254, 0.5);
    padding-bottom: 10px;
}
.profile-container .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}
.profile-container .info-item {
    background: rgba(255, 255, 255, 0.03);
    padding: 15px;
    border-radius: 12px;
}
.profile-container .info-item label {
    display: block;
    font-size: 12px;
    color: #888;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.profile-container .info-item span {
    font-size: 16px;
    color: #fff;
}
.profile-container .actions { margin-top: 20px; }
.profile-container .btn {
    display: inline-block;
    padding: 12px 28px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: #fff;
}
.profile-container .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); }
<?php endif; ?>
</style>




<?= $this->Flash->render() ?>

<?php if ($loggedInUser['correo'] === 'admin@example.com'): ?>
<div class="actions">
    <?= $this->Html->link('Agregar Usuario', ['action' => 'add'], ['class' => 'btn btn-add']) ?>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Idioma</th>
            <th>Edad</th>
            <th>Fecha Registro</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= h($user->nombre) ?></td>
            <td><?= h($user->apellido) ?></td>
            <td><?= h($user->correo) ?></td>
            <td><?= h($user->language) ?></td>
            <td><?= h($user->edad) ?></td>
            <td><?= h($user->created_at) ?></td>
            <td><?= h($user->updated_at) ?></td>
            <td>
                <div class="actions-cell">
                    <?= $this->Html->link('Editar', ['action' => 'edit', $user->id], ['class' => 'edit']) ?>
                    <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $user->id], ['confirm' => '¿Estás seguro de eliminar este usuario?', 'class' => 'delete']) ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($users->isEmpty()): ?>
<div class="empty">No hay usuarios registrados</div>
<?php endif; ?>

<?php else: ?>
<div class="profile-container">
    <div class="card">
        <h2>Mi Perfil</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Nombre</label>
                <span><?= h($user->nombre) ?></span>
            </div>
            <div class="info-item">
                <label>Apellido</label>
                <span><?= h($user->apellido) ?></span>
            </div>
            <div class="info-item">
                <label>Correo</label>
                <span><?= h($user->correo) ?></span>
            </div>
            <div class="info-item">
                <label>Idioma</label>
                <span><?= h($user->language) ?></span>
            </div>
            <div class="info-item">
                <label>Edad</label>
                <span><?= h($user->edad) ?> años</span>
            </div>
            <div class="info-item">
                <label>Fecha de Registro</label>
                <span><?= h($user->created_at) ?></span>
            </div>
        </div>
        <div class="actions">
            <?= $this->Html->link('Editar Mi Perfil', ['action' => 'edit', $user->id], ['class' => 'btn btn-edit']) ?>
        </div>
    </div>
</div>
<?php endif; ?>