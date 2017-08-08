<?php

require_once("highscorefuncties.php");


function profielPagina()
{
    ob_start();



    return ob_get_clean();
}

/**
 * @param string $string
 * @param bool $lineBreaks
 * @return string
 */
function htmlEncode($string, $lineBreaks = false)
{
    $string = trim($string);
    $string = htmlspecialchars($string);

    if (!$lineBreaks) {
        $string = str_ireplace(["\r\n", "\n", "\r"], "<br />", $string);
    }

    return $string;
}

/**
 * Returns an array from the first bb-tag named $bbcommand (a string)
 * array is coded like this: $array["parameter"],["content"], [position] and [length]
 * where position is the position of the tag within the string given (integer)
 *
 * @param string $string
 * @param $bbcommand
 * @return array|bool
 */
function bbGetTag($string, $bbcommand)
{
    //full tag
    $tagInStrPos = stripos($string, "[$bbcommand");
    $fullTag = stristr($string, "[$bbcommand");

    $pos = stripos($fullTag, "[/$bbcommand]");
    if (!$pos)
        $pos = strlen($fullTag);

    $fullTag = substr($fullTag, 0, $pos + strlen($bbcommand) + 3);
    //full tag

    //parameter
    $pos2 = stripos($fullTag, "]");
    if (!$pos2)
        $pos2 = strlen($fullTag);

    $parameter = substr($fullTag, 2 + strlen($bbcommand), $pos2 - (2 + strlen($bbcommand)));
    //parameter

    //content
    $content = substr($fullTag, $pos2 + 1, $pos - $pos2 - 1);
    //content

    //if no parameter given, the parameter will be the same as the content
    if ($pos2 == strlen($bbcommand) + 1)//no parameter
        $parameter = $content;

    if (!strlen($fullTag))
        return (false);

    return ($age = array("parameter" => $parameter,
        "content" => $content,
        "position" => $tagInStrPos,
        "length" => strlen($fullTag)
    )
    );
}

/**
 * Parse text with BB-codes into HTML.
 *
 * @param $string
 * @param $naam
 * @return mixed
 */
function bbDecode($string, $naam)
{
    global $xpTable;

    $string = htmlEncode($string);

    $string = str_ireplace("[b]", "<b>", $string);
    $string = str_ireplace("[/b]", "</b>", $string);
    $string = str_ireplace("[i]", "<i>", $string);
    $string = str_ireplace("[/i]", "</i>", $string);
    $string = str_ireplace("[d]", "<s>", $string);
    $string = str_ireplace("[/d]", "</s>", $string);

    $string = str_ireplace("[htab]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $string);
    $string = str_ireplace("[tab]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $string);

    $string = str_ireplace("[6]", "<div class='profiel_6'>", $string);
    $string = str_ireplace("[/6]", "</div>", $string);
    $string = str_ireplace("[5]", "<div class='profiel_5'>", $string);
    $string = str_ireplace("[/5]", "</div>", $string);

    // Target calculator
    while (stripos($string, "[doel") !== false) {
        $array_tag = bbGetTag($string, "doel");
        $array_tag["parameter"] = ucwords(strtolower($array_tag["parameter"]));

        $xpTarget = $xpTable[$array_tag["content"]];
        $lvlTarget = $array_tag["content"];
        $stats = getStats($naam);

        $xpNow = $stats ? $stats[$array_tag["parameter"]]["exp"] : 0;
        $lvlNow = $stats ? $stats[$array_tag["parameter"]]["level"] : 0;

        if (!$lvlTarget) {
            $lvlTarget = "Max";
        }

        $xpToGo = $xpTarget - $xpNow;
        if ($xpToGo < 0) {
            $xpToGo = 0;
        }

        $xpPercent = 100 / $xpTarget * $xpNow;
        if ($xpPercent > 100) {
            $xpPercent = 100;
        }
        if ($xpPercent < 0) {
            $xpPercent = 0;
        }

        $addString = "</div>
		<table class='profiel_table_doel' style='border-collapse:collapse'>
			<tr style='heigth:20px'>
				<td>" . $array_tag["parameter"] . "</td>
				<td rowspan='2'>" . number_format($xpPercent, 2, ",", ".") . "%</td></tr>
			<tr style='heigth:20px'>
				<td class='bbcode_doel' style='border-left-width:1px; border-right-width:1px; padding-left:2px; padding-right:2px'>$lvlNow</td>
				<td class='bbcode_doel' style='width:" . $xpPercent * 2 . "px; background-color:green'></td>
				<td class='bbcode_doel' style='width:" . (100 - $xpPercent) * 2 . "px; background-color:red'></td>
				<td class='bbcode_doel' style='border-left-width:1px; padding-left:2px; padding-right:2px'>$lvlTarget</td>
			</tr>
			<tr style='heigth:20px'>
				<td colspan='5'>" . number_format($xpToGo, 0, ",", ".") . " XP left - " . number_format($xpTarget, 0, ",", ".") . " XP doel</td>
			</tr>
		</table><div class='profiel_p'>";

        $string = substr_replace($string, $addString, $array_tag["position"], $array_tag["length"]);
    }

    // Hidden

    // URL
    while (stripos($string, "[link") !== false) {
        $array_tag = bbGetTag($string, "link");

        if (stripos($array_tag["parameter"], "/") !== false) {
            $string = substr_replace($string, "<a target='_blank' href='" . $array_tag["parameter"] . "'>" . $array_tag["content"] . "</a>", $array_tag["position"], $array_tag["length"]);
        } else {
            $string = substr_replace($string, "<a target='_blank' href='/toxic/account/leden/bestanden/" . str_replace(" ", "_", $naam) . "/" . $array_tag["parameter"] . "'>" . $array_tag["content"] . "</a>", $array_tag["position"], $array_tag["length"]);
        }
    }

    // Image
    while (stripos($string, "[afbeelding") !== false) {
        $array_tag = bbGetTag($string, "afbeelding");

        if (stripos($array_tag["content"], "/") !== false) {
            $string = substr_replace($string, "<img src='" . $array_tag["content"] . "' />", $array_tag["position"], $array_tag["length"]);
        } else {
            $string = substr_replace($string, "<img src='bestanden/" . str_replace(" ", "_", $naam) . "/" . $array_tag["content"] . "' />", $array_tag["position"], $array_tag["length"]);
        }
    }

    // Verwijder empty tags
    $string = str_ireplace("<div class='profiel_h1'></div>", "", $string);
    $string = str_ireplace("<div class='profiel_h2'></div>", "", $string);
    $string = str_ireplace("<div class='profiel_p'></div>", "", $string);

    // Misc
    $string = str_ireplace("</div><div class='profiel_p'>", "", $string);

    return $string;
}
