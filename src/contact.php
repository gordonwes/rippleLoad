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
                                <a class="link" href="http://atklab.com/" target="_blank" rel="noopener">Atk+Lab</a><span>. Check out some of my </span>
                                <a class="project_link link" href="<?= $baseUrl ?>/projects">projects</a>.<br>
                                <a href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om' class="link">Get in touch</a>

                            </h1>

                            <p>

                                I live in Treviso, Italy.<br>
                                Front-end developer, with a graphic background.<br>
                                Ability to create responsive sites, mobile-oriented, with progressive enhancement and accessible from all platforms.<br>
                                I give a lot of importance to performance and compatibility of technologies in the several cross-browser environments.<br>
                                I have the capacity to use correct heading, alt attributes, meta-tag and Schema markup for a good SEO optimization.

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