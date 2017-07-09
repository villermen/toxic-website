<?php
    $title1 = "Toxic - Account";
    require("../includes/pagestart.php");
?>

<h1>Leden panel</h1>

<h2>Account</h2>

<p>
    <?php if (isset($_GET["login"])): ?>
        <a href='<?=$baseUrl?>account/'>Log in &#60;verberg&#62;</a>
    <?php else: ?>
        <a href='<?=$baseUrl?>account/?login'>Log in</a>
    <?php endif; ?>
</p>

<?php if (isset($_GET["login"])): ?>
    <form class='account' method='post' action='<?=$baseUrl?>account/login.php'>
        Je gebruikersnaam:<br />
        <input type='text' name='naam' maxlength='12' size='12' /><br />
        <br />
        Je wachtwoord:<br />
        <input class='pass' type='password' name='wachtwoord' maxlength='12' size='12' /><input type='submit' value='Log In' style='margin-left:5px' />
    </form>
<?php endif; ?>

<p>
    <?php if (isset($_GET["nieuw"])): ?>
        <a href='<?=$baseUrl?>account/'>Maak een account aan &#60;verberg&#62;</a><br />
    <?php else: ?>
        <a href='<?=$baseUrl?>account/?nieuw'>Maak een account aan</a><br />
    <?php endif; ?>
</p>

<?php if (isset($_GET["nieuw"])): ?>
    <form class='account' method='post' action='<?=$baseUrl?>account/nieuw.php'>
        Je gebruikersnaam: (maximaal 12 tekens)<br />
        <input type='text' name='naam' maxlength='12' size='12' /><br />
        <br />
        Je wachtwoord: (maximaal 12 tekens)<br />
        <input class='pass' type='password' name='wachtwoord' maxlength='12' size='12' /><br />
        <br />
        De opgekregen toegangscode<br />
        <input class='pass' type='password' name='code' maxlength='4' size='4' /><input type='submit' value='Maak Account' style='margin-left:5px'/>
    </form>
<?php endif; ?>

<p>
    <?php if (isset($_GET["verander_naam"])): ?>
        <a href='<?=$baseUrl?>account/'>Verander je gebruikersnaam &lt;verberg&gt;</a>
    <?php else: ?>
        <a href='<?=$baseUrl?>account/?verander_naam'>Verander je gebruikersnaam</a>
    <?php endif; ?>
</p>

<?php if (isset($_GET["verander_naam"])): ?>
    <form class='account' method='post' action='<?=$baseUrl?>account/verander_naam.php'>
        Nieuwe naam:<br />
        <input type='text' name='naam' maxlength='12' size='12' /><br />
        <br />
        Je wachtwoord:<br />
        <input class='pass' type='password' name='wachtwoord' maxlength='12' size='12' /><input type='submit' value='Verander' style='margin-left:5px' />
    </form>
<?php endif; ?>

<?php
/*
echo "<p>";
if (isset($_GET["verander_pass"]))
	echo "<a href='index.php'>Verander je wachtwoord &#60;verberg&#62;</a><br />";
else
	echo "<a href='index.php?verander_pass'>Verander je wachtwoord</a><br />";
echo "</p>";

if (isset($_GET["verander_pass"]))
		echo 	"<form class='account' method='post' action='verander_pass.php'>
					Je wachtwoord nu:<br />
					<input class='pass' type='password' name='wachtwoord_oud' maxlength='12' size='12' /><br />
					<br />
					Je nieuwe wachtwoord: (maximaal 12 tekens)<br />
					<input class='pass' type='password' name='wachtwoord_nieuw1' maxlength='12' size='12' /><br />
					<br />
					Hertyp wachtwoord:<br />
					<input class='pass' type='password' name='wachtwoord_nieuw2' maxlength='12' size='12' /><input type='submit' value='Verander' style='margin-left:5px' />
				</form>";
				
*/		
?>

<?php require("../includes/pageend.php"); ?>
