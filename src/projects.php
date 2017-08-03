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

                            <button class="button is_checked" data-filter="*">all</button><span></span>

                            <?php
                            foreach ($projectTags as $tag) {
                                echo '<button data-filter="';
                                echo $tag;
                                echo '">';
                                echo $tag;
                                echo '</button><span></span>';
                            }
                            ?>

                        </div>

                        <div class="container_projects clear">

                            <?php
                            foreach ($project_block as $project) {
                                echo $project;
                            }
                            ?>

                        </div>

                        <div class="end_list">
                            <p>You've reached the end. <a href="#" onclick="goTop('.vertical_align')">Go TOP.</a></p>
                        </div>
                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>