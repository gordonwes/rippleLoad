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

                                <?php 
                                $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
                                if ($locale !== 'it_IT') {
                                    echo '<span>Ciao! </span>';
                                } else {
                                    echo '<span class="initial_hi">Ciao! </span>';
                                }
                                ?>
                                <span class="move_it">
                                    <i data-depth="0.50">👋🏻</i>
                                </span>
                                <br class="last_separator">
                                <span>I'm </span>Alberto Gorgonio<span>,&nbsp;
                                <br>a front-end </span>web developer <span><br>
                                based in Treviso, Italy.&nbsp;<br>
                                Take a look at some of my </span>
                                <a class="project_link link hover" href="<?= $baseUrl ?>/projects">projects</a>. <br class="last_separator">
                                <a href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om' class="link hover">Get in touch!</a>

                            </h1>

                            <p>

                                Currently working @<a class="link hover" href="http://atklab.com/" target="_blank" rel="noopener">ATK+LAB</a><br>
                                <span>I make bespoke sites for every need. </span><br>
                                <a class="link hover more" href="#">MORE +</a>

                                <span class="more_content">
                                    Lorem ipsum dolor sit amed, <br/>
                                    Ciao lorem dolor rr itaca <br/>
                                    Provetto in photoshop e esperto illustratore
                                </span>

                            </p>

                        </div>

                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>