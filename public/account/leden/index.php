<?php
    $title1 = "Toxic - Leden panel - Leden";
    require("../../includes/pagestart.php");
?>

<h1>Leden panel</h1>

<h2>Leden</h2>

<?php if (!$login): ?>
    <p>Niet ingelogd.</p>
<?php elseif (stripos($login["privileges"],"m") === false): ?>
    <p>Je hebt niet de bevoegdheid om deze pagina te bekijken.</p>
    <p>Klik <a href="<?=$baseUrl?>account/">hier</a> om terug te gaan naar het panel</p>
<?php else: ?>
    <p>
        <?php
            $array_namen = $sqlite->query("SELECT naam, rank FROM leden ORDER BY naam ASC");
            while($naam = $array_namen->fetchArray(SQLITE3_ASSOC))
            {
                if ($naam["rank"])
                {
                    switch ($naam["rank"])
                    {
                        case 7:
                            echo "<img src='{$baseUrl}includes/owner.png' alt='Leider' />";
                            break;
                        case 6:
                            echo "<img src='{$baseUrl}includes/general.png' alt='Generaal' />";
                            break;
                        case 5:
                            echo "<img src='{$baseUrl}includes/captain.png' alt='Captain' />";
                            break;
                        case 4:
                            echo "<img src='{$baseUrl}includes/lieutenant.png' alt='Luitenant' />";
                            break;
                        case 3:
                            echo "<img src='{$baseUrl}includes/sergeant.png' alt='Sergeant' />";
                            break;
                        case 2:
                            echo "<img src='{$baseUrl}includes/corporal.png' alt='Corporaal' />";
                            break;
                        case 1:
                            echo "<img src='{$baseUrl}includes/recruit.png' alt='Rekruut' />";
                            break;
                    }
                }
                else {
                    echo "<img src='{$baseUrl}includes/friend.png' alt='Vriend' />";
                }

                echo "<a href='{$baseUrl}account/profiel.php?naam=" . $naam["naam"] . "'>" . $naam["naam"] . "</a>";

                $statement = $sqlite->prepare("SELECT waar, gemaakt_door, bekeken_door FROM bewerkingen WHERE gemaakt_door=:naam");
                $statement->bindValue("naam", $naam["naam"]);
                $array_geupdate = $statement->execute()->fetchArray(SQLITE3_ASSOC);

                if ($array_geupdate) {
                    if ($array_geupdate["gemaakt_door"] != $login["naam"] && stripos($array_geupdate["bekeken_door"], $login["naam"]) == false) {
                        echo "*";
                    }
                }

                echo "<br />";
            }
        ?>
    </p>

<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
