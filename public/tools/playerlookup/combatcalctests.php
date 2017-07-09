<?php
/*
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
		
	echo ")";*/
?>

<?php

//returns the combat level, the summoning bonus that is included in it and the class (for calculations)
//returns an array, use list() to assign to seperate vars
function calcCombat($att,$str,$def,$ranged,$magic,$hp,$pray,$summon)
	{
	$att=max($att,1);
	$str=max($str,1);
	$def=max($def,1);
	$ranged=max($ranged,1);
	$magic=max($magic,1);
	$hp=max($hp,10);
	$pray=max($pray,1);
	$summon=max($summon,1);
	
	if ($att+$str>=$ranged*1.5 and $att+$str>=$magic*1.5)
		{
		$combat=floor(0.25*(floor(13/10*($att+$str))+$def+$hp+floor(0.5*$pray)+floor(0.5*$summon)));
		$sumAdd=$combat-floor(0.25*(floor(13/10*($att+$str))+$def+$hp+floor(0.5*$pray)));
		}
	elseif ($ranged*1.5>$att+$str and $ranged*1.5>=$magic*1.5)
		{
		$combat=floor(0.25*(floor(13/10*(1.5*$ranged))+$def+$hp+floor(0.5*$pray)+floor(0.5*$summon)));
		$sumAdd=$combat-floor(0.25*(floor(13/10*(1.5*$ranged))+$def+$hp+floor(0.5*$pray)));
		}
	else
		{
		$combat=floor(0.25*(floor(13/10*(1.5*$magic))+$def+$hp+floor(0.5*$pray)+floor(0.5*$summon)));
		$sumAdd=$combat-floor(0.25*(floor(13/10*(1.5*$magic))+$def+$hp+floor(0.5*$pray)));
		}

	return(array($combat,$sumAdd));
	}

list($combat,$sumAdd)=calcCombat(91,99,94,93,99,98,80,85);
echo $combat." ".$sumAdd;
?>