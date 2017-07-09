<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Leden panel - Leden</title>
</head>

<body>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<h1>Leden panel</h1>

<h2>Leden</h2>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"M")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om deze pagina te bekijken.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//maak lijst van alle leden
	echo "<p>";
	
	$array_namen=mysql_query("select naam from leden order by naam");
	while ($naam=mysql_fetch_array($array_namen))
		{
		//ranks ervoor
		$rank=mysql_fetch_array(mysql_query("select rank from ledenlijst where naam='" . $naam["naam"] . "'"));
		$rank=$rank["rank"];
		
		if (isset($rank))
			{
			switch ($rank)
				{
				case 7:
					echo "<img src='owner.png' alt='Leider' />";
					break;
				case 6:
					echo "<img src='general.png' alt='Generaal' />";
					break;
				case 5:
					echo "<img src='captain.png' alt='Captain' />";
					break;
				case 4:
					echo "<img src='lieutenant.png' alt='Luitenant' />";
					break;
				case 3:
					echo "<img src='sergeant.png' alt='Sergeant' />";
					break;
				case 2:
					echo "<img src='corporal.png' alt='Corporaal' />";
					break;
				case 1:
					echo "<img src='recruit.png' alt='Rekruut' />";
					break;
				}
			}
		else
			echo "<img src='friend.png' alt='Vriend' />";
			
		echo "<a href='profiel.php?naam=" . $naam["naam"] . "'>" . $naam["naam"] . "</a>";
		
		if ($array_geupdate=mysql_fetch_array(mysql_query("select waar,gemaakt_door,bekeken_door from bewerkingen where gemaakt_door='" . $naam["naam"] . "'")));
			{
			if ($array_geupdate!=array())
				if (substr_count($array_geupdate["bekeken_door"],INLOGNAAM)==0 && substr_count($array_geupdate["gemaakt_door"],INLOGNAAM)==0)
					echo "*";
			}
		
		echo "<br />";
		}
		
	echo "</p>";
	}

?>

</body>

</html>


