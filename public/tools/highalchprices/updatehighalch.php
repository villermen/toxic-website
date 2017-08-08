<?php

exit("I don't work no more.");

function getgeprice($id) 
	{
    $url = "http://itemdb-rs.runescape.com/viewitem.ws?obj=".$id;
    $startat="<b>Market price:</b> ";
    $stopat="</span>";
    $ch=curl_init();
    $timeout=5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $start=curl_exec($ch);
    curl_close($ch);
    $exploded=explode($startat,$start);
    $exploded=explode($stopat,$exploded[1]);
    $result=str_replace('<br />','',nl2br($exploded[0]));
    
	if (stristr($result,"k"))
		{
		$result=str_ireplace("k","",$result);
		$result=$result*1000;
		}
	elseif (stristr($result,"m"))
		{
		$result=str_ireplace("m","",$result);
		$result=$result*1000000;
		}
	
	return $result;
	}
	
echo getgeprice(11696);

?> 
