<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
include("D:/website/toxic/sjablonen/bbcodefuncties.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Eventplanner Aanpassen</title>
</head>

<body>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<h1>Eventplanner Aanpassen</h1>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"E")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om de eventplanner te bewerken.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//updaten
	if (isset($_POST["inhoud"]))
		{
		$inhoud=htmlEncode($_POST["inhoud"]);
		mysql_query("delete from bewerkingen where waar='eventplanner'");
		mysql_query("insert into bewerkingen (waar,gemaakt_door,wat,bekeken_door) values ('eventplanner','" . INLOGNAAM . "','" . $inhoud . "','" . INLOGNAAM . "')");
		
		echo "<p>De eventplanner is geupdate.</p>";
		}
	
	//UI
	$inhoud=mysql_fetch_array(mysql_query("select wat from bewerkingen where waar='eventplanner'"));
	$inhoud=str_replace("<br />","\r\n",$inhoud["wat"]);
	
	echo "
	<form class='events_edit' method='post' action='events_edit.php'>
		Inhoud:<br />
		<textarea style='width:100%' rows='20' cols='100' name='inhoud'>" . $inhoud . "</textarea><br />
		<br />
		<input type='submit' value='Verander Eventplanner' />
	</form>";
	
	}
?>

</body>

</html>