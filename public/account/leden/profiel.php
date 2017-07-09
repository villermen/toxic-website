<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
include("D:/website/toxic/sjablonen/bbcodefuncties.php");
include("D:/website/toxic/sjablonen/highscorefuncties.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	echo "<title>Toxic - " . $_GET["naam"] . "</title>";
	?>
</head>

<body>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"M")==0)
	{
	echo "<h1>Profiel van " . $_GET["naam"] . "</h1>
		  <p>Je hebt niet de bevoegdheid om deze pagina te bekijken.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//haal gegevens op
	$urlnaam=str_ireplace(" ","_",INLOGNAAM);
	
	$titel=mysql_query("select profieltiteltekst from leden where naam='" . $_GET["naam"] . "'");
	$titel=mysql_fetch_array($titel);
	$titel=bbDecode($titel["profieltiteltekst"],$_GET["naam"]);
	
	$muziek=mysql_fetch_array(mysql_query("select profielmuziek from leden where naam='" . $_GET["naam"] . "'"));
	$muziek=$muziek["profielmuziek"];
	if (isset($muziek))
		if ($muziek!="")
			$muziek="<embed src='/account/leden/bestanden/$urlnaam/$muziek' autostart='true' style='visibility:hidden; display:inline; width:0px; height:0px' />";
	else
		$muziek="";
	
	$inhoud=mysql_query("select profielinhoudtekst from leden where naam='" . $_GET["naam"] . "'");
	$inhoud=mysql_fetch_array($inhoud);
	$inhoud=bbDecode("<div class='profiel_p'>" . $inhoud["profielinhoudtekst"] . "</div>",$_GET["naam"]);
	
	$views=mysql_query("select views from leden where naam='" . $_GET["naam"] . "'");
	$views=mysql_fetch_array($views);
	$views_status=substr($views["views"],0,3);
	$views=substr($views["views"],3);
	
	//laat gegevens zien
	if ($titel==null)
		echo "<h1>Profiel van " . $_GET["naam"] . "</h1><p>" . $_GET["naam"] . " heeft nog geen eigen profiel.</p>";
	else
		{
		echo "<h1>" . $titel . "</h1>" . $muziek . $inhoud;
		
		if ($views_status=="aan")
			echo "<p>Aantal views: " . $views . "</p>";		
		}
		
	//update bekeken in database	
	$array_bekeken=mysql_fetch_array(mysql_query("select nummer,waar,gemaakt_door,bekeken_door from bewerkingen where waar='profiel' and gemaakt_door='" . $_GET["naam"] . "'"));
	
	if (substr_count($array_bekeken["bekeken_door"],INLOGNAAM)==0)
		mysql_query("update bewerkingen set bekeken_door='" . $array_bekeken["bekeken_door"] . "," . INLOGNAAM . "' where nummer='" . $array_bekeken["nummer"] . "'");
	
	//als je niet de maker bent 1 optellen bij aantal views
	if (($views_status=="aan" or $views_status=="uit") and INLOGNAAM!=$_GET["naam"])
		{
		mysql_query("update leden set views='$views_status" . ($views+1) . "' where naam='" . $_GET["naam"] . "'");
		}
	}
?>

</body>

</html>