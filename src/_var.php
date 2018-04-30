<!-- General Var -->
<?php

$baseUrl = 'http://localhost:8888/rippleLoad';
//$baseUrl = 'http://workspacestage.altervista.org';

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
$email = 'gorgonioalberto@gmail.com';
$obfuscatedEmail = '';
for ($i=0; $i<strlen($email); $i++){
    $obfuscatedEmail .= "&#" . ord($email[$i]) . ";";
}
$workplaceName = 'ATK+LAB';
$workplaceUrl = 'http://atklab.com';
$socialLink = array(
    "Linkedin" => "https://it.linkedin.com/in/alberto-gorgonio-04988757"
);
$telephoneDetect = 'no';
$isDev = 'true';