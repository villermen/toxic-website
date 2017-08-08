<?php error_reporting(false);

exit("I don't work no more.");

if (!include("../../includes/statfunctions.php"))
	die("Gegevensverwerkingsfuncties konden niet worden geladen. (compare.php regel 4)");
	
//requested names
if (!isset($_GET["name1"]) or !$_GET["name1"]!="")
	{
	$name1=false;
	}
if (!isset($_GET["name2"]) or !$_GET["name2"]!="")
	{
	$name2=false;
	}
	
if (strlen($_GET["name1"])>12)
	$name1=false;				
else
	$name1=$_GET["name1"];
	
if (strlen($_GET["name2"])>12)
	$name2=false;				
else
	$name2=$_GET["name2"];	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<?php error_reporting(false);
	include("D:/website/toxic/tools/playerlookup/metadata.txt");
	?>
	<link rel="stylesheet" type="text/css" href="/toxic/tools/playerlookup/styles.css" />
	<title>Toxic - Compare players</title>
</head>

<body>

<h1>Compare players</h1>

<?php error_reporting(false);

if ($name1!=false and $name2!=false)
	{
	if (getStats($name1,$values1) and getStats($name2,$values2))
		{
		$notFoundError=false;
		
		//combat calculator
		$att1=max($values1["Attack"]["level"],1);
		$str1=max($values1["Strength"]["level"],1);
		$def1=max($values1["Defence"]["level"],1);
		$constitution1=max($values1["Constitution"]["level"],10);
		$prayer1=max($values1["Prayer"]["level"],1);
		$magic1=max($values1["Magic"]["level"],1);
		$ranged1=max($values1["Ranged"]["level"],1);
		$summoning1=max($values1["Summoning"]["level"],1);
		
		$cb_melee1=floor(0.25*(floor(13/10*($att1+$str1))+$def1+$constitution1+floor(0.5*$prayer1)));
		$cb_magic1=floor(0.25*(floor(13/10*floor(3/2*$magic1))+$def1+$constitution1+floor(0.5*$prayer1)));
		$cb_ranged1=floor(0.25*(floor(13/10*floor(3/2*$ranged1))+$def1+$constitution1+floor(0.5*$prayer1)));
		$scb_melee1=floor(0.25*(floor(13/10*($att1+$str1))+$def1+$constitution1+floor(0.5*$prayer1)+floor(0.5*$summoning1)));
		$scb_magic1=floor(0.25*(floor(13/10*floor(3/2*$magic1))+$def1+$constitution1+floor(0.5*$prayer1)+floor(0.5*$summoning1)));
		$scb_ranged1=floor(0.25*(floor(13/10*floor(3/2*$ranged1))+$def1+$constitution1+floor(0.5*$prayer1)+floor(0.5*$summoning1)));
		
		$max_cb1=max(max($cb_melee1,$cb_magic1),$cb_ranged1);
		$max_scb1=max(max($scb_melee1,$scb_magic1),$scb_ranged1);
		
		$combatColorOut1=decrgb(max($max_scb1-50,0)/88);
		
		$combatOut1=$max_scb1;
		if ($summoning1!=1)
			{
			$combatOut1=$combatOut1." ($max_cb1";
			
			switch ($max_cb1)
				{
				case $cb_melee1:
					$combatOut1="$combatOut1+".($scb_melee1-$cb_melee1).")";
					break;
				case $cb_magic1:
					$combatOut1="$combatOut1+".($scb_magic1-$cb_magic1).")";
					break;
				case $cb_ranged1:
					$combatOut1="$combatOut1+".($scb_ranged1-$cb_ranged1).")";
					break;
				}
			}
			
		$att2=max($values2["Attack"]["level"],1);
		$str2=max($values2["Strength"]["level"],1);
		$def2=max($values2["Defence"]["level"],1);
		$constitution2=max($values2["Constitution"]["level"],10);
		$prayer2=max($values2["Prayer"]["level"],1);
		$magic2=max($values2["Magic"]["level"],1);
		$ranged2=max($values2["Ranged"]["level"],1);
		$summoning2=max($values2["Summoning"]["level"],1);
		
		$cb_melee2=floor(0.25*(floor(13/10*($att2+$str2))+$def2+$constitution2+floor(0.5*$prayer2)));
		$cb_magic2=floor(0.25*(floor(13/10*floor(3/2*$magic2))+$def2+$constitution2+floor(0.5*$prayer2)));
		$cb_ranged2=floor(0.25*(floor(13/10*floor(3/2*$ranged2))+$def2+$constitution2+floor(0.5*$prayer2)));
		$scb_melee2=floor(0.25*(floor(13/10*($att2+$str2))+$def2+$constitution2+floor(0.5*$prayer2)+floor(0.5*$summoning2)));
		$scb_magic2=floor(0.25*(floor(13/10*floor(3/2*$magic2))+$def2+$constitution2+floor(0.5*$prayer2)+floor(0.5*$summoning2)));
		$scb_ranged2=floor(0.25*(floor(13/10*floor(3/2*$ranged2))+$def2+$constitution2+floor(0.5*$prayer2)+floor(0.5*$summoning2)));
		
		$max_cb2=max(max($cb_melee2,$cb_magic2),$cb_ranged2);
		$max_scb2=max(max($scb_melee2,$scb_magic2),$scb_ranged2);
		
		$combatColorOut2=decrgb(max($max_scb2-50,0)/88);
		
		$combatOut2=$max_scb2;
		if ($summoning2!=1)
			{
			$combatOut2="$combatOut2 ($max_cb2";
			
			switch ($max_cb2)
				{
				case $cb_melee2:
					$combatOut2="$combatOut2+".($scb_melee2-$cb_melee2).")";
					break;
				case $cb_magic2:
					$combatOut2="$combatOut2+".($scb_magic2-$cb_magic2).")";
					break;
				case $cb_ranged2:
					$combatOut2="$combatOut2+".($scb_ranged2-$cb_ranged2).")";
					break;
				}
			}
		
		echo "
		<table id='playerInfo'>
			<tbody>
				<tr>
					<td class='player1'>
						<h1>$name1</h1>
						<img src='http://services.runescape.com/m=avatar-rs/$name1/chat.gif' alt='' /><img src='http://services.runescape.com/m=avatar-rs/$name1/full.gif' alt='' /><br />
						<br />
						<a href='user.php?name=$name1'>View detailed stats</a><br />
						<br />
						<span style='color:$combatColorOut1'>Combat: $combatOut1<span><br />
						<br />
					</td>
					
					<td class='player2'>
						<h1>$name2</h1>
						<img src='http://services.runescape.com/m=avatar-rs/$name2/full.gif' alt='' /><img src='http://services.runescape.com/m=avatar-rs/$name2/chat.gif' alt='' /><br />
						<br />
						<a href='user.php?name=$name2'>View detailed stats</a><br />
						<br />
						<span style='color:$combatColorOut2'>Combat: $combatOut2<span><br />
						<br />
					</td>
				</tr>
			</tbody>";
		
		echo "
		<table id='playerStats' summary='Stats'>
			<thead>
				<tr class='head'>
					<th>Skill</th>
					<th>Level</th>
					<th>XP</th>
					<th>Rank</th>
					
					<th class='spacer'></th>
					<th>Level</th>
					<th>XP</th>
					<th>Rank</th>
					<th class='spacer'></th>
					
					<th>Rank</th>
					<th>XP</th>
					<th>Level</th>
					<th>Skill</th>
				</tr>
			</thead>
			<tbody>";
				
		//skills table
		$rowNumb=0;
		foreach ($values1 as $key=>$stats1)
			{
			$stats2=$values2[$key];
			
			$skill1=$stats1["skill"];
			$level1=$stats1["level"];
			$xp1=$stats1["exp"];
			$rank1=$stats1["rank"];
			
			$skill2=$stats2["skill"];
			$level2=$stats2["level"];
			$xp2=$stats2["exp"];
			$rank2=$stats2["rank"];
			
			$rowNumb+=1;
			
			//main color
			if ($skill1!="Total") //for levels 30-120
				$levelColor1=decrgb((max(30,min($level1,99))-30)/69);
			else //for levels 750-2496
				$levelColor1=decrgb((max(750,min($level1,2496))-750)/1746);

			if ($skill2!="Total") //for levels 30-120
				$levelColor2=decrgb((max(30,min($level2,99))-30)/69);
			else //for levels 750-2496
				$levelColor2=decrgb((max(750,min($level2,2496))-750)/1746);
			
			//skill
			if ($skill1!="Average")
				 $skillOut1=$skill1;
			else
				 $skillOut1="&nbsp;&nbsp;$skill1*";
				 
			if ($skill2!="Average")
				 $skillOut2=$skill2;
			else
				 $skillOut2="&nbsp;&nbsp;$skill2*";
			
			//level
			if ($level1==-1)
				$levelOut1="--";
			else
				$levelOut1=round($level1,2);
			
			if ($level2==-1)
				$levelOut2="--";
			else
				$levelOut2=round($level2,2);
			
			//xp
			if ($xp1==-1)
				$xpOut1="--";
			else
				$xpOut1=number_format($xp1,0,".",",");
				
			if ($xp2==-1)
				$xpOut2="--";
			else
				$xpOut2=number_format($xp2,0,".",",");
				
			//rank
			$rankColor1=decrgb(1-min(max($rank1/2000000,0),1));
			
			if ($rank1==-1)
				{
				$rankOut1="--";
				$rankColor1=decrgb(0);
				}
			else
				$rankOut1=number_format($rank1,0,".",",");
				
			$rankColor2=decrgb(1-min(max($rank2/2000000,0),1));
			
			if ($rank2==-1)
				{
				$rankOut2="--";
				$rankColor2=decrgb(0);
				}
			else
				$rankOut2=number_format($rank2,0,".",",");
				
			//compare level
			if ($level1>$level2)
				{
				$compareLevelColor=decrgb(1);
				$compareLevel="+".round(max($level1,1)-max($level2,1),2);
				}
			elseif ($level1==$level2)
				{
				$compareLevelColor=decrgb(0.5);
				$compareLevel="=";
				}
			else
				{
				$compareLevelColor=decrgb(0);
				$compareLevel=round(max($level1,1)-max($level2,1),2);
				}
				
			//compare xp
			if ($xp1>$xp2)
				{
				$compareXpColor=decrgb(1);
				$compareXp="+".number_format(max($xp1,0)-max($xp2,0),0,".",",");
				}
			elseif ($xp1==$xp2)
				{
				$compareXpColor=decrgb(0.5);
				$compareXp="=";
				}
			else
				{
				$compareXpColor=decrgb(0);
				$compareXp=number_format(max($xp1,0)-max($xp2,0),0,".",",");
				}

			//compare rank
			if ($rank1<$rank2)
				{
				$compareRankColor=decrgb(1);
				if ($rank1!=-1)
					$compareRank="+".number_format(max($rank2,0)-max($rank1,0),0,".",",");
				else
					{
					$compareRankColor=decrgb(0);
					$compareRank="--";	
					}					
				}
			elseif ($rank1==$rank2)
				{
				$compareRankColor=decrgb(0.5);
				$compareRank="=";
				}
			else
				{
				$compareRankColor=decrgb(0);
				if ($rank2!=-1)
					$compareRank=number_format(max($rank2,0)-max($rank1,0),0,".",",");
				else
					{
					$compareRankColor=decrgb(1);
					$compareRank="--";
					}
				}	

			//output the whole row
			//background color
			if ($rowNumb%2)
				echo "<tr class='row1'>";
			else
				echo "<tr class='row2'>";
				
			//user1's stats
			echo "<td class='skill' style='color:$levelColor1'>$skillOut1</td><td style='color:$levelColor1'>$levelOut1</td><td style='color:$levelColor1'>$xpOut1</td><td style='color:$rankColor1'>$rankOut1</td>";
			
			//comparison section
			echo "<td class='spacer'></td><td style='color:$compareLevelColor'>$compareLevel</td><td style='color:$compareXpColor'>$compareXp</td><td style='color:$compareRankColor'>$compareRank</td><td class='spacer'></td>";
			
			//user2's stats
			echo "<td style='color:$rankColor2'>$rankOut2</td><td style='color:$levelColor2'>$xpOut2</td><td style='color:$levelColor2'>$levelOut2</td><td class='skill' style='color:$levelColor2'>$skillOut2</td>";
			
			echo "</tr>\r\n";
			}
		
		echo "</tbody></table>";
		
		//set info with same width as stats
		echo "
		<script type='text/javascript'>
			document.getElementById('playerInfo').style.width=document.getElementById('playerStats').offsetWidth+'px';
		</script>
		";
		}
	else
		{
		echo "
		<p>At least one of the names could not be found in the RS player database.<br />
		Please check if the names you input are correct.</p>";
		$notFoundError=true;
		}
	}

	//compare other players
	echo
	"
	<script type='text/javascript'>
		function swapUsers()
			{
			var user1=document.getElementById('inputName1').value;
			var user2=document.getElementById('inputName2').value;
			
			document.getElementById('inputName1').value=user2;
			document.getElementById('inputName2').value=user1;
			}
	</script>
	
	
	<p>Enter usernames in the boxes below to compare their stats.</p>
	<form method='get' action='compare.php'>
		<input type='text' maxlength='12' name='name1' value='$name1' id='inputName1'>
		<input type='button' value='Swap' onclick='swapUsers()'>
		<input type='text' maxlength='12' name='name2' value='$name2' id='inputName2'>
		<input type='submit' value='Compare' />
	</form>";
	if ($name1 and $name2 and !$notFoundError)
		echo "
	<br />
	<p>
	* The average level and xp are calculated from the total level and xp, where the average rank is the average of all 25 skills plus the total level.
	</p>";
	
?>
	
</body>

</html>
