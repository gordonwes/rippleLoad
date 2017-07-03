<?php
require '_var.php'; 
$pageTitle = 'Home';
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
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle) ?>">

                <div class="container_text">
                    <h1>HOME</h1>
                </div>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>