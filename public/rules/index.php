<?php
    $title1 = "Toxic - Rules";
    $title2 = "Toxic - Regels";
    require("../includes/pagestart.php");
?>

<?php if ($_LANG != 2): ?>
    <h1>Rules</h1>

    <h2>Joining</h2>
    <p>
        If you want to join the clan you must at least have a combat level of 100 or higher because of the combat-based events we organise.<br />
        Please introduce yourself to us in the clanchat "CC Toxic".<br />
        <br />
        We try to organize as many events as possible, often 2 events a week.<br />
        Try to be with as many events as possible, if you don't visit any events for a long time we can consider lowering your rank or an eventual kick (unless there is a reason supplied like sickness/holidays).
    </p>

    <h2>Kicks</h2>
    <p>In the clanchat we don't tolerate:</p>
    <ul>
        <li>Spam</li>
        <li>Racism</li>
        <li>nasty jokes</li>
    </ul>
    <p>
        A joke can be appreciated, but if someone tells you to stop, really stop.<br />
        We mostly kick after 2 warnings, but faster if you got kicked before.<br />
        <br />
        If it's crowded in the CC please only say loot you've received worth more than 100k or special items, otherwise the CC will get spammed.<br />
        <br />
        In case of trouble, or a kick that you don't know of why you got it: please contact one of the star-rank members.
    </p>

    <h2>Ranks</h2>
    <p>
        The ranksystem in the CC (clanchat):<br />
        <br />
        <img src='<?=$baseUrl?>includes/friend.png' alt='Friend' /> -  Recruit, an official member.<br />
        <img src='<?=$baseUrl?>includes/recruit.png' alt='Recruit' /> - A regularly active member.<br />
        <img src='<?=$baseUrl?>includes/corporal.png' alt='Corporal' /> - An active member that have played a lot of events with us.<br />
        <img src='<?=$baseUrl?>includes/sergeant.png' alt='Sergeant' /> - An excellent member, a member that have proven to be responsible enough to earn the right to kick.<br />
        <img src='<?=$baseUrl?>includes/lieutenant.png' alt='Lieutenant' /> - A member that can also lead events.<br />
        <img src='<?=$baseUrl?>includes/captain.png' alt='Captain' /> - A member that can discuss changes for the clansystem, and all the above mentioned.<br />
        <img src='<?=$baseUrl?>includes/general.png' alt='General' /> - A leader.<br />
        <br />
        There were lots of people asking for higher ranks.<br />
        We have created a rule that if you nag about getting a higher rank, your rank will be lowered.<br />
    </p>
<?php else: ?>
    <h1>Regels</h1>

    <h2>Joinen</h2>
    <p>
        Als je bij de clan wilt komen moet je in ieder geval een combat level van 100 hebben i.v.m. de combatevents die we houden.<br />
        Als je dat hebt kun je even een praatje komen maken in de clanchat "CC Toxic".<br />
        <br />
        We proberen zo vaak mogelijk events te houden, meestal 2 events per week.<br />
        Probeer aan zoveel mogelijk mee te doen, als je lang aan geeneen event meedoet (behalve bij uitzonderingen zoals vakantie/ziekte) kunnen we besluiten om je rank te verlagen of uiteindelijk een clankick.
    </p>

    <h2>Kicks</h2>
    <p>In de clanchat tolereren we geen:</p>
    <ul>
        <li>Spam</li>
        <li>Racisme</li>
        <li>gemene grappen</li>
    </ul>
    <p>
        Een grapje kan altijd maar als iemand zegt ophouden, ook echt doen.<br />
        We kicken meestal na 2 waarschuwingen, ben je al vaker gekickt dan soms eerder.<br />
        <br />
        In de CC als het druk is a.u.b. alleen loot van meer dan 100k of speciale items opnoemen, het wordt anders nogal spammend.<br />
        <br />
        In geval van problemen, of een kick waarvan jij denkt dat ie niet gepast was: even contact op nemen met een van de leden met een ster-rank.
    </p>

    <h2>Ranks</h2>
    <p>
        Het rankingsysteem voor in de CC (clanchat):<br />
        <br />
        <img src='<?=$baseUrl?>includes/friend.png' alt='Friend' /> -  Rekruut, een offici�el lid van de clan.<br />
        <img src='<?=$baseUrl?>includes/recruit.png' alt='Recruit' /> - Een regelmatig actief lid.<br />
        <img src='<?=$baseUrl?>includes/corporal.png' alt='Corporal' /> - Een actief, behulpzaam lid die met events mee doet van tijd tot tijd.<br />
        <img src='<?=$baseUrl?>includes/sergeant.png' alt='Sergeant' /> - Een uitmuntend lid, een lid die bewezen heeft verantwoordelijk genoeg te zijn om het recht te hebben mensen te kicken.<br />
        <img src='<?=$baseUrl?>includes/lieutenant.png' alt='Lieutenant' /> - Een lid die het vermogen heeft om events te leiden.<br />
        <img src='<?=$baseUrl?>includes/captain.png' alt='Captain' /> - Een lid die beslissingen kan voorstellen, en al het hierboven genoemde.<br />
        <img src='<?=$baseUrl?>includes/general.png' alt='General' /> - Een leider.<br />
        <br />
        Er werd veel gezeurd om hogere ranks in de clan.<br />
        We hebben nu de regel dat als je zeurt om een hogere rank, je juist een lagere zult krijgen.<br />
    </p>
<?php endif; ?>

<?php require("../includes/pageend.php"); ?>
