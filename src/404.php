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
            <div class="wrapper barba-container" data-namespace="404">

                <section class="vertical_align">
                    <div class="container_404">
                        <h1><span>404</span><br>Page not found</h1>
                        <a class="return_link" href='<?= $baseUrl ?>/'>return home</a>
                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>