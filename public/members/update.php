<?php

set_time_limit(120);

exit("Lets keep the stats read-only for now...");

function GetRSstats($username,&$result)
	{
    $arrSkills = array(
            "Total",
            "Attack",
            "Defence",
            "Strength",
            "Hitpoints",
            "Ranged",
            "Prayer",
            "Magic",
            "Cooking",
            "Woodcutting",
            "Fletching",
            "Fishing",
            "Firemaking",
            "Crafting",
            "Smithing",
            "Mining",
            "Herblore",
            "Agility",
            "Thieving",
            "Slayer",
            "Farming",
            "Runecraft",
            "Hunter",
            "Construction",
            "Summoning"
            );

    $arrLevels = @file("http://hiscore.runescape.com/index_lite.ws?player=" . urlencode($username),FILE_IGNORE_NEW_LINES);
    $result = Array();

    if($arrLevels === false || empty($username) || strlen($username) > 15)
        return false;

    $iLength = count($arrSkills);
    for($i = 0;$i < $iLength;$i++)
		{
        $levels = explode(",",$arrLevels[$i]);
		$arrStats[$arrSkills[$i]]["skill"] = $arrSkills[$i];
        $arrStats[$arrSkills[$i]]["rank"] = $levels[0];
        $arrStats[$arrSkills[$i]]["level"] = $levels[1];
        $arrStats[$arrSkills[$i]]["exp"] = $levels[2];
		}

    $result = $arrStats;
    return true;
}

function writeStats($naam,$status,$file)
	{
	if(GetRSstats($naam,$stats))
		{
			
		fwrite($file,$status . "," . $naam);
			
		foreach($stats as $values)
			{
			fwrite($file,"," . $values["level"]);
			}
			
		fwrite($file,";");
		
		echo "> naam " . $naam . " is geupdate<br />";
			
		}
	else
		echo "> naam " . $naam . " is niet beschikbaar in de runescape hiscores en dus niet geupdate<br />";
	}

echo "> script gestart <br />";
	
$file = fopen("statsdb.txt","w");

writeStats("Dark Rangex","leider",$file);
writeStats("Villermen","generaal",$file);
writeStats("Werwar666","generaal",$file);
writeStats("Flomiel","luitenant",$file);
writeStats("Hippie Owner","luitenant",$file);
writeStats("3dagsvlieg","recruut",$file);
writeStats("Badhero99","recruut",$file);
writeStats("Baso0o","recruut",$file);
writeStats("Combusken007","recruut",$file);
writeStats("Codered882","recruut",$file);
writeStats("Demon Ownz4","recruut",$file);
writeStats("Dj Rendier","recruut",$file);
writeStats("Dr Marco2","recruut",$file);
writeStats("Drag0nic3","recruut",$file);
writeStats("Ersteel","recruut",$file);
writeStats("F1shsh0w Nl","recruut",$file);
writeStats("Firezword25","recruut",$file);
writeStats("Gewoon M0mma","recruut",$file);
writeStats("Herdef23","recruut",$file);
writeStats("Hesterk2000","recruut",$file);
writeStats("Ikkom2","recruut",$file);
writeStats("Jezusisback","recruut",$file);
writeStats("Kookosnoot14","recruut",$file);
writeStats("Magic8666","recruut",$file);
writeStats("Maxlem1111","recruut",$file);
writeStats("Michelmage0","luitenant",$file);
writeStats("Moord95","recruut",$file);
writeStats("Mr Yoda0","recruut",$file);
writeStats("Obius Pure","recruut",$file);
writeStats("Paratinas","recruut",$file);
writeStats("Petros Ii","recruut",$file);
writeStats("Phalok","recruut",$file);
writeStats("Pure20pure","recruut",$file);
writeStats("R4ng30wnsall","recruut",$file);
writeStats("Remi Xx","recruut",$file);
writeStats("Scorpor ","recruut",$file);
writeStats("Sjoerd59","recruut",$file);
writeStats("Spikker11","recruut",$file);
writeStats("Sylvester S1","recruut",$file);
writeStats("Th3fmsh0w","recruut",$file);
writeStats("Tsies","recruut",$file);
writeStats("Vennexis","recruut",$file);
writeStats("Wieikben4","recruut",$file);
writeStats("Wild Mg Boy","recruut",$file);
writeStats("X Elkarno X","recruut",$file);
writeStats("Zz Sleep Zz8","recruut",$file);

fclose($file);

echo "&gt; script beëindigd <br />";

/*
opbouw van array: $stats

$stats
	"Total"
		"skill" = "Total"
		"rank"  = nummer
		"level" = nummer
		"exp"   = nummer
	"Attack"
		"skill" = "Attack"
		"rank"  = nummer
		"level" = nummer
		"exp"   = nummer
	"Defence"
		"skill" = "Defence"
		"rank"  = nummer
		"level" = nummer
		"exp"   = nummer
	"Strength"
		"skill" = "Strength"
		"rank"  = nummer
		"level" = nummer
		"exp"   = nummer
*/

// voorbeeld gebruik: $stats['Defence']['rank']
?>
