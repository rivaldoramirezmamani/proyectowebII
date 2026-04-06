<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Login', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Login', 'action' => 'logout']);
        $builder->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $builder->connect('/rutas', ['controller' => 'Rutas', 'action' => 'index']);
        $builder->connect('/rutas/add', ['controller' => 'Rutas', 'action' => 'add']);
        $builder->connect('/rutas/edit/*', ['controller' => 'Rutas', 'action' => 'edit']);
        $builder->connect('/rutas/delete/*', ['controller' => 'Rutas', 'action' => 'delete']);
        $builder->connect('/rutas/usar/*', ['controller' => 'Rutas', 'action' => 'usar']);
        $builder->connect('/rutas/mapa', ['controller' => 'Rutas', 'action' => 'map']);
        $builder->connect('/theme', ['controller' => 'Rutas', 'action' => 'theme']);
        $builder->fallbacks();
    });
};
