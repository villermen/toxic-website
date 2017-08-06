<?php
    $title1 = "Toxic - members";
    $title2 = "Toxic - Leden";
    require("../includes/pagestart.php");
?>

<?php if ($_LANG != 2): ?>
    <h1>Members</h1>

    <p style="color:red">
        I used the memberlist, stats and system from an earlier date as I updated the page to an auto-highscore-retrieve script later on.
        (this one is an early test from december 2009, the real thing back then already looked better than this)
    </p>

    <table class="leden" cellspacing="0">
        <tr>
            <td class="leden">Name</td>
<?php else: ?>
    <h1>Leden</h1>

    <p style="color:red">
        Ik heb de ledenlijst, stats en het systeem van een eerder moment gebruikt omdat ik de pagina later omgebouwd heb in iets dat de highscores direct uit de RS database haalt.
        (dit is een vroege test van december 2009, het zag er zelfs toen al beter uit dan dit)
    </p>

    <table class="leden" cellspacing="0">
        <tr>
            <td class="leden">Naam</td>
<?php endif; ?>

            <td class="leden">Total</td>
            <td class="leden">Att</td>
            <td class="leden">Def</td>
            <td class="leden">Str</td>
            <td class="leden">Hp</td>
            <td class="leden">Range</td>
            <td class="leden">Pray</td>
            <td class="leden">Mage</td>
            <td class="leden">Cook</td>
            <td class="leden">Wc</td>
            <td class="leden">Fletch</td>
            <td class="leden">Fish</td>
            <td class="leden">Fm</td>
            <td class="leden">Craft</td>
            <td class="leden">Smith</td>
            <td class="leden">Mining</td>
            <td class="leden">Herb</td>
            <td class="leden">Agil</td>
            <td class="leden">Thiev</td>
            <td class="leden">Slay</td>
            <td class="leden">Farm</td>
            <td class="leden">Rc</td>
            <td class="leden">Hunter</td>
            <td class="leden">Construct</td>
            <td class="leden">Summon</td>
        </tr>

<?php
    $file = fopen("statsdb.txt","r");

    while (!feof($file))
    {
        for ($n=1; $n<=27; $n++)
        {
            $str = fgetc($file);
            $char = null;

            while ($char != "," && $char != ";")
            {
                $str .= $char;
                $char = fgetc($file);

                if ($char === false) {
                    break 2;
                }
            }

            if ($n == 1) {
                echo "<tr>";
                switch ($str) {
                    case "leider":
                        echo "<td class='leden'><img src='{$basePath}members/owner.png' alt='Leider' class='leden' />";
                        break;
                    case "recruut":
                        echo "<td class='leden'><img src='{$basePath}members/recruit.png' alt='Recruut' class='leden' />";
                        break;
                    case "generaal":
                        echo "<td class='leden'><img src='{$basePath}members/general.png' alt='Generaal' class='leden' />";
                        break;
                    case "luitenant":
                        echo "<td class='leden'><img src='{$basePath}members/lieutenant.png' alt='Luitenant' class='leden' />";
                        break;
                    default:
                        echo "<td class='leden'>" . $naam . "</td>";
                        break;
                }
            } elseif ($n == 2) {
                echo $str . "</td>";
            } else {
                if ($str == -1)
                    echo "<td class='leden' style='color:red'>" . $str . "</td>";
                elseif ($str >= 90 && $str < 99)
                    echo "<td class='leden' style='color:green'>" . $str . "</td>";
                elseif ($str == 99)
                    echo "<td class='leden' style='color:lime'>" . $str . "</td>";
                else
                    echo "<td class='leden'>" . $str . "</td>";
            }
        }

        echo "</tr>";
    }

    fclose($file);

    echo "</table>";
?>

<?php if ($_LANG != 2): ?>
    <p>
        Scores are stored in a file that can be updated from now on.<br />
        So whenever you think the list is not up-to-date enough all you have to do is click this link: <a href="<?=$basePath?>members/update.php">update</a>
    </p>
<?php else: ?>
    <p>
        De scores worden vanaf nu opgeslagen in een bestand dat via een link geupdate kan worden.<br />
        Dus als je het niet up-to-date genoeg vind hoef je alleen maar op deze link te klikken: <a href="<?=$basePath?>members/update.php">update</a>
    </p>
<?php endif; ?>

<?php require("../includes/pageend.php"); ?>
