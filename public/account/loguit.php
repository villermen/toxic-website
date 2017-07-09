<?php
    $title1 = "Toxic - Uitloggen";
    require("../includes/pagestart.php");

    if ($login) {
        // mysql_query("update leden set login_id='NULL' where login_id='" . $_COOKIE["id"] . "'");

        setcookie("id","",time()-1, $baseUrl);

        $bericht="<p>Je bent nu uitgelogd.</p>";
    } else {
        $bericht = "<p>Je bent niet ingelogd!</p>";
    }
?>

<h1>Uitloggen</h1>

<?=$bericht?>

<p>Klik <a href='<?=$baseUrl?>account/'>hier</a> om weer terug te gaan naar het panel</p>

<?php require("../includes/pageend.php"); ?>
