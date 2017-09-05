<div id="informativa_cookie">
    <div class="wrapper">
        <div id="contenitore_testo_cookie">
            <p><strong>This site uses cookies.</strong> By continuing to browse the site you are agreeing to their use.</p>
        </div>
        <div id="contenitore_bottone_cookie"> 
            <a id="ok_cookie" href="#">OK</a>
            <a href="https://en.wikipedia.org/wiki/HTTP_cookie" target="_blank" rel="noopener">More info</a>
        </div>
    </div>
</div>

<script>
    var nameCookie = '<?= str_replace(' ', '_', strtolower($siteName)) ?>_cookie';
    var colors = <?= json_encode($colorsBkg); ?>;
    var firstColor = <?php if (is_array($colorsBkg[0])) {echo json_encode($mainColor);} else {echo '"' . $mainColor . '"';} ?>;
    var isGradient = <?php if (is_array($colorsBkg[0])) {echo 'true';} else {echo 'false';} ?>;
    var baseUrl = '<?= $baseUrl ?>';
</script>

<script src="<?= $baseUrl ?>/js/build/production<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>