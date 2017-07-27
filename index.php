<?php

// Require
require __DIR__ . '/vendor/autoload.php';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
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

/*$app->post('/admin', function ($request, $response, $args) {

    $table = Capsule::table('users')->find(1);
    $user = $table->name;
    $psw = $table->password;

    if (empty($psw)) {
        $table->password
    }

    $_SESSION["user"] = $user === $request->getParam('username');
    $_SESSION["psw"] = password_verify($psw, password_hash($request->getParam('password'), PASSWORD_BCRYPT));
    $_SESSION["no-bot"] = empty($_POST['other']);

    if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"]) {
        return $response->withRedirect('projects');
    } else {
        return $response->withRedirect('admin?error=true');
    }

});*/

$app->post('/admin', function ($request, $response, $args) {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ag";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_user = $conn->query("SELECT name FROM users");
        $query_psw = $conn->query("SELECT password FROM users");

        $fetch_user = $query_user->fetch();
        $user = $fetch_user["name"];

        $fetch_psw = $query_psw->fetch();
        $psw = $fetch_psw["password"];

        if (!isset($psw)) {

            $new_psw = password_hash($request->getParam('password'), PASSWORD_BCRYPT);

            $sql = "UPDATE users SET password='$new_psw' WHERE id=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $_SESSION["user"] = $user === $request->getParam('username');
            $_SESSION["psw"] = password_verify($request->getParam('password'), $psw);
            $_SESSION["no-bot"] = empty($_POST['other']);

        } else {

            $_SESSION["user"] = $user === $request->getParam('username');
            $_SESSION["psw"] = password_verify($request->getParam('password'), $psw);
            $_SESSION["no-bot"] = empty($_POST['other']);

        }

        if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"]) {
            return $response->withRedirect('projects');
        } else {
            return $response->withRedirect('admin?error=true');
        }

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;

});

$app->post('/upload', function ($request, $response, $args) {

    $files = $request->getUploadedFiles();
    if (empty($files['newfile'])) {
        throw new Exception('Expected a newfile');
    }

    $newfile = $files['newfile'];

    if ($newfile->getError() === UPLOAD_ERR_OK) {
        $uploadFileName = $newfile->getClientFilename();
        $newfile->moveTo("./upload/$uploadFileName");
    }

});

require __DIR__ . '/app/session.php';

$app->run();











