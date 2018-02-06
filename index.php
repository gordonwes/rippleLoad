<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

// New Slim app instance
$app = new Slim\App([
    // settings
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'renderer' => [
            'template_path' => __DIR__ . '/app/'
        ],
        'db' => [
            'servername' => 'localhost',
            'username' => 'root', // workspacestage 
            'password' => 'root',
            'dbname' => 'ag' // my_workspacestage
        ],
        'idleTime' => [
            'time' => 600
        ],
        'cover' => [
            'max_width' => 450,
            'max_height' => 450,
            'max_weight' => 4,
            'optimization' => 95
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

    $conn = $c->db;

    $main_query = "SELECT * FROM tags ORDER BY value DESC";
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

$container['visitedUser'] = function ($c) {

    $conn = $c->db;

    $main_query = "SELECT * FROM visitors ORDER BY timestamp DESC";
    $main_query_init = $conn->prepare($main_query);
    $main_query_init->execute();
    $visited_user_fetch = $main_query_init->fetchAll();

    $conn = null;

    $list_visited_user = array();

    foreach ($visited_user_fetch as $visited_user) {

        $list_visited_user[] =  $visited_user;

    }

    return $list_visited_user;

};

$container['projectBlock'] = function ($c) {

    $conn = $c->db;

    $main_query = "SELECT * FROM projects ORDER BY timestamp DESC";
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
        $size = $project['size'];
        $ref_tags = json_decode($tags);

        $projectsBlock = '<article class="project ' . $size . '" itemscope itemtype="http://schema.org/WebSite">
                                <div class="container_img" style="background-image:url(' . $cover . ');"></div>
                                <div class="container_txt">
                                <h2 itemprop="name">' . $title . '</h2>';
        if (isset($desc) && !empty($desc)) {
            $projectsBlock .= '<div class="description" itemprop="description"><p>' . $desc . '</p></div>';
        }
        $projectsBlock .= '<a href="' . $url . '" target="_blank" itemprop="url" rel="noopener">Visit Site</a>
                                <div class="project_tag">
                                <span data-tag="';

        if (is_array($ref_tags) || $ref_tags instanceof Traversable) {
            foreach ($ref_tags as $tag) {
                $projectsBlock .= $tag . ' ';
            }
        }

        $projectsBlock .= '">';

        if (is_array($ref_tags) || $ref_tags instanceof Traversable) {
            foreach ($ref_tags as $tag) {
                $projectsBlock .= $tag;
                if ($tag !== end($ref_tags)) $projectsBlock .= ', ';
            }
        }

        $projectsBlock .= '</span></div></div></article>';

        $block_project[] = $projectsBlock;

    }

    return $block_project;

};

$container['projectList'] = function ($c) {

    $conn = $c->db;

    $main_query = "SELECT * FROM projects ORDER BY timestamp ASC";
    $main_query_init = $conn->prepare($main_query);
    $main_query_init->execute();
    $content_fetch = $main_query_init->fetchAll();

    $conn = null;

    $list_project = array();

    foreach ($content_fetch as $project) {

        $id = $project['timestamp'];
        $title = $project['title'];

        $projectsList = array($id, $title);

        $list_project[] = $projectsList;

    }

    return $list_project;

};

$container['devProjects'] = function ($c) {

    return scandir(__DIR__ . "/development");

};

$container['timeIdle'] = function ($c) {

    $idleTime = $c->get('settings')['idleTime']['time'];

    if (time() - $_SESSION['timestamp'] > $idleTime){
        session_destroy();
        session_unset();
        return header("Refresh:0");
    } else {
        $_SESSION['timestamp'] = time();
    }

};

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Define named route
$app->get('/', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'about-me.php', $args);
    return $response;
})->setName('about-me');

$app->get('/projects', function ($request, $response, $args) {
    $response = $this->renderer->render($response, 'projects.php', array(
        'project_tags' => $this->get("tagsBlock"),
        'project_block' => $this->get("projectBlock")
    ));
    return $response;
})->setName('projects');

$app->get('/login', function ($request, $response, $args) {

    if (isset($_SESSION["admin"])) {

        return $response->withRedirect('admin');

    } else {
        $conn = $this->get("db");

        $user_ip = $_SERVER["REMOTE_ADDR"];

        $query_login = $conn->query("SELECT COUNT(*) FROM ip WHERE address LIKE '$user_ip' AND timestamp > (now() - interval 10 minute)");
        $fetch_attempt = $query_login->fetch();

        if ($fetch_attempt[0] > 3) {
            $response = $this->renderer->render($response, 'login.php', array(
                'max_attempts' => 'true'
            ));
            return $response;
        } else {
            $response = $this->renderer->render($response, 'login.php', $args);
            return $response;
        }
    }

})->setName('login');

$app->get('/admin', function ($request, $response, $args) {

    if (isset($_SESSION["admin"])) {

        $this->get("timeIdle");

        $response = $this->renderer->render($response, 'admin.php', array(
            'project_list' => $this->get("projectList"),
            'tags_list' => $this->get("tagsBlock"),
            'visited_user_list' => $this->get("visitedUser")
        ));
        return $response;
    } else {
        return $response->withRedirect('login');
    }
})->setName('admin');

$app->get('/dev', function ($request, $response, $args) {
    if (isset($_SESSION["admin"])) {

        $this->get("timeIdle");

        $response = $this->renderer->render($response, 'dev.php', array(
            'dev_projects' => $this->get("devProjects")
        ));
        return $response;
    } else {
        return $response->withRedirect('login');
    }
})->setName('dev');

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

    $user_ip = $_SERVER["REMOTE_ADDR"];
    $sql = "INSERT INTO ip (address ,timestamp)VALUES ('$user_ip',CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $user_ip = $_SERVER["REMOTE_ADDR"];

    $query_login = $conn->query("SELECT COUNT(*) FROM ip WHERE address LIKE '$user_ip' AND timestamp > (now() - interval 10 minute)");
    $fetch_attempt = $query_login->fetch();

    if (!isset($user) || empty($user) || !isset($psw) || empty($psw)) {

        if (!isset($user) || empty($user)) {

            $new_user = $request->getParam('username');

            $sql = "UPDATE admin SET username='$new_user' WHERE id=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

        }

        if (!isset($psw) || empty($psw)) {

            $new_psw = password_hash($request->getParam('password'), PASSWORD_BCRYPT);

            $sql = "UPDATE admin SET password='$new_psw' WHERE id=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

        }

        $sql = "DELETE FROM ip WHERE address ='$user_ip'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $response = $this->renderer->render($response, 'login.php', array(
            'credential_set' => 'true'
        ));

        return $response;

    }

    $_SESSION["user"] = $user === $request->getParam('username');
    $_SESSION["psw"] = password_verify($request->getParam('password'), $psw);
    $_SESSION["no-bot"] = empty($_POST['other']);

    if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"] && $fetch_attempt[0] <= 4) {

        $_SESSION["admin"] = true;

        $_SESSION['timestamp'] = time();

        $sql = "DELETE FROM ip WHERE address ='$user_ip'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $conn = null;

        return $response->withRedirect('admin');
    } elseif ($fetch_attempt[0] > 4) {
        $response = $this->renderer->render($response, 'login.php', array(
            'max_attempts' => 'true'
        ));
        $conn = null;
        return $response;
    } else {
        $response = $this->renderer->render($response, 'login.php', array(
            'error' => 'true'
        ));
        $conn = null;
        return $response;
    }

});

$app->post('/upload/project', function ($request, $response, $args) {

    $conn = $this->get("db");

    $projectName = $request->getParam('projectname');
    $projectUrl = $request->getParam('projecturl');
    $projectTags = $request->getParam('projecttags');
    $projectDescription = $request->getParam('projectdesc');
    $projectSize = $request->getParam('projectsize');
    $projectCover = $request->getUploadedFiles();

    if (!empty($projectCover['newfile'])) {

        $newfile = $projectCover['newfile'];

        if ($newfile->getError() === UPLOAD_ERR_OK) {

            $uploadFileName = $newfile->getClientFilename();
            $uploadFileType = $newfile->getClientMediaType();
            $uploadFileSize = $newfile->getSize() / 1024;

            if ($uploadFileSize < $this->get('settings')['cover']['max_weight'] * 1000) {

                $path = __DIR__ . "/images/upload/$uploadFileName";

                $newfile->moveTo($path);

                if ($uploadFileType !== 'image/gif') {

                    list($width, $height) = getimagesize($path);

                    if ($uploadFileType === 'image/jpeg') {
                        $im = imagecreatefromjpeg($path);
                        header('Content-Type: image/jpeg');
                    } elseif ($uploadFileType === 'image/png') {
                        $im = imagecreatefrompng($path);
                        header('Content-Type: image/png');
                    } else {
                        return false;
                    }

                    $maxWidth = $this->get('settings')['cover']['max_width'];
                    $maxHeight = $this->get('settings')['cover']['max_height'];
                    $jpgQuality = $this->get('settings')['cover']['optimization'];
                    $pngQuality = ($jpgQuality - 100) / 11.111111;
                    $pngQuality = round(abs($pngQuality));

                    // Calculate ratio of desired maximum sizes and original sizes.
                    $widthRatio = $maxWidth / $width;
                    $heightRatio = $maxHeight / $height;

                    // Ratio used for calculating new image dimensions.
                    $ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
                    $newWidth  = (int)$width  * $ratio;
                    $newHeight = (int)$height * $ratio;

                    // Create final image with new dimensions.
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);

                    if ($uploadFileType === 'image/png' || $uploadFileType === 'image/gif') {
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                        imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
                    }

                    imagecopyresampled($newImage, $im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    if ($uploadFileType === 'image/jpeg') {
                        imageinterlace($newImage, true);
                        imagejpeg($newImage, $path, $jpgQuality);
                    } elseif ($uploadFileType === 'image/png') {
                        imagepng($newImage, $path, $pngQuality);
                    } elseif ($uploadFileType === 'image/gif') {
                        imagegif($newImage, $path);
                    } else {
                        return false;
                    }

                    // Free up the memory.
                    imagedestroy($im);
                    imagedestroy($newImage);

                }

                $coverName = $uploadFileName;

            } else {

                $response = $this->renderer->render($response, 'admin.php', array(
                    'img_too_big' => $this->get('settings')['cover']['max_weight'],
                    'project_list' => $this->get("projectList"),
                    'tags_list' => $this->get("tagsBlock")
                ));
                return $response;

            }

            $add_value = $conn->prepare("INSERT INTO projects(cover, title, description, url, tags, size, timestamp)
        VALUES(:cover, :title, :description, :url, :tags, :size, :timestamp)");

            $add_value->execute(array(
                "cover" => "images/upload/" . $coverName,
                "title" => $projectName,
                "description" => $projectDescription,
                "url" => $projectUrl,
                "tags" => json_encode($projectTags),
                "size" => $projectSize,
                "timestamp" => date("Y-m-d H:i:s")
            ));

            $conn = null;

            return $response->withRedirect('../admin');

        }

    }

});

$app->post('/manager/tags', function ($request, $response, $args) {

    $conn = $this->get("db");

    $tagName = $request->getParam('tagname');

    if ($request->getParam('submit') == 'Add New Tag') {

        $sql = "INSERT INTO tags SET value='$tagName'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

    } else {

        $sql = "DELETE FROM tags WHERE value ='$tagName'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

    }

    $conn = null;

    return $response->withRedirect('../admin');

});

$app->post('/delete/project', function ($request, $response, $args) {

    $conn = $this->get("db");

    $timestamp_to_delete = $request->getParam('timestamp_project');

    $sql = "DELETE FROM projects WHERE timestamp ='$timestamp_to_delete'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $conn = null;

    return $response->withRedirect('../admin');

});

$app->post('/delete/dev', function ($request, $response, $args) {

    $name_to_delete = $request->getParam('name_dev');

    if ($name_to_delete) {
        $path_delete = __DIR__ . '/development/' . $name_to_delete;
        if (is_writable($path_delete)) {
            if (!is_dir($path_delete)) {
                unlink($path_delete);
            } else {
                if (substr($path_delete, strlen($path_delete) - 1, 1) != '/') {
                    $path_delete .= '/';
                }
                $files = glob($path_delete . '*', GLOB_MARK);
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        self::deleteDir($file);
                    } else {
                        unlink($file);
                    }
                }
                rmdir($path_delete);
            }
        }

    }

    return $response->withRedirect('../dev');

});

$app->post('/upload/dev', function ($request, $response, $args) {

    $file = $request->getUploadedFiles();

    if (!empty($file['newfile'])) {

        $newfile = $file['newfile'];

        if ($newfile->getError() === UPLOAD_ERR_OK) {

            $uploadFileName = $newfile->getClientFilename();
            $uploadFileSize = $newfile->getSize() / 1024;

            ini_set('memory_limit', '128M');

            if ($uploadFileSize < 100000) {

                $newfile->moveTo(__DIR__ . "/development/$uploadFileName");

                return $response->withRedirect('../dev');

            } else {

                $response = $this->renderer->render($response, 'dev.php', array(
                    'file_too_big' => 'true',
                    'dev_projects' => $this->get("devProjects")
                ));
                return $response;

            }

        }

    }

});

$app->post('/track', function ($request, $response, $args) {

    $conn = $this->get("db");

    $userDetails = $request->getParsedBody();

    $ip = $_SERVER["REMOTE_ADDR"];

    $query_ip = $conn->query("SELECT ip FROM visitors");

    $fetch_ip = $query_ip->fetch();
    $registered_ip = $fetch_ip["ip"];

    $black_list_ip = array('127.0.0.1', '::1');

    if ($registered_ip !== $ip && !in_array($ip, $black_list_ip)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=" . $ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $ip_data_in = curl_exec($ch);
        curl_close($ch);

        $ipdat = json_decode($ip_data_in, true);

        if (strlen(trim($ipdat->geoplugin_countryCode)) >= 2) {
            $country = $ipdat->geoplugin_countryName;
        } else {
            $country = htmlspecialchars($userDetails['lang']);
        }

        $add_user = $conn->prepare("INSERT INTO visitors(ip, device, browser, country, visitedYear, visitedMonth, visitedDay, visitedHour, timestamp)
        VALUES(:ip, :device, :browser, :country, :visitedYear, :visitedMonth, :visitedDay, :visitedHour, :timestamp)");

        $add_user->execute(array(
            "ip" => $ip,
            "device" => htmlspecialchars($userDetails['device']),
            "browser" => htmlspecialchars($userDetails['browser']),
            "country" => $country,
            "visitedYear" => date("Y"),
            "visitedMonth" => date("m"),
            "visitedDay" => date("d"),
            "visitedHour" => date("H"),
            "timestamp" => date("Y-m-d H:i:s")
        ));
    }

    $conn = null;

});

$app->run();