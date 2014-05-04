<?php

require __DIR__.'/config.php'; 
require "password.php";

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIMyFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

// Create services and inject into the app. 
$di->set('form', '\Mos\HTMLForm\CForm');

$app->url->setUrlType(\Anax\Url\CUrl::URL_APPEND);
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_grid.php');

$di->set('CommentController', function() use ($di) {
    $controller = new \Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('table', function() {
    $table = new \Feeloor\Table\CTable();
    return $table;
});

$app->router->add('', function() use ($app) {
 
    $app->theme->setTitle("Me");
 
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/index', [
        'content' => $content,
        'byline'  => $byline,
    ]); 
    

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'list',
    ]);

    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
        ]);
});

$app->router->add('report', function() use($app) {

	$app->theme->setTitle("Redovisning");

	$content = $app->fileContent->get('report.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');

	$byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

	$app->views->add('me/index', [
		'content' => $content, 
		'byline'  => $byline,
		]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'list',
    ]);

    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
        ]);
});

$app->router->add('source', function() use ($app) {
 
    //$app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
 
});

$app->router->add('newTheme/regions', function() use($app) {
    $app->theme->setTitle("Nytt Tema");

    $app->theme->setVariable('regionsStyle', 'backgroundGrey');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-1, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-1');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-2, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-2');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-3, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-3');

    $app->views->add('me/index', [
        'content' => '<h1>Välkommen</h1>Detta är en test av mitt tema, med massa olika regioner.',
        'byline'  => null,
        ], 'main');

    $app->views->add('me/index', [
        'content' => '<h1>Senaste nytt</h1><p>Här kommer senaste nytt komma upp.</p>',
        'byline' => null,
    ], 'sidebar');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-1, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-1');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-2, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-2');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-3, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-3');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-4, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-4');
});

$app->router->add('newTheme/square-net', function() use($app) {
    $app->theme->setTitle("Rutnät");
    $app->theme->setVariable('wrapperStyle', 'grid');

       $app->theme->setVariable('regionsStyle', 'backgroundGrey');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-1, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-1');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-2, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-2');

    $app->views->add('me/index', [
        'content' => 'Detta är featured-3, och här kan man lägga nyheter eller nåt.',
        'byline'  => null,
        ], 'featured-3');

    $app->views->add('me/index', [
        'content' => '<h1>Välkommen</h1>Detta är en test av mitt tema, med massa olika regioner.',
        'byline'  => null,
        ], 'main');

    $app->views->add('me/index', [
        'content' => '<h1>Senaste nytt</h1><p>Här kommer senaste nytt komma upp.</p>',
        'byline' => null,
    ], 'sidebar');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-1, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-1');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-2, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-2');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-3, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-3');

    $app->views->add('me/index', [
        'content' => 'Detta är footer-col-4, och här kan man lägga länkar eller nåt.',
        'byline' => null,
    ], 'footer-col-4'); 

});

$app->router->add('newTheme/fonts', function() use($app) {
    $app->theme->setTitle("Font-Awesome");

    $content = $app->fileContent->get('font-awesome.html');

    $app->views->add('me/index', [
        'content' => $content,
        'byline' => null
        ]);
});

$app->router->add('table', function() use ($app) {
    $app->theme->setTitle("Table-test");

    $app->table->create([
            'tableClass' => 'class',
            
            'data' => [
                'heading' => [
                    'item-1' => [
                        'type' => 'th',
                        'class' => 'th-class',
                        'content' => 'column 1',
                    ],

                    'item-2' => [
                        'type' => 'th',
                        'class' => 'th-class',
                        'content' => 'column 2',
                    ],

                    'item-3' => [
                        'type' => 'th',
                        'class' => 'th-class',
                        'content' => 'column 3',
                    ],
                ],

                'row-1' => [
                    'item-1' => [
                        'type' => 'td',
                        'class' => 'td-class1',
                        'content' => 'one',
                    ],

                    'item-2' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'two',
                    ],

                    'item-3' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'three',
                    ],
                ],

                'row-2' => [
                    'item-1' => [
                        'type' => 'td',
                        'class' => 'td-class1',
                        'content' => 'four',
                    ],

                    'item-2' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'five',
                    ],

                    'item-3' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'six',
                    ],  
                ],

                'row-3' => [
                    'item-1' => [
                        'type' => 'td',
                        'class' => 'td-class1',
                        'content' => 'seven',
                    ],

                    'item-2' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'eight',
                    ],

                    'item-3' => [
                        'type' => 'td',
                        'class' => 'tdssss',
                        'content' => 'nine',
                    ],  
                ],
            ],
        ]);

    $app->views->add('me/index', [
        'content' => $app->table->showTable(),
        'byline' => null
    ]);
});

$app->router->handle();
$app->theme->render();