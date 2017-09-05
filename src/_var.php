<!-- General Var -->
<?php

$baseUrl = 'http://localhost:8888/rippleLoad';
$siteName = 'Alberto Gorgonio';
/*$colorsBkg = array(
    "#4A89DC", 
    "#DA4453",
    "#F6BB42", 
    "#8CC152",  
    "#434A54"
);*/

$colorsBkg = array(
    array("#f6d365", "#fda085"),
    array("#fbc2eb", "#a6c1ee"),
    array("#84fab0", "#8fd3f4"),
    array("#a1c4fd", "#c2e9fb")
);

$mainColor = $colorsBkg[array_rand($colorsBkg, 1)];

$author = 'Alberto Gorgonio';
$telephoneDetect = 'no';
$isDev = 'true';