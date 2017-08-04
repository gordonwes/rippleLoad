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
                            foreach ($project_list as $prj) {

                                echo '<div class="single_prj"><form role="form" method="POST" enctype="multipart/form-data" action="' . $baseUrl . '/delete/project">
                                        <input type="num" value="' . $prj[0] . '" name="id_project" required>
                                        <input type="submit" name="submit" value="">
                                        </form><span>( ' . $prj[0] . ' )</span> ' . $prj[1] . '</div>';

                            }
                            ?>

                        </div>

                        <div class="container_forms">

                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/tags">

                                <input type="text" name="tagname" placeholder="Tag Name" required>
                                <input type="submit" name="submit_tag" value="Add New Tag">
                                <input type="submit" name="remove_tag" value="Remove Tag">

                            </form>

                            <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/project">

                                <input type="text" name="projectname" placeholder="Project Name" required>
                                <textarea name="projectdesc" placeholder="Short Description"></textarea>
                                <input type="url" name="projecturl" placeholder="Project Url" required>

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

                            </form>

                        </div>

                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>