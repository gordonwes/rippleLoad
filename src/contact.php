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
            <div class="wrapper barba-container" data-namespace="<?= strtolower($pageTitle); ?>">

                <section class="vertical_align">
                    <!--<div class="container_intro">
<h1>
<span>Hi there!<br> I'm </span>Alberto Gorgonio<span>,</span>
</h1>
<h2>
<span>a</span> web
<span class="container_slide">
<span class="container_transition_slide">
<span class="slide">developer</span>
<span class="slide">designer</span>
<span class="slide">developer</span>
</span>
</span><br/>
<span>check out some of my </span>
<a class="project_link" href="<?= $baseUrl ?>/projects">projects</a>
<span style="margin-left: -5px;">!</span>
</h2>
<a class="email" href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om'>gorgonioalberto[at]gmail.com</a>
</div>-->

                    <div class="container_intro">

                        <h1>

                            <span>Hi there! I'm </span>Alberto Gorgonio<span>, a </span>web developer <span>working at </span>
                            <a href="#">Atk+Lab</a>. <span>Check out some of my </span>
                            <a class="project_link" href="<?= $baseUrl ?>/projects">projects</a>.
                            Get in touch  <a class="email" href='mail&#116;o&#58;gorgo&#37;6Eioal&#98;&#37;65rt&#111;&#64;&#37;67&#37;6D&#97;&#105;&#37;6C&#46;&#37;&#54;3om'>gorgonioalberto[at]gmail.com</a>

                        </h1>

                    </div>

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>