<?php
    $title1 = "Toxic - Nieuw Account";
    require("../includes/pagestart.php");

    $code = "IK5S";

    $bericht = "";

    if (!isset($_POST["naam"], $_POST["wachtwoord"], $_POST["code"])) {
        $bericht = "Je hoeft nu niet op deze pagina te zijn...";
    } else {
        $naam = ucwords(strtolower(trim($_POST["naam"])));
        $wachtwoord = ucwords(strtolower(trim($_POST["wachtwoord"])));
        $toegangscode = strtoupper($_POST["code"]);

        if (!$naam || !$wachtwoord || !$toegangscode) {
            $bericht = "Je hebt in een van de vakken niets ingevuld... Check het even na.";
        } elseif ($toegangscode !== $code) {
            $bericht = "De opgegeven toegangscode was fout... Probeer opnieuw.";
        } else {
            $statement = $sqlite->prepare("SELECT naam FROM leden WHERE naam=:naam");
            $statement->bindValue("naam", $naam);

            $statement = $array_dubbel = $statement->execute();

            if (!$statement) {
                $bericht = "
                    Er kan geen verbinding met de server worden gemaakt.<br />
                    Probeer over een paar minuten opnieuw.
                ";
            } else {
                $array_dubbel = $statement->fetchArray(SQLITE3_ASSOC);
                if ($array_dubbel) {
                    $bericht = sprintf("De opgegeven naam (%s) is al in gebruik, probeer een andere.", $array_dubbel["naam"]);
                } else {
                    $statement = $sqlite->prepare("INSERT INTO leden (naam, wachtwoord) VALUES (:naam, :wachtwoord)");
                    $statement->bindValue("naam", $naam);
                    $statement->bindValue("wachtwoord", $wachtwoord);

                    if (!$statement->execute()) {
                        $bericht = "
                            De naam kon niet worden opgeslagen.<br />
                            Neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a>
                        ";
                    } else {
                        mkdir(__DIR__."/leden/bestanden/" . str_ireplace(" ", "_", $naam));

                        $bericht = "
                            Je accountnaam en wachtwoord zijn opgeslagen in de database.<br />
                            De opgegeven accountnaam was: " . $naam . "
                        </p>
                        <p>
                            Je account moet nog goedgekeurd worden door een leider voordat je op de ledendelen van de site mag komen<br />
                            Dit kun je even vragen aan een leider in de CC.";
                    }
                }
            }
        }
    }
?>

<h1>Nieuw account</h1>

<?php if ($bericht): ?>
    <p><?=$bericht;?></p>
<?php endif; ?>

<p>Klik <a href="<?=$basePath;?>account">hier</a> om weer terug te gaan naar het panel</p>

<?php require("../includes/pageend.php"); ?>
