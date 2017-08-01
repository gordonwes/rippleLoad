<footer></footer>

<div id="informativa_cookie">
    <div class="wrapper">
        <div id="contenitore_testo_cookie">
            <p>Questo sito utilizza i cookies, continuando la navigazione acconsenti all'utilizzo degli stessi.</p>
        </div>
        <div id="contenitore_bottone_cookie">
            <a id="ok_cookie" href="#">OK</a>
            <a href="https://it.wikipedia.org/wiki/Cookie" target="_blank" rel="noopener">Più informazioni</a>
        </div>
    </div>
</div>

<script>
    var nameCookie = '<?= str_replace(' ', '_', strtolower($siteName)) ?>_cookie';
    var colors = <?= json_encode($colorsBkg) ?>;
    var firstColor = '<?= $mainColor ?>';
    var baseUrl = '<?= $baseUrl ?>';
    var projectPage = <?php $fi = new FilesystemIterator(__DIR__ . '/../projects/', FilesystemIterator::SKIP_DOTS);
    printf("%d", iterator_count($fi) - 1); ?>;
</script>

<script src="<?= $baseUrl ?>/js/build/production<?php if ($isDev !== 'true') echo '.min' ?>.js"></script>

<!--<script type="application/ld+json">
{ 
"@context" : "http://schema.org",
"@type" : "Organization",
"name": "Bontà Viva",
"url" : "<?= $baseUrl ?>",
"logo" : "<?= $baseUrl ?>/images/logo.png",
"email": "info(at)bonta-viva.it",
"telephone": "+39800910290",
"address": {
"@type": "PostalAddress",
"addressLocality": "Borso del Grappa, Treviso, Italy",
"postalCode": "31030",
"streetAddress": "Via Molinetto, 76"
}
}
</script>-->
