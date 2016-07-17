<?php
eval("print(\"" . $hm_boxhead_tpl . "\");");

include "./em2016_global.php";
$lang->load("EM2016");

$akttime = time();

$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_em2016_spiele WHERE datetime > '" . intval($akttime) . "' ORDER BY datetime ASC Limit 0,5");

while ($row_nextgames = $db->fetch_array($result_nextgames)) {
	$rowclass = getone($count++, "tablea", "tableb");
	$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
	$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

	$checkgame1 = $row_nextgames['team_1_id']{0};
	$checkgame2 = $row_nextgames['team_2_id']{0};
	if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "V") {
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

		if ($check1[0] == "V") {
			$teamname1 = $lang->items['LANG_EM2016_PHP_13'];
		}

		$teamname1 .= "&nbsp;$tabelle&nbsp;$check1[1]";
		$name1 = $teamname1;
		$flagge1 = "spacer.gif";
	}
	if ($checkgame2 == "W" || $checkgame2 == "S" || $checkgame2 == "V") {
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

		if ($check2[0] == "V") {
			$teamname2 = $lang->items['LANG_EM2016_PHP_13'];
		}

		$teamname2 .= "&nbsp;$tabelle&nbsp;$check2[1]";
		$name2 = $teamname2;
		$flagge2 = "spacer.gif";
	}

	for ($i = 0; $i < count($allids2); $i++) {
		if ($row_nextgames['team_1_id'] == $allids2[$i]) {
			$teamname1 = $allnames2[$i];
			$name1 = "<a href=\"em2016.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">$teamname1</a>";
			$flagge1 = $allflags2[$i];
		}
		if ($row_nextgames['team_2_id'] == $allids2[$i]) {
			$teamname2 = $allnames2[$i];
			$name2 = "<a href=\"em2016.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">$teamname2</a>";
			$flagge2 = $allflags2[$i];
		}
	}

	// Quote
	$quote1 = 0;
	$quote2 = 0;

	$result_q = $db->query("SELECT * FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row_nextgames['gameid'] . " ");
	while ($row = $db->fetch_array($result_q)) {
		if ($row['goals_1'] > $row['goals_2']) {
			$quote1++;
		}

		if ($row['goals_2'] > $row['goals_1']) {
			$quote2++;
		}
	}

	list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2016_usertipps WHERE gameid = " . $row_nextgames['gameid']);

	if ($anzahl > 0) {
		$quote1 = round(($quote1 / $anzahl) * 100, 0);
		$quote2 = round(($quote2 / $anzahl) * 100, 0);
	}
	// !Quote

	eval("\$em2016_nextgames .= \"" . $tpl->get("em2016_sponsor_em2016_nextgames") . "\";");
}

eval("print(\"" . $tpl->get("em2016_sponsor_portalboxen_emtippnext5") . "\");");

eval("print(\"" . $hm_boxtail_tpl . "\");");
?>
