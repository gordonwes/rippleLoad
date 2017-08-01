<?php
require '_var.php'; 
$pageTitle = 'Login';
$pageDesc = 'Lorem ipsum dolor sit amed';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle . ' | ' . $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

        <link href="<?= $baseUrl ?>/css/login<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section class="vertical_align">
                    <div class="container_login">

                        <form role="form" method="post" action="<?= $baseUrl ?>/login">

                            <input type="text" name="username" placeholder="Username">

                            <input type="password" name="password" placeholder="Password">

                            <input type="text" name="other" style="position:absolute;left:-9999px;top:-9999px;">

                            <input type="submit" name="submit" value="Login">

                        </form>

                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/login<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>