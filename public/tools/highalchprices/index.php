<?php
include("../../sjablonen/constanten.php");

function getgeprice($id) 
	{
    $url = "http://itemdb-rs.runescape.com/viewitem.ws?obj=".$id;
    $startat="<b>Market price:</b> ";
    $stopat="</span>";
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    $start=curl_exec($ch);
    curl_close($ch);
    $exploded=explode($startat,$start);
    $exploded=explode($stopat,$exploded[1]);
    $result=str_replace('<br />','',nl2br($exploded[0]));
    $result=str_replace(",","",$result);
	
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
	
if (isset($_POST["submit"]))
	{
	echo getgeprice($_POST["toevoegen"]);
	echo $_POST["toevoegen"];
	}	
	
if (isset($_GET["update"]))
	{
	$updated=false;
	$item=$_GET["update"];
	$item=mysql_real_escape_string($item);
	
	if ($item==0)
		{
		if ($mysql_items=mysql_query("select id from highalch"))
			{
			while ($mysql_item=mysql_fetch_array($mysql_items))
				{
				$item=$mysql_item["id"];
				$nieuwe_prijs=getgeprice($item);
				mysql_query("update highalch set geprijs='$nieuwe_prijs' where id='$item'");
				}
			$updated=true;
			}
		}
	else
		{
		if (mysql_fetch_array(mysql_query("select * from highalch where id='$item'")))
			{
			$nieuwe_prijs=getgeprice($item);
			if (mysql_query("update highalch set geprijs='$nieuwe_prijs' where id='$item'"))
				$updated=true;
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<?php
		include("../../sjablonen/metadata.txt");
		?>
		<title>Toxic - High-alch prices</title>
	</head>

	<body>

		<?php
		include("../../sjablonen/menu.php");
		?>

		<h1>High-alch prices</h1>

		<?php
		if (isset($updated))
			{
			if ($updated)
				echo "<p>Succesfully updated.</p>";
			else
				echo "<p>Couldn't update.</p>";
			}
		?>

		<table>
			<thead>
				<tr><td>Naam</td><td>GE-prijs</td><td>High-alch prijs</td><td>Verschil</td><td style='cursor:pointer' onclick='location.assign("?update=0")'>Update alles</td></tr>
			</thead>
			<tbody>
				<?php error_reporting(false);
				
				$i=1;
				$mysql_highalch=mysql_query("select * from highalch order by naam asc");
				while ($highalch=mysql_fetch_array($mysql_highalch))
					{
					$table[$i]=array(
					"id"=>$highalch["id"],
					"naam"=>$highalch["naam"],
					"geprijs"=>$highalch["geprijs"],
					"highalchprijs"=>$highalch["highalchprijs"],
					"verschil"=>$highalch["highalchprijs"]-$highalch["geprijs"]);
					$i+=1;
					}

				foreach($table as $table2)
					{
					echo "<tr><td>" .$table2["naam"]. "</td><td>" .$table2["geprijs"] . "</td><td>" .$table2["highalchprijs"] . "</td><td>" .$table2["verschil"]. "</td><td style='cursor:pointer' onclick='location.assign(\"?update=". $table2["id"] ."\")'>Update prijs</td></tr>";
					}
					
				?>
			</tbody>
		</table>
		
		<h2>Add an item</h2>
		
		<form action="/toxic/kit" method="post">
			Item-ID:<br />
			<input name="toevoegen" type="text" maxlength="10" /><br />
			<input name="submit" type="submit" value="Toevoegen" />
		</form>
		
		<?php
		if (isset($_POST["submit"]))
			{
			echo "<p>Item wasn't added, haven't created the system yet.</p>";
			}
			
		if (isset($_GET["update"]))
			{
			echo "<script type='text/javascript'>location.assign('index.php');</script>";
			}
			
		?>

	</body>

</html>
