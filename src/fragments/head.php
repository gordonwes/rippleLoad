<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

<!-- Prefetch DNS for external assets -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<meta name="author" content="<?= $author ?>">

<?php if ($isDev == 'true') { ?>
<meta name="robots" content="noindex,nofollow">
<?php } ?>

<!-- Favicon -->
<!-- For IE 11, Chrome, Firefox, Safari, Opera -->
<link rel="icon" type="image/png" href="<?= $baseUrl ?>/images/favicon/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="<?= $baseUrl ?>/images/favicon/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="<?= $baseUrl ?>/images/favicon/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="<?= $baseUrl ?>/images/favicon/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="<?= $baseUrl ?>/images/favicon/favicon-128.png" sizes="128x128" />

<!-- IE Browser -->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta http-equiv="cleartype" content="on">
<meta name="msapplication-tap-highlight" content="no">

<!-- IE 10 / Windows 8 -->
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="<?= $baseUrl ?>/images/favicon/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="<?= $baseUrl ?>/images/favicon/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="<?= $baseUrl ?>/images/favicon/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="<?= $baseUrl ?>/images/favicon/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="<?= $baseUrl ?>/images/favicon/mstile-310x310.png" />
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
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= $baseUrl ?>/images/favicon/apple-touch-icon-152x152.png" />

<!-- Safari osx pinned tab -->
<link rel="mask-icon" href="<?= $baseUrl ?>/images/favicon/favicon.svg" color="<?= $mainColor ?>">

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Asap:400,500" rel="stylesheet">

<!-- Style -->
<link href="<?= $baseUrl ?>/css/style<?php if ($isDev !== 'true') echo '.min' ?>.css" rel="stylesheet">

<style type="text/css">
    :root{
        --bkg: <?= $mainColor ?>;
    }
    header nav a:before{
        background: var(--bkg) !important;
    }
    canvas, .container_fn_project .filters{
        background-color: <?= $mainColor ?>;
    }
</style>

<script type="text/javascript">
    document.documentElement.classList.remove('no_js');
</script>

<!--[if lte IE 7]>
alert('This browser is outdated and some of the site's features may not work! Upgrade it or switch to another to improve the experience.);
<![endif]-->
<!--[if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<script src="<?= $baseUrl ?>/js/classList.min.js"></script>
<![endif]-->