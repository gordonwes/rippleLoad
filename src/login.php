<?php
require '_var.php'; 
$pageTitle = 'Login';
$pageDesc = 'Login to admin area';
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
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_login <?php if (isset($max_attempts)) echo 'max_attempts'; if (isset($error)) echo 'incorrect_login' ?>">

                            <form role="form" method="post" action="<?= $baseUrl ?>/login">

                                <input type="text" name="username" placeholder="Username" required <?php if (isset($max_attempts)) echo 'disabled' ?>>

                                <input type="password" name="password" placeholder="Password" required <?php if (isset($max_attempts)) echo 'disabled' ?>>

                                <input type="text" name="other" style="position:absolute;left:-9999px;top:-9999px;">

                                <input type="submit" name="submit" value="Login" <?php if (isset($max_attempts)) echo 'disabled' ?>>

                            </form>

                            <?php if (isset($max_attempts)) { ?>
                            <p class="message_attempts">Too many attempts, try again in 10 minutes.</p>
                            <?php } 
                             if (isset($error)) { ?>
                            <p class="message_error">Error, incorrect user or password.</p>
                            <?php } 
                             if (isset($credential_set)) { ?>
                            <p class="message_credential_set">First login detected. Data store in DB. <br/> Log in again.</p>
                            <?php } ?>


                        </div>
                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>