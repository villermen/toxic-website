<?php
    $title1 = "Toxic - Profiel";
    require("../../includes/pagestart.php");

    $permission = false;
    $gebruiker = null;
    if ($login && stripos($login["privileges"], "M") !== false) {
        $permission = true;

        $statement = $sqlite->prepare("SELECT * FROM leden WHERE naam=:naam");
        $statement->bindValue("naam", $_GET["naam"]);
        $statement = $statement->execute();

        if ($statement) {
            $gebruiker = $statement->fetchArray(SQLITE3_ASSOC);

            if ($gebruiker) {
                $urlnaam = str_ireplace(" ", "_", $gebruiker["naam"]);
                $views_aan = stripos($gebruiker["views"], "aan") !== false;
                $views = (int)substr($gebruiker["views"], 3);
            }
        }
    }
?>

<?php if ($permission && $gebruiker): ?>
    <?php if ($gebruiker["profieltiteltekst"]): ?>
        <h1><?=bbDecode($gebruiker["profieltiteltekst"], $gebruiker["naam"]);?></h1>

        <?php if ($gebruiker["profielmuziek"]): ?>
            <embed src="<?=$basePath;?>account/leden/bestanden/<?=$urlnaam;?>/<?=$gebruiker["profielmuziek"];?>" autostart="true" style="visibility:hidden; display:inline; width:0px; height:0px"></embed>
        <?php endif; ?>

        <div class='profiel_p'>
            <?=bbDecode($gebruiker["profielinhoudtekst"], $gebruiker["naam"]);?>
        </div>

        <?php if ($views_aan): ?>
            <div class='profiel_p'>Aantal views: <?=$views?></div>
        <?php endif;?>
    <?php else: ?>
        <h1>Profiel van <?=$gebruiker["naam"];?></h1>
        <p>
            <?=$gebruiker["naam"];?> heeft nog geen eigen profiel.
        </p>
    <?php endif; ?>

    <?php
        // Update bekeken in database
        $statement = $sqlite->prepare("SELECT * FROM bewerkingen WHERE waar='profiel' AND gemaakt_door=:profielnaam");
        $statement->bindValue("profielnaam", $gebruiker["naam"]);
        $statement = $statement->execute();

        if ($statement) {
            $bewerking = $statement->fetchArray(SQLITE3_ASSOC);
            if (stripos($bewerking["bekeken_door"], $login["naam"]) === false) {
                // In hindsight this plays terribly with the name change functionality =)
                $statement = $sqlite->prepare("UPDATE bewerkingen SET bekeken_door=:bekeken_door WHERE nummer=:nummer");
                $statement->bindValue("bekeken_door", $bewerking["bekeken_door"].",".$login["naam"]);
                $statement->bindValue("nummer", $bewerking["nummer"]);
                $statement->execute();
            }
        }

        // Als je niet de maker bent 1 optellen bij het aantal views
        if ($login["naam"] !== $gebruiker["naam"]) {
            $statement = $sqlite->prepare("UPDATE leden SET views=:views WHERE naam=:naam");
            $statement->bindValue("views", ($views_aan ? "aan" : "uit") . ($views + 1));
            $statement->bindValue("naam", $gebruiker["naam"]);
            $statement->execute();
        }
    ?>
<?php elseif (!$permission): ?>
    <p>
        Je hebt niet de bevoegdheid om deze pagina te bekijken.
    </p>
    <p>
        Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel.
    </p>
<?php else: ?>
    <p>
        Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel.
    </p>
    <p>
        De opgevraagde gebruiker bestaat niet.
    </p>
<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
