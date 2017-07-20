<?php
require '_var.php'; 
$pageTitle = 'Projects';
$pageDesc = 'Lorem ipsum dolor sit amed';
?>

<!DOCTYPE html>
<html class="no_js">
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
                            <button class="button is_checked" data-filter="*">all <span></span></button>
                            <button class="button" data-filter="website">website <span></span></button>
                            <button class="button" data-filter="graphic">graphic <span></span></button>
                            <button class="button" data-filter="native">native <span></span></button>
                        </div>

                        <div class="container_projects clear">
                            <?php include_once 'projects/projects_list_01.php'; ?>
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