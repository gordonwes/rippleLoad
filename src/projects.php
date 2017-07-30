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

        <?php if (isset($_SESSION["admin"])) { ?>
        <link href="<?= $baseUrl ?>/css/admin<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">
        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>
        <?php } ?>

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section class="vertical_align">

                    <div class="container_fn_project wrapper">
                        <div class="filters">
                            <button class="button is_checked" data-filter="*">all</button>
                            <button class="button" data-filter="website">website</button>
                            <button class="button" data-filter="graphic">graphic</button>
                            <button class="button" data-filter="native">native</button>
                        </div>

                        <p class="container_count"><span>0</span> projects showed</p>

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

                <?php 
                if (isset($_SESSION["admin"])) {
                    include_once 'fragments/admin.php';
                } 
                ?>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>