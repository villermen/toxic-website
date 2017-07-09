<?php error_reporting(false);
include("D:/website/toxic/sjablonen/constanten.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php error_reporting(false);
	include("D:/website/toxic/sjablonen/metadata.txt");
	?>
	<title>Toxic - Bestandsbeheer</title>
	
	<script type="text/javascript">
	function verwijderen()
		{
		verwijderen=confirm("Weet je zeker dat je het bestand wilt verwijderen? Dit kan niet ongedaan gemaakt worden.");
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

<h1>Bestandsbeheer</h1>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"M")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om bestanden op de site te zetten.</p>
		  <p>Klik <a href='/toxic/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//invoer verwerken
	if (isset($_POST["actie"]))
		{
		//bestand uploaden
		/*
		
		*/
		
		//bestand verwijderen
		if ($_POST["actie"]=="verwijderen")
			{			
			if (unlink("D:/website/toxic/account/leden/bestanden/" . INLOGNAAM . "/" . $_POST["bestand"]))
				echo "<p>Bestand " . $_POST["bestand"] . " is succesvol verwijderd.";
			else
				echo "<p>Kon bestand " . $_POST["bestand"] . " niet verwijderen. Misschien is het al verwijderd?";
			}
			
		//bestand hernoemen
		if ($_POST["actie"]=="hernoemen")
			{
			$bestand=$_POST["bestand"];
			
			$extensie=strrpos($bestand,".");
			$extensie=substr_replace($bestand,"",0,$extensie);
			
			$nieuw=$_POST["nieuw"];
			$nieuw=str_ireplace(" ","_",$nieuw);
			$nieuw=str_ireplace("/","",$nieuw);
			$nieuw=str_ireplace("\\","",$nieuw);
			$nieuw=str_ireplace("%","",$nieuw);
			if ($nieuw!="")
				if (!file_exists("D:/website/toxic/account/leden/bestanden/" . INLOGNAAM . "/$nieuw$extensie"))
					if (rename("D:/website/toxic/account/leden/bestanden/" . INLOGNAAM . "/$bestand","D:/website/account/leden/bestanden/" . INLOGNAAM . "/$nieuw$extensie"))
						echo "<p>Bestand $bestand is succesvol hernoemd naar $nieuw$extensie</p>";
					else
						echo "<p>Kon bestand $bestand niet hernoemen. Wellicht heb je een niet toegestaan symbool ingevoerd.</p>";
				else
					echo "<p>Er bestaat al een bestand met de naam $nieuw$extensie</p>";
			else
				echo "<p>De nieuwe naam van het bestand ($nieuw$extensie) is niet geldig, het bestand is niet hernoemd.</p>";
			}
		}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	//bestanden laten zien
	echo   "<h2>Alle Bestanden</h2>";
	$urlnaam=str_ireplace(" ","_",INLOGNAAM);
	$array_bestanden=glob("D:/website/toxic/account/leden/bestanden/$urlnaam/*.{png,jpeg,jpg,jpe,gif,mp3,wav,ogg,wma,doc,docx,txt,xls,xlsx,ppt,pptx}",GLOB_BRACE);
	
	echo "<p>";
	foreach($array_bestanden as $bestand)
		{
		$bestand=str_ireplace("D:/website/toxic/account/leden/bestanden/$urlnaam/","",$bestand);
		echo "<a href='/toxic/account/leden/bestanden/$urlnaam/$bestand'>$bestand</a><br />";
		}
	echo "</p>";
	
	//bestand toevoegen
	echo   "<h2>Bestand Uploaden</h2>";
	//ireplace " " "_"
	//max 30mb
	/*
	<form class='bestandsbeheer'  method='post' action='bestandsbeheer.php' enctype="multipart/form-data">
		<input type='hidden' name='actie' value='uploaden' />
		Bestand:<br />
		<input type='file' name='bestand' value='test' /><br />
		<br />
		<input type='submit' value='Upload Bestand' />
	</form>
	*/
	
	//bestand verwijderen
	echo "
	<h2>Bestand Verwijderen</h2>
	
	<form id='verwijderen' class='bestandsbeheer' method='post' action='bestandsbeheer.php'>
		<input type='hidden' name='actie' value='verwijderen' />
		Bestand:<br />
		<select name='bestand'>";
		
		$i=0;
		foreach ($array_bestanden as $bestand)
			{
			$bestand=str_ireplace("D:/website/toxic/account/leden/bestanden/$urlnaam/","",$bestand);
			
			if ($i==0)
				{
				echo "<option selected='selected' value='$bestand'>$bestand</option>";
				$i=1;
				}
			else
				echo "<option value='$bestand'>$bestand</option>";
			}
		
	echo "</select>
		<input type='button' onclick='verwijderen()' value='Verwijder' />
	</form>";
	
	//bestand hernoemen
	echo "
	<h2>Bestand Hernoemen</h2>
	
	<form class='bestandsbeheer' method='post' action='bestandsbeheer.php'>
		<input type='hidden' name='actie' value='hernoemen' />
		Bestand:<br />
		<select name='bestand'>";
		
		$i=0;
		foreach ($array_bestanden as $bestand)
			{
			$bestand=str_ireplace("D:/website/toxic/account/leden/bestanden/$urlnaam/","",$bestand);
			
			if ($i==0)
				{
				echo "<option selected='selected' value='$bestand'>$bestand</option>";
				$i=1;
				}
			else
				echo "<option value='$bestand'>$bestand</option>";
			}
		
	echo "
		</select><br />
		<br />
		Nieuwe naam, zonder bestandsextensie (deel na de punt):<br />
		<input type='text' name='nieuw' maxlength='35' /><br />
		<br />
		<input type='submit' value='Hernoem' />
	</form>";
	}
?>

</body>

</html>