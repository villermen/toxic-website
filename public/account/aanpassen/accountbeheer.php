<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Accountbeheer</title>
	
	<script type="text/javascript">
	function verwijderen()
		{
		verwijderen=confirm("Weet je zeker dat je dit account wilt verwijderen?");
		if (verwijderen)
			document.forms["verwijderen"].submit();
		else
			location.reload();
		}
	</script>
	
</head>

<body>

<?php error_reporting(false);
include("D:/website/toxic/sjablonen/menu.php");
include("D:/website/toxic/sjablonen/accountmenu.php");
?>

<h1>Accountbeheer</h1>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"A")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om de accounts te beheren.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//invoer verwerken
	if (isset($_POST["actie"]))
		{
		
		}
		
	//UI
	//toegangscode	
	echo "
	<h2>Toegangscode</h2>
	";
		
	//verwijderen
	echo "
	<h2>Account verwijderen</h2>
	<p>Gegevens: [naam][privileges]</p>";
	
	//herstellen
	echo "
	<h2>Account herstellen</h2>
	";
		
	}
?>

</body>

</html>