<?php

if (!isset($_COOKIE["lang"])) {
    $langswap = 2;
} elseif ($_COOKIE["lang"] == 2) {
    $langswap = 1;
} else {
    $langswap = 2;
}

setcookie("lang", $langswap,time()+60*60*24*365);
header("Location: ".$_SERVER["HTTP_REFERER"]);
