<header>

    <nav class="wrapper">
        <ul>
            <li><a href="<?= $baseUrl ?>/">CONTACT</a></li>
            <li><a href="<?= $baseUrl ?>/projects">PROJECTS</a></li>
        </ul>

        <?php if (isset($_SESSION["admin"])) { ?>
        <div class="container_admin_link">
            <a href="<?= $baseUrl ?>/dev" class="no-barba">DEV</a>
            <a href="<?= $baseUrl ?>/admin" class="no-barba">+ Add Project</a>
        </div>
        <?php } ?>

    </nav>

</header>

<canvas id="color_change"></canvas>