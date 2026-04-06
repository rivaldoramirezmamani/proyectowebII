<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var $history
 */
$this->layout = 'dark';
?>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        min-height: 100vh;
        color: #e4e4e4;
        padding: 20px;
    }
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .header h1 {
        font-size: 32px;
        color: #fff;
    }
    .logout-btn {
        padding: 10px 24px;
        background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .logout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(233, 69, 96, 0.4);
    }
    .card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .card h2 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid rgba(233, 69, 96, 0.5);
        padding-bottom: 10px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    .info-item {
        background: rgba(255, 255, 255, 0.03);
        padding: 15px;
        border-radius: 12px;
    }
    .info-item label {
        display: block;
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .info-item span {
        font-size: 16px;
        color: #fff;
    }
    .btn {
        display: inline-block;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .btn-edit {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: #fff;
    }
    .btn-delete {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
        color: #fff;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    .actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    th {
        color: #888;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    td {
        color: #e4e4e4;
    }
    tr:hover td {
        background: rgba(255, 255, 255, 0.03);
    }
    .empty {
        text-align: center;
        padding: 30px;
        color: #666;
    }
    .message {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .message.success {
        background: rgba(76, 175, 80, 0.2);
        border: 1px solid rgba(76, 175, 80, 0.5);
        color: #81c784;
    }
    .message.error {
        background: rgba(244, 67, 54, 0.2);
        border: 1px solid rgba(244, 67, 54, 0.5);
        color: #e57373;
    }
</style>

<div class="profile-container">
    <div class="header">
        <h1>Mi Perfil</h1>
        <div style="display: flex; align-items: center; gap: 15px;">
            <span class="user-info"><?= h($user->nombre ?? 'Usuario') ?></span>
            <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Login', 'action' => 'logout'], ['class' => 'logout-btn']) ?>
        </div>
    </div>

    <?= $this->Flash->render() ?>

    <div class="card">
        <h2>Información Personal</h2>
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
                <label>Fecha de Registro</label>
                <span><?= h($user->created_at) ?></span>
            </div>
            <div class="info-item">
                <label>Última Actualización</label>
                <span><?= h($user->updated_at) ?></span>
            </div>
        </div>
        <div class="actions">
            <?= $this->Html->link('Editar Perfil', ['action' => 'edit'], ['class' => 'btn btn-edit']) ?>
            <?= $this->Form->postLink('Eliminar Cuenta', ['action' => 'delete'], ['confirm' => '¿Estás seguro de que quieres eliminar tu cuenta?', 'class' => 'btn btn-delete']) ?>
        </div>
    </div>

    <div class="card">
        <h2>Historial de Actividad</h2>
        <?php if ($history->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Acción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $entry): ?>
                    <tr>
                        <td><?= h($entry->action) ?></td>
                        <td><?= h($entry->created_at) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No hay historial registrado</div>
        <?php endif; ?>
    </div>
</div>
