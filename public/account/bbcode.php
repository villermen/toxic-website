<?php
    $title1 = "Toxic - BB-Code";
    include("../includes/pagestart.php");
?>

<h1>BB-Code</h1>

<h2>Wat is BB-code?</h2>
<p>
    Op sommige delen van de site kun je BB-code gebruiken om tekst die je intypt op te maken.<br />
    Je kan bijvoorbeeld een tekst vetgedrukt maken, maar bijvoorbeeld ook zorgen dat er een link van gemaakt word waar je op kan klikken.
</p>

<h2>Syntax</h2>
<p>
    Bb-code kun je gebruiken door aan het begin van de op te maken tekst een commando te plaatsen, tussen [ en ].<br />
    Aan het eind van de tekst komt datzelfde commando, maar dan met een / ervoor.<br />
    Voorbeeldje: [b]opgemaakte tekst[/b].<br />
    <br />
    Sommige commando's hebben aan een stuk tekst niet genoeg, voor die commando's werkt het zo:<br />
    [b|parameter]opgemaakte tekst[/b].<br />
    Hierin moet je de parameter vervangen door iets wat die opmaak nodig heeft, zoals bij een link, de url waar de link naartoe moet gaan.
</p>

<h2>Commando's</h2>
<p>
    Hier volgt een lijst met mogelijke commando's en uitleg daarover.
</p>
<table>
	<tr>
		<td class='bbhelp'>Commando</td>
		<td class='bbhelp'>Gebruik</td>
		<td class='bbhelp'>Uitwerking</td>
		<td class='bbhelp'>Opmerking</td>
	</tr>
	<tr>
		<td class='bbhelp'>b</td>
		<td class='bbhelp'>[b]vetgedrukte tekst[/b]</td>
		<td class='bbhelp'><b>vetgedrukte tekst</b></td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>i</td>
		<td class='bbhelp'>[i]schuine tekst[/i]</td>
		<td class='bbhelp'><i>schuine tekst</i></td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>d</td>
		<td class='bbhelp'>[d]doorhaalde tekst[/d]</td>
		<td class='bbhelp'><s>doorhaalde tekst</s></td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>6</td>
		<td class='bbhelp'>[6]grootste tekst[/6]</td>
		<td class='bbhelp'><div class="profiel_6">grootste tekst</div></td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>5</td>
		<td class='bbhelp'>[5]een-na-grootste tekst[/5]</td>
		<td class='bbhelp'><div class="profiel_5">een-na-grootste tekst</div></td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>tab</td>
		<td class='bbhelp'>[tab]tekst</td>
		<td class='bbhelp'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tekst</td>
		<td class='bbhelp'>&nbsp;</td>
	</tr>
	<tr>
		<td class='bbhelp'>link</td>
		<td class='bbhelp'>[link|http://toxic.gotdns.com/]korte naam[/link]</td>
		<td class='bbhelp'><a href="http://toxic.gotdns.com/">korte naam</a></td>
		<td class='bbhelp'>Vergeet geen "http://" voor de url te zetten</td>
	</tr>
	<tr>
		<td class='bbhelp'>afbeelding</td>
		<td class='bbhelp'>[afbeelding]http://toxic.gotdns.com/favicon.ico[/afbeelding]</td>
		<td class='bbhelp'><img alt="" src="http://toxic.gotdns.com/favicon.ico" /></td>
		<td class='bbhelp'>Vergeet geen "http://" voor de url te zetten</td>
	</tr>
	<tr>
		<td class='bbhelp'>doel</td>
		<td class='bbhelp'>[doel|mining]99[/doel]</td>
		<td class='bbhelp'>...</td>
		<td class='bbhelp'>Bij de levels kan je 1-99 kiezen, en 0 voor 200m xp.<br />Voor de skills heb je bepaalde mogelijkheden, die staan in de tabel hieronder.</td>
	</tr>
</table>

<h2>Skills</h2>

<table>
	<tr><td>Attack</td></tr>
	<tr><td>Defence</td></tr>
	<tr><td>Strength</td></tr>
	<tr><td>Hitpoints</td></tr>
	<tr><td>Ranged</td></tr>
	<tr><td>Prayer</td></tr>
	<tr><td>Magic</td></tr>
	<tr><td>Cooking</td></tr>
	<tr><td>Woodcutting</td></tr>
	<tr><td>Fletching</td></tr>
	<tr><td>Fishing</td></tr>
	<tr><td>Firemaking</td></tr>
	<tr><td>Crafting</td></tr>
	<tr><td>Smithing</td></tr>
	<tr><td>Mining</td></tr>
	<tr><td>Herblore</td></tr>
	<tr><td>Agility</td></tr>
	<tr><td>Thieving</td></tr>
	<tr><td>Slayer</td></tr>
	<tr><td>Farming</td></tr>
	<tr><td>Runecraft</td></tr>
	<tr><td>Hunter</td></tr>
	<tr><td>Construction</td></tr>
	<tr><td>Summoning</td></tr>
</table>

<?php require("../includes/pageend.php"); ?>
