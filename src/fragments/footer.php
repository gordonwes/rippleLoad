<div id="informativa_cookie">
    <div class="wrapper">
        <div id="contenitore_testo_cookie">
            <p><strong>This site uses cookies.</strong> By continuing to browse the site you are agreeing to their use.</p>
        </div>
        <div id="contenitore_bottone_cookie"> 
            <a id="ok_cookie" href="#">OK</a>
            <?php if ($locale !== 'it'){
    echo '<a href="https://en.wikipedia.org/wiki/HTTP_cookie" target="_blank" rel="noopener">More info</a>';
} else {
    echo '<a href="https://it.wikipedia.org/wiki/Cookie" target="_blank" rel="noopener">More info</a>';
} ?>
        </div>
    </div>
</div>

<script>
    var nameCookie = '<?= str_replace(' ', '_', strtolower($siteName)) ?>_cookie';
    var isDev = <?= $isDev ?>;
    var colors = <?= json_encode($colorsBkg) ?>;
    var firstColor = '<?= $mainColor ?>';
    var baseUrl = '<?= $baseUrl ?>';
    console.info('%cMade by ' + '%c<?= $author; ?>' + ' %c@<?= date("Y"); ?>', 'font-weight: bold; color: #999;','font-weight: bold; color: <?= $mainColor ?>;', 'color: #999;');
    console.info('<?= $email; ?>');
    paceOptions = {
        restartOnRequestAfter: false
    }
</script>

<script src="<?= $baseUrl ?>/js/build/production<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>