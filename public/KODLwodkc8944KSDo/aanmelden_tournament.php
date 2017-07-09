<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php
	include("D:\website\metadata.txt");
	?>
	<title>Toxic - Home</title>
</head>

<body>

<?php
include("D:\website\menu.php");
?>

<h1>Aanmelden duel tournament</h1>

<?php
if (isset($_COOKIE["id"]))
	{
	mysql_connect("localhost","<REMOVED>","<REMOVED>");
	mysql_select_db("toxic");
	
	$array_loginnaam=mysql_query("select * from login where id='" . $_COOKIE["id"] . "'");
	$array_loginnaam=mysql_fetch_array($array_loginnaam);
	
	$array_naam=mysql_query("select naam from aanmeldingen_duel_tournament where naam='" . $array_loginnaam["naam"] . "'");
	$array_naam=mysql_fetch_array($array_naam);
	
	if ($array_loginnaam["naam"]!=$array_naam["naam"])
		{
		mysql_query("insert into aanmeldingen_duel_tournament (naam) values ('" . $array_loginnaam["naam"] . "')");
		
		$string_aanmeldingen=mysql_query("select aanmeldingen from eventplanner where nummer='2'");
		$string_aanmeldingen=mysql_fetch_array($string_aanmeldingen);
		
		mysql_query("update eventplanner set aanmeldingen='" . $string_aanmeldingen["aanmeldingen"] .  $array_loginnaam["naam"] . "<br/>' where nummer='2'");
		
		echo "<p>Je naam (" . $array_loginnaam["naam"] . ") is toegevoegd aan de aanmeldingen.</p>";
		}
	else
		echo "<p>Je naam (" . $array_loginnaam["naam"] . ") is al toegevoegd aan de aanmeldingen!</p>";
	}
else
	echo "<p>Je bent niet ingelogd.<br/>
		  Log je eerst in voordat je je naam toevoegd, anders is er geen naam om toe te voegen =).</p>";
?>
