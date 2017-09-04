<header>

    <nav class="wrapper">
        <ul>
            <li><a class="link" href="<?= $baseUrl ?>/">ABOUT ME</a></li>
            <li><a class="link" href="<?= $baseUrl ?>/projects">PROJECTS</a></li>
        </ul>

        <?php if (isset($_SESSION["admin"])) { ?>
        <div class="container_admin_link">
            <a href="<?= $baseUrl ?>/dev" class="no-barba link">DEV</a>
            <a href="<?= $baseUrl ?>/admin" class="no-barba link">ADMIN</a>
        </div>
        <?php } ?>

    </nav>

</header>

<canvas id="color_change"></canvas>