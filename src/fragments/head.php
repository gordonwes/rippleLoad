<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

<!-- Prefetch DNS for external assets -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<meta name="author" content="<?= $author ?>">

<!-- Favicon -->
<!-- For IE 11, Chrome, Firefox, Safari, Opera -->
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_32.png" sizes="32x32" type="image/png">
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_16.png" sizes="16x16" type="image/png">
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_48.png" sizes="48x48" type="image/png">
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_64.png" sizes="64x64" type="image/png">
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_128.png" sizes="128x128" type="image/png">
<link rel="icon" href="<?= $baseUrl ?>/images/favicon/favicon_192.png" sizes="192x192" type="image/png">

<!-- IE Browser -->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="cleartype" content="on">
<meta name="msapplication-tap-highlight" content="no">

<!-- IE 10 / Windows 8 -->
<meta name="msapplication-TileImage" content="<?= $baseUrl ?>/images/favicon/favicon_192.png">
<meta name="msapplication-TileColor" content="#fff">
<meta name="msapplication-navbutton-color" content="#000">

<!-- UC Mobile Browser -->
<meta name="wap-font-scale" content="no">

<!-- Android Browser -->
<meta name="theme-color" content="<?= $mainColor ?>">
<meta name="mobile-web-app-capable" content="yes">

<!-- iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="format-detection" content="telephone=<?= $telephoneDetect ?>">

<!-- Safari osx pinned tab -->
<link rel="mask-icon" href="<?= $baseUrl ?>/images/favicon/favicon.svg" color="<?= $mainColor ?>">

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Asap:400,500" rel="stylesheet">

<!-- Style -->
<link href="<?= $baseUrl ?>/css/style<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

<style type="text/css">
    header nav a{
        border-bottom-color: <?php echo $colorsBkg[0] ?>;
    }
</style>

<script type="text/javascript">
    document.documentElement.classList.remove('no_js');
</script>

<!--[if lte IE 7]>
alert('Questo browser è antiquato e alcune funzioni del sito potrebbero non funzionare! Aggiornalo o passa ad un altro per migliorare l'esperienza.);
<![endif]-->
<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<![endif]-->