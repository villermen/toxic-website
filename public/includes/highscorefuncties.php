<?php error_reporting(false);

//haalt stats van account op
function getStats($username,&$result)
	{
    $arrSkills = array(
            "Total",
			"Average",
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
            "Runecrafting",
            "Hunter",
            "Construction",
            "Summoning",
			"Dungeoneering"
            );

    $sPagina = "http://hiscore.runescape.com/index_lite.ws?player=";

    $arrLevels = @file($sPagina.urlencode($username),FILE_IGNORE_NEW_LINES);
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

	/*
	opbouw van array: $result

	$result
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
	}