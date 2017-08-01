<?php
require '_var.php'; 
$pageTitle = 'Admin';
$pageDesc = 'Lorem ipsum dolor sit amed';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle . ' | ' . $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

        <link href="<?= $baseUrl ?>/css/admin<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section class="vertical_align">
                    <div class="container_admin">

                        <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload">

                            <input type="text" name="projectname" placeholder="Project Name" required>
                            <input type="url" name="projecturl" placeholder="Project Url" required>

                            <div class="container_filter">

                                <h3>Filters</h3>

                                <?php
    foreach ($projectTags as $tag) {
        echo '<label><input type="checkbox" name="projecttags[]" value="';
        echo $tag;
        echo '"><i></i><span>';
        echo $tag;
        echo '</span></label>';
    }
                                ?>

                            </div>

                            <div class="container_image_upload">
                                <h3>Cover Image</h3>
                                <input type="hidden" name="MAX_FILE_SIZE" value="200000000" />
                                <label>
                                    <span>Upload image</span>
                                    <input type="file" name="newfile" accept="image/*" required>
                                </label>
                            </div>    

                            <input type="submit" name="submit" value="Upload Project"> 
                            
                            <span class="container_upload_result"></span>

                        </form>

                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>