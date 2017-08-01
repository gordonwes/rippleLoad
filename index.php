<?php

session_start();

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

$app->get('/login', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'login.php', $args);
    return $response;
})->setName('login');

$app->get('/admin', function ($request, $response, $args) {
    if (isset($_SESSION["admin"])) {
        $response = $this->renderer->render($response, 'admin.php', $args);
        return $response;
    } else {
        return $response->withRedirect('login');
    }
})->setName('admin');

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['renderer']->render($response->withStatus(404), '404.php', [
            "404" => "Not Found"
        ]);
    };
};

$app->post('/login', function ($request, $response, $args) {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ag";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_user = $conn->query("SELECT username FROM admin");
        $query_psw = $conn->query("SELECT password FROM admin");

        $fetch_user = $query_user->fetch();
        $user = $fetch_user["username"];

        $fetch_psw = $query_psw->fetch();
        $psw = $fetch_psw["password"];

        if (!isset($psw) || empty($psw)) {

            $new_psw = password_hash($request->getParam('password'), PASSWORD_BCRYPT);

            $sql = "UPDATE admin SET password='$new_psw' WHERE id=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

        }

        $_SESSION["user"] = $user === $request->getParam('username');
        $_SESSION["psw"] = password_verify($request->getParam('password'), $psw);
        $_SESSION["no-bot"] = empty($_POST['other']);


        if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"]) {
            $_SESSION["admin"] = true;
            return $response->withRedirect('projects');
        } else {
            return $response->withRedirect('login?error=true');
        }

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;

});

$app->post('/upload', function ($request, $response, $args) {

    $projectName = $request->getParam('projectname');
    $projectUrl = $request->getParam('projecturl');
    $projectTags = $request->getParam('projecttags');

    $files = $request->getUploadedFiles();

    if (!empty($files['newfile'])) {

        $newfile = $files['newfile'];

        if ($newfile->getError() === UPLOAD_ERR_OK) {

            $uploadFileName = $newfile->getClientFilename();
            $uploadFileType = $newfile->getClientMediaType();
            $uploadFileSize = $newfile->getSize() / 1024;
            $maxSize = $request->getParam('MAX_FILE_SIZE');

            if ($uploadFileSize < $maxSize && $uploadFileType === 'image/jpeg' || $uploadFileType === 'image/png') {
                //echo $newfile->getStream();  // retrieve asset
                $newfile->moveTo(__DIR__ . "/assets/$uploadFileName");
            }

        }

    }

});

$app->run();











