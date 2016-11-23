<?php
/**
 *    MOD                  : WM-2006/2014/EM-2016/WM-2018 Tippspiel
 *    file                 : wm2018_global.php
 *    copyright            : WM2006-Tippspiel © 2006 batida444
 *    copyright            : WM2014-Tippspiel © 2014 Viktor
 *    copyright            : EM2016-Tippspiel © 2016 @ kill0rz
 *    copyright            : WM2018-Tippspiel © 2018 @ kill0rz
 *    web                  : www.v-gn.de
 *    Boardversion         : Burning Board wBB 2.3
 */

$lang->load("WM2018");

$userwmtipp = 0;
$uservwmtipp = 0;
$userdatayes = 0;
$akttime = time();

$resultgruppen = $db->query("SELECT * FROM bb" . $n . "_wm2018_teams ORDER BY teamid ASC");
while ($rowgruppen = $db->fetch_array($resultgruppen)) {
	$allids2[] = $rowgruppen['teamid'];
	$allnames2[] = $rowgruppen['name'];
	$allflags2[] = $rowgruppen['flagge'];
}

$allusertippgameids2 = array();
$resultusertipps = $db->query("SELECT * FROM bb" . $n . "_wm2018_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' ORDER BY gameid ASC");
while ($rowusertipps = $db->fetch_array($resultusertipps)) {
	$allusertippgameids2[] = $rowusertipps['gameid'];
}

$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");

$fontcolor = substr($style['normalfontcolor'], 1, 6);
if (empty($fontcolor)) {
	$fontcolor = "000000";
}

$titlecolor = substr($style['tablecatbgcolor'], 1, 6);
$bgcolor = substr($style['tablebbgcolor'], 1, 6);
$bordercolor = substr($style['tablebbgcolor'], 1, 6);
$bordercolorebay = substr($style['tableabgcolor'], 1, 6);

if ($wm2018_options['ebay_cat'] != 0) {
	$ebay_cat = "&CategoryID={$wm2018_options['ebay_cat']}";
}

eval("\$wm2018_ebay = \"" . $tpl->get("wm2018_ebay") . "\";");
eval("\$wm2018_header = \"" . $tpl->get("wm2018_header") . "\";");
eval("\$wm2018_footer = \"" . $tpl->get("wm2018_footer") . "\";");

function getQuote($gameid) {
	// Original by Mr.Fisch, Anpassungen by kill0rz
	// berechnet die Tippquoten für das übergebene Spiel
	global $quote1, $quote2, $db;
	$quote1 = 0;
	$quote2 = 0;
	$minusanzahl = 0;

	$result_q = $db->query("SELECT * FROM bb" . $n . "_wm2018_usertipps WHERE gameid = " . $gameid . " ");
	while ($row = $db->fetch_array($result_q)) {
		if ($row['goals_1'] > $row['goals_2']) {
			$quote1++;
		} elseif ($row['goals_2'] > $row['goals_1']) {
			$quote2++;
		} else {
			$minusanzahl++;
		}

	}

	list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_wm2018_usertipps WHERE gameid = " . $gameid);

	$anzahl -= $minusanzahl;
	if ($anzahl > 0) {
		$quote1 = round(($quote1 / $anzahl) * 100, 0);
		$quote2 = round(($quote2 / $anzahl) * 100, 0);
	}
}

?>
