<?php
require '_var.php'; 
$pageTitle = 'Contact';
$pageDesc = 'Lorem ipsum dolor sit amed';
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
            <div class="barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section>
                    <div class="wrapper">
                        <div class="container_intro">

                            <h1>

                                <span>Hi there! I'm </span>Alberto Gorgonio<span>, a </span>web developer <span>working at </span>
                                <a class="link keyword" href="http://atklab.com/" target="_blank" rel="noopener">Atk+Lab</a><span>. Check out some of my </span>
                                <a class="project_link link keyword" href="<?= $baseUrl ?>/projects">projects</a>.<br>  <!-- Have a look through some of my projects -->
                                <a href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om' class="link keyword">Get in touch!</a>

                            </h1>

                            <p>

                                Front-end dev with a graphic background<br> based in Treviso, Italy.<br>
                                I make bespoke sites for every need.

                            </p>

                        </div>

                        <p class="legal">© 2017 Alberto Gorgonio</p>
                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>