<?php error_reporting(false); //retrieve requested page

session_start();
$_SESSION["page"]=$_GET["page"];

$notFound=false;
switch ($_GET["page"])
	{
	case "home":
		$include="content/home.htm";
		break;
	case "join":
		$include="content/joinen.htm";
		break;
	default:
		$notFound=true;
		break;
	}

if ($notFound or !include($include))
	echo "404 - De pagina kon niet worden gevonden.<br />
	<img src='404.png' title='404 - pagina niet gevonden' />";	
	
?>





