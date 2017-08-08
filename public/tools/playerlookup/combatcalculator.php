<?php

exit("I don't work no more.");

//requested name
if (isset($_GET["name"]) && ($_GET["name"]!=""))
	{
	if (strlen($_GET["name"])>12)
		$name=false;				
	else
		$name=$_GET["name"];
	}
else
	$name=false;

	
$title1="Toxic - Combat calculator";
$css1="/toxic/includes/standard.css";
$css2="styles.css";
require("../../includes/pagestart.php");
?>

<script type="text/javascript">
	function validateInput(element)
		{
		var newValue=element.value.match(/[0-9]/g);
		if (newValue!=null)
			{
			newValue=newValue.join("");
			}
		element.value=newValue;
		}
</script>

<table style="margin-left:0px; width:100%">
	<tr>
		<td style="text-align:left">
			Fill in the forms, or enter your username. (the forms will override the fetched highscore stats if not empty)<br />
			
			<form style="margin-left:0px">
				<label for="attack">Attack</label> <input id="attack" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="strength">Strength</label> <input id="strength" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="defence">Defence</label> <input id="defence" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="ranged">Ranged</label> <input id="ranged" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="magic">Magic</label> <input id="magic" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="constitution">Constitution</label> <input id="constitution" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="prayer">Prayer</label> <input id="prayer" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" /><br />
				<label for="summoning">Summoning</label> <input id="summoning" type="text" maxlength="3" style="width:3em" onchange="validateInput(this)" />
			</form>
		</td>
		<td>
		</td>
	</tr>
</table>
