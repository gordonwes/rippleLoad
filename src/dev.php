<?php
require '_var.php'; 
$pageTitle = 'Dev';
$pageDesc = 'Private server for small stuff';
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
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">
                <div class="wrapper">
                    <section>
                        <ul>
                            <?php

                            $real_dev = 0;

                            foreach ($dev_projects as $dev) {

                                if (substr($dev, 0, 1 ) !== ".") {
                                    echo '<li><form role="form" method="POST" enctype="multipart/form-data" action="' . $baseUrl . '/delete/dev">
                                        <input type="text" value="' . $dev . '" name="name_dev" required>
                                        <input type="submit" name="submit" value="">
                                    </form>';
                                    echo '<a href="' . $baseUrl . '/development/' . $dev . '" target="_blank">';
                                    echo $dev;
                                    echo '</a></li>';
                                    $real_dev++; 
                                }

                            }

                            if ($real_dev == 0) {
                                echo '<p class="empty_list">No file yet!</p>';
                            }

                            ?>
                        </ul>

                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/dev">
                            <div class="container_file_upload">
                                <h3>Upload File</h3>
                                <label>
                                    <span>Upload file</span>
                                    <input type="file" name="newfile" required>
                                </label>
                            </div>
                            <div class="container_progress">
                                <progress id="progressBar" value="0" max="100"></progress>
                                <p id="progressCount">0%</p>
                            </div>
                            <input type="submit" value="UPLOAD">
                        </form>

                        <p class="file_big">File too big! 100MB's the limit ;)</p>

                        <?php if (isset($file_too_big)) { ?>
                        <p class="file_big">File too big! 100MB's the limit ;)</p>
                        <?php }  ?>

                    </section>
                </div>
            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>