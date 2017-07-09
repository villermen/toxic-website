<?php error_reporting(false);

//replace html tags with text
function htmlEncode($string)
	{	
	/* fallback
	$string=str_ireplace("&","&amp;",$string);
	$string=str_ireplace("<","&lt;",$string);
	$string=str_ireplace(">","&gt;",$string);
	$string=str_ireplace("'","&#39;",$string);
	$string=str_ireplace('"',"&quot;",$string);
	*/
	
	$string=htmlentities($string,ENT_QUOTES,"ISO-8859-15");
	$string=str_replace("\t","     ",$string);
	$string=str_replace(" ","&nbsp;",$string);
	$string=str_replace("\r\n","<br />",$string);

	return($string);
	}

/*returns an array from the first bb-tag named $bbcommand (a string)
**array is coded like this: $array["parameter"],["content"], [position] and [length]
**where position is the position of the tag within the string given (integer)
*/
function bbGetTag($string,$bbcommand)
	{
	//full tag
	$tagInStrPos=stripos($string,"[$bbcommand");	
	$fullTag=stristr($string,"[$bbcommand");	

	$pos=stripos($fullTag,"[/$bbcommand]");
	if (!$pos)
		$pos=strlen($fullTag);

	$fullTag=substr($fullTag,0,$pos+strlen($bbcommand)+3);
	//full tag

	//parameter
	$pos2=stripos($fullTag,"]");
	if (!$pos2)
		$pos2=strlen($fullTag);		

	$parameter=substr($fullTag,2+strlen($bbcommand),$pos2-(2+strlen($bbcommand)));
	//parameter

	//content
	$content=substr($fullTag,$pos2+1,$pos-$pos2-1);
	//content
	
	//if no parameter given, the parameter will be the same as the content
	if ($pos2==strlen($bbcommand)+1)//no parameter
		$parameter=$content;
	
	if (!strlen($fullTag))
		return(false);
	
	return($age=array("parameter"=>$parameter, 
					  "content"=>$content, 
					  "position"=>$tagInStrPos,
					  "length"=>strlen($fullTag)
					  )
		  );
	}

//bb-decoder
function bbDecode($string,$naam)
	{
	$string=str_ireplace("[b]","<b>",$string);
	$string=str_ireplace("[/b]","</b>",$string);
	$string=str_ireplace("[i]","<i>",$string);
	$string=str_ireplace("[/i]","</i>",$string);
	$string=str_ireplace("[d]","<s>",$string);
	$string=str_ireplace("[/d]","</s>",$string);
	
	$string=str_ireplace("[htab]","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$string);
	$string=str_ireplace("[tab]","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$string);
	
	$string=str_ireplace("[6]","<div class='profiel_6'>",$string);
	$string=str_ireplace("[/6]","</div>",$string);
	$string=str_ireplace("[5]","<div class='profiel_5'>",$string);
	$string=str_ireplace("[/5]","</div>",$string);
	
	//target calculator
	while (substr_count($string,"[doel")>0)
		{
		$array_tag=bbGetTag($string,"doel");
		$array_tag["parameter"]=ucwords(strtolower($array_tag["parameter"]));
		
		$xpTarget=mysql_fetch_array($xptarget=mysql_query("select xp from xp_table where level='" . $array_tag["content"] . "'"));
		$xpTarget=$xpTarget["xp"];
		$lvlTarget=$array_tag["content"];
		getStats($naam,$stats);
		$xpNow=$stats[$array_tag["parameter"]]["exp"];
		$lvlNow=$stats[$array_tag["parameter"]]["level"];
		
		if ($lvlTarget==0)
			$lvlTarget="Max";
		
		$xpToGo=$xpTarget-$xpNow;
		if ($xpToGo<0)
			$xpToGo=0;
		
		$xpPercent=$xpNow/$xpTarget*100;
		if ($xpPercent>100)
			$xpPercent=100;
		if ($xpPercent<=0)
			$xpPercent=100;
		

		
		$addString="</div>
		<table class='profiel_table_doel' style='border-collapse:collapse'>
			<tr style='heigth:20px'>
				<td>" . $array_tag["parameter"] . "</td>
				<td rowspan='2'>" . number_format($xpPercent,2,",",".") . "%</td></tr>
			<tr style='heigth:20px'>
				<td class='bbcode_doel' style='border-left-width:1px; border-right-width:1px; padding-left:2px; padding-right:2px'>$lvlNow</td>
				<td class='bbcode_doel' style='width:" . $xpPercent*2 . "px; background-color:green'></td>
				<td class='bbcode_doel' style='width:" . (100-$xpPercent)*2 . "px; background-color:red'></td>
				<td class='bbcode_doel' style='border-left-width:1px; padding-left:2px; padding-right:2px'>$lvlTarget</td>
			</tr>
			<tr style='heigth:20px'>
				<td colspan='5'>" . number_format($xpToGo,0,",",".") . " XP left - " .  number_format($xpTarget,0,",",".") . " XP doel</td>
			</tr>
		</table><div class='profiel_p'>";
		
		$string=substr_replace($string,$addString,$array_tag["position"],$array_tag["length"]);
		}
	
	//hidden
	
	//url
	while (substr_count($string,"[link")>0)
		{
		$array_tag=bbGetTag($string,"link");
		
		if (substr_count($array_tag["parameter"],"/")>0)
			$string=substr_replace($string,"<a target='_blank' href='" . $array_tag["parameter"] . "'>" . $array_tag["content"] . "</a>",$array_tag["position"],$array_tag["length"]);
		else
			$string=substr_replace($string,"<a target='_blank' href='/toxic/account/leden/bestanden/" . str_replace(" ","_",$naam) . "/" . $array_tag["parameter"] . "'>" . $array_tag["content"] . "</a>",$array_tag["position"],$array_tag["length"]);
		}
	
	//image
	while (substr_count($string,"[afbeelding")>0)
		{
		$array_tag=bbGetTag($string,"afbeelding");
		
		if (substr_count($array_tag["content"],"/")>0)
			$string=substr_replace($string,"<img alt='' src='" . $array_tag["content"] . "' />",$array_tag["position"],$array_tag["length"]);
		else
			$string=substr_replace($string,"<img alt='' src='/toxic/account/leden/bestanden/" . str_replace(" ","_",$naam) . "/" . $array_tag["content"] . "' />",$array_tag["position"],$array_tag["length"]);
		}
		
	//verwijder empty tags
	$string=str_ireplace("<div class='profiel_h1'></div>","",$string);
	$string=str_ireplace("<div class='profiel_h2'></div>","",$string);
	$string=str_ireplace("<div class='profiel_p'></div>","",$string);
	
	//misc
	$string=str_ireplace("</div><div class='profiel_p'>","",$string);
	
	return($string);
	}