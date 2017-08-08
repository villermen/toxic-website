<?php
    $title = "Toxic - Eventplanner Aanpassen";
    require("../../includes/pagestart.php");

    $permission = false;
    if ($login && stripos($login["privileges"], "E") !== false) {
        $permission = true;

        $eventPlanner = $sqlite->query("SELECT * FROM bewerkingen WHERE waar='eventplanner'")->fetchArray(SQLITE3_ASSOC);

        if (!$eventPlanner) {
            $eventPlanner = ["wat" => ""];
        }

        $geupdate = false;
        if (isset($_POST["inhoud"])) {
            $eventPlanner["wat"] = $_POST["inhoud"];

            $sqlite->query("DELETE FROM bewerkingen WHERE waar='eventplanner'");
            $statement = $sqlite->prepare("
                INSERT INTO bewerkingen 
                (waar, gemaakt_door, wat, bekeken_door) VALUES
                ('eventplanner', :gemaakt_door, :wat, :gemaakt_door)
            ");
            $statement->bindValue("gemaakt_door", $login["naam"]);
            $statement->bindValue("wat", $eventPlanner["wat"]);
            $statement->execute();

            $geupdate = true;
        }
    }
?>

<h1>Eventplanner Aanpassen</h1>

<?php if ($permission): ?>
    <?php if ($geupdate): ?>
        <p>De eventplanner is geupdate.</p>
    <?php endif; ?>

    <form class="events_edit" method="post" action="events_edit.php">
        Inhoud:<br />
        <textarea style="width:100%" rows="20" cols="100" name="inhoud"><?=$eventPlanner["wat"];?></textarea><br />
        <br />
        <input type="submit" value="Verander Eventplanner" />
    </form>
<?php else: ?>
    <p>Je hebt niet de bevoegdheid om de eventplanner te bewerken.</p>
    <p>Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel</p>
<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
