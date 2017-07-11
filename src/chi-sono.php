<?php
require '_var.php'; 
$pageTitle = 'Chi Sono';
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
            <div class="wrapper barba-container" data-namespace="<?= str_replace(' ', '', strtolower($pageTitle)); ?>">

                <div class="vertical_align">
                    <div class="layer" data-depth="0.05">
                        <h1>Alberto Gorgonio</h1>
                        <h2>web developer</h2>
                        <a href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om'>gorgonioalberto[at]gmail.com</a>
                    </div>
                </div>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>