<?php
    $title1 = "Toxic - Accountbeheer";
    require("../../includes/pagestart.php");

    $permission = $login && stripos($login["privileges"], "A") !== false;

    if ($permission) {
        // Invoer verwerken
        if (isset($_POST["actie"])) {

        }
    }
?>
<h1>Accountbeheer</h1>

<?php if ($permission): ?>
    <p style="color: red">
        Well this is just unfinished...
    </p>

    <h2>Toegangscode</h2>

    <h2>Account verwijderen</h2>

    <h2>Account herstellen</h2>

    <p>Gegevens: [naam][privileges]</p>
<?php else: ?>
    <p>Je hebt niet de bevoegdheid om de accounts te beheren.</p>
    <p>Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel</p>
<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
