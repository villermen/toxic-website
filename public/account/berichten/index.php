<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php
	error_reporting(false);
	include("D:/website/metadata.txt");
	?>
	<title>Toxic - Leden panel - Berichten</title>
</head>

<body>

<?php
include("D:/website/menu.php");
include("D:/website/accountmenu.php");
include("D:/website/account/functies.php");
?>

<h1>Leden panel</h1>

<?php

//indien error met database
if (substr_count($bevoegdheid=bevoegdheid(),"<p>")>0)
	echo $bevoegdheid;
elseif (substr_count($bevoegdheid,"M")==0) //geen toegang
	{
	echo "<p>Je hebt niet de bevoegdheid om berichten te maken/bekijken.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	echo "
	<h2>Berichten</h2>
	
	<p><a href='nieuw_bericht.php'>Nieuw Bericht</a><br />
	<br />
	<a href='inbox.php'>Inbox</a><br />
	<br />
	<a href='verzonden_berichten.php'>Verzonden berichten</a></p>";
	}
	
?>
	
</body>

</html>
