<?php
require '_var.php'; 
$pageTitle = 'About Me';
$pageDesc = 'Web developer based in Treviso, Italy';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle . ' | ' . $siteName ?></title>
        <meta name="description" content="<?= $pageDesc ?>">

        <?php include_once 'fragments/head.php'; ?>

    </head>

    <body>

        <?php include_once 'fragments/header.php'; ?>

        <main id="barba-wrapper">
            <div class="barba-container" data-namespace="<?= str_replace(" ","-", strtolower($pageTitle)); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_intro">

                            <h1>

                                <span>Hi there!</span> 
                                <span class="move_it">
                                    <i data-depth="0.50">👋</i>
                                </span>
                                <br> 
                                <span>I'm </span>Alberto Gorgonio<span>,
                                <br>a </span>web developer <span>based in Treviso, Italy.
                                Check out some of my </span>
                                <a class="project_link link keyword" href="<?= $baseUrl ?>/projects">projects</a>.<br>  <!-- Have a look through some of my projects -->
                                <a href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om' class="link keyword">Get in touch!</a>

                            </h1>

                            <p>

                                Front-end dev with a graphic background,<br> 
                                working @<a class="link keyword" href="http://atklab.com/" target="_blank" rel="noopener">ATK+LAB</a><br>
                                I make bespoke sites for every need.

                            </p>

                        </div>

                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>