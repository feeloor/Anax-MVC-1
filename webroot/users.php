<?php

require __DIR__.'/config.php'; 
require "password.php";

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIMyFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

// Create services and inject into the app. 
$di->set('form', '\Mos\HTMLForm\CForm');

$di->set('CommentController', function() use ($di) {
    $controller = new \Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app->url->setUrlType(\Anax\Url\CUrl::URL_APPEND);
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_databas.php');

$app->theme->setTitle('Testar ny databasklass');

$app->router->add('', function() use ($app) {
	$app->views->add('me/index', [
        'content' => "Välkommen",
        'byline' => null
        ]);
});

$app->router->add('add', function() use ($app) {

    $form = $app->form;

    $form->create([], [
        'name' => [
            'type'       => 'text',
            'label'      => 'Name: ',
            'required'   => true,
            'validation' => ['not_empty'],
        ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Lägg till användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],    
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $name = $_SESSION['form-save']['name']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create("users/add/" . $name));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
        ]);
});

$app->router->add('update', function() use ($app) {
    $form = $app->form;

    $form->create([], [
        'id' => [
            'type'       => 'text',
            'label'      => 'ID: ',
            'required'   => true,
            'validation' => ['not_empty', 'numeric'],
            ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Uppdatera användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $id = $_SESSION['form-save']['id']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create("users/update/" . $id));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
    ]);
});

$app->router->add('delete', function() use ($app) {
    $form = $app->form;

    $form->create([], [
        'id' => [
            'type' => 'text',
            'label' => 'ID: ',
            'required' => true,
            'validation' => ['not_empty', 'numeric'],
        ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Ta bort användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $id = $_SESSION['form-save']['id']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create('users/delete/' . $id));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
    ]);
});

$app->router->add('id', function() use ($app) {
    $form = $app->form;

    $form->create([], [
        'id' => [
            'type' => 'text',
            'label' => 'ID: ',
            'required' => true,
            'validation' => ['not_empty', 'numeric'],
        ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Visa användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $id = $_SESSION['form-save']['id']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create('users/id/' . $id));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
    ]);
});

$app->router->add('soft-delete', function() use ($app) {
    $form = $app->form;

    $form->create([], [
        'id' => [
            'type' => 'text',
            'label' => 'ID: ',
            'required' => true,
            'validation' => ['not_empty', 'numeric'],
        ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Inaktivera användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $id = $_SESSION['form-save']['id']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create('users/softDelete/' . $id));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
    ]);
});

$app->router->add('undo-soft-delete', function() use ($app) {
   $form = $app->form;

    $form->create([], [
        'id' => [
            'type' => 'text',
            'label' => 'ID: ',
            'required' => true,
            'validation' => ['not_empty', 'numeric'],
        ],

        'submit' => [
            'type' => 'submit',
            'value' => 'Aktivera användare',
            'callback' => function($form) {
                $form->saveInSession = true;
                return true;
            }
        ],
    ]);

    $checkSent = $form->check();

    if($checkSent === true)
    {
        $id = $_SESSION['form-save']['id']['value'];
        session_unset($_SESSION['form-save']);

        $app->response->redirect($app->url->create('users/undoSoftDelete/' . $id));
    }

    $app->views->add('me/index', [
        'content' => $form->getHTML(),
        'byline'  => null
    ]); 
});

$app->router->add('setup', function() use ($app) {
 
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

$app->router->add('setup-comment', function() use ($app) {
 
    $app->db->dropTableIfExists('comment')->execute();
 
    $app->db->createTable(
        'comment',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'name' => ['varchar(80)'],
            'web' => ['varchar(80)'],
            'mail' => ['varchar(80)'],
            'content' => ['text'],
            'timestamp' => ['datetime'],
            'ip'      => ['varchar(80)'],
            'thumbs'  => ['integer'],
            'updated' => ['datetime'],
        ]
    )->execute();
});

$app->router->handle();
$app->theme->render();

