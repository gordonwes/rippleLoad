<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
$baseUrl = 'http://localhost:8888/vue';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'displayErrorDetails' => true,
        'view_path' => __DIR__ . '/app/'
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