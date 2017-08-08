<?php
    $title1 = "Toxic - Ledenlijst aanpassen";
    require("../../includes/pagestart.php");
?>

<h1>Ledenlijst Aanpassen</h1>
<p style="color: red">
    To be reimplemented... Or not.
</p>

<?php
    require("../../includes/pageend.php");
    exit();
?>

<h1>Ledenlijst Aanpassen</h1>

<?php error_reporting(false);

//bevoegdheidscheck
if (INLOGRANKERROR!=false)
	echo INLOGRANKERROR;
elseif (substr_count(INLOGRANK,"L")==0)
	{
	echo "<p>Je hebt niet de bevoegdheid om de eventplanner te bewerken.</p>
		  <p>Klik <a href='/account'>hier</a> om terug te gaan naar het panel</p>";
	}
else
	{
	//opgegeven dingen verwerken
	if (isset($_POST["actie"]) && isset($_POST["naam"]))
		{
		$naam=ucwords(strtolower(trim($_POST["naam"])));
		if (isset($_POST["rank"]))
			{
			$ranknum=$_POST["rank"];
			switch ($ranknum)
				{
				case 0:
					$ranknaam="Vriend"; break;
				case 1:
					$ranknaam="recruut"; break;
				case 2:
					$ranknaam="corporaal"; break;
				case 3:
					$ranknaam="sergeant"; break;
				case 4:
					$ranknaam="luitenant"; break;
				case 5:
					$ranknaam="captain"; break;
				case 6:
					$ranknaam="generaal"; break;
				case 7:
					$ranknaam="leider"; break;
				default:
					$ranknaam="Vriend"; break;
				}
			}
			
		if ($naam!="")
			{
			if ($_POST["actie"]=="toevoegen" && isset($ranknum))
				{
				$array_leden_naam=mysql_query("select naam from ledenlijst where naam='" . $naam . "'");
				$array_leden_naam=mysql_fetch_array($array_leden_naam);
				if (!isset($array_leden_naam["naam"]))
					if (mysql_query("insert into ledenlijst (naam,rank) values ('" . $naam . "','" . $ranknum . "')"))
						echo "<p>" . $naam . " is opgeslagen in de ledenlijst met als rank " . $ranknaam . ".</p>";
					else
						echo "<p>Kan " . $naam . " niet toevoegen, onbekende fout.<br />
							  Neem even contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
				else
					echo "<p>Kan " . $naam . " niet toevoegen, de naam staat al in de ledenlijst.</p>";
				}
				
			if ($_POST["actie"]=="veranderen" && isset($ranknum))
				{
				$array_leden_naam=mysql_query("select naam from ledenlijst where naam='" . $naam . "'");
				$array_leden_naam=mysql_fetch_array($array_leden_naam);
				if (isset($array_leden_naam["naam"]))
					if (mysql_query("update ledenlijst set rank='" . $ranknum . "' where naam='" .$naam. "'"))
						echo "<p>De rank van " . $naam . " is veranderd naar " . $ranknaam . ".</p>";
					else
						echo "<p>Kan rank niet veranderen, onbekende fout.<br />
							  Neem even contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
				else
					echo "<p>Kan rank niet veranderen, de naam staat nog niet in de ledenlijst.</p>";
				}
			
			if ($_POST["actie"]=="verwijderen")
				{
				$array_leden_naam=mysql_query("select naam from ledenlijst where naam='" . $naam . "'");
				$array_leden_naam=mysql_fetch_array($array_leden_naam);
				if (isset($array_leden_naam["naam"]))
					if (mysql_query("delete from ledenlijst where naam='" .$naam. "'"))
						echo "<p>" . $naam . " is verwijderd uit de ledenlijst.</p>";
					else
						echo "<p>Kan " . $naam . " niet verwijderen, onbekende fout.<br />
							  Neem even contact op met de beheerder: <a href='mailto:villermen@gmail.com'>Villermen</a></p>";
				else
					echo "<p>Kan " . $naam . " niet verwijderen, de naam staat nog niet in de ledenlijst.</p>";
				}
			
			if (!isset($ranknum))
				if ($_POST["actie"]=="toevoegen" || $_POST["actie"]=="veranderen")
					echo "<p>Je hebt geen rank opgegeven.</p>";
			}
		else 
			echo "<p>Je hebt geen naam opgegeven.</p>";
		}
	
	//UI
	
	echo "
	<h2>Voeg lid toe</h2>
	<form method='post' action='leden_edit.php' class='leden_edit'>
	<input type='hidden' name='actie' value='toevoegen' />
	Naam:<br />
	<input type='text' name='naam' maxlength='12' size='12' /><br />
	<br />
	Rank:<br />
	<input type='radio' name='rank' value='0' /><img src='/toxic/leden/Friend.png' alt='Vriend' />Vriend
	<input type='radio' name='rank' value='1' /><img src='/toxic/leden/recruit.png' alt='Recruut' />Recruut
	<input type='radio' name='rank' value='2' /><img src='/toxic/leden/corporal.png' alt='Corporaal' />Corporaal
	<input type='radio' name='rank' value='3' /><img src='/toxic/leden/sergeant.png' alt='Sergeant' />Sergeant
	<input type='radio' name='rank' value='4' /><img src='/toxic/leden/lieutenant.png' alt='Luitenant' />Luitenant
	<input type='radio' name='rank' value='5' /><img src='/toxic/leden/captain.png' alt='Captain' />Captain
	<input type='radio' name='rank' value='6' /><img src='/toxic/leden/general.png' alt='Generaal' />Generaal
	<input type='radio' name='rank' value='7' /><img src='/toxic/leden/owner.png' alt='Leider' />Leider<br />
	<br />
	<input type='submit' value='Lid Toevoegen' />
	</form>

	<h2>Verander rank</h2>
	<form method='post' action='leden_edit.php' class='leden_edit'>
	<input type='hidden' name='actie' value='veranderen' />
	Naam:<br />
	<select name='naam'>";
	
	$array_leden=mysql_query("select naam from ledenlijst order by rank desc,naam asc");	
	while($lid=mysql_fetch_array($array_leden))
		{
		$lid=$lid["naam"];
		echo "<option value='$lid' >$lid</option>";
		}
	
	echo 
	"</select><br />
	<br />
	Rank:<br />
	<input type='radio' name='rank' value='0' /><img src='/toxic/leden/friend.png' alt='Vriend' />Vriend
	<input type='radio' name='rank' value='1' /><img src='/toxic/leden/recruit.png' alt='Recruut' />Recruut
	<input type='radio' name='rank' value='2' /><img src='/toxic/leden/corporal.png' alt='Corporaal' />Corporaal
	<input type='radio' name='rank' value='3' /><img src='/toxic/leden/sergeant.png' alt='Sergeant' />Sergeant
	<input type='radio' name='rank' value='4' /><img src='/toxic/leden/lieutenant.png' alt='Luitenant' />Luitenant
	<input type='radio' name='rank' value='5' /><img src='/toxic/leden/captain.png' alt='Captain' />Captain
	<input type='radio' name='rank' value='6' /><img src='/toxic/leden/general.png' alt='Generaal' />Generaal
	<input type='radio' name='rank' value='7' /><img src='/toxic/leden/owner.png' alt='Leider' />Leider<br />
	<br />
	<input type='submit' value='Rank Veranderen' />
	</form>
	
	<h2>Verwijder lid</h2>
	<form method='post' action='leden_edit.php' class='leden_edit'>
	<input type='hidden' name='actie' value='verwijderen' />
	Naam:<br />
	<select name='naam'>";
	
	$array_leden=mysql_query("select naam from ledenlijst order by rank desc,naam asc");	
	while($lid=mysql_fetch_array($array_leden))
		{
		$lid=$lid["naam"];
		echo "<option value='$lid' >$lid</option>";
		}
	
	echo 
	"</select><br />
	<br />
	<input type='submit' value='Lid Verwijderen' />
	</form>
	";
	
	if ($mysql_array_ledenlijst=mysql_query("select naam,rank from ledenlijst order by rank desc,naam asc"))
		{
		function numNaarNaam($ranknum)
			{
			switch ($ranknum)
				{
				case 0:
					$ranknaam="Vriend"; break;
				case 1:
					$ranknaam="Recruut"; break;
				case 2:
					$ranknaam="Corporaal"; break;
				case 3:
					$ranknaam="Sergeant"; break;
				case 4:
					$ranknaam="Luitenant"; break;
				case 5:
					$ranknaam="Captain"; break;
				case 6:
					$ranknaam="Generaal"; break;
				case 7:
					$ranknaam="Leider"; break;
				default:
					$ranknaam="Vriend"; break;
				}
				
			return $ranknaam;
			}
		
		$index=0;
		while($array_ledenlijst=mysql_fetch_array($mysql_array_ledenlijst))
			{
			$index+=1;
			}
		
		$mysql_array_ledenlijst=mysql_query("select naam,rank from ledenlijst order by rank desc,naam asc");
		
		echo "<h2>Leden</h2><table class='leden_edit' summary='Overzicht leden'><tr><td colspan='2'>Pagina 1</td></tr><tr><td>Naam</td><td>Rank</td></tr>";
		
		for ($i=0; $i<=$index; $i++)
			{
			if ($array_ledenlijst=mysql_fetch_array($mysql_array_ledenlijst))
				{
				if ($i==10 || $i==20 || $i==30 || $i==40)
					{
					echo "</table><table class='leden_edit' summary='Overzicht leden'><tr><td colspan='2'>Pagina " . ($i/10+1) . "</td></tr><tr><td>Naam</td><td>Rank</td></tr>";
					}
			
				echo "<tr><td>" . $array_ledenlijst["naam"] . "</td><td>" . numNaarNaam($array_ledenlijst["rank"]) . "</td></tr>";
				}
			}			
		echo "</table>";
		} 
		
	}
?>

</body>

</html>
