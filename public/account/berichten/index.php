<?php
    $titel = "Toxic - Leden panel - Berichten";
    require("../../includes/pagestart.php");

    $permission = $login && stripos($login["privileges"], "M") !== false;
?>

<h1>Leden panel</h1>

<h2>Berichten <span style="color: red">(werkt nog niet)</span></h2>

<?php if ($permission): ?>
    <p>
        <a href="nieuw_bericht.php">Nieuw Bericht</a><br />
        <br />
        <a href="inbox.php">Inbox</a><br />
        <br />
        <a href="verzonden_berichten.php">Verzonden berichten</a>
    </p>
<?php else: ?>
    <p>Je hebt niet de bevoegdheid om berichten te maken/bekijken.</p>
    <p>Klik <a href="<?=$basePath;?>account">hier</a> om terug te gaan naar het panel</p>
<?php endif; ?>

<?php require("../../includes/pageend.php"); ?>
