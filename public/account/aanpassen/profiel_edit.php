<?php
    $title1 = "Toxic - Profiel Aanpassen";
    require("../../includes/pagestart.php");

    $permission = false;
    $updated = false;
    $voorbeeld = false;
    if ($login && stripos($login["privileges"], "M") !== false) {
        $permission = true;

        // Opgegeven dingen verwerken
        if (isset($_POST["titel"]))
        {
            if ($_POST["actie"] === "Verander Profiel")
            {
                $views = (isset($_POST["views"]) ? "aan" : "uit") . (int)substr($login["views"], 3);

                $statement = $sqlite->prepare("UPDATE leden SET 
                    profielmuziek=:profielmuziek, profieltiteltekst=:profieltiteltekst,
                    profielinhoudtekst=:profielinhoudtekst, views=:views
                    WHERE naam=:naam
                ");
                $statement->bindValue("profielmuziek", $_POST["muziek"]);
                $statement->bindValue("profieltiteltekst", $_POST["titel"]);
                $statement->bindValue("profielinhoudtekst", $_POST["inhoud"]);
                $statement->bindValue("views", $views);
                $statement->bindValue("naam", $login["naam"]);
                $statement->execute();

                $updated = true;

                if (!isset($_POST["stil"])) {
                    // Een entry toevoegen van deze actie, en een eventueel vorige verwijderen
                    $statement = $sqlite->prepare("DELETE FROM bewerkingen WHERE waar='profiel' AND gemaakt_door=:gemaakt_door");
                    $statement->bindValue("gemaakt_door", $login["naam"]);
                    $statement->execute();

                    $statement = $sqlite->prepare("INSERT INTO bewerkingen
                        (waar, gemaakt_door, bekeken_door, wat) VALUES
                        ('profiel', :naam, :naam, 'false')");
                    $statement->bindValue("naam", $login["naam"]);
                    $statement->execute();
                }
            }

            if ($_POST["actie"] === "Voorbeeld") {
                $voorbeeld = true;
            }
        }

        $urlnaam = str_ireplace(" ", "_", $login["naam"]);
        $muziekOpties = glob($baseDirectory . "account/leden/bestanden/$urlnaam/*.{mp3,wav,wma,ogg}", GLOB_BRACE);
        $muziekOpties = array_map("basename", $muziekOpties);

        $views_aan = isset($_POST["views"]) ?: substr($login["views"], 0, 3) === "aan";
    }
?>

<h1>Profiel Aanpassen</h1>

<?php if ($permission): ?>
    <?php if ($updated): ?>
        <p>Je profiel is geüpdate.</p>
    <?php endif; ?>

    <?php if ($voorbeeld): ?>
        <p>Je profiel is nog niet geupdate, scroll naar onder voor het voorbeeld.</p>
    <?php endif; ?>

	<form class="profiel_edit" method="post" action="profiel_edit.php">
		Titel:<br />
		<input type="text" name="titel" value="<?=htmlEncode(isset($_POST["titel"]) ? $_POST["titel"] : $login["profieltiteltekst"], true);?>" maxlength="50" size="50" /><br />
		<br />
		Inhoud:<br />
		<textarea style="width:100%" rows="20" cols="100" name="inhoud"><?=htmlEncode(isset($_POST["inhoud"]) ? $_POST["inhoud"] : $login["profielinhoudtekst"], true);?></textarea>
		<br />
		Achtergrondmuziek*:<br />
		<select name="muziek">
			<option value="0">-- Geen achtergrondmuziek --</option>
            <?php foreach($muziekOpties as $muziekOptie): ?>
                <option
                    value="<?=$muziekOptie;?>"
                    <?php if ($muziekOptie === isset($_POST["muziek"]) ? $_POST["muziek"] : $login["profielmuziek"]): ?>
                        selected="selected"
                    <?php endif; ?>
                >
                    <?=$muziekOptie;?>
                </option>
            <?php endforeach; ?>
        </select><br />
        <br />
        <input id="views" type="checkbox" name="views" value="aan"<?php if ($views_aan): ?> checked="checked"<?php endif; ?> /><label for="views">Laat aantal views zien</label><br />
        <br />
        <input id="stil" type="checkbox" name="stil" value="aan" /><label for="stil">Stille update (laat leden niet zien dat je iets hebt veranderd)</label><br />
        <br />
        <input type="submit" name="actie" value="Verander Profiel" />
        <input type="submit" name="actie" value="Voorbeeld" /><br />
        <br />
        * Achtergrondmuziek word niet ondersteund door alle browsers.<br />
        * Alleen mp3/wav/ogg/wma muziekformaten worden ondersteund.
    </form>

    <h2>BB-code</h2>
    <p>
        Je kan in de inhoud van je profiel BB-code gebruiken, dat is een code om tekst op te maken die je ook vaak op forums ziet.<br />
        Uitleg over BBcode kun je <a href="<?=$basePath;?>account/bbcode.php" target="_blank">hier</a> vinden (opent in een nieuw tabblad/venster).
    </p>

    <?php if ($voorbeeld): ?>
        <h2>Voorbeeld</h2>

        <h1><?=bbDecode($_POST["titel"], $login["naam"]);?></h1>

        <?php if ($_POST["muziek"]): ?>
            <embed src="<?=$basePath;?>account/leden/bestanden/<?=$urlnaam;?>/<?=$_POST["muziek"];?>" autostart="true" style="visibility:hidden; display:inline; width:0px; height:0px"></embed>
        <?php endif; ?>

        <div class='profiel_p'>
            <?=bbDecode($_POST["inhoud"], $login["naam"]);?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>
        Je hebt niet de bevoegdheid om een profiel te hebben, of je account is nog niet goedgekeurd door een leider.
    </p>
    <p>
        Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel.
    </p>
<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
