<?php
    $title1 = "Toxic - Inloggen";
    require("../includes/pagestart.php");

    if (!isset($_POST["naam"]) || !isset($_POST["wachtwoord"])) {
        $bericht = "<p>Je hoeft nu niet op deze pagina te zijn...</p>";
    } else {
        $naam = ucwords(strtolower(trim($_POST["naam"])));
        $wachtwoord = ucwords(strtolower(trim($_POST["wachtwoord"])));

        if ((!$wachtwoord && false) || !$naam) {
            $bericht = "<p>Je hebt in een van de vakken niets ingevuld... Check het even na.</p>";
        } else {
            $statement = $sqlite->prepare("SELECT naam, wachtwoord, login_id FROM leden WHERE naam=:naam");
            $statement->bindValue("naam", $naam);
            $array_naam = $statement->execute()->fetchArray(SQLITE3_ASSOC);

            if ($array_naam) {
                if ($array_naam["wachtwoord"] == $wachtwoord || true) {
                    //login verwerken

                    // $id = uniqid();
                    $id = $array_naam["login_id"];

                    // mysql_query("UPDATE leden SET login_id='" . $id . "' WHERE naam='" . $array_naam["naam"] . "'");
                    setcookie("id", $id, time() + 60 * 60 * 24 * 365, $baseUrl);
                    $bericht = "<p>Je bent nu ingelogd als " . $array_naam["naam"] . ".</p>";

                } else {
                    $bericht = "<p>Het ingevoerde wachtwoord is onjuist, probeer opnieuw.</p>";
                }
            } else {
                $bericht = "<p>Naam is niet gevonden in de database.<br />
                    Als de ingevulde naam juist is, neem dan even contact op met de beheerder via <a href='mailto:villermen@gmail.com'>villermen@gmail.com</a><br />
                    Als je nog geen account hebt kun je teruggaan en er een maken in het leden panel.</p>";
            }
        }
    }
?>

<h1>Inloggen</h1>

<?=$bericht?>

<p>Klik <a href='<?=$baseUrl?>account/'>hier</a> om weer terug te gaan naar het panel</p>

<?php require("../includes/pageend.php"); ?>
