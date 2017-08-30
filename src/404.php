<?php
require '_var.php'; 
$pageTitle = '404 | Page not found';
$pageDesc = '';
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
            <div class="barba-container" data-namespace="404">

                <section class="vertical_align">
                    <div class="wrapper">
                        <div class="container_404">
                            <h1><span class="alert">404</span><br>Page not found</h1>
                            <a class="home_link" href='<?= $baseUrl ?>/'>return home</a>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>