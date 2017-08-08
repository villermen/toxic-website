<?php
    require_once("tekstfuncties.php");
    require_once("highscorefuncties.php");

    $sqlite = new SQLite3(__DIR__."/../../database.sqlite3", SQLITE3_OPEN_READONLY);

    // Since I created this site with multiple front controllers on an absolute root domain I need to do some magic to find out what the base path is
    // The following code will subtract a certain amount of directories from the requested path to get the base path
    // The amount of directories is based on the difference between the base directory and the directory of the index
    $baseDirectory = str_replace("\\", "/", dirname(__DIR__)) . "/";
    $indexControllerDirectory = str_replace("\\", "/", dirname(realpath($_SERVER["SCRIPT_FILENAME"]))) . "/";
    $relativePathToIndex = substr($indexControllerDirectory, strlen($baseDirectory));
    $relativePathToIndexParts = substr_count($relativePathToIndex, "/");
    $scriptNameArray = array_filter(explode("/", str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"]))));
    $basePathArray = $relativePathToIndexParts
        ? array_slice($scriptNameArray, 0, -$relativePathToIndexParts)
        : $scriptNameArray;
    $basePath = "/" . implode("/", $basePathArray);

    if ($basePath !== "/") {
        $basePath .= "/";
    }

    $_LANG = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : 1;

    if (isset($title2) and $_LANG == 2) {
        $title = $title2;
    } elseif (isset($title1)) {
        $title = $title1;
    } else {
        $title = "Toxic";
    }

    // Safed-up account stuff from sjablonen/constanten.php (Which might have been in the process of being ported?)
    $login = false;
    if (isset($_COOKIE["id"])) {
        $statement = $sqlite->prepare("SELECT * FROM leden WHERE login_id=:loginId");
        $statement->bindValue("loginId", $_COOKIE["id"]);

        $statement = $statement->execute();

        if ($statement) {
            $login = $statement->fetchArray(SQLITE3_ASSOC);
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Villermen" />
        <meta name="description" content="De clansite van Toxic, een RuneScape clan" />
        <meta name="keywords" content="toxic,clan,runescape,t0xic" />
        <meta name="robots" content="index,follow" />
        <link rel="shortcut icon" type="image/x-icon" href="<?=$basePath?>favicon.ico" />
        <script type="text/javascript" src="<?=$basePath?>includes/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=$basePath?>includes/standard.css" />

        <script type="text/javascript">
            function mouseOverButton(object) {
                object.style.backgroundImage="url('<?=$basePath?>includes/button2.png')";
                object.style.color="gray";
            }

            function mouseOutButton(object) {
                object.style.backgroundImage="url('<?=$basePath?>includes/button.png')";
                object.style.color="black";
            }

            function goto(url) {
                location.assign(url);
            }
        </script>
        <title><?php echo $title; ?></title>
    </head>

    <body>
        <img src="<?=$basePath?>includes/banner.png" alt="" class="menu" />

        <table class="menu">
            <tr>
                <?php
                    if ($_LANG != 2) {
                        $home = "Home";
                        $members = "Members";
                        $events = "Events";
                        $rules = "Rules";
                        $gallery = "Gallery";
                        $tools = "Tools";
                        $teamspeak = "Teamspeak";
                        $account = "Account";
                        echo "<td><a href='{$basePath}langswap.php' title='bekijk deze pagina in het nederlands'><img src='{$basePath}includes/nederlands.png' /></a></td>";
                    } else {
                        $home = "Home";
                        $members = "Leden";
                        $events = "Evenementen";
                        $rules = "Regels";
                        $gallery = "Afbeeldingen";
                        $tools = "Tools";
                        $teamspeak = "Teamspeak";
                        $account = "Account";
                        echo "<td><a href='{$basePath}langswap.php' title='view this page in english'><img src='{$basePath}includes/english.png' /></a></td>";
                    }
                ?>
                
                <td class="menu" onclick="goto('<?=$basePath?>')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$home?></td>
                <td class="menu" onclick="goto('<?=$basePath?>members/?pagina=1')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$members?></td>
                <td class="menu" onclick="goto('<?=$basePath?>events')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$events?></td>
                <td class="menu" onclick="goto('<?=$basePath?>rules')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$rules?></td>
                <td class="menu" onclick="goto('<?=$basePath?>gallery')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$gallery?></td>
                <td class="menu" onclick="goto('<?=$basePath?>tools')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$tools?></td>
                <td class="menu" onclick="goto('<?=$basePath?>teamspeak')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$teamspeak?></td>
                <td class="menu" onclick="goto('<?=$basePath?>account')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$account?></td>
            </tr>
        </table>

<?php if ($login): ?>
        <table class='accountmenu' summary='Links Account'>
            <tr>
                <td class='accountmenu'><a class='accountmenu' href='<?=$basePath?>account/'>Account</a></td>
                <td class='accountmenu'><a class='accountmenu' href='<?=$basePath?>account/aanpassen/'>Aanpassen</a></td>
                <td class='accountmenu'><a class='accountmenu' href='<?=$basePath?>account/leden/'>Leden</a></td>
                <td class='accountmenu'><a class='accountmenu' style='color:red; margin-right:0px;' href='<?=$basePath?>account/berichten/'>Berichten</a>

                    <?php if ($login): ?>
                <td class='accountmenu_login'>Ingelogd als <?=$login["naam"]?> &nbsp;<a href='<?=$basePath?>account/loguit.php'>&lt;log uit&gt;</a></td>
                <?php endif; ?>
            </tr>
        </table>
<?php endif; ?>
