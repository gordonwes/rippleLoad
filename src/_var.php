<!-- General Var -->
<?php

$baseUrl = 'http://localhost:8888/rippleLoad'; //'http://workspacestage.altervista.org';
$siteName = 'Alberto Gorgonio';
$colorsBkg = array(
    "#4A89DC", 
    "#DA4453",
    "#F6BB42", 
    "#8CC152",  
    "#434A54"
);

$mainColor = $colorsBkg[array_rand($colorsBkg, 1)];

$locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$author = 'Alberto Gorgonio';
$telephoneDetect = 'no';
$isDev = 'true';