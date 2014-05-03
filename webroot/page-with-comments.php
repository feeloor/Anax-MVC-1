<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential settings.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->addStylesheet('css/comment.css');
// Home route
$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Welcome to Anax Guestbook");
    $app->views->add('comment/index');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

    $isPosted = $app->request->getPost('edit');

    if($isPosted)
    {
        $id = $app->request->getPost('id');
        $comments = $app->session->get('comments', []);
        $comment = $comments[$id];

        $app->views->add('comment/form', [
        'mail'      => $comment['mail'],
        'web'       => $comment['web'],
        'name'      => $comment['name'],
        'content'   => $comment['content'],
        'output'    => null,
        'edit'      => $id,
        ]);
    } else {

        $app->views->add('comment/form', [
            'mail'      => null,
            'web'       => null,
            'name'      => null,
            'content'   => null,
            'output'    => null,
            'edit'      => null,
        ]);
    }
});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();
