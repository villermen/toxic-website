<?php
	$title1 = "Toxic - Gallery";
	$title2 = "Toxic - Afbeeldingen";
	require("../includes/pagestart.php");
?>

<?php if ($_LANG != 2): ?>
    <h1>Gallery</h1>

    <p>
    If you made a sweet picture, send it to <a href='mailto:villermen@gmail.com'>villermen@gmail.com</a>. Please save it in png or bmp format.<br />
    </p>

    <h2>Previous homepage picture</h2>
    <img src='<?=$basePath?>gallery/team.png' alt='Teampicture' style='margin-left:100px'/>

    <h2>Toxic on fire!</h2>
    <img src='<?=$basePath?>gallery/toxiconfire.png' alt='Toxic on Fire!' style='margin-left:100px'/>

    <p>Arcane Rays en Villermen do the questcape emote together</p>
    <img src="<?=$basePath?>gallery/questcape2.gif" alt="Werwar666 en Villermen questcape emote" style="margin-left:100px"/>
<?php else: ?>
    <h1>Afbeeldingen</h1>

    <p>
    Als je een leuk plaatje hebt, stuur hem dan op naar <a href='mailto:villermen@gmail.com'>villermen@gmail.com</a>. Sla hem alsjeblieft op in png of bmp formaat.<br />
    </p>

    <h2>Vorige homepage foto</h2>
    <img src='<?=$basePath?>gallery/team.png' alt='Teamfoto' style='margin-left:100px'/>

    <h2>Toxic on fire!</h2>
    <img src='<?=$basePath?>gallery/toxiconfire.png' alt='Toxic on Fire!' style='margin-left:100px'/>

    <p>Arcane Rays en Villermen doen samen de questcape emote</p>
    <img src="<?=$basePath?>gallery/questcape2.gif" alt="Werwar666 en Villermen questcape emote" style="margin-left:100px"/>
<?php endif; ?>

<?php require("../includes/pageend.php"); ?>
