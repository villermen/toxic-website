<?php
	$title1 = "Toxic - Home";
	require("includes/pagestart.php");
?>

<h1>Home</h1>

<?php if ($_LANG != 2): ?>
    <p style="color:red">
        This is an archived version of the site that was hosted on toxic.gotdns.com around 2010.
        It used to serve as an informational website for my RuneScape clan.
    </p>
    <p>
    Hello and welcome to Toxic's clansite.<br />
    We are a RuneScape clan that organises lots of events, like boss-fighting and clanwars.<br />
    If you're interested in joining the clan, come visit us in the clanchat channel: CC Toxic.<br />
    <br />
    We are planning on going to GWD alot in the near future, especially in the weekends, so it would be wise to train your combat stats.
    </p>
<?php else: ?>
    <p style="color:red">
        This is een gearchiveerde versie van de site die werd gehost op toxic.gotdns.com rond 2010.
        Hij diende als een informatiepagina voor mijn RuneScape clan.
    </p>
    <p>
    Hallo en welkom op de clansite van Toxic.<br />
    Wij zijn een RuneScape clan die een hoop events organiseerd, waaronder boss-fights en clanwars.<br />
    Als je het leuk lijkt om de clan te joinen, maak alvast een praatje in de clanchat channel: CC Toxic.<br />
    <br />
    We zijn van plan om veel naar de GWD te gaan, vooral in de weekenden, dus het zou handig zijn als iedereen zijn combat stats zou trainen hiervoor.
    </p>
<?php endif; ?>

<img src="<?=$basePath?>dungeoneering_team2.png" alt="Toxic!" />

<?php require("includes/pageend.php"); ?>
