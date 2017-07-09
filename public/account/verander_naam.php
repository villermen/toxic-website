<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Naam Veranderen</title>
</head>

<body>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<h1>Naam veranderen</h1>

<?php error_reporting(false);

if (INLOGID!=false)
	{
	if (isset($_POST["wachtwoord"]))
		{		
		$array_resources=mysql_query("select naam,wachtwoord from leden where login_id='" . INLOGID . "'");
		$array_resources=mysql_fetch_array($array_resources);
		
		if (isset($array_resources["naam"]))
			if ($array_resources["naam"]!="")
				{
				$naam_oud=$array_resources["naam"];
				$dbwachtwoord=$array_resources["wachtwoord"];
				}
				
		$wachtwoord=ucwords(strtolower(trim($_POST["wachtwoord"])));
		$naam_nieuw=ucwords(strtolower(trim($_POST["naam"])));
		
		if ($wachtwoord==$dbwachtwoord)
			{
			if ($naam_nieuw!="")
				{
				$array_dubbel=mysql_query("select naam from leden where naam='" . $naam_nieuw . "'");
				$array_dubbel=mysql_fetch_array($array_dubbel);
				
					if (isset($array_dubbel["naam"]))
						echo "<p>De opgegeven naam (" . $naam_nieuw . ") is al in gebruik, probeer een andere.</p>";
					else
						{
						if (mysql_query("update leden set naam='" . $naam_nieuw . "' where naam='" . $naam_oud . "'"))
							{
							echo "<p>Je nieuwe accountnaam is opgeslagen in de database.<br />
									 De opgegeven accountnaam was: $naam_nieuw</p>";
									 
							//verander profielmap
							$naam_oud_url=str_ireplace(" ","_",$naam_oud);
							$naam_nieuw_url=str_ireplace(" ","_",$naam_nieuw);
							
							if (file_exists("D:/website/account/leden/bestanden/$naam_oud_url"))
								if (rename("D:/website/account/leden/bestanden/$naam_oud_url","D:/website/account/leden/bestanden/$naam_nieuw_url"))
									{
									//verander links in profiel
									$profielinhoud=mysql_query("select profielinhoudtekst from leden where naam='$naam_nieuw'");
									$profielinhoud=mysql_fetch_array($profielinhoud);
									$profielinhoud=$profielinhoud["profielinhoudtekst"];
									
									$profielinhoud=str_ireplace("[link|bestanden/$naam_oud_url/","[link|bestanden/$naam_nieuw_url/",$profielinhoud);
									$profielinhoud=str_ireplace("[afbeelding]bestanden/$naam_oud_url/","[afbeelding]bestanden/$naam_nieuw_url/",$profielinhoud);
									
									if (mysql_query("update leden set profielinhoudtekst='$profielinhoud' where naam='$naam_nieuw'"))
										echo "<p>Je profielmap op de site is veranderd, en bestaande links in je profiel die er via een url naartoe wijzen ook.<br />
										      Kijk alsjeblieft even na of alle plaatjes en links nog correct werken.</p>";
											  
									//delete profielupdate (lage prioriteit)
									mysql_query("delete from bewerkingen where waar='profiel' and gemaakt_door='$naam_oud'");
									}
							}
						else
							echo "<p>De nieuwe naam kon niet worden opgeslagen.<br>
									 Neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
						}
				}
			else
				echo "<p>Je hebt in een van de vakken niks ingevuld.<br />
						 Controleer het even...</p>";
			}
		else
			echo "<p>Je wachtwoord was onjuist, probeer opnieuw...</p>";
		}
	else
		echo "<p>Je hoeft nu niet op deze pagina te zijn...</p>";
	}
else
	echo "<p>Je bent niet ingelogd.<br />
	         Ga terug naar het panel, en log in voordat je je naam kunt veranderen.</p>";
?>

<p>Klik <a href='/account'>hier</a> om weer terug te gaan naar het panel</p>

</body>

</html>