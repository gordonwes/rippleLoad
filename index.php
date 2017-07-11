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
    $response = $this->renderer->render($response, 'index.php', $args);
    return $response;
})->setName('homepage');

$app->get('/chi-sono', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'chi-sono.php', $args);
    return $response;
})->setName('chi-sono');

$app->run();