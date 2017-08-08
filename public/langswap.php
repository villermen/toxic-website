<?php

$title1 = "Toxic - Langswap";
require("includes/pagestart.php");

if (!isset($_COOKIE["lang"])) {
    $langswap = 2;
} elseif ($_COOKIE["lang"] == 2) {
    $langswap = 1;
} else {
    $langswap = 2;
}

setcookie("lang", $langswap, time()+60*60*24*365, $basePath);

if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"]) {
    $redirect = $_SERVER["HTTP_REFERER"];
} else {
    $redirect = $basePath;
}

header("Location: " . $redirect);

require("includes/pageend.php");
