<header>

    <nav class="wrapper">
        <ul>
            <li><a href="<?= $baseUrl ?>/">CONTACT</a></li>
            <li><a href="<?= $baseUrl ?>/projects">PROJECTS</a></li>
        </ul>
    </nav>

    <?php if (isset($_SESSION["admin"])) { ?>
    <span>CIAO ALBERTO</span>
    <?php } ?>

</header>

<canvas id="color_change"></canvas>