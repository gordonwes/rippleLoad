<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
$baseUrl = 'http://localhost:8888/rippleLoad';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

// Fetch DI Container
$container = $app->getContainer();

// Define named route

$app->get('/', function ($request, $response, $args) {
    $response = $response->withRedirect("app/index.php");
    return $response;
})->setName('homepage');

$app->get('/prova', function ($request, $response, $args) {
    $response = $response->withRedirect("app/prova.php");
    return $response;
})->setName('prova');

$app->run();