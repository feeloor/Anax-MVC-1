<?php

require __DIR__.'/config.php'; 
require "password.php";

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIMyFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_grid.php');
$app->theme->setTitle('Testar ny databasklass');

$app->router->add('', function() use ($app) {
	echo "Lite databastester";
});

/*$app->router->add('setup', function() use ($app) {
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();

      $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = date(DATE_RFC2822);
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);


});

$app->router->add('users/add/:acronym', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'add'
        ]);
});

$app->router->add('users/delete/:number', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'delete'
        ]);
});

$app->router->add('users/update/:number', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'update'
        ]);
});*/

$app->router->add('users/list', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list'
    ]);
});

$app->router->add('users/id/:number', function() use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'id'
        ]);
});

$app->router->handle();
$app->theme->render();

