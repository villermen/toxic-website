<?php
	$title1 = "Toxic - Teamspeak";
	require("../includes/pagestart.php");
?>

<h1>TeamSpeak</h1>

<img src="<?=$baseUrl?>teamspeak/logo.png" alt="teamspeak logo" />

<?php if ($_LANG != 2): ?>
    <p>
        Toxic's got it's own TeamSpeak 3 server.<br />
        <br />
        If you don't have TeamSpeak 3 installed on your computer, you can download it <a href='http://teamspeak.com/?page=downloads'>here</a>.<br />
        If you don't yet know what TeamSpeak is, information can be found on <a href='http://teamspeak.com/?page=home'>this page</a>.<br />
        <br />
        If you've installed TeamSpeak, you can direct connect to it by using the following link: <a href='ts3server://toxic.gotdns.com?port=10000'>Toxic server</a><br />
        If the link doesn't work for some reason, you can connect manually too.<br />
        In the connect window, input "toxic.gotdns.com" for the address and "10000" for the port.<br />
        The password is "test".
    </p>
<?php else: ?>
    <p>
        Toxic heeft zijn eigen TeamSpeak 3 server.<br />
        <br />
        Als je nog geen TeamSpeak 3 hebt kun je die vanaf <a href='http://teamspeak.com/?page=downloads'>deze pagina</a> downloaden.<br />
        Als je niet weet wat TeamSpeak is kun je <a href='http://teamspeak.com/?page=home'>hier</a> uitleg vinden.<br />
        <br />
        Als je TeamSpeak hebt geïnstalleerd is hier de link om er direct mee te verbinden: <a href='ts3server://toxic.gotdns.com?port=10000'>Toxic server</a><br />
        Werkt de link om de een of andere reden niet, dan kan je ook handmatig verbinden.<br />
        Typ bij het connect scherm bij address "toxic.gotdns.com" en bij port "10000".<br />
        Het wachtwoord is "test".
    </p>
<?php endif; ?>

<?php require("../includes/pageend.php"); ?>
