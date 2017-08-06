<?php
    $title1 = "Toxic - Naam Veranderen";
    require("../includes/pagestart.php");

    if (!$login) {
        $bericht = "
            Je bent niet ingelogd.<br />
	        Ga terug naar het panel en log in voordat je jouw naam kunt veranderen.
        ";
    } else {
        if (!isset($_POST["wachtwoord"], $_POST["naam"])) {
            $bericht = "Je hoeft nu niet op deze pagina te zijn...";
        } else {
            $wachtwoord = ucwords(strtolower(trim($_POST["wachtwoord"])));
            $naam_nieuw = ucwords(strtolower(trim($_POST["naam"])));

            if ($wachtwoord !== $login["wachtwoord"]) {
                $bericht = "Je wachtwoord was onjuist, probeer opnieuw...";
            } else {
                $statement = $sqlite->prepare("SELECT naam FROM leden WHERE naam=:naam_nieuw");
                $statement->bindValue("naam_nieuw", $naam_nieuw);
                $statement = $statement->execute();

                if (!$statement) {
                   $bericht = "Database error bij ophalen bestaande namen, neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>villermen@gmail.com</a>.";
                } else {
                    if ($statement->fetchArray()) {
                        $bericht = "De opgegeven nieuwe naam is al in gebruik. Probeer een andere.";
                    } else {
                        $statement = $sqlite->prepare("UPDATE leden SET naam=:naam_nieuw WHERE naam=:naam_oud");
                        $statement->bindValue("naam_nieuw", $naam_nieuw);
                        $statement->bindValue("naam_oud", $login["naam"]);

                        if (!$statement->execute() || !$sqlite->changes()) {
                            $bericht = "
                                De nieuwe naam kon niet worden opgeslagen.<br>
								Neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a>
							";
                        } else {
                            // Verander profielmap
                            $naam_oud_url = str_ireplace(" ","_", $login["naam"]);
                            $naam_nieuw_url = str_ireplace(" ","_", $naam_nieuw);

                            $bericht = "
                                Je nieuwe accountnaam is opgeslagen in de database.<br />
                                De opgegeven accountnaam was: $naam_nieuw
                            ";

                            if (file_exists(__DIR__."/leden/bestanden/$naam_oud_url")) {
                                if (rename(__DIR__ . "/leden/bestanden/$naam_oud_url", __DIR__ . "/leden/bestanden/$naam_nieuw_url")) {
                                    // Verander links in profiel
                                    $profielinhoudtekst = $login["profielinhoudtekst"];

                                    $profielinhoudtekst = str_ireplace("[link|bestanden/$naam_oud_url/", "[link|bestanden/$naam_nieuw_url/", $profielinhoudtekst);
                                    $profielinhoudtekst = str_ireplace("[afbeelding]bestanden/$naam_oud_url/", "[afbeelding]bestanden/$naam_nieuw_url/", $profielinhoudtekst);

                                    $statement = $sqlite->prepare("UPDATE leden SET profielinhoudtekst=:profielinhoudtekst WHERE naam=:naam_nieuw");
                                    $statement->bindValue("profielinhoudtekst", $profielinhoudtekst);
                                    $statement->bindValue("naam_nieuw", $naam_nieuw);
                                    $statement = $statement->execute();

                                    // Verander naam in bewerkingen
                                    $statement = $sqlite->prepare("UPDATE bewerkingen SET gemaakt_door=:naam_nieuw WHERE gemaakt_door=:naam_oud");
                                    $statement->bindValue("naam_nieuw", $naam_nieuw);
                                    $statement->bindValue("naam_oud", $login["naam"]);
                                    $statement->execute();

                                    $bericht .= "
									</p>
									<p>
									    Je profielmap op de site is veranderd, en bestaande links in je profiel die er via een url naartoe wijzen ook.<br />
                                        Kijk alsjeblieft even na of alle plaatjes en links nog correct werken.
                                    ";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>

<h1>Naam veranderen</h1>

<?php if ($bericht): ?>
    <p><?=$bericht;?></p>
<?php endif; ?>

<p>Klik <a href="<?=$basePath;?>account">hier</a> om weer terug te gaan naar het panel</p>

<?php require("../includes/pageend.php"); ?>
