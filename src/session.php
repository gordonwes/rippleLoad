<?php

// Start the session
session_start();

if ($_SESSION["user"] && $_SESSION["psw"] && $_SESSION["no-bot"]) {
    $_SESSION["admin"] = true;
} else{
    $_SESSION["admin"] = false;
}

?>