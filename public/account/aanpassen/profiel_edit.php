<?php
    $title1 = "Toxic - Profiel Aanpassen";
    require("../../includes/pagestart.php");
?>

<h1>Profiel Aanpassen</h1>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"M")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om een profiel te hebben, of je account is nog niet goedgekeurd door een leider.</p>
		  <p>Klik <a href='/toxic/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//opgegeven dingen verwerken
	if (isset($_POST["titel"]))
		{
		if ($_POST["actie"]=="Verander Profiel")
			{
			//titel
			$titel=htmlEncode($_POST["titel"]);
			mysql_query("update leden set profieltiteltekst='" . $titel . "' where naam='" . INLOGNAAM . "'");
			
			//muziek
			$muziek=$_POST["muziek"];
			if ($muziek=="false")
				$muziek="";
			mysql_query("update leden set profielmuziek='$muziek' where naam='" . INLOGNAAM . "'");
			
			//inhoud
			$inhoud=htmlEncode($_POST["inhoud"]);
			mysql_query("update leden set profielinhoudtekst='$inhoud' where naam='" . INLOGNAAM . "'");
			
			//opties
			if (isset($_POST["views"]))
				$status_views="aan";
			else
				$status_views="uit";
			
			$views=mysql_fetch_array(mysql_query("select views from leden where naam='" . INLOGNAAM . "'"));
			if ($views)
				$views=substr($views["views"],3);
			else
				$views="";
				
			mysql_query("update leden set views='$status_views$views' where naam='" . INLOGNAAM . "'");
			
			if ($_POST["stil"]!="aan")
				{
				//een entry toevoegen van deze actie, en een eventueel vorige verwijderen
				mysql_query("delete from bewerkingen where waar='profiel' and gemaakt_door='" . INLOGNAAM . "'");
				mysql_query("insert into bewerkingen (waar,gemaakt_door,bekeken_door,wat) values ('profiel','" . INLOGNAAM . "','" . INLOGNAAM . "','FALSE')");
				}
				
			echo "<p>Je profiel is geüpdate.</p>";
			}
			
		if ($_POST["actie"]=="Voorbeeld")
			echo "<p>Je profiel is nog niet geupdate, scroll naar onder voor het voorbeeld.</p>";
		}	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//gegevens om in te vullen in form halen
	$titeltekst=mysql_query("select profieltiteltekst from leden where naam='" . INLOGNAAM . "'");
	$titeltekst=mysql_fetch_array($titeltekst);
	$titeltekst=$titeltekst["profieltiteltekst"];
	
	//voor het selecteren van het al opgegeven bestand bij form
	$muziek=mysql_fetch_array(mysql_query("select profielmuziek from leden where naam='" . INLOGNAAM . "'"));
	$muziek=$muziek["profielmuziek"];
	
	if (isset($_POST["titel"]) and $_POST["actie"]=="Voorbeeld")
		$muziek=$_POST["muziek"];
	
	$inhoudtekst=mysql_query("select profielinhoudtekst from leden where naam='" . INLOGNAAM . "'");
	$inhoudtekst=mysql_fetch_array($inhoudtekst);
	$inhoudtekst=$inhoudtekst["profielinhoudtekst"];
	$inhoudtekst=str_replace("<br />","\r\n",$inhoudtekst);
	
	if (isset($_POST["titel"]) and $_POST["actie"]=="Voorbeeld")
		$inhoudtekst=$_POST["inhoud"];
	
	$views=mysql_fetch_array(mysql_query("select views from leden where naam='" . INLOGNAAM . "'"));
	$views=$views["views"];
	
	if ($views)
		{
		$views=substr($views,0,3);
		if ($views=="aan")
			$checked="checked='checked'";
		else
			$checked="";
		}
	else
		$checked="";
		
	if (isset($_POST["titel"]) and isset($_POST["views"]))
		$checked="checked='checked'";
	
	//profiel bewerken
	
	$urlnaam=str_ireplace(" ","_",INLOGNAAM);
	$array_muziek=glob("D:/website/account/leden/bestanden/$urlnaam/*.{mp3,wav,wma,ogg}",GLOB_BRACE);
	
	echo "
	<h2>Profiel</h2>
	<form class='profiel_edit' method='post' action='profiel_edit.php'>
		Titel:<br />
		<input type='text' name='titel' value='" . $titeltekst . "' maxlength='50' size='50' /><br />
		<br />
		Inhoud:<br />
		<textarea style='width:100%' rows='20' cols='100' name='inhoud'>" . $inhoudtekst . "</textarea>
		<br />
		Achtergrondmuziek*:<br />
		<select name='muziek'>
			<option value='false'>-- Geen Achtergrondmuziek --</option>";	
		
		foreach($array_muziek as $bestand)
			{
			$bestand=str_ireplace("D:/website/account/leden/bestanden/$urlnaam/","",$bestand);
			
			if ($bestand==$muziek)
				echo "<option value='$bestand' selected='selected'>$bestand</option>";
			else
				echo "<option value='$bestand'>$bestand</option>";
			}
			
		echo "
		</select><br />
		<br />
		<input type='checkbox' name='views' value='aan' $checked/>Laat aantal views zien<br />
		<br />
		<input type='checkbox' name='stil' value='aan' />Stille update (laat leden niet zien dat je iets hebt veranderd)<br />
		<br />
		<input type='submit' name='actie' value='Verander Profiel' /> <input type='submit' name='actie' value='Voorbeeld' /><br />
		<br />
		* Achtergrondmuziek word niet ondersteund door alle browsers.<br />
		* Alleen mp3/wav/ogg/wma muziekformaten worden ondersteund.
	</form>";
	
	//BBcode uitleg
	echo "
	<h2>BBcode</h2>
	
	<p>
	Je kan in de inhoud van je profiel BBcode gebruiken, dat is een code om tekst op te maken die je ook vaak op forums ziet.<br />
	Uitleg over BBcode kun je <a href='/toxic/account/bbcode.php' target='_blank'>hier</a> vinden (opent in een nieuw tabblad/venster).
	</p>";
	
	//voorbeeld
	if (isset($_POST["titel"]))
		{
		if ($_POST["actie"]=="Voorbeeld")
			{			
			echo "<h2>Voorbeeld</h2>";
			
			//titel
			$titel=htmlEncode($_POST["titel"]);
			echo "<h1>" . bbDecode($titel,INLOGNAAM) . "</h1>";
			
			//muziek
			$muziek=$_POST["muziek"];
			if ($muziek!="false")
				$muziek="<embed src='/account/leden/bestanden/$urlnaam/$muziek' autostart='true' style='visibility:hidden; display:inline; width:0px; height:0px' />";
			else
				$muziek="";
				
			echo $muziek;
				
			//inhoud
			$inhoud=htmlEncode($_POST["inhoud"]);
			echo bbDecode("<div class='profiel_p'>$inhoud</div>",INLOGNAAM);
			
			//views
			if (isset($_POST["views"]))
				$status_views="aan";
			else
				$status_views="uit";
			
			$views=mysql_fetch_array(mysql_query("select views from leden where naam='" . INLOGNAAM . "'"));
			if ($views)
				$views=substr($views["views"],3);
			else
				$views="";
			
			if ($status_views=="aan")
				echo "<p>Aantal views: " . $views . "</p>";
			}
		}	
	}
?>

</body>

</html>
