<?php
require '_var.php'; 
$pageTitle = 'Privacy Policy';
$pageDesc = 'Privacy policy for Alberto Gorgonio';
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
            <div class="barba-container" data-namespace="<?= str_replace(" ","-", strtolower($pageTitle)); ?>">

                <section>

                    <div class="wrapper">

                        <div class="container_privacy">

                            <p>Privacy</p>

                        </div>

                    </div>

                </section>
                
            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>