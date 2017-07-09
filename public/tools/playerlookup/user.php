<?php

if (!include("../../sjablonen/highscorefuncties.php"))
	die("Statprocessfunctions could not be loaded, execution failed. (user.php line 4)");
	
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

	
if (!$name)	
	$title1="Toxic - Player lookup";
else
	$title1="Toxic - Player lookup - $name";
$css1="/toxic/includes/standard.css";
$css2="styles.css";
require("../../includes/pagestart.php");

if ($name!=false)
	{
	if (getStats($name,$stats))
		{
		echo "<h1>Personal highscores for " . $name . "</h1>
		
		<p>
		<img src='http://services.runescape.com/m=avatar-rs/$name/chat.gif' alt='' /><img src='http://services.runescape.com/m=avatar-rs/$name/full.gif' alt='' /><br />
		<br />
		<a href='http://services.runescape.com/m=adventurers-log/display_player_profile.ws?searchName=$name'>View this player's adventurer's log</a><br />
		<br />
		<a href='compare.php?name1=$name&name2='>Compare this player</a><br />
		<br />";
		
		//combat calculator
		$att=max($stats["Attack"]["level"],1);
		$str=max($stats["Strength"]["level"],1);
		$def=max($stats["Defence"]["level"],1);
		$constitution=max($stats["Constitution"]["level"],10);
		$prayer=max($stats["Prayer"]["level"],1);
		$magic=max($stats["Magic"]["level"],1);
		$ranged=max($stats["Ranged"]["level"],1);
		$summoning=max($stats["Summoning"]["level"],1);
		
		$cb_melee=floor(0.25*(floor(13/10*($att+$str))+$def+$constitution+floor(0.5*$prayer)));
		$cb_magic=floor(0.25*(floor(13/10*floor(3/2*$magic))+$def+$constitution+floor(0.5*$prayer)));
		$cb_ranged=floor(0.25*(floor(13/10*floor(3/2*$ranged))+$def+$constitution+floor(0.5*$prayer)));
		$scb_melee=floor(0.25*(floor(13/10*($att+$str))+$def+$constitution+floor(0.5*$prayer)+floor(0.5*$summoning)));
		$scb_magic=floor(0.25*(floor(13/10*floor(3/2*$magic))+$def+$constitution+floor(0.5*$prayer)+floor(0.5*$summoning)));
		$scb_ranged=floor(0.25*(floor(13/10*floor(3/2*$ranged))+$def+$constitution+floor(0.5*$prayer)+floor(0.5*$summoning)));
		
		$max_cb=max(max($cb_melee,$cb_magic),$cb_ranged);
		$max_scb=max(max($scb_melee,$scb_magic),$scb_ranged);
		
		echo "<span style='color:".decrgb(max($max_scb-50,0)/88)."'>Combat: ".$max_scb;
		
		if ($summoning!=1)
			{
			echo " ($max_cb";
			
			switch ($max_cb)
				{
				case $cb_melee:
					echo "+" . ($scb_melee-$cb_melee);
					break;
				case $cb_magic:
					echo "+" . ($scb_magic-$cb_magic);
					break;
				case $cb_ranged:
					echo "+" . ($scb_ranged-$cb_ranged);
					break;
				default:
					echo "";
					break;
				}
				
			echo ")";
			}
		//combat calculator end
		echo "</span></p>";
		
		echo "
			<table id='playerStats' summary='Stats'>
				<thead>
					<tr class='head'>
						<th>Skill</th>
						<th>Level</th>
						<th>XP</th>
						<th>Rank</th>
						<th>XP till next</th>
						<th>progress</th>
					</tr>
				</thead>
				<tbody>";
				
		//skills table
		$rowCount=0;
		foreach($stats as $values)
			{
			$skill=$values["skill"];
			$level=$values["level"];
			$xp=$values["exp"];
			$rank=$values["rank"];
			
			//color fitting level
			if ($skill!="Total") //for levels 30-120
				$levelColor=decrgb((max(30,min($level,99))-30)/69);
			else //for levels 750-2496
				$levelColor=decrgb((max(750,min($level,2496))-750)/1746);
			
			//background color
			$rowCount+=1;
			if ($rowCount%2)
				echo "<tr class='row1'>";
			else
				echo "<tr class='row2'>";
			
			//skill
			echo "<td style='color:$levelColor'>";
			if ($skill!="Average")
				 echo "$skill</td>";
			else
				 echo "&nbsp;&nbsp;$skill*</td>";
			
			//level
			if ($level==-1)
				$levelOut="--";
			else
				{
				$levelOut=floor($level);
				if ($skill=="Average")
					$levelOut=$levelOut."/".xpToLevel($xp);
				}
				
			echo "<td style='color:$levelColor'>$levelOut</td>";
			
			//xp
			if ($xp==-1)
				echo "<td style='color:$levelColor'>--</td>"; 
			else
				echo "<td style='color:$levelColor'>".number_format($xp,0,".",",")."</td>";
				
			//rank
			$rankColor=decrgb(1-min(max($rank/2000000,0),1));
			
			if ($rank==-1)
				{
				$rankOut="--";
				$rankColor=decrgb(0);
				}
			else
				$rankOut=number_format($rank,0,".",",");
				
			echo "<td style='color:$rankColor'>$rankOut</td>";	
			
			//xp till next level (echoes at progress)
			$nextLevelXp=mysql_fetch_assoc(mysql_query("SELECT xp FROM xp_table WHERE level='".($level+1)."'"));
			$nextLevelXp=$nextLevelXp["xp"];
			$xpTillNext=number_format($nextLevelXp-$xp,0,".",",");
			
			//progress to next level
			$thisLevelXp=mysql_fetch_assoc(mysql_query("SELECT xp FROM xp_table WHERE level='$level'"));
			$thisLevelXp=$thisLevelXp["xp"];
			
			$totalXpThisLevel=$nextLevelXp-$thisLevelXp;
			$xpGainedThisLevel=$totalXpThisLevel-($nextLevelXp-$xp);
			$progress=round($xpGainedThisLevel/$totalXpThisLevel*100,2);
			
			//echo xp till next level and progress
			if ($skill=="Total" or $skill=="Average" or $level==-1)
				{
				echo "<td style='color:".decrgb(0)."'>&nbsp;</td>";
				echo "<td style='color:".decrgb(0)."'>&nbsp;</td>"; 
				}
			elseif (($skill!="Dungeoneering" and $level==99) or ($skill=="Dungeoneering" and $level==120))
				{
				echo "<td style='color:".decrgb(1)."'>&nbsp;</td>";
				echo "<td style='color:".decrgb(1)."'>&nbsp;</td>";
				}
			else
				{
				echo "<td style='color:".decrgb($progress/100)."'>$xpTillNext</td>";
				echo "<td style='color:".decrgb($progress/100)."'>$progress%</td>"; 
				}
				
			echo "</tr>";
			}
		
		echo "</tbody></table>";
		}
	else
		echo "<h1>Wrong name</h1>
		<p>The name: \"$name\" could not be found in the RS player database.<br />
		Please check if the name you input is correct.</p>";
	}
else
	echo "<h1>Enter username</h1>";

	echo
	"<p>Enter a username in the box below to look-up it's stats:</p>
	<form method='get' action='user.php'>
		<input type='text' name='name' value='$name'>
	</form>";
	if ($name)
		echo "
	<br />
	<p>
	* The average xp is calculated from the total xp, where the average rank is the average of the rank from all 25 skills plus the total level's.<br />
	* The first level shown is the average of the total level, the one after the slash is the level according to the average xp.
	</p>";
	
?>
	
</body>

</html>
