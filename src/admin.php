<?php
require '_var.php'; 
$pageTitle = 'Admin';
$pageDesc = 'Manage projects and tags like a boss';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle , ' | ' , $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

        <link href="<?= $baseUrl ?>/css/login<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">
        <link href="<?= $baseUrl ?>/css/admin<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_admin clear">

                            <div class="list_projects">

                                <h3>Projects List</h3>

                                <div class="container_drag">

                                    <?php $i = 0;
                                    foreach ($project_list as $prj) {

                                        echo '<div class="single_prj" data-id="' , $i , '"><form role="form" method="POST" enctype="multipart/form-data" action="' , $baseUrl , '/delete/project"><input type="num" value="' , $prj[0] , '" name="timestamp_project" required><input type="submit" name="submit" value=""></form><div class="edit_project"></div>' , $prj[1] , '</div>';

                                        $i++;

                                    }

                                    if (count($project_list) == 0) {
                                        echo '<p class="empty_list">No projects yet!</p>';
                                    } ?>

                                </div>
                                
                                <a href="#" class="trigger_change_order">UPDATE ORDER</a>

                            </div>

                            <div class="container_forms">

                                <form role="form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/manager/tags">

                                    <input type="text" list="tags_suggestion" name="tagname" placeholder="Tag Name *" required>
                                    <input type="submit" name="submit" value="Add New Tag">
                                    <input type="submit" name="remove" value="Remove Tag">

                                    <datalist id="tags_suggestion">
                                        <?php foreach ($tags_list as $tag) {
                                            echo '<option value="' , $tag , '">';
                                        } ?>
                                    </datalist>

                                </form>

                                <form role="form" class="main_form" method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/upload/project">

                                    <input type="text" name="projectname" placeholder="Project Name *" required>
                                    <textarea name="projectdesc" placeholder="Short Description"></textarea>
                                    <input type="url" name="projecturl" placeholder="Project Url *" required>
                                    
                                    <input type="hidden" name="projectorder" value="<?= count($project_list); ?>">

                                    <div class="container_filter">

                                        <h3>Tags</h3>

                                        <?php foreach ($tags_list as $tag) {
                                            echo '<label><input type="checkbox" name="projecttags[]" value="' , $tag , '"><i></i><span>' , $tag , '</span></label>';
                                        }
                                      if (count($tags_list) == 0) {
                                          echo '<p class="empty_list">No tags yet!</p>';
                                      } ?>

                                    </div>

                                    <div class="container_size">
                                        <h3>Block Size</h3>
                                        <div class="container_select">
                                            <select name="projectsize">
                                                <option value="normal" selected>Select Size Block (Normal) *</option>
                                                <option value="h2">Double Height</option>
                                                <option value="w2">Double Width</option>
                                                <option value="w2 h2">Double Width/Height</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="container_image_upload">
                                        <h3>Cover Image</h3>
                                        <label>
                                            <span>Upload image *</span>
                                            <input type="file" name="newfile" accept="image/*" required>
                                        </label>
                                        <img class="placeholder_image" src="#">
                                    </div>

                                    <input type="submit" name="submit" value="Upload Project"> 

                                </form>

                                <?php if (isset($img_too_big)) { ?>
                                <p class="file_big">Img too big! <?= $img_too_big ?>MB's the limit ;)</p>
                                <?php }  ?>

                            </div>

                            <?php if (count($visited_user_list) !== 0) { $index_visitor = 0; ?>
                            <div class="list_visited_user">

                                <p class="total_count">Unique visitors: <?= count($visited_user_list); ?></p>

                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Used device</th>
                                            <th>Browser</th>
                                            <th>Country</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($visited_user_list as $visited_user) { 
                                        $index_visitor++; ?>
                                        <tr>
                                            <td><?= $index_visitor; ?></td>
                                            <td><?= $visited_user['device']; ?></td>
                                            <td><?= $visited_user['browser']; ?></td>
                                            <td><?= $visited_user['country']; ?></td>
                                            <td><?= $visited_user['visitedHour'] , 'h on ' , $visited_user['visitedDay'] , '/' , $visited_user['visitedMonth'] , ', ' , $visited_user['visitedYear']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <?php } ?>

                        </div>

                    </div>
                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

        <script src="<?= $baseUrl ?>/js/build/admin<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

    </body>
</html>