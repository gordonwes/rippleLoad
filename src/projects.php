<?php
require '_var.php'; 
$pageTitle = 'Projects';
$pageDesc = 'A collection of all my projects, carefully crafted';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle , ' | ' , $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

    </head>  

    <body class="is_loading">

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_fn_project">
                            <div class="filters">
                                <div class="container_filters">
                                    <button class="button is_checked link" data-filter="*">all</button><span></span>

                                    <?php foreach ($project_tags as $tag) {
                                        echo '<button class="link" data-filter="' , $tag , '">' , $tag , '</button><span></span>';
                                    } ?>

                                </div>

                                <div class="container_more_scroll">
                                    <div class="scroll_sx"></div>
                                    <div class="scroll_dx"></div>
                                </div>

                            </div>
                            
                            <div class="container_projects clear">

                                <?php if (count($project_block) == 0) {
                                    echo '<p class="empty_list">No projects yet!</p>';
                                }

                                foreach ($project_block as $project) {
                                    echo $project;
                                } ?>

                            </div>

                            <?php if (count($project_block) !== 0) { ?>
                            <div class="end_list">
                                <p>You've reached the end. <a href="#" onclick="goTop(0, 600)">Go TOP.</a></p>
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