<?php
require '_var.php'; 
$pageTitle = 'Projects';
$pageDesc = 'A collection of all my projects, carefully crafted';
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
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_fn_project">
                            <div class="filters">

                                <button class="button is_checked link" data-filter="*">all</button><span></span>

                                <?php

                                foreach ($project_tags as $tag) {
                                    echo '<button class="link" data-filter="';
                                    echo $tag;
                                    echo '">';
                                    echo $tag;
                                    echo '</button><span></span>';
                                }
                                ?>

                            </div>

                            <div class="container_projects clear">

                                <?php

                                if (count($project_block) == 0) {
                                    echo '<p class="empty_list">No projects yet!</p>';
                                }

                                foreach ($project_block as $project) {
                                    echo $project;
                                }
                                ?>

                            </div>

                            <?php

                            if (count($project_block) !== 0) {
                            ?>
                            <div class="end_list">
                                <p>You've reached the end. <a href="#" onclick="goTop('.barba-container')">Go TOP.</a></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>