<?php
require '_var.php'; 
$pageTitle = 'Projects';
$pageDesc = 'Lorem ipsum dolor sit amed';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle . ' | ' . $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section class="vertical_align">

                    <div class="container_fn_project wrapper">
                        <div class="filters">
                            <button class="button is_checked" data-filter="*">all</button>

                            <?php
                            foreach ($projectTags as $tag) {
                                echo '<button class="button" data-filter="';
                                echo $tag;
                                echo '">';
                                echo $tag;
                                echo '</button>';
                            }
                            ?>

                        </div>

                        <p class="container_count"><span>0</span> projects showed</p>

                        <div class="container_projects clear">
                            <?php 

                            //include_once 'projects/projects_list_01.php'; 

                            $servername = "localhost";
                            $username = "root";
                            $password = "root";
                            $dbname = "ag";

                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $query_title = $conn->query("SELECT title FROM projects");
                                $query_url = $conn->query("SELECT url FROM projects");
                                $query_tags = $conn->query("SELECT tags FROM projects");
                                $query_cover = $conn->query("SELECT cover FROM projects");

                                $fetch_title = $query_title->fetch();
                                $title = $fetch_title["title"];

                                $fetch_url = $query_url->fetch();
                                $url = $fetch_url["url"];

                                $fetch_tags = $query_tags->fetch();
                                $tags = $fetch_tags["tags"];

                                $fetch_cover = $query_cover->fetch();
                                $cover = $fetch_cover["cover"];

                                $main_query = "SELECT * FROM projects ORDER BY id DESC LIMIT 0,10";
                                $sql = $conn->prepare($main_query);
                                $sql->execute();
                                $content = $sql->fetchAll();
                              
                                foreach ($content as $project) {

                                    echo '<article class="project"><div class="container_img" style="background-image:url("';
                                    echo $cover;
                                    echo ');"></div><div class="container_txt"><h2>';
                                    echo $title;
                                    echo '</h2><a href="';
                                    echo $url;
                                    echo '">See more</a><div class="project_tag"><span data-tag="';
                                    echo json_decode($tags);
                                    echo '">';
                                    echo json_decode($tags);
                                    echo '</span></div></div></article>';

                                }

                            } catch(PDOException $e) {
                                echo $sql . "<br>" . $e->getMessage();
                            }

                            $conn = null;

                            ?>
                        </div>

                        <div class="projects_status">
                            <div class="loader-ellips infinite-scroll-request">
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                            </div>
                            <p class="infinite-scroll-last">You've reached the end. <a href="#" onclick="goTop('.vertical_align')">Go TOP.</a></p>
                            <p class="infinite-scroll-error">Error loading next page. <a href="#" onclick="retryPageLoad()">RETRY</a></p>
                        </div>
                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>