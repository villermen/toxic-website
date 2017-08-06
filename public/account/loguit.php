<?php
    $title1 = "Toxic - Uitloggen";
    require("../includes/pagestart.php");

    if ($login) {
        $statement = $sqlite->prepare("UPDATE leden SET login_id=NULL WHERE login_id=:login_id");
        $statement->bindValue("login_id", $_COOKIE["id"]);
        $statement->execute();

        setcookie("id","",time()-1, $basePath);

        $bericht="<p>Je bent nu uitgelogd.</p>";
    } else {
        $bericht = "<p>Je bent niet ingelogd!</p>";
    }
?>

<h1>Uitloggen</h1>

<?=$bericht?>

<p>Klik <a href='<?=$basePath?>account/'>hier</a> om weer terug te gaan naar het panel</p>

<?php require("../includes/pageend.php"); ?>
