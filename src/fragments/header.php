<header>

    <nav class="wrapper">
        <ul>
            <li><a href="<?= $baseUrl ?>/">CONTACT</a></li>
            <li><a href="<?= $baseUrl ?>/projects">PROJECTS</a></li>
        </ul>
        <?php if (isset($_SESSION["admin"])) { ?>
        <a href="<?= $baseUrl ?>/admin" class="no-barba">+ Add Project</a>
        <?php } ?>
    </nav>

</header>

<canvas id="color_change"></canvas>