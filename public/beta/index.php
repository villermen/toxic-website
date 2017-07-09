<?php error_reporting(false); //load last page if session still active

session_start();
if (isset($_SESSION["page"]))
	$lastPage=$_SESSION["page"];
else
	$lastPage="home";

?>

<html>
	<head>
		<title>Layout testsite toxic-clan.nl</title>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<link rel="stylesheet" type="text/css" href="standard.css">
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript">
			function loadContent(page)
				{
				$("#content").fadeOut(0,function()
					{
					$("#content").html("<img src='loading.gif' />");
					$.get("contentloader.php?page="+page,function(fetchedContent)
						{
						$("#content").html(fetchedContent);
						$("#content").fadeIn(500);
						});
					});
				}
		</script>
	<head>
	
	<body>
		<table id="maintable" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td id="header" colspan="2" style="height:200px">
					<!--Header (login form in balk aan de onderkant van header, eventuele stats in zelfde balk) background-image (niet img)-->
				</td>
			</tr>
			
			<tr>
				<td id="navbar">
					<img class="menuitem1" onclick="javascript:loadContent('home')" src="nav_home.png" /><br />
					<img class="menuitem1" onclick="javascript:loadContent('leden')" src="nav_leden.png" /><br />
					<img class="menuitem1" onclick="location.assign('http://www.phpbb.com/styles/demo/3.0/index.php?style_id=655')" src="nav_forum.png" /><br />
					<img class="menuitem1" onclick="javascript:loadContent('join')" src="nav_joinen.png" /><br />
				</td>
				
				<td id="content"></td>
			</tr>
		</table>
		
		<?php error_reporting(false); //load home or last page
		
		echo "<script type='text/javascript'>loadContent(\"$lastPage\")</script>";
		
		?>
	</body>
</html>