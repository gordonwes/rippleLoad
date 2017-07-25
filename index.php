<?php

// Require
require __DIR__ . '/vendor/autoload.php';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'ag',
            'username' => 'root',
            'password' => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        'renderer' => [
            'template_path' => __DIR__ . '/app/',
        ]
    ]
]);

use Illuminate\Database\Capsule\Manager as Capsule;

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

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

$app->get('/admin', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'login.php', $args);
    return $response;
})->setName('login');

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['renderer']->render($response->withStatus(404), '404.php', [
            "404" => "Not Found"
        ]);
    };
};

$app->post('/admin', function ($request, $response, $args) {

    $user = Capsule::table('users')->find(1)->name;
    $psw = Capsule::table('users')->find(1)->password;
    
    $_SESSION["user"] = $user === $_POST['username'];
    //$_SESSION["psw"] = password_verify(crypt($_POST['password'], $psw), $psw);
    $_SESSION["psw"] = $_POST['password'] === $psw;
    $_SESSION["no-bot"] = empty($_POST['other']);

    if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"]) {
        return $response->withRedirect('projects');
    } else {
        return $response->withRedirect('admin?error=true');
    }

});

require __DIR__ . '/app/session.php';

$app->run();











