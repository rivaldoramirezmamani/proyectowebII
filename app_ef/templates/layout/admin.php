<?php
$theme = $_COOKIE['theme'] ?? 'dark';
$isDark = $theme !== 'light';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: <?= $isDark ? 'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)' : 'linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)' ?>;
            min-height: 100vh;
            color: <?= $isDark ? '#e4e4e4' : '#333' ?>;
        }
        .header {
            background: <?= $isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(255, 255, 255, 0.9)' ?>;
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid <?= $isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)' ?>;
        }
        .header h1 { font-size: 24px; color: <?= $isDark ? '#fff' : '#333' ?>; }
        .header .user-info { color: <?= $isDark ? '#888' : '#666' ?>; font-size: 14px; }
        .header .logout-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
        }
        .container { padding: 40px; max-width: 1200px; margin: 0 auto; }
        .actions { margin-bottom: 20px; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .btn-primary { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .btn-danger { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%); }
        .btn-add { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
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
            letter-spacing: 1px;
        }
        td { color: <?= $isDark ? '#e4e4e4' : '#333' ?>; }
        tr:hover td { background: <?= $isDark ? 'rgba(255, 255, 255, 0.03)' : 'rgba(0, 0, 0, 0.03)' ?>; }
        .actions-cell { display: flex; gap: 10px; }
        .actions-cell a, .actions-cell button {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            border: none;
            cursor: pointer;
        }
        .actions-cell a.edit { background: #4facfe; color: #fff; }
        .actions-cell button.delete { background: #ff6b6b; color: #fff; }
        .message {
            padding: 14px 20px;
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
        .empty { text-align: center; padding: 40px; color: #666; }
        .theme-toggle {
            padding: 8px 16px;
            background: <?= $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)' ?>;
            color: <?= $isDark ? '#fff' : '#333' ?>;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $loggedInUser['correo'] === 'admin@example.com' ? 'Administrador' : 'Mi Perfil' ?></h1>
        <div>
            <span class="user-info"><?= h($loggedInUser['nombre'] ?? 'Usuario') ?></span>
            <?= $this->Html->link('Rutas', ['controller' => 'Rutas', 'action' => 'index'], ['class' => 'logout-btn', 'style' => 'margin-right:10px']) ?>
            <?= $this->Form->create(null, ['url' => ['controller' => 'Rutas', 'action' => 'theme'], 'style' => 'display:inline']) ?>
            <?= $this->Form->hidden('theme', ['value' => $isDark ? 'light' : 'dark']) ?>
            <?= $this->Form->button($isDark ? '☀️ Claro' : '🌙 Oscuro', ['class' => 'theme-toggle']) ?>
            <?= $this->Form->end() ?>
            <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Login', 'action' => 'logout'], ['class' => 'logout-btn']) ?>
        </div>
    </div>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>
