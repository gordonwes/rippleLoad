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

                                <span <?php if ($locale == 'it') { ?>class="initial_hi"<?php } ?>>Ciao! </span>
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
                                    <span>
                                    Follow me on 
                                    <?php $socialCount = 0;
                                    foreach ($socialLink as $socialName => $socialUrl) { $socialCount++; ?>
                                        <a class="link hover" href="<?= $socialUrl; ?>" rel="noopener" target="_blank"><?= $socialName; ?></a><?php if (count($socialLink) !== $socialCount) {
                                            echo ', ';
                                        } else {
                                            echo '.';
                                        }
                                    } ?>
                                    </span>
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