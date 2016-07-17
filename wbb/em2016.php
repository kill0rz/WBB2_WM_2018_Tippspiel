<?php
/**
 *    MOD                  : WM-2006/2014/EM-2016 Tippspiel
 *    file                 : em2016.php
 *    copyright            : WM2006-Tippspiel © 2006 batida444
 *    copyright            : WM2014-Tippspiel © 2014 Viktor
 *    copyright            : EM2016-Tippspiel © 2016 @ kill0rz
 *    web                  : www.v-gn.de
 *    Boardversion         : Burning Board wBB 2.3
 */

$filename = "em2016.php";

require "./global.php";
include "./em2016_global.php";
$lang->load("EM2016");

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
} else {
	$action = "index";
}

if ($em2016_options['em2016aktiv'] == 0 || !$wbbuserdata['can_em2016_see']) {
	redirect($lang->get("LANG_EM2016_PHP_1"), $url = "index.php" . $SID_ARG_1ST);
}

$em2016userdata = $db->query_first("SELECT userid,tipp_em,tipp_vem FROM bb" . $n . "_em2016_userpunkte WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
if ($em2016userdata['tipp_em'] != 0) {
	$useremtipp = $em2016userdata['tipp_em'];
}

if ($em2016userdata['tipp_vem'] != 0) {
	$uservemtipp = $em2016userdata['tipp_vem'];
}

if (!empty($em2016userdata['userid'])) {
	$userdatayes = 1;
}

if ($em2016_options['gh_aktiv'] == 1) {
	$waehrung = $db->query_first("SELECT waehrung FROM bb" . $n . "_guthaben");
	$waehrung = $waehrung['waehrung'];
}

/*
//Reset Tageswertung 1x am Tag
if ($em2016_options['lasttageswertungreset'] != date("d")) {
// update reset-Datum
$db->query("UPDATE bb" . $n . "_em2016_options SET lasttageswertungreset='" . date("d") . "';");

// reset tageswertung
$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_vortag");
$db->query("CREATE TABLE bb" . $n . "_em2016_vortag (userid int(5), punkte int(10), pos int(3) default NULL auto_increment, PRIMARY KEY (pos));");
$db->query("ALTER TABLE bb" . $n . "_em2016_vortag ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;");
$db->query("ALTER TABLE bb" . $n . "_em2016_vortag ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;");
$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_em2016_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, ((tipps_richtig+tipps_tendenz)/tipps_falsch) DESC,tipps_gesamt DESC  Limit 0,{$em2016_options['topuser']}");

while ($row_topuser = $db->fetch_array($result_topuser)) {
//insert values vortag
$em2016_rank_merk = $em2016_rank_merk + 1;
if ($em2016_punkte_merk != $row_topuser['punkte']) {
$em2016_rank = $em2016_rank_merk;
$em2016_punkte_merk = $row_topuser['punkte'];
}
$db->query("INSERT INTO bb" . $n . "_em2016_vortag (userid, punkte, pos) VALUES ('" . $row_topuser['userid'] . "', '" . $row_topuser['punkte'] . "', '" . $em2016_rank . "');");
}
}*/

$lastgame4emtipp = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . intval($em2016_options['lastgame4emtipp']) . "'");
$lastgamedate = formatdate($wbbuserdata['dateformat'], $lastgame4emtipp['datetime']);
$lastgametime = formatdate($wbbuserdata['timeformat'], $lastgame4emtipp['datetime']);
// ++++++++++++++++++
// +++ Startseite +++
// ++++++++++++++++++
if ($action == "index") {
	// FIFA News Anfang
	if ($em2016_options['showrssnews'] == 1) {
		$count = "0";
		$newsem2016total = "";
		$feedurl = "http://de.fifa.com/worldcup/news/rss.xml";
		if ($em2016_options['showrssnews_method'] == "0") {
			$data = file_get_contents($feedurl);
		} else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $feedurl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch);
			curl_close($ch);
		}
		preg_match_all("/<item>(.+)<\/item>/sU", $data, $items);
		foreach ($items[1] as $item) {
			$count++;
			if ($count <= $em2016_options['rssnews']) {
				preg_match("/<title>(.+)<\/title>/U", $item, $title);
				preg_match("/<link>(.+)<\/link>/U", $item, $link);
				$link1 = 'http://de.fifa.com' . $link[1];
				// $link1 = $link[1];
				// $link1 = substr("$link1", 9);
				// $link1 = substr("$link1", 0, - 3);
				$title1 = $title[1];
				$title1 = substr("$title1", 9);
				$title1 = substr("$title1", 0, -3);
				$title1 = utf8_decode("$title1");
				$title2 = $title1;
				if (wbb_strlen($title1) > 50) {
					$title1 = wbb_substr($title1, 0, 50) . "...";
				}

				$newsem2016total .= "&raquo; <a href=\"{$link1}\" target=\"_blank\" title=\"{$title2}\">{$title1}</a><br />";
			}
		}
	}
	// FIFA News Ende
	// Persönliche Box Anfang
	if ($wbbuserdata['userid']) {
		$result_userdata = $db->query_first("SELECT * FROM bb" . $n . "_em2016_userpunkte WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		if (!$result_userdata['tipps_gesamt']) {
			$tippsgesamt = $lang->items['LANG_EM2016_PHP_2'];
		} else {
			$tippsgesamt = "<b><a href=\"em2016.php?action=showusertippsdetail&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\">{$result_userdata['tipps_gesamt']}</a></b>";
		}
		eval("\$lang->items['LANG_EM2016_TPL_INDEX_4'] = \"" . $lang->get4eval("LANG_EM2016_TPL_INDEX_4") . "\";");
	}
	// Persönliche Box Ende
	// Next X Games Anfang
	$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_em2016_spiele WHERE datetime > '" . intval($akttime) . "' ORDER BY datetime ASC Limit 0,{$em2016_options['nextxgames']}");
	while ($row_nextgames = $db->fetch_array($result_nextgames)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
		$gamedate = strtr($gamedate, $replace_datum_komma);
		$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

		$checkgame1 = $row_nextgames['team_1_id']{
			0};
		$checkgame2 = $row_nextgames['team_2_id']{
			0};
		if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "D") {
			$check1 = explode('-', $row_nextgames['team_1_id']);
			if ($check1[1] == "A" || $check1[1] == "B" || $check1[1] == "C" || $check1[1] == "D" || $check1[1] == "E" || $check1[1] == "F") {
				$tabelle = $lang->items['LANG_EM2016_PHP_5'];
			} else {
				$tabelle = $lang->items['LANG_EM2016_PHP_7'];
			}

			if ($check1[0] == "W") {
				$teamname1 = $lang->items['LANG_EM2016_PHP_11'];
			}

			if ($check1[0] == "S") {
				$teamname1 = $lang->items['LANG_EM2016_PHP_12'];
			}

			if ($check1[0] == "D") {
				$teamname1 = $lang->items['LANG_EM2016_PHP_13'];
			}

			$teamname1 .= "&nbsp;{$tabelle}&nbsp;{$check1[1]}";
			$name1 = $teamname1;
			$flagge1 = "spacer.gif";
		}
		if ($checkgame2 == "W" || $checkgame2 == "S" || $checkgame2 == "D") {
			$check2 = explode('-', $row_nextgames['team_2_id']);
			if ($check2[1] == "A" || $check2[1] == "B" || $check2[1] == "C" || $check2[1] == "D" || $check2[1] == "E" || $check2[1] == "F") {
				$tabelle = $lang->items['LANG_EM2016_PHP_5'];
			} else {
				$tabelle = $lang->items['LANG_EM2016_PHP_7'];
			}

			if ($check2[0] == "W") {
				$teamname2 = $lang->items['LANG_EM2016_PHP_11'];
			}

			if ($check2[0] == "S") {
				$teamname2 = $lang->items['LANG_EM2016_PHP_12'];
			}

			if ($check2[0] == "D") {
				$teamname2 = $lang->items['LANG_EM2016_PHP_13'];
			}

			$teamname2 .= "&nbsp;{$tabelle}&nbsp;$check2[1]";
			$name2 = $teamname2;
			$flagge2 = "spacer.gif";
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if ($row_nextgames['team_1_id'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = "<a href=\"em2016.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
				$flagge1 = $allflags2[$i];
			}
			if ($row_nextgames['team_2_id'] == $allids2[$i]) {
				$teamname2 = $allnames2[$i];
				$name2 = "<a href=\"em2016.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
				$flagge2 = $allflags2[$i];
			}
		}

		//mf Quote
		$quote1 = 0;
		$quote2 = 0;
		$minusanzahl = 0;

		$result_q = $db->query("SELECT * FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row_nextgames['gameid']);
		while ($row = $db->fetch_array($result_q)) {
			if ($row['goals_1'] > $row['goals_2']) {
				$quote1++;
			} elseif ($row['goals_2'] > $row['goals_1']) {
				$quote2++;
			} else {
				$minusanzahl++;
			}

		}

		list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row_nextgames['gameid']);

		$anzahl -= $minusanzahl;
		if ($anzahl > 0) {
			$quote1 = round(($quote1 / $anzahl) * 100, 0);
			$quote2 = round(($quote2 / $anzahl) * 100, 0);
		}
		//!mf Quote

		eval("\$em2016_nextgames .= \"" . $tpl->get("em2016_nextgames") . "\";");
	}
	// Next X Games Ende
	// EM beendet ?
	if ($em2016_options['1st'] > 0) {
		$result_1st = $db->query_first("SELECT name, flagge FROM bb" . $n . "_em2016_teams WHERE teamid = '" . intval($em2016_options['1st']) . "'");
		$result_2nd = $db->query_first("SELECT name, flagge FROM bb" . $n . "_em2016_teams WHERE teamid = '" . intval($em2016_options['2nd']) . "'");
	}
	// EM beendet ?
	// Gruppentabelle Anfang
	if (isset($_REQUEST['gruppensort'])) {
		$gruppensort = wbb_trim($_REQUEST['gruppensort']);
	} else {
		$gruppensort = "A";
	}

	$gruppensort = substr($gruppensort, 0, 1);
	$result_gruppentabelle = $db->query("SELECT * FROM bb" . $n . "_em2016_teams WHERE gruppe = '" . addslashes($gruppensort) . "' ORDER BY punkte DESC, td DESC, g DESC");
	while ($row_gruppentabelle = $db->fetch_array($result_gruppentabelle)) {
		$rowclass = getone($count++, "tablea", "tableb");
		eval("\$em2016_gruppentabelle .= \"" . $tpl->get("em2016_gruppentabelle") . "\";");
	}
	// Gruppentabelle Ende
	// Punkteverteilung Anfang
	$result_punkte = $db->query("SELECT * FROM bb" . $n . "_em2016_punkte ORDER BY punkteid");
	while ($row_punkte = $db->fetch_array($result_punkte)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($row_punkte['punkteid'] == 2 && $em2016_options['tendenz'] == 0) {
			$em2016_punkte .= '';
			$count++;
		} elseif ($row_punkte['punkteid'] == 3 && $em2016_options['gk_jn'] == 0) {
			$em2016_punkte .= '';
			$count++;
		} elseif ($row_punkte['punkteid'] == 4 && $em2016_options['rk_jn'] == 0) {
			$em2016_punkte .= '';
			$count++;
		} elseif ($row_punkte['punkteid'] == 5 && $em2016_options['elfer_jn'] == 0) {
			$em2016_punkte .= '';
			$count++;
		} elseif (($row_punkte['punkteid'] == 6 || $row_punkte['punkteid'] == 7) && $em2016_options['winnertipp_jn'] == 0) {
			$em2016_punkte .= '';
			$count++;
		} else {
			eval("\$em2016_punkte .= \"" . $tpl->get("em2016_punkte") . "\";");
		}

	}
	// Punkteverteilung Ende
	// Top-X-User Anfang
	$count = 0;
	$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_em2016_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, ((tipps_richtig+tipps_tendenz)/tipps_falsch) DESC,tipps_gesamt DESC Limit 0,{$em2016_options['topuser']}");
	while ($row_topuser = $db->fetch_array($result_topuser)) {
		$rowclass = getone($count++, "tablea", "tableb");
		//** Ranking Start *//
		$em2016_rank_merk = $em2016_rank_merk + 1;
		if ($em2016_punkte_merk != $row_topuser['punkte']) {
			$em2016_rank = $em2016_rank_merk;
			$em2016_punkte_merk = $row_topuser['punkte'];
		}
		if ($em2016_rank == 1) {
			$em2016_userrank = "<img src=\"images/em2016/em2016_rank_1.gif\" border=\"0\" alt=\"em2016_rank_1.gif\" title=\"\" />";
		}

		if ($em2016_rank == 2) {
			$em2016_userrank = "<img src=\"images/em2016/em2016_rank_2.gif\" border=\"0\" alt=\"em2016_rank_2.gif\" title=\"\" />";
		}

		if ($em2016_rank == 3) {
			$em2016_userrank = "<img src=\"images/em2016/em2016_rank_3.gif\" border=\"0\" alt=\"em2016_rank_3.gif\" title=\"\" />";
		}

		if ($em2016_rank > 3) {
			$em2016_userrank = "<b>$em2016_rank</b>";
		}
		//** Ranking Ende *//

		$richtig = $row_topuser['tipps_richtig'] + $row_topuser['tipps_tendenz'];
		if (($richtig + $row_topuser['tipps_falsch']) > 0) {
			$quote = round($richtig * 100 / ($richtig + $row_topuser['tipps_falsch']));
		} else {
			$quote = 0;
		}

		$vortag = $db->query_first("SELECT userid,pos,punkte FROM bb" . $n . "_em2016_vortag WHERE userid = '" . intval($row_topuser['userid']) . "'");

		$tagerg = $row_topuser['punkte'] - $vortag['punkte'];
		if ($tagerg >= 0) {
			$tagerg = "+" . $tagerg;
		}

		if (!isset($vortag['pos']) || $vortag['pos'] > $em2016_rank) {
			$tagtendenz = "<img src=\"images/em2016/hoch.jpg\">";
		} elseif ($vortag['pos'] == $em2016_rank) {
			$tagtendenz = "<img src=\"images/em2016/gleich.gif\">";
		} else {
			$tagtendenz = "<img src=\"images/em2016/runter.jpg\">";
		}

		if ($em2016_rank == 1) {
			$krone = "<img src=\"images/em2016/krone.gif\" alt='krone'>";
		} else {
			$krone = "";
		}

		eval("\$em2016_topuser .= \"" . $tpl->get("em2016_topuser") . "\";");
	}

	//** Europameisterquote Start **//
	$em2016_meisterquote = '';
	$emtipp_tipps_gesamt = '';
	list($emtipp_tipps_gesamt) = $db->query_first("SELECT COUNT(tipp_em) FROM bb" . $n . "_em2016_userpunkte WHERE tipp_em > 0");
	$result = $db->query("SELECT tipp_em, COUNT(tipp_em) AS anzahl FROM bb" . $n . "_em2016_userpunkte
						WHERE tipp_em > 0
						GROUP BY tipp_em
						ORDER BY anzahl DESC");
	while ($quote_emtipp = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		for ($i = 0; $i < count($allids2); $i++, $count++) {
			if ($quote_emtipp['tipp_em'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = "$teamname1";
				$flagge1 = $allflags2[$i];
				//** gleiche Tipps zählen
				$emtipp_tipps = $quote_emtipp['anzahl'];
				//** Quote berechnen
				$emtipp_quote = round($emtipp_tipps * 100 / $emtipp_tipps_gesamt);
			}
		}
		eval("\$em2016_meisterquote .= \"" . $tpl->get("em2016_meisterquote") . "\";");
	}
	//** Europameisterquote Ende **//

	// Top-X-User Ende
	eval("\$lang->items['LANG_EM2016_TPL_INDEX_8'] = \"" . $lang->get4eval("LANG_EM2016_TPL_INDEX_8") . "\";");
	eval("\$lang->items['LANG_EM2016_TPL_INDEX_32'] = \"" . $lang->get4eval("LANG_EM2016_TPL_INDEX_32") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2016_index") . "\");");
}
// +++++++++++++++++
// ++ Ergebnisse +++
// +++++++++++++++++
if ($action == "showresults") {
	if (isset($_REQUEST['auswahl'])) {
		$auswahl = intval($_REQUEST['auswahl']);
	} else {
		$auswahl = "1";
	}

	if ($auswahl == 1) {
		$gruppen = "A,B,C,D,E,F";
		$type = $lang->items['LANG_EM2016_PHP_3'];
	}
	if ($auswahl == 2) {
		$gruppen = "8";
		$type = $lang->items['LANG_EM2016_PHP_4'];
		$tabelle = $lang->items['LANG_EM2016_PHP_5'];
	}
	if ($auswahl == 3) {
		$gruppen = "4";
		$type = $lang->items['LANG_EM2016_PHP_6'];
		$tabelle = $lang->items['LANG_EM2016_PHP_7'];
	}
	if ($auswahl == 4) {
		$gruppen = "2";
		$type = $lang->items['LANG_EM2016_PHP_8'];
		$tabelle = $lang->items['LANG_EM2016_PHP_7'];
	}
	if ($auswahl == 5) {
		$gruppen = "3";
		$type = $lang->items['LANG_EM2016_PHP_9'];
		$tabelle = $lang->items['LANG_EM2016_PHP_7'];
	}
	if ($auswahl == 6) {
		$gruppen = "1";
		$type = $lang->items['LANG_EM2016_PHP_10'];
		$tabelle = $lang->items['LANG_EM2016_PHP_7'];
	}
	$result_gruppen = explode(',', $gruppen);
	for ($rg = 0; $rg < count($result_gruppen); $rg++) {
		if ($auswahl == 1) {
			$type .= $result_gruppen[$rg];
		}

		$result = $db->query("SELECT * FROM bb" . $n . "_em2016_spiele WHERE gruppe = '" . $result_gruppen[$rg] . "' ORDER BY datetime ASC");
		while ($row = $db->fetch_array($result)) {
			$rowclass = getone($count++, "tablea", "tableb");
			$gamedate = formatdate($wbbuserdata['dateformat'], $row['datetime'], 1);
			$gamedate = strtr($gamedate, $replace_datum_komma);
			$gametime = formatdate($wbbuserdata['timeformat'], $row['datetime']);
			$flagge1 = "spacer.gif";
			$flagge2 = "spacer.gif";
			for ($i = 0; $i < count($allids2); $i++) {
				if ($row['team_1_id'] == $allids2[$i]) {
					$name1 = $allnames2[$i];
					$flagge1 = $allflags2[$i];
					$done1 = 1;
				}
				if ($row['team_2_id'] == $allids2[$i]) {
					$name2 = $allnames2[$i];
					$flagge2 = $allflags2[$i];
					$done2 = 1;
				}
			}
			if ($done1 == 0) {
				$result_vorrunde = explode('-', $row['team_1_id']);
				if ($result_vorrunde[0] == "W") {
					$name1 = $lang->items['LANG_EM2016_PHP_11'];
				}

				if ($result_vorrunde[0] == "S") {
					$name1 = $lang->items['LANG_EM2016_PHP_12'];
				}

				if ($result_vorrunde[0] == "D") {
					$name1 = $lang->items['LANG_EM2016_PHP_13'];
				}

				$name1 .= "&nbsp;{$tabelle}&nbsp;{$result_vorrunde[1]}";
			}
			if ($done2 == 0) {
				$result_vorrunde = explode('-', $row['team_2_id']);
				if ($result_vorrunde[0] == "W") {
					$name2 = $lang->items['LANG_EM2016_PHP_11'];
				}

				if ($result_vorrunde[0] == "S") {
					$name2 = $lang->items['LANG_EM2016_PHP_12'];
				}

				if ($result_vorrunde[0] == "D") {
					$name2 = $lang->items['LANG_EM2016_PHP_13'];
				}

				$name2 .= "&nbsp;{$tabelle}&nbsp;{$result_vorrunde[1]}";
			}
			$gamedetails = '';
			if ($row['game_goals_1'] != '' && $row['game_goals_2'] != '') {
				$gamedetails = "<a href=\"em2016.php?action=gamedetails&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\"><img src=\"images/em2016/details.gif\" border=\"0\"alt=\"{$lang->items['LANG_EM2016_PHP_14']}\" title=\"{$lang->items['LANG_EM2016_PHP_14']}\"></a>";
			}

			if ($row['tipps'] > 0) {
				$spieltipps = "<a href=\"em2016.php?action=tippsprogame&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\">{$row['tipps']}</a>";
			} else {
				$spieltipps = $row['tipps'];
			}

			//mf Quote
			$quote1 = 0;
			$quote2 = 0;
			$minusanzahl = 0;

			$result_q = $db->query("SELECT * FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row['gameid'] . " ");
			while ($row2 = $db->fetch_array($result_q)) {
				if ($row2['goals_1'] > $row2['goals_2']) {
					$quote1++;
				} elseif ($row2['goals_2'] > $row2['goals_1']) {
					$quote2++;
				} else {
					$minusanzahl++;
				}

			}

			list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row['gameid']);

			$anzahl -= $minusanzahl;
			if ($anzahl > 0) {
				$quote1 = round(($quote1 / $anzahl) * 100, 0);
				$quote2 = round(($quote2 / $anzahl) * 100, 0);
			}
			//mf !Quote

			eval("\$em2016_showresult_bit_bit .= \"" . $tpl->get("em2016_showresult_bit_bit") . "\";");
			$done1 = 0;
			$done2 = 0;
		}
		eval("\$em2016_showresult_bit .= \"" . $tpl->get("em2016_showresult_bit") . "\";");
		$em2016_showresult_bit_bit = '';
		if ($auswahl == 1) {
			$type = substr("$type", 0, -1);
		}

	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_showresults") . "\");");
}
// +++++++++++++++++++++
// ++ Tipp-Übersicht +++
// +++++++++++++++++++++
if ($action == "maketipp") {
	if (!$wbbuserdata['can_em2016_use']) {
		redirect($lang->get("LANG_EM2016_PHP_15"), $url = "index.php" . $SID_ARG_1ST);
	}

	if (isset($_REQUEST['games_art'])) {
		$games_art = intval($_REQUEST['games_art']);
	} else {
		$games_art = "1";
	}

	if ($games_art == 1) {
		$gamesart = $lang->items['LANG_EM2016_PHP_16'];
	}

	if ($games_art == 2) {
		$gamesart = $lang->items['LANG_EM2016_PHP_17'];
	}

	$serverdate = formatdate($wbbuserdata['dateformat'], $akttime);
	$servertime = formatdate($wbbuserdata['timeformat'], $akttime);
	$tipptime2 = $akttime + $em2016_options['tipptime'];
	$templatetime = $em2016_options['tipptime'] / 60;
	$result = $db->query("SELECT * FROM bb" . $n . "_em2016_spiele WHERE game_goals_1 = '' AND game_goals_2 = '' AND team_1_id " . is_integer(team_1_id) . " AND team_2_id " . is_integer(team_1_id) . " AND datetime > {$tipptime2} ORDER BY datetime ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$date = formatdate($wbbuserdata['dateformat'], $row['datetime'], 1);
		$time = formatdate($wbbuserdata['timeformat'], $row['datetime']);
		$timetipp = $row['datetime'] - $em2016_options['tipptime'];
		$date2 = formatdate($wbbuserdata['dateformat'], $timetipp, 1);
		$time2 = formatdate($wbbuserdata['timeformat'], $timetipp);
		if ($row['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F') {
			$type = $lang->items['LANG_EM2016_PHP_18'];
		}

		if ($row['gruppe'] == '8') {
			$type = $lang->items['LANG_EM2016_PHP_4'];
		}

		if ($row['gruppe'] == '4') {
			$type = $lang->items['LANG_EM2016_PHP_6'];
		}

		if ($row['gruppe'] == '2') {
			$type = $lang->items['LANG_EM2016_PHP_8'];
		}

		if ($row['gruppe'] == '3') {
			$type = $lang->items['LANG_EM2016_PHP_19'];
		}

		if ($row['gruppe'] == '1') {
			$type = $lang->items['LANG_EM2016_PHP_10'];
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if ($row['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		if ((!in_array($row['gameid'], $allusertippgameids2) && ($games_art == 1 && $outputcount < 10)) || ($games_art == 2 && !in_array($row['gameid'], $allusertippgameids2))) {
			$outputcount++;
			eval("\$em2016_maketipp_bit .= \"" . $tpl->get("em2016_maketipp_bit") . "\";");
		} else {
			$count++;
		}
	}

	//check if em and vem tipp still possible
	$result = $db->query("SELECT gameid FROM bb" . $n . "_em2016_spiele WHERE team_1_id AND team_2_id AND game_goals_1 != '' AND game_goals_2 != '' ORDER BY datetime ASC");
	$lastgametipped = $db->num_rows($result);

	if ($em2016_options['winnertipp_jn'] == 1 && $em2016_options['lastgame4emtipp'] > $lastgametipped) {
		eval("\$em2016_maketipp_bit_bit .= \"" . $tpl->get("em2016_maketipp_bit_bit") . "\";");
	}

	eval("\$em2016_maketipp_bit_bit_bit .= \"" . $tpl->get("em2016_maketipp_bit_bit_bit") . "\";");

	eval("\$lang->items['LANG_EM2016_TPL_MAKETIPP_5'] = \"" . $lang->get4eval("LANG_EM2016_TPL_MAKETIPP_5") . "\";");
	eval("\$lang->items['LANG_EM2016_TPL_MAKETIPP_7'] = \"" . $lang->get4eval("LANG_EM2016_TPL_MAKETIPP_7") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2016_maketipp") . "\");");
}
// +++++++++++++++++++
// ++ Tipp abgeben +++
// +++++++++++++++++++
if ($action == "tippabgabe") {
	if (!$wbbuserdata['can_em2016_use']) {
		redirect($lang->get("LANG_EM2016_PHP_15"), $url = "index.php" . $SID_ARG_1ST);
	}

	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . intval($_POST['gameid']) . "'");
		$time2 = $result_time['datetime'] - $em2016_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2016_PHP_20"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
		}

		// Prüfen, ob User schon dieses Spiel getippt hat
		$tipp_exist = $db->query_first("SELECT gameid FROM bb" . $n . "_em2016_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' AND gameid = '" . intval($_POST['gameid']) . "'");
		if ($tipp_exist['gameid']) {
			redirect($lang->get("LANG_EM2016_PHP_43"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
		}

		// Prüfen ob Achtelfinale, Viertelfinale, Halbfinale oder Finale und Tipp unentschieden
		if (intval($_POST['gameid']) > 48 && ($_POST['tipp_1']) == intval($_POST['tipp_2'])) {
			redirect($lang->get("LANG_EM2016_PHP_41"), $url = "em2016.php?action=tippabgabe&amp;gameid={$_POST['gameid']}" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		$tippok = '1';
		$gk = '-1';
		$rk = '-1';
		$elfer = '-1';
		if (!preg_match("/^[0-9]{1,}/", $_POST['tipp_1'])) {
			$tippok = 0;
		}

		if (!preg_match("/^[0-9]{1,}/", $_POST['tipp_2'])) {
			$tippok = 0;
		}

		if ($em2016_options['gk_jn'] == 1 && $_POST['tipp_gk'] == -1) {
			$tippok = 0;
		} elseif ($em2016_options['gk_jn'] == 1 && $_POST['tipp_gk'] != -1) {
			$gk = $_POST['tipp_gk'];
		}
		if ($em2016_options['rk_jn'] == 1 && $_POST['tipp_rk'] == -1) {
			$tippok = 0;
		} elseif ($em2016_options['rk_jn'] == 1 && $_POST['tipp_rk'] != -1) {
			$rk = $_POST['tipp_rk'];
		}
		if ($em2016_options['elfer_jn'] == 1 && $_POST['tipp_elfer'] == -1) {
			$tippok = 0;
		} elseif ($em2016_options['elfer_jn'] == 1 && $_POST['tipp_elfer'] != -1) {
			$elfer = $_POST['tipp_elfer'];
		}
		if ($tippok == 1) {
			$db->unbuffered_query("INSERT INTO bb" . $n . "_em2016_usertipps (userid,gameid,goals_1,goals_2,gk,rk,elfer) VALUES ('" . intval($wbbuserdata['userid']) . "','" . intval($_POST['gameid']) . "','" . intval($_POST['tipp_1']) . "','" . intval($_POST['tipp_2']) . "','" . intval($gk) . "','" . intval($rk) . "','" . intval($elfer) . "')");
			if ($userdatayes == 1) {
				$db->unbuffered_query("UPDATE bb" . $n . "_em2016_userpunkte SET tipps_gesamt=tipps_gesamt+1 WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
			}
			if ($userdatayes == 0) {
				$db->unbuffered_query("INSERT INTO bb" . $n . "_em2016_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','1','0','0','0','0','0')");
			}
			// Guthaben aktiv ? Dann speichern
			if ($em2016_options['gh_aktiv'] == 1) {
				$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2016_PHP_21'] . "#" . intval($_POST['gameid']) . ")','" . $em2016_options['gh_ab_normtipp'] . "','" . $lang->items['LANG_EM2016_PHP_22'] . "')");
				$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2016_options['gh_ab_normtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
			}
			// +++++++++++++++++++++++++++++++
			$db->unbuffered_query("UPDATE bb" . $n . "_em2016_spiele SET tipps=tipps+1 WHERE gameid = '" . intval($_POST['gameid']) . "'");
			header("Location: em2016.php?action=tipok{$SID_ARG_2ND_UN}");
		} else {
			$error = $lang->items['LANG_EM2016_PHP_23'];
		}
	}
	// Prüfen ob Guthaben aktiv und noch genug Guthaben vorhanden
	if ($em2016_options['gh_aktiv'] == 1) {
		if ($wbbuserdata['guthaben'] < $em2016_options['gh_ab_normtipp']) {
			redirect($lang->get("LANG_EM2016_PHP_24"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
		}

	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// Prüfen, ob User schon dieses Spiel getippt hat
	$tipp_exist = $db->query_first("SELECT gameid FROM bb" . $n . "_em2016_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' AND gameid = '" . intval($_REQUEST['gameid']) . "'");
	if ($tipp_exist['gameid']) {
		redirect($lang->get("LANG_EM2016_PHP_43"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
	}

	$result_game = $db->query_first("SELECT * FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	$date = formatdate($wbbuserdata['dateformat'], $result_game['datetime'], 1);
	$time = formatdate($wbbuserdata['timeformat'], $result_game['datetime']);
	for ($i = 0; $i < count($allids2); $i++) {
		if ($result_game['team_1_id'] == $allids2[$i]) {
			$name1 = $allnames2[$i];
			$flagge1 = $allflags2[$i];
		}
		if ($result_game['team_2_id'] == $allids2[$i]) {
			$name2 = $allnames2[$i];
			$flagge2 = $allflags2[$i];
		}
	}
	if ($em2016_options['winnertipp_jn'] == 1) {
		if ($useremtipp == 0) {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($useremtipp != $allids2[$i]) {
					eval("\$em2016_auswahl_emtipp .= \"" . $tpl->get("em2016_auswahl_emtipp") . "\";");
				}
			}
			eval("\$lang->items['LANG_EM2016_TPL_TIPPABGABE_EM_2'] = \"" . $lang->get4eval("LANG_EM2016_TPL_TIPPABGABE_EM_2") . "\";");
			eval("\$em2016_tippabgabe_em .= \"" . $tpl->get("em2016_tippabgabe_em") . "\";");
		}
	}
	if ($em2016_options['winnertipp_jn'] == 1) {
		if ($uservemtipp == 0) {
			for ($j = 0; $j < count($allids2); $j++) {
				if ($uservemtipp != $allids2[$j]) {
					eval("\$em2016_auswahl_vemtipp .= \"" . $tpl->get("em2016_auswahl_vemtipp") . "\";");
				}
			}
			eval("\$lang->items['LANG_EM2016_TPL_TIPPABGABE_VEM_2'] = \"" . $lang->get4eval("LANG_EM2016_TPL_TIPPABGABE_VEM_2") . "\";");
			eval("\$em2016_tippabgabe_vem .= \"" . $tpl->get("em2016_tippabgabe_vem") . "\";");
		}
	}
	if ($em2016_options['gk_jn'] == 1) {
		eval("\$em2016_tippabgabe_gk .= \"" . $tpl->get("em2016_tippabgabe_gk") . "\";");
	}

	if ($em2016_options['rk_jn'] == 1) {
		eval("\$em2016_tippabgabe_rk .= \"" . $tpl->get("em2016_tippabgabe_rk") . "\";");
	}

	if ($em2016_options['elfer_jn'] == 1) {
		eval("\$em2016_tippabgabe_elfer .= \"" . $tpl->get("em2016_tippabgabe_elfer") . "\";");
	}

	eval("\$lang->items['LANG_EM2016_TPL_TIPPABGABE_5'] = \"" . $lang->get4eval("LANG_EM2016_TPL_TIPPABGABE_5") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2016_tippabgabe") . "\");");
}
// ++++++++++++++++++
// ++ Tipp ist OK +++
// ++++++++++++++++++
if ($action == "tipok") {
	eval("\$tpl->output(\"" . $tpl->get("em2016_tipok") . "\");");
}
// ++++++++++++++++++++++++
// ++ Europameister-Tipp ++
// ++++++++++++++++++++++++
if ($action == "tippabgabe_em") {
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . $em2016_options['lastgame4emtipp'] . "'");
		$time2 = $result_time['datetime'] - $em2016_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2016_PHP_20"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		if ($_POST['tipp_em'] != -1) {
			if ($em2016_options['winnertipp_jn'] == 1 && ($uservemtipp != intval($_POST['tipp_em'])) && $userdatayes == 0) {
				$db->query("INSERT INTO bb" . $n . "_em2016_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','0','0','0','0','" . intval($_POST['tipp_em']) . "','0')");
				// Guthaben aktiv ? Dann speichern
				if ($em2016_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2016_PHP_25'] . "','" . $em2016_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2016_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2016_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2016.php?action=tipok{$SID_ARG_2ND_UN}");
			} elseif ($em2016_options['winnertipp_jn'] == 1 && ($uservemtipp != intval($_POST['tipp_em'])) && $userdatayes == 1) {
				$db->query("UPDATE bb" . $n . "_em2016_userpunkte SET tipp_em = '" . intval($_POST['tipp_em']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
				// Guthaben aktiv ? Dann speichern
				if ($em2016_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2016_PHP_25'] . "','" . $em2016_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2016_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2016_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2016.php?action=tipok{$SID_ARG_2ND_UN}");
			}
		} else {
			header("Location: em2016.php?action=tippabgabe&amp;gameid={$gameid}{$SID_ARG_2ND_UN}");
		}
	}
}
// +++++++++++++++++++++++++++
// ++ Vizeeuropameister-Tipp +++
// +++++++++++++++++++++++++++
if ($action == "tippabgabe_vem") {
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . $em2016_options['lastgame4emtipp'] . "'");
		$time2 = $result_time['datetime'] - $em2016_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2016_PHP_20"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		if ($_POST['tipp_vem'] != -1) {
			if ($em2016_options['winnertipp_jn'] == 1 && ($useremtipp != $_POST['tipp_vem']) && $userdatayes == 0) {
				$db->query("INSERT INTO bb" . $n . "_em2016_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','0','0','0','0','0','" . intval($_POST['tipp_vem']) . "')");
				// Guthaben aktiv ? Dann speichern
				if ($em2016_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2016_PHP_26'] . "','" . $em2016_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2016_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2016_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2016.php?action=tipok{$SID_ARG_2ND_UN}");
			}
			if ($em2016_options['winnertipp_jn'] == 1 && ($useremtipp != intval($_POST['tipp_vem'])) && $userdatayes == 1) {
				$db->query("UPDATE bb" . $n . "_em2016_userpunkte SET tipp_vem = '" . intval($_POST['tipp_vem']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
				// Guthaben aktiv ? Dann speichern
				if ($em2016_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2016_PHP_26'] . "','" . $em2016_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2016_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2016_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2016.php?action=tipok{$SID_ARG_2ND_UN}");
			}
			header("Location: em2016.php?action=maketipp");
		} else {
			header("Location: em2016.php?action=tippabgabe&amp;gameid={$gameid}{$SID_ARG_2ND_UN}");
		}
	} else {
		header("Location: em2016.php?action=maketipp");
	}
}
// ++++++++++++++++++++++++
// ++ Usertipps ansehen +++
// ++++++++++++++++++++++++
if ($action == "showusertipps") {
	$result = $db->query("SELECT up.*,uu.username FROM bb" . $n . "_em2016_userpunkte up LEFT JOIN bb" . $n . "_users uu ON up.userid=uu.userid ORDER BY punkte DESC, tipps_gesamt DESC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($row['tipp_em'] == 0) {
			$image_emtipp = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_27']}\" title=\"{$lang->items['LANG_EM2016_PHP_27']}\" />";
		} else {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($wbbuserdata['userid'] == intval($row['userid'])) {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_em'] == $allids2[$i]) {
							$image_emtipp = "<img src=\"images/em2016/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					}
				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_em'] == $allids2[$i]) {
							$image_emtipp = "<img src=\"images/em2016/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					} else {
						$image_emtipp = "<img src=\"images/em2016/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
		}
		if ($row['tipp_vem'] == 0) {
			$image_vemtipp = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_28']}\" title=\"{$lang->items['LANG_EM2016_PHP_28']}\" />";
		} else {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($wbbuserdata['userid'] == intval($row['userid'])) {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_vem'] == $allids2[$i]) {
							$image_vemtipp = "<img src=\"images/em2016/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					}
				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_vem'] == $allids2[$i]) {
							$image_vemtipp = "<img src=\"images/em2016/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					} else {
						$image_vemtipp = "<img src=\"images/em2016/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
		}
		eval("\$em2016_showusertipps_bit .= \"" . $tpl->get("em2016_showusertipps_bit") . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_showusertipps") . "\");");
}
// ++++++++++++++++++++++++++++++++++
// ++ Usertipps im Detail ansehen +++
// ++++++++++++++++++++++++++++++++++
if ($action == "showusertippsdetail") {

	$result_username = $db->query_first("SELECT username FROM bb" . $n . "_users WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	// Europameister und Vizeeuropameister auslesen und anzeigen
	$emtipp_done = '0';
	$vemtipp_done = '0';
	$result_emtipp = $db->query_first("SELECT tipp_em,tipp_vem FROM bb" . $n . "_em2016_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	if ($result_emtipp['tipp_em'] == '0') {
		if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
			$emtipp_name = "<a href=\"em2016.php?action=emtipp_only" . $SID_ARG_2ND . "\">{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_12']}</a>";
		}

		if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
			$emtipp_name = "{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_12']}";
		}

		$emtipp_flagge = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_16']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_16']}\" />";
		$emtipp_done = '1';
	}
	if ($result_emtipp['tipp_vem'] == '0') {
		if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
			$vemtipp_name = "<a href=\"em2016.php?action=emtipp_only" . $SID_ARG_2ND . "\">{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_12']}</a>";
		}

		if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
			$vemtipp_name = "{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_12']}";
		}

		$vemtipp_flagge = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_16']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_16']}\" />";
		$vemtipp_done = '1';
	}
	if ($emtipp_done == '0' || $vemtipp_done == '0') {
		for ($ii = 0; $ii < count($allids2); $ii++) {
			if ($result_emtipp['tipp_em'] != '0' && $result_emtipp['tipp_em'] == $allids2[$ii]) {
				if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
					$emtipp_name = $allnames2[$ii];
					$emtipp_flagge = "<img src=\"images/em2016/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$emtipp_name\" title=\"$emtipp_name\" />";
					$emtipp_edit = '';
					if ($lastgame4emtipp['datetime'] > $akttime) {
						$emtipp_edit = "&nbsp;<a href=\"em2016.php?action=editemtipp&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2016/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
					}
				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						$emtipp_name = $allnames2[$ii];
						$emtipp_flagge = "<img src=\"images/em2016/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$emtipp_name\" title=\"$emtipp_name\" />";
						$emtipp_edit = '';
					} else {
						$emtipp_name = "<b>{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}</b>";
						$emtipp_flagge = "<img src=\"images/em2016/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
			if ($result_emtipp['tipp_vem'] != '0' && $result_emtipp['tipp_vem'] == $allids2[$ii]) {
				if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
					$vemtipp_name = $allnames2[$ii];
					$vemtipp_flagge = "<img src=\"images/em2016/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$vemtipp_name\" title=\"$vemtipp_name\" />";
					$vemtipp_edit = '';
					if ($lastgame4emtipp['datetime'] > $akttime) {
						$vemtipp_edit = "&nbsp;<a href=\"em2016.php?action=editvemtipp&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2016/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
					}

				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						$vemtipp_name = $allnames2[$ii];
						$vemtipp_flagge = "<img src=\"images/em2016/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$vemtipp_name\" title=\"$vemtipp_name\" />";
						$vemtipp_edit = '';
					} else {
						$vemtipp_name = "<b>{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}</b>";
						$vemtipp_flagge = "<img src=\"images/em2016/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
		}
	}

	// Alle Spieltipps auslesen und anzeigen
	$result_game = $db->query("SELECT ut.*,g.* FROM bb" . $n . "_em2016_usertipps ut LEFT JOIN bb" . $n . "_em2016_spiele g ON ut.gameid=g.gameid WHERE userid = '" . intval($_REQUEST['userid']) . "' ORDER BY g.datetime ASC");
	while ($row_game = $db->fetch_array($result_game)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$edittipp = '';
		if (intval($_REQUEST['userid']) == $wbbuserdata['userid']) {
			if (($row_game['datetime'] - $akttime) > $em2016_options['tipptime']) {
				$edittipp = "&nbsp;<a href=\"em2016.php?action=edittipp&amp;gameid={$row_game['gameid']}&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2016/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2016_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
			}
		}
		for ($i = 0; $i < count($allids2); $i++) {
			if ($row_game['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row_game['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		$gamedate = formatdate($wbbuserdata['dateformat'], $row_game['datetime'], 1);
		$gamedate = strtr($gamedate, $replace_datum_komma);
		$gametime = formatdate($wbbuserdata['timeformat'], $row_game['datetime']);

		if ($row_game['gk'] == 1) {
			$image_gk = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
		}

		if ($row_game['gk'] == 0) {
			$image_gk = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
		}

		if ($row_game['gk'] == -1) {
			$image_gk = "<img src=\"images/em2016/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
		}

		if ($row_game['rk'] == 1) {
			$image_rk = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
		}

		if ($row_game['rk'] == 0) {
			$image_rk = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
		}

		if ($row_game['rk'] == -1) {
			$image_rk = "<img src=\"images/em2016/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
		}

		if ($row_game['elfer'] == 1) {
			$image_elfer = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
		}

		if ($row_game['elfer'] == 0) {
			$image_elfer = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
		}

		if ($row_game['elfer'] == -1) {
			$image_elfer = "<img src=\"images/em2016/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
		}

		if ($row_game['game_goals_1'] != '' && $row_game['game_goals_2'] != '') {
			if ($row_game['game_gk'] == $row_game['gk']) {
				$tippright_gk = "&nbsp;<img src=\"images/em2016/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_31']}\" title=\"{$lang->items['LANG_EM2016_PHP_31']}\" />";
			}

			if ($row_game['game_gk'] != $row_game['gk'] && $row_game['gk'] != -1) {
				$tippright_gk = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
			}

			if ($row_game['game_rk'] == $row_game['rk']) {
				$tippright_rk = "&nbsp;<img src=\"images/em2016/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_31']}\" title=\"{$lang->items['LANG_EM2016_PHP_31']}\" />";
			}

			if ($row_game['game_rk'] != $row_game['rk'] && $row_game['rk'] != -1) {
				$tippright_rk = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
			}

			if ($row_game['game_elfer'] == $row_game['elfer']) {
				$tippright_elfer = "&nbsp;<img src=\"images/em2016/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_31']}\" title=\"{$lang->items['LANG_EM2016_PHP_31']}\" />";
			}

			if ($row_game['game_elfer'] != $row_game['elfer'] && $row_game['elfer'] != -1) {
				$tippright_elfer = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
			}

			$ende = 0;
			// +++++++++++++++++++ 1. Prüfung
			// Tipp exakt richtig ?
			if ($row_game['game_goals_1'] == $row_game['goals_1'] && $row_game['game_goals_2'] == $row_game['goals_2']) {
				$tippright_result = "&nbsp;<img src=\"images/em2016/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_31']}\" title=\"{$lang->items['LANG_EM2016_PHP_31']}\" />";
				$ende = 1;
			}
			// +++++++++++++++++++
			// +++++++++++++++++++ 2. Prüfung
			// Spiel unentschieden, Tipp unentschieden, Tendenz richtig ?
			if ($ende == 0) {
				if ($em2016_options['tendenz'] == 1) {
					if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2016/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_33']}\" title=\"{$lang->items['LANG_EM2016_PHP_33']}\" />";
						$ende = 1;
					}
				}
				if ($em2016_options['tendenz'] == 0) {
					if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++
			// +++++++++++++++++++ 3. Prüfung
			// Spiel unentschieden, Tipp Sieg
			if ($ende == 0) {
				if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] != $row_game['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
					$ende = 1;
				}
			}
			// +++++++++++++++++++
			// +++++++++++++++++++ 4. Prüfung
			// Spiel Sieg, Tipp Sieg (falsch), Tendenz richtig ?
			if ($ende == 0) {
				if ($em2016_options['tendenz'] == 1) {
					if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2016/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_33']}\" title=\"{$lang->items['LANG_EM2016_PHP_33']}\" />";
						$ende = 1;
					}
				}
				if ($em2016_options['tendenz'] == 0) {
					if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++
			// +++++++++++++++++++ 5. Prüfung
			// Spiel Sieg, Tipp Niederlage
			// Siel Niederlage, Tipp Sieg
			// Spiel Sieg, Tipp unentschieden
			if ($ende == 0) {
				if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] != $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2016/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_32']}\" title=\"{$lang->items['LANG_EM2016_PHP_32']}\" />";
					$ende = 1;
				}
			}
			// +++++++++++++++++++
		}
		// Tipp nur anzeigen, wenn Spiel schon gespielt
		if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
			if ($row_game['datetime'] < $akttime) {
				eval("\$em2016_showusertippsdetail_bit .= \"" . $tpl->get("em2016_showusertippsdetail_bit") . "\";");
			}
		} else {
			eval("\$em2016_showusertippsdetail_bit .= \"" . $tpl->get("em2016_showusertippsdetail_bit") . "\";");
		}

		$tippright_gk = '';
		$tippright_rk = '';
		$tippright_elfer = '';
		$tippright_result = '';
		$abc = '';
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_showusertippsdetail") . "\");");
}
// +++++++++++++++++++++++++++++++++++++++++++
// ++ Alle Spiele einer Mannschaft ansehen +++
// +++++++++++++++++++++++++++++++++++++++++++
if ($action == "showallgames") {
	$result = $db->query("SELECT * FROM bb" . $n . "_em2016_spiele WHERE team_1_id = '" . intval($_REQUEST['teamid']) . "' OR team_2_id = '" . intval($_REQUEST['teamid']) . "' ORDER BY datetime ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row['datetime']);
		$gamedate = strtr($gamedate, $replace_datum_komma);
		$gametime = formatdate($wbbuserdata['timeformat'], $row['datetime']);
		if ($row['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F' || 'G' || 'H') {
			$type = $lang->items['LANG_EM2016_PHP_18'];
		}

		if ($row['gruppe'] == '8') {
			$type = $lang->items['LANG_EM2016_PHP_4'];
		}

		if ($row['gruppe'] == '4') {
			$type = $lang->items['LANG_EM2016_PHP_6'];
		}

		if ($row['gruppe'] == '2') {
			$type = $lang->items['LANG_EM2016_PHP_8'];
		}

		if ($row['gruppe'] == '3') {
			$type = $lang->items['LANG_EM2016_PHP_19'];
		}

		if ($row['gruppe'] == '1') {
			$type = $lang->items['LANG_EM2016_PHP_10'];
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if (intval($_REQUEST['teamid']) == $allids2[$i]) {
				$name = $allnames2[$i];
				$name_alt = $name;
				$flagge = $allflags2[$i];
			}
			if ($row['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
				$name1_alt = $name1;
				if (intval($_REQUEST['teamid']) == $row['team_1_id']) {
					$name1 = "<b>" . $name1 . "</b>";
				}

			}
			if ($row['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
				$name2_alt = $name2;
				if (intval($_REQUEST['teamid']) == $row['team_2_id']) {
					$name2 = "<b>" . $name2 . "</b>";
				}

			}
		}
		$gamedetails = '';

		//mf Quote
		$quote1 = 0;
		$quote2 = 0;

		$result_q = $db->query("SELECT * FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row['gameid'] . " ");
		while ($row2 = $db->fetch_array($result_q)) {
			if ($row2['goals_1'] > $row2['goals_2']) {
				$quote1++;
			}

			if ($row2['goals_2'] > $row2['goals_1']) {
				$quote2++;
			}

		}

		list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row['gameid']);

		if ($anzahl > 0) {
			$quote1 = round(($quote1 / $anzahl) * 100, 0);
			$quote2 = round(($quote2 / $anzahl) * 100, 0);
		}
		//mf !Quote

		if ($row['game_goals_1'] != '' && $row['game_goals_2'] != '') {
			$gamedetails = "<a href=\"em2016.php?action=gamedetails&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\"><img src=\"images/em2016/details.gif\" border=\"0\"alt=\"{$lang->items['LANG_EM2016_PHP_14']}\" title=\"{$lang->items['LANG_EM2016_PHP_14']}\"></a>";
		}

		eval("\$em2016_showallgames_bit .= \"" . $tpl->get("em2016_showallgames_bit") . "\";");
		$name1 = '';
		$name2 = '';
		$name1_alt = '';
		$name2_alt = '';
		$flagge1 = '';
		$flagge2 = '';
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_showallgames") . "\");");
}
// +++++++++++++++++++++++++++++++++++++
// ++ Details zu einem Spiel ansehen +++
// +++++++++++++++++++++++++++++++++++++
if ($action == "gamedetails") {
	$result = $db->query_first("SELECT * FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	$gamedate = formatdate($wbbuserdata['dateformat'], $result['datetime']);
	$gamedate = strtr($gamedate, $replace_datum_komma);
	$gametime = formatdate($wbbuserdata['timeformat'], $result['datetime']);
	if ($result['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F' || 'G' || 'H') {
		$type = $lang->items['LANG_EM2016_PHP_18'];
	}

	if ($result['gruppe'] == '8') {
		$type = $lang->items['LANG_EM2016_PHP_4'];
	}

	if ($result['gruppe'] == '4') {
		$type = $lang->items['LANG_EM2016_PHP_6'];
	}

	if ($result['gruppe'] == '2') {
		$type = $lang->items['LANG_EM2016_PHP_8'];
	}

	if ($result['gruppe'] == '3') {
		$type = $lang->items['LANG_EM2016_PHP_19'];
	}

	if ($result['gruppe'] == '1') {
		$type = $lang->items['LANG_EM2016_PHP_10'];
	}

	for ($i = 0; $i < count($allids2); $i++) {
		if ($result['team_1_id'] == $allids2[$i]) {
			$name1 = $allnames2[$i];
			$flagge1 = $allflags2[$i];
		}
		if ($result['team_2_id'] == $allids2[$i]) {
			$name2 = $allnames2[$i];
			$flagge2 = $allflags2[$i];
		}
	}
	if ($em2016_options['gk_jn'] == 1) {
		if ($result['game_gk'] == 1) {
			$game_gk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_34']}</span></td></tr>";
		}

		if ($result['game_gk'] == 0) {
			$game_gk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_35']}</span></td></tr>";
		}

	}
	if ($em2016_options['rk_jn'] == 1) {
		if ($result['game_rk'] == 1) {
			$game_rk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_36']}</span></td></tr>";
		}

		if ($result['game_rk'] == 0) {
			$game_rk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_37']}</span></td></tr>";
		}

	}
	if ($em2016_options['elfer_jn'] == 1) {
		if ($result['game_elfer'] == 1) {
			$game_elfer = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_38']}</span></td></tr>";
		}

		if ($result['game_elfer'] == 0) {
			$game_elfer = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2016_PHP_39']}</span></td></tr>";
		}

	}
	$linkjn = 0;
	if (!empty($result['gamelink'])) {
		$linkjn = 1;
		$link = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\"><a href=\"{$result['gamelink']}\" target=\"_blank\">{$lang->items['LANG_EM2016_PHP_40']}</a></span></td></tr>";
	}
	$commentjn = 0;
	if (!empty($result['gamecomment'])) {
		$commentjn = 1;
		$comment1 = nl2br($result['gamecomment']);
		$comment2 = "<tr><td class=\"tablea\" align=\"left\"><span class=\"normalfont\">{$comment1}</span></td></tr>";
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_gamedetails") . "\");");
}
// ++++++++++++++++++++++++++++++++++++++++++++
// ++ Alle Usertipps zu einem Spiel ansehen +++
// ++++++++++++++++++++++++++++++++++++++++++++
if ($action == "tippsprogame") {
	// Tipps nur anzeigen, wenn Spiel schon gespielt
	$result_datetime = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	if ($result_datetime['datetime'] > $akttime) {
		redirect($lang->get("LANG_EM2016_PHP_60"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	$result = $db->query("SELECT ut.*,u.username FROM bb" . $n . "_em2016_usertipps ut LEFT JOIN bb" . $n . "_users u ON ut.userid=u.userid WHERE gameid = '" . intval($_REQUEST['gameid']) . "' ORDER BY userid ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($em2016_options['gk_jn'] == 1) {
			if ($row['gk'] == 0) {
				$game_gk = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
			}

			if ($row['gk'] == 1) {
				$game_gk = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
			}

		}
		if ($em2016_options['rk_jn'] == 1) {
			if ($row['rk'] == 0) {
				$game_rk = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
			}

			if ($row['rk'] == 1) {
				$game_rk = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
			}

		}
		if ($em2016_options['elfer_jn'] == 1) {
			if ($row['elfer'] == 0) {
				$game_elfer = "<img src=\"images/em2016/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_30']}\" title=\"{$lang->items['LANG_EM2016_PHP_30']}\" />";
			}

			if ($row['elfer'] == 1) {
				$game_elfer = "<img src=\"images/em2016/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2016_PHP_29']}\" title=\"{$lang->items['LANG_EM2016_PHP_29']}\" />";
			}

		}
		eval("\$em2016_tippsprogame_bit .= \"" . $tpl->get("em2016_tippsprogame_bit") . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_tippsprogame") . "\");");
}
// ++++++++++++++++++++++++++
// ++ Usertipps editieren +++
// ++++++++++++++++++++++++++
if ($action == "edittipp") {
	// Speichern des geänderten Tipps
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Mindesttippabgabezeit
		if ((intval($_POST['datetime']) - $akttime) < $em2016_options['tipptime']) {
			redirect($lang->get("LANG_EM2016_PHP_44"), $url = "em2016.php" . $SID_ARG_1ST);
		}

		// Prüfen ob Achtelfinale, Viertelfinale, Halbfinale, Spiel um Platz 3 oder Finale und Tipp unentschieden
		if (intval($_POST['gameid']) > 48 && (intval($_POST['tipp_1']) == intval($_POST['tipp_2']))) {
			redirect($lang->get("LANG_EM2016_PHP_41"), $url = "em2016.php?action=edittipp&amp;gameid={$_POST['gameid']}&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_2ND);
		}

		$tippok = 1;
		$gk = -1;
		$rk = -1;
		$elfer = -1;
		if (!preg_match("/^[0-9]{1,}/", intval($_POST['tipp_1']))) {
			$tippok = 0;
		}

		if (!preg_match("/^[0-9]{1,}/", intval($_POST['tipp_2']))) {
			$tippok = 0;
		}

		if ($em2016_options['gk_jn'] == 1 && intval($_POST['tipp_gk']) == -1) {
			$tippok = 0;
		} elseif ($em2016_options['gk_jn'] == 1 && intval($_POST['tipp_gk']) != -1) {
			$gk = $_POST['tipp_gk'];
		}
		if ($em2016_options['rk_jn'] == 1 && intval($_POST['tipp_rk']) == -1) {
			$tippok = 0;
		} elseif ($em2016_options['rk_jn'] == 1 && intval($_POST['tipp_rk']) != -1) {
			$rk = intval($_POST['tipp_rk']);
		}
		if ($em2016_options['elfer_jn'] == 1 && intval($_POST['tipp_elfer']) == -1) {
			$tippok = 0;
		} elseif ($em2016_options['elfer_jn'] == 1 && intval($_POST['tipp_elfer']) != -1) {
			$elfer = intval($_POST['tipp_elfer']);
		}
		if ($tippok == 1) {
			$db->unbuffered_query("UPDATE bb" . $n . "_em2016_usertipps SET goals_1 = '" . intval($_POST['tipp_1']) . "', goals_2 = '" . intval($_POST['tipp_2']) . "', gk = '$gk', rk = '$rk', elfer = '$elfer' WHERE gameid = '" . intval($_POST['gameid']) . "' AND userid = '" . intval($wbbuserdata['userid']) . "'");
			redirect($lang->get("LANG_EM2016_PHP_45"), $url = "em2016.php?action=showusertippsdetail&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_1ST);
		} elseif ($tippok == 0) {
			redirect($lang->get("LANG_EM2016_PHP_46"), $url = "em2016.php?action=edittipp&amp;gameid=" . intval($_POST['gameid']) . "&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_2ND);
		}
	}
	// Anzeigen des zu ändernden Tipps
	// User ist auch der, der er zu sein scheint ?
	if (intval($_REQUEST['userid']) != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2016_PHP_47"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	// Tipp von diesem User existiert auch ?
	$checktipp = $db->query_first("SELECT gameid FROM bb" . $n . "_em2016_usertipps WHERE gameid = '" . intval($_REQUEST['gameid']) . "' AND userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$checktipp['gameid']) {
		redirect($lang->get("LANG_EM2016_PHP_48"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	$result_game = $db->query("SELECT ut.*,g.* FROM bb" . $n . "_em2016_usertipps ut LEFT JOIN bb" . $n . "_em2016_spiele g ON ut.gameid=g.gameid WHERE ut.gameid = '" . intval($_REQUEST['gameid']) . "' AND ut.userid = '" . intval($_REQUEST['userid']) . "'");
	while ($row_game = $db->fetch_array($result_game)) {
		// Mindesttippabgabezeit noch nicht erreicht ?
		if (($row_game['datetime'] - $akttime) < $em2016_options['tipptime']) {
			redirect($lang->get("LANG_EM2016_PHP_49"), $url = "em2016.php" . $SID_ARG_1ST);
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if ($row_game['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row_game['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		if ($em2016_options['gk_jn'] == 1) {
			$tipp_gk_jn = array(1 => '', 2 => '');
			if (isset($row_game['gk'])) {
				$tipp_gk_jn[$row_game['gk']] = ' selected="selected"';
			}

			eval("\$em2016_tippedit_gk .= \"" . $tpl->get("em2016_tippedit_gk") . "\";");
		}
		if ($em2016_options['rk_jn'] == 1) {
			$tipp_rk_jn = array(1 => '', 2 => '');
			if (isset($row_game['rk'])) {
				$tipp_rk_jn[$row_game['rk']] = ' selected="selected"';
			}

			eval("\$em2016_tippedit_rk .= \"" . $tpl->get("em2016_tippedit_rk") . "\";");
		}
		if ($em2016_options['elfer_jn'] == 1) {
			$tipp_elfer_jn = array(1 => '', 2 => '');
			if (isset($row_game['elfer'])) {
				$tipp_elfer_jn[$row_game['elfer']] = ' selected="selected"';
			}

			eval("\$em2016_tippedit_elfer .= \"" . $tpl->get("em2016_tippedit_elfer") . "\";");
		}
		eval("\$tpl->output(\"" . $tpl->get("em2016_tippedit") . "\");");
	}
}
// ++++++++++++++++++++++++
// ++ EM-Tipp editieren +++
// ++++++++++++++++++++++++
if ($action == "editemtipp") {
	if ($lastgame4emtipp['datetime'] < $akttime) {
		redirect($lang->get("LANG_EM2016_PHP_50"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	// +++++++++++++++++++++++++++++++++++
	if (isset($_POST['send'])) {
		if ($_POST['tipp_em'] == -1) {
			redirect($lang->get("LANG_EM2016_PHP_51"), $url = "em2016.php" . $SID_ARG_1ST);
		}

		$db->unbuffered_query("UPDATE bb" . $n . "_em2016_userpunkte SET tipp_em = '" . intval($_POST['tipp_em']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		redirect($lang->get("LANG_EM2016_PHP_52"), $url = "em2016.php" . $SID_ARG_1ST);
	}
	// +++++++++++++++++++++++++++++++++++
	if ($_REQUEST['userid'] != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2016_PHP_53"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	$result = $db->query_first("SELECT tipp_em, tipp_vem FROM bb" . $n . "_em2016_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$result['tipp_em']) {
		redirect($lang->get("LANG_EM2016_PHP_54"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_em'] == $allids2[$j]) {
			$em_name = $allnames2[$j];
			$em_flagge = "<img src=\"images/em2016/flaggen/{$allflags2[$j]}\" alt=\"{$em_name}\" title=\"{$em_name}\" />";
		}
	}
	for ($i = 0; $i < count($allids2); $i++) {
		if ($result['tipp_em'] != $allids2[$i] && $result['tipp_vem'] != $allids2[$i]) {
			eval("\$em2016_auswahl_emtipp .= \"" . $tpl->get("em2016_auswahl_emtipp") . "\";");
		}
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_editemtipp") . "\");");
}
// +++++++++++++++++++++++++++++
// ++ Vize-EM-Tipp editieren +++
// +++++++++++++++++++++++++++++
if ($action == "editvemtipp") {
	if ($lastgame4emtipp['datetime'] < $akttime) {
		redirect($lang->get("LANG_EM2016_PHP_55"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	// +++++++++++++++++++++++++++++++++++
	if (isset($_POST['send'])) {
		if ($_POST['tipp_vem'] == -1) {
			redirect($lang->get("LANG_EM2016_PHP_56"), $url = "em2016.php" . $SID_ARG_1ST);
		}

		$db->unbuffered_query("UPDATE bb" . $n . "_em2016_userpunkte SET tipp_vem = '" . intval($_POST['tipp_vem']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		redirect($lang->get("LANG_EM2016_PHP_57"), $url = "em2016.php" . $SID_ARG_1ST);
	}
	// +++++++++++++++++++++++++++++++++++
	if ($_REQUEST['userid'] != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2016_PHP_58"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	$result = $db->query_first("SELECT tipp_em, tipp_vem FROM bb" . $n . "_em2016_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$result['tipp_vem']) {
		redirect($lang->get("LANG_EM2016_PHP_59"), $url = "em2016.php" . $SID_ARG_1ST);
	}

	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_vem'] == $allids2[$j]) {
			$vem_name = $allnames2[$j];
			$vem_flagge = "<img src=\"images/em2016/flaggen/{$allflags2[$j]}\" alt=\"$vem_name\" title=\"$vem_name\" />";
		}
	}
	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_vem'] != $allids2[$j] && $result['tipp_em'] != $allids2[$j]) {
			eval("\$em2016_auswahl_vemtipp .= \"" . $tpl->get("em2016_auswahl_vemtipp") . "\";");
		}
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_editvemtipp") . "\");");
}

if ($action == "emtipp_only") {
	// Prüfen auf genug Tippzeit
	$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2016_spiele WHERE gameid = '" . $em2016_options['lastgame4emtipp'] . "'");
	$time2 = $result_time['datetime'] - $em2016_options['tipptime'];
	if ($akttime > $time2) {
		redirect($lang->get("LANG_EM2016_PHP_20"), $url = "em2016.php?action=maketipp" . $SID_ARG_2ND);
	}

	if ($em2016_options['winnertipp_jn'] == 1) {
		$selected = '';
		for ($i = 0; $i < count($allids2); $i++) {
			if ($useremtipp != $allids2[$i]) {
				eval("\$em2016_auswahl_emtipp .= \"" . $tpl->get("em2016_auswahl_emtipp") . "\";");
			} else {
				eval("\$em2016_auswahl_emtipp .= \"" . $tpl->get("em2016_auswahl_emtipp_selected") . "\";");
			}
		}
		eval("\$lang->items['LANG_EM2016_TPL_TIPPABGABE_EM_2'] = \"" . $lang->get4eval("LANG_EM2016_TPL_TIPPABGABE_EM_2") . "\";");
		eval("\$em2016_tippabgabe_em.= \"" . $tpl->get("em2016_tippabgabe_em") . "\";");
	}
	if ($em2016_options['winnertipp_jn'] == 1) {
		$selected = '';
		for ($j = 0; $j < count($allids2); $j++) {
			if ($uservemtipp != $allids2[$j]) {
				eval("\$em2016_auswahl_vemtipp .= \"" . $tpl->get("em2016_auswahl_vemtipp") . "\";");
			} else {
				eval("\$em2016_auswahl_vemtipp .= \"" . $tpl->get("em2016_auswahl_vemtipp_selected") . "\";");
			}
		}
		eval("\$lang->items['LANG_EM2016_TPL_TIPPABGABE_VEM_2'] = \"" . $lang->get4eval("LANG_EM2016_TPL_TIPPABGABE_VEM_2") . "\";");
		eval("\$em2016_tippabgabe_vem .= \"" . $tpl->get("em2016_tippabgabe_vem") . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get("em2016_emtipp_only") . "\");");
}
