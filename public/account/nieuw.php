<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Nieuw Account</title>
</head>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<h1>Nieuw account</h1>

<?php error_reporting(false);

if (isset($_POST["naam"]) && isset($_POST["wachtwoord"]) && isset($_POST["code"]))
	{
	$naam=ucwords(strtolower(trim($_POST["naam"])));
	$wachtwoord=ucwords(strtolower(trim($_POST["wachtwoord"])));
	$toegangscode=strtoupper($_POST["code"]);

	if ($naam=="" || $_POST["wachtwoord"]=="" || $_POST["code"]=="")
		echo "<p>Je hebt in een van de vakken niets ingevuld... Check het even na.</p>";
	else
		{
		if ($toegangscode=="IK5S")
			{
			if (mysql_connect("localhost","<REMOVED>","<REMOVED>"))
				{
				if (mysql_select_db("toxic"))
					{
					$array_dubbel=mysql_query("select naam from leden where naam='" . $naam . "'");
					$array_dubbel=mysql_fetch_array($array_dubbel);
					if (isset($array_dubbel["naam"]))
						echo "<p>De opgegeven naam (" . $naam . ") is al in gebruik, probeer een andere.</p>";
					else
						{
						$sqlcommand="insert into leden (naam,wachtwoord) values ('" . $naam . "','" . $wachtwoord . "')";
						if (mysql_query($sqlcommand))
							{
							echo "<p>Je accountnaam en wachtwoord zijn opgeslagen in de database.<br />
								  De opgegeven accountnaam was: " . $naam . "</p>
								  <p>Je account moet nog goedgekeurd worden door een leider voordat je op de ledendelen van de site mag komen<br />
								  Dit kun je even vragen aan een leider in de CC</p>";
							mkdir("D:/website/account/leden/bestanden/" . str_ireplace(" ","_",$naam));
							}
						else
							echo "<p>De naam kon niet worden opgeslagen.<br>
								  Neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
						}
					}
				else
					echo "<p>De opgevraagde database is niet beschikbaar.<br />
						  Neem a.u.b. contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
				}
			else 
				echo "<p>Er kan geen verbinding met de server worden gemaakt.<br />
					   Probeer over een paar minuten opnieuw.</p>";				
			}
		else
			echo "<p>De opgegeven toegangscode was fout... Probeer opnieuw.</p>";
		}
	}
else
	echo "<p>Je hoeft nu niet meer op deze pagina te zijn...</p>";
?>

<p>Klik <a href='/account'>hier</a> om weer terug te gaan naar het panel</p>

</body>

</html>
