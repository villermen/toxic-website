<?php
    $sqlite = new SQLite3(__DIR__."/../../database.sqlite3");

    // Since I created this site with multiple front controllers on an absolute root domain I need to do some magic to find out what the relative base url is
    $baseDirectory = dirname(__DIR__);
    $relativeFrontControllerDirectory = dirname(str_replace($baseDirectory, "", $_SERVER["SCRIPT_FILENAME"]));
    $relativeFrontControllerDirectoryParts = array_filter(explode("/", str_replace("\\", "/", $relativeFrontControllerDirectory)));
    $baseUrl = str_repeat("../", count($relativeFrontControllerDirectoryParts));

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
        $statement = $sqlite->prepare("SELECT naam, privileges, login_id FROM leden WHERE login_id=:loginId");
        $statement->bindValue("loginId", $_COOKIE["id"]);
        $login = $statement->execute()->fetchArray(SQLITE3_ASSOC);
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
        <link rel="shortcut icon" type="image/x-icon" href="<?=$baseUrl?>favicon.ico" />
        <script type="text/javascript" src="<?=$baseUrl?>includes/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>includes/standard.css" />

        <script type="text/javascript">
            function mouseOverButton(object) {
                object.style.backgroundImage="url('<?=$baseUrl?>includes/button2.png')";
                object.style.color="gray";
            }

            function mouseOutButton(object) {
                object.style.backgroundImage="url('<?=$baseUrl?>includes/button.png')";
                object.style.color="black";
            }

            function goto(url) {
                location.assign(url);
            }
        </script>
        <title><?php echo $title; ?></title>
    </head>

    <body>
        <img src="<?=$baseUrl?>includes/banner.png" alt="" class="menu" />

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
                        echo "<td><a href='{$baseUrl}langswap.php' title='bekijk deze pagina in het nederlands'><img src='{$baseUrl}includes/nederlands.png' /></a></td>";
                    } else {
                        $home = "Home";
                        $members = "Leden";
                        $events = "Evenementen";
                        $rules = "Regels";
                        $gallery = "Afbeeldingen";
                        $tools = "Tools";
                        $teamspeak = "Teamspeak";
                        $account = "Account";
                        echo "<td><a href='{$baseUrl}langswap.php' title='view this page in english'><img src='{$baseUrl}includes/english.png' /></a></td>";
                    }
                ?>
                
                <td class="menu" onclick="goto('<?=$baseUrl?>')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$home?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>members/?pagina=1')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$members?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>events')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$events?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>rules')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$rules?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>gallery')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$gallery?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>tools')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$tools?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>teamspeak')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$teamspeak?></td>
                <td class="menu" onclick="goto('<?=$baseUrl?>account')" onmouseover="mouseOverButton(this)" onmouseout="mouseOutButton(this)"><?=$account?></td>
            </tr>
        </table>

<?php if ($login): ?>
        <table class='accountmenu' summary='Links Account'>
            <tr>
                <td class='accountmenu'><a class='accountmenu' href='<?=$baseUrl?>account/'>Account</a></td>
                <td class='accountmenu'><a class='accountmenu' href='<?=$baseUrl?>account/aanpassen/'>Aanpassen</a></td>
                <td class='accountmenu'><a class='accountmenu' href='<?=$baseUrl?>account/leden/'>Leden</a></td>
                <td class='accountmenu'><a class='accountmenu' style='color:red; margin-right:0px;' href='<?=$baseUrl?>account/berichten/'>Berichten</a>

                    <?php if ($login): ?>
                <td class='accountmenu_login'>Ingelogd als <?=$login["naam"]?> &nbsp;<a href='<?=$baseUrl?>account/loguit.php'>&lt;log uit&gt;</a></td>
                <?php endif; ?>
            </tr>
        </table>
<?php endif; ?>
