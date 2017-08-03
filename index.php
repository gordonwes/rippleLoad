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
        ],
        'db' => [
            'servername' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'ag'
        ]
    ]
]);

$container = $app->getContainer();

$container['db'] = function ($c) {

    $servername = $c->get('settings')['db']['servername'];
    $username = $c->get('settings')['db']['username'];
    $password = $c->get('settings')['db']['password'];
    $dbname = $c->get('settings')['db']['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

};

$container['tagsBlock'] = function ($c) {

    $servername = $c->get('settings')['db']['servername'];
    $username = $c->get('settings')['db']['username'];
    $password = $c->get('settings')['db']['password'];
    $dbname = $c->get('settings')['db']['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $main_query = "SELECT * FROM tags ORDER BY id DESC";
    $main_query_init = $conn->prepare($main_query);
    $main_query_init->execute();
    $tags_fetch = $main_query_init->fetchAll();

    $conn = null;

    $list_tags = array();

    foreach ($tags_fetch as $tag) {

        $list_tags[] = $tag['value'];

    }

    return $list_tags;

};

$container['projectBlock'] = function ($c) {

    $servername = $c->get('settings')['db']['servername'];
    $username = $c->get('settings')['db']['username'];
    $password = $c->get('settings')['db']['password'];
    $dbname = $c->get('settings')['db']['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $main_query = "SELECT * FROM projects ORDER BY id DESC";
    $main_query_init = $conn->prepare($main_query);
    $main_query_init->execute();
    $content_fetch = $main_query_init->fetchAll();

    $conn = null;

    $block_project = array();

    foreach ($content_fetch as $project) {

        $cover = $project['cover'];
        $title = $project['title'];
        $desc = $project['description'];
        $url = $project['url'];
        $tags = $project['tags'];

        $projectsBlock = '<article class="project">
                                <div class="container_img" style="background-image:url(' . $cover . ');"></div>
                                <div class="container_txt">
                                <h2>' . $title . '</h2>';
        if (isset($desc) && !empty($desc)) {
            $projectsBlock .= '<p>' . $desc . '</p>';
        }
        $projectsBlock .= '<a href="' . $url . '">See more</a>
                                <div class="project_tag">
                                <span data-tag="';

        foreach (json_decode($tags) as $tag) {
            $projectsBlock .= $tag;
            if ($tag !== end(json_decode($tags))) $projectsBlock .= ', ';
        }

        $projectsBlock .= '">';

        foreach (json_decode($tags) as $tag) {
            $projectsBlock .= $tag;
            if ($tag !== end(json_decode($tags))) $projectsBlock .= ', ';
        }

        $projectsBlock .= '</span></div></div></article>';

        $block_project[] = $projectsBlock;

    }

    return $block_project;

};

$container['projectList'] = function ($c) {

    $servername = $c->get('settings')['db']['servername'];
    $username = $c->get('settings')['db']['username'];
    $password = $c->get('settings')['db']['password'];
    $dbname = $c->get('settings')['db']['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $main_query = "SELECT * FROM projects ORDER BY id ASC";
    $main_query_init = $conn->prepare($main_query);
    $main_query_init->execute();
    $content_fetch = $main_query_init->fetchAll();

    $conn = null;

    $list_project = array();

    foreach ($content_fetch as $project) {

        $id = $project['id'];
        $title = $project['title'];

        $projectsList = array($id, $title);

        $list_project[] = $projectsList;

    }

    return $list_project;

};

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
    $response = $this->renderer->render($response, 'projects.php', array(
        'project_tags' => $this->get("tagsBlock"),
        'project_block' => $this->get("projectBlock")
    ));
    return $response;
})->setName('projects');

$app->get('/login', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'login.php', $args);
    return $response;
})->setName('login');

$app->get('/admin', function ($request, $response, $args) {
    if (isset($_SESSION["admin"])) {
        $response = $this->renderer->render($response, 'admin.php', array(
            'project_list' => $this->get("projectList"),
            'tags_list' => $this->get("tagsBlock")
        ));
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

    $conn = $this->get("db");

    $query_user = $conn->query("SELECT username FROM admin");
    $query_psw = $conn->query("SELECT password FROM admin");

    $fetch_user = $query_user->fetch();
    $user = $fetch_user["username"];

    $fetch_psw = $query_psw->fetch();
    $psw = $fetch_psw["password"];

    $conn = null;

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

});

$app->post('/upload/project', function ($request, $response, $args) {

    $conn = $this->get("db");

    $projectName = $request->getParam('projectname');
    $projectUrl = $request->getParam('projecturl');
    $projectTags = $request->getParam('projecttags');
    $projectDescription = $request->getParam('projectdesc');
    $projectCover = $request->getUploadedFiles();

    if (!empty($projectCover['newfile'])) {

        $newfile = $projectCover['newfile'];

        if ($newfile->getError() === UPLOAD_ERR_OK) {

            $uploadFileName = $newfile->getClientFilename();
            $uploadFileType = $newfile->getClientMediaType();
            $uploadFileSize = $newfile->getSize() / 1024;
            $maxSize = $request->getParam('MAX_FILE_SIZE');

            if ($uploadFileSize < $maxSize && $uploadFileType === 'image/jpeg' || $uploadFileType === 'image/png') {
                $newfile->moveTo(__DIR__ . "/images/upload/$uploadFileName");
                $coverName = $uploadFileName;
            } else {
                $coverName = 'images/upload/default.jpg';
            }

        }

    }

    $add_value = $conn->prepare("INSERT INTO projects(cover, title, description, url, tags)
        VALUES(:cover, :title, :description, :url, :tags)");

    $add_value->execute(array(
        "cover" => "images/upload/" . $coverName,
        "title" => $projectName,
        "description" => $projectDescription,
        "url" => $projectUrl,
        "tags" => json_encode($projectTags)
    ));

    $conn = null;

    return $response->withRedirect('../admin');

});

$app->post('/upload/tags', function ($request, $response, $args) {

    $conn = $this->get("db");

    $tagName = $request->getParam('tagname');

    $sql = "INSERT INTO tags SET value='$tagName'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $conn = null;

    return $response->withRedirect('../admin');

});

$app->post('/delete/project', function ($request, $response, $args) {

    $conn = $this->get("db");

    $id_to_delete = $request->getParam('id_project');

    $sql = "DELETE FROM projects WHERE id ='$id_to_delete'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $conn = null;

    return $response->withRedirect('../admin');

});

$app->run();











