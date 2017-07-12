<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
$baseUrl = 'http://localhost:8888/rippleLoad';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'displayErrorDetails' => true,
        'renderer' => [
            'template_path' => __DIR__ . '/app/',
        ]
    ]
]);


$container = $app->getContainer();
// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Define named route

$app->get('/', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'contact.php', $args);
    return $response;
})->setName('contact');

$app->get('/projects', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'projects.php', $args);
    return $response;
})->setName('projects');

$app->run();