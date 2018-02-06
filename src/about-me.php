<?php
require '_var.php'; 
$pageTitle = 'About Me';
$pageDesc = 'Web developer based in Treviso, Italy';
?>

<!DOCTYPE html>
<html class="no_js" lang="en">
    <head>

        <title><?= $pageTitle , ' | ' , $siteName ?></title>
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
                                if ($locale !== 'it') {
                                    echo '<span>Ciao! </span>';
                                } else {
                                    echo '<span class="initial_hi">Ciao! </span>';
                                }
                                ?>
                                <span class="move_it">
                                    <img src="<?= $baseUrl ?>/images/icons/waving-hand.png" data-depth="0.50" alt="Hi Folks!" aria-hidden="true">
                                </span>
                                <br class="last_separator">
                                <span>I'm </span><?= $author; ?><span>,&nbsp;
                                <br>a front-end </span>web developer <span><br>
                                based in Treviso, Italy.&nbsp;<br>
                                Take a look at some of my </span>
                                <a class="project_link link hover" href="<?= $baseUrl ?>/projects">projects</a>. <br class="last_separator">
                                <a href='mailto:<?= $obfuscatedEmail; ?>' class="link hover">Get in touch!</a>

                            </h1>

                            <p>

                                Currently working @<a class="link hover" href="<?= $workplaceUrl; ?>" target="_blank" rel="noopener"><?= $workplaceName; ?></a><br>
                                <span>I make bespoke sites for every need. </span><br>
                                <a class="link hover more" href="#">MORE +</a>

                                <span class="more_content">
                                    Front-end developer, with a graphic background.<br>
                                    Ability to create responsive sites, mobile-oriented, with progressive enhancement and accessible from all platforms.
                                    I give a lot of importance to performance and compatibility of technologies in the several cross-browser environments.
                                    I have the ability to use correct heading, alt attributes, meta-tag and Schema markup for a good SEO optimization.
                                </span>

                            </p>

                        </div>

                    </div>

                    <!--<svg height="0" width="0" viewBox="0 0 455.18 764.03">
                        <defs>
                            <clipPath id="pattern" clipPathUnits="objectBoundingBox" transform="scale(0.00219693 0.00130884)">
                                <path d="M454.68,761.25c-21.75-57-69.37-93.75-122-93.75a113.44,113.44,0,0,0-29.08,3.79c0-1.42.08-2.63.08-3.79,0-27.31-10.4-53-30.07-74.28-19-20.53-45.59-35.22-75-41.37.68-7,1-14,1-20.85,0-52.5-18.66-102.26-54-143.89-34.07-40.18-82.36-70.05-136-84.13.63-6.9.95-13.79.95-20.48a223.33,223.33,0,0,0-10-66.1c1.86.07,3.46.1,5,.1,83.26,0,151-73.79,151-164.5A177.53,177.53,0,0,0,149.12.5H454.68Z"/>
                            </clipPath>
                        </defs>
                    </svg>-->

                </section>

            </div>
        </main>

        <?php include_once 'fragments/footer.php'; ?>

    </body>
</html>