<?php
require '_var.php'; 
$pageTitle = 'Dev';
$pageDesc = 'Lorem ipsum dolor sit amed';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle . ' | ' . $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

        <link href="<?= $baseUrl ?>/css/dev<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <ul>
                        <?php

                        foreach ($dev_projects as $dev) {

                            if (substr($dev, 0, 1 ) !== ".") {
                                echo '<li><a href="' . $baseUrl . '/development/' . $dev . '" target="_blank">';
                                echo $dev;
                                echo '</a></li>';
                            }

                        }

                        ?>
                    </ul>

                    <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/file">
                        <div class="container_file_upload">
                            <h3>Upload File</h3>
                            <label>
                                <span>Upload file</span>
                                <input type="file" name="newfile" required>
                            </label>
                        </div>
                        <input type="submit" value="UPLOAD">
                    </form>

                    <progress id="progressBar" value="0" max="100"></progress>
                    <p id="progressCount"></p>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>