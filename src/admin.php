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
                    <div class="container_admin wrapper clear">

                        <div class="list_projects">

                            <h3>Projects List</h3>

                            <?php

                            $i = 0;

                            foreach ($project_list as $prj) {

                                echo '<div class="single_prj"><form role="form" method="POST" enctype="multipart/form-data" action="' . $baseUrl . '/delete/project">
                                        <input type="num" value="' . $prj[0] . '" name="timestamp_project" required>
                                        <input type="submit" name="submit" value="">
                                        </form><span>( ' . $i . ' )</span> ' . $prj[1] . '</div>';

                                $i++;

                            }

                            if (count($project_list) == 0) {
                                echo '<p class="empyt_list">No projects yet!</p>';
                            }

                            ?>

                        </div>

                        <div class="container_forms">

                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/manager/tags">

                                <input type="text" name="tagname" placeholder="Tag Name *" required>
                                <input type="submit" name="submit" value="Add New Tag">
                                <input type="submit" name="remove" value="Remove Tag">

                            </form>

                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/project">

                                <input type="text" name="projectname" placeholder="Project Name *" required>
                                <textarea name="projectdesc" placeholder="Short Description"></textarea>
                                <input type="url" name="projecturl" placeholder="Project Url *" required>

                                <div class="container_filter">

                                    <h3>Tags</h3>

                                    <?php

    foreach ($tags_list as $tag) {
        echo '<label><input type="checkbox" name="projecttags[]" value="';
        echo $tag;
        echo '"><i></i><span>';
        echo $tag;
        echo '</span></label>';
    }
                                  if (count($tags_list) == 0) {
                                      echo '<p class="empyt_list">No tags yet!</p>';
                                  }

                                    ?>

                                </div>

                                <div class="container_image_upload">
                                    <h3>Cover Image</h3>
                                    <label>
                                        <span>Upload image *</span>
                                        <input type="file" name="newfile" accept="image/*" required>
                                    </label>
                                </div>

                                <input type="submit" name="submit" value="Upload Project"> 

                            </form>

                            <?php if (isset($img_too_big)) { ?>
                            <p class="file_big">Img too big! 2MB's the limit ;)</p>
                            <?php }  ?>

                        </div>

                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>