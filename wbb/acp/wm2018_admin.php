<?php
/***************************************************************************
 *
 *   MOD                  : WM-2006/2014/EM-2016/WM-2018 Tippspiel
 *   file                 : wm2018_admin.php
 *   copyright            : WM2006-Tippspiel � 2006 @ batida444
 *   copyright            : WM2014-Tippspiel � 2014 @ Viktor
 *   copyright            : EM2016-Tippspiel � 2016 @ kill0rz
 *   copyright            : WM2018-Tippspiel � 2018 @ kill0rz
 *   web                  : kill0rz.com
 *   Boardversion         : Burning Board wBB 2.3
 ***************************************************************************/

require './global.php';
require './lib/class_parse.php';
require './lib/class_parsecode.php';
require './wm2018_gameids.php';

if (!checkAdminPermissions("a_can_wm2018_edit")) {
	access_error(1);
}

$lang->load("ACP_WM2018,MISC,POSTINGS");

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
} else {
	$action = "info";
}

if ($action == "info") {
	eval("\$tpl->output(\"" . $tpl->get('wm2018_info', 1) . "\");");
}

if ($action == "options") {
	$message = stripcrap(wbb_trim($_POST['message']));
	$message = parseURL($message);

	if (isset($_POST['send'])) {
		$tipptime = $_POST['tipptime'] * 60;
		$sql_query = "UPDATE bb" . $n . "_wm2018_options SET wm2018aktiv = '" . intval($_POST['wm2018_aktiv_jn']) . "', showrssnews = '" . intval($_POST['showrssnews']) . "', rssnews = '" . intval($_POST['rssnews']) . "', rssnews_showfeed = '" . mysqli_escape_string($db->link_id, $_POST['rssnews_showfeed']) . "', wmticker_width = '" . intval($_POST['wmticker_width']) . "', nextxgames = '" . intval($_POST['nextxgames']) . "', topuser = '" . intval($_POST['topuser']) . "', tipptime = '" . intval($tipptime) . "', tendenz = '" . intval($_POST['tendenz']) . "', gk_jn = '" . intval($_POST['gk_jn']) . "', rk_jn = '" . intval($_POST['rk_jn']) . "', elfer_jn = '" . intval($_POST['elfer_jn']) . "', winnertipp_jn = '" . intval($_POST['winnertipp_jn']) . "', lastgame4wmtipp = '" . intval($_POST['lastgame4wmtipp']) . "', nonaddedgamescount = '" . intval($_POST['nonaddedgamescount']) . "', currentgamescount = '" . intval($_POST['currentgamescount']) . "', gh_aktiv = '" . intval($_POST['gh_aktiv']) . "', gh_infos = '" . intval($_POST['gh_infos']) . "', gh_ab_normtipp = '" . intval($_POST['gh_ab_normtipp']) . "', gh_ab_wmtipp = '" . intval($_POST['gh_ab_wmtipp']) . "', gh_gut_normtipp_richtig = '" . intval($_POST['gh_gut_normtipp_richtig']) . "', gh_gut_normtipp_tendenz = '" . intval($_POST['gh_gut_normtipp_tendenz']) . "', gh_gut_wmtipp_richtig = '" . intval($_POST['gh_gut_wmtipp_richtig']) . "', ebay_rel_aktiv = '" . intval($_POST['ebay_rel_aktiv']) . "', ebay_pub_id = '" . intval($_POST['ebay_pub_id']) . "', ebay_cat = '" . intval($_POST['ebay_cat']) . "', po_aktiv = '" . intval($_POST['po_aktiv']) . "', vgposttid = '" . intval($_POST['vgposttid']) . "', vgpostuid = '" . intval($_POST['vgpostuid']) . "', viconid = '" . intval($_POST['viconid']) . "', vgthema = '" . addslashes($_POST['vgthema']) . "', message = '" . addslashes($_POST['message']) . "', vboardid = '" . intval($_POST['vboardid']) . "', vprefix = '" . addslashes($_POST['vprefix']) . "', vgposthtml = '" . intval($_POST['vgposthtml']) . "', diskussionsthreadid = '" . intval($_POST['diskussionsthreadid']) . "', showrssnews_method = '" . intval($_POST['showrssnews_method']) . "', showtableonindex_nontippedgames = '" . intval($_POST['showtableonindex_nontippedgames']) . "', showtableonindex_donegames = '" . intval($_POST['showtableonindex_donegames']) . "', showtableonindex_donegamescount = '" . intval($_POST['showtableonindex_donegamescount']) . "';";
		$db->unbuffered_query($sql_query);
		header("Location: wm2018_admin.php?action=options&sid={$session['hash']}");
		exit();
	}

	$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");

	//DiskussionsthreadID
	/* Boards f�r Posting holen */
	$result = $db->query("SELECT boardid, parentid, boardorder, title, invisible, isboard FROM bb" . $n . "_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}
	$permissioncache = getPermissions();
	$diskussionsthreadid_options = makeboardselect(0, 1, $wm2018_options['diskussionsthreadid'], "%s *");

	$tipptime = $wm2018_options['tipptime'] / 60;
	if ($wm2018_options['wm2018aktiv'] == "1") {
		$sel_wm2018aktiv[1] = " selected";
	} else {
		$sel_wm2018aktiv[0] = " selected";
	}

	if ($wm2018_options['showrssnews'] == "1") {
		$sel_showrss[1] = " selected";
	} else {
		$sel_showrss[0] = " selected";
	}

	if ($wm2018_options['showrssnews_method'] == "1") {
		$sel_showrssnews_method[1] = " selected";
	} else {
		$sel_showrssnews_method[0] = " selected";
	}

	if ($wm2018_options['rssnews_showfeed'] == "fifa") {
		$sel_rssnews_showfeed[0] = " selected";
	} else {
		$sel_rssnews_showfeed[1] = " selected";
	}

	if ($wm2018_options['tendenz'] == "1") {
		$sel_tendenz[1] = " selected";
	} else {
		$sel_tendenz[0] = " selected";
	}

	if ($wm2018_options['gk_jn'] == "1") {
		$sel_gk_jn[1] = " selected";
	} else {
		$sel_gk_jn[0] = " selected";
	}

	if ($wm2018_options['rk_jn'] == "1") {
		$sel_rk_jn[1] = " selected";
	} else {
		$sel_rk_jn[0] = " selected";
	}

	if ($wm2018_options['elfer_jn'] == "1") {
		$sel_elfer_jn[1] = " selected";
	} else {
		$sel_elfer_jn[0] = " selected";
	}

	if ($wm2018_options['winnertipp_jn'] == "1") {
		$sel_winnertipp_jn[1] = " selected";
	} else {
		$sel_winnertipp_jn[0] = " selected";
	}

	if ($wm2018_options['gh_aktiv'] == "1") {
		$sel_gh_aktiv[1] = " selected";
	} else {
		$sel_gh_aktiv[0] = " selected";
	}

	if ($wm2018_options['gh_infos'] == "1") {
		$sel_gh_infos[1] = " selected";
	} else {
		$sel_gh_infos[0] = " selected";
	}

	if ($wm2018_options['ebay_rel_aktiv'] == "1") {
		$sel_ebay_rel_aktiv[1] = " selected";
	} else {
		$sel_ebay_rel_aktiv[0] = " selected";
	}

	if ($wm2018_options['po_aktiv'] == "1") {
		$sel_po_aktiv[1] = " selected";
	} else {
		$sel_po_aktiv[0] = " selected";
	}

	if ($wm2018_options['showtableonindex_nontippedgames'] == "1") {
		$sel_showtableonindex_nontippedgames[1] = " selected";
	} else {
		$sel_showtableonindex_nontippedgames[0] = " selected";
	}

	if ($wm2018_options['showtableonindex_donegames'] == "1") {
		$sel_showtableonindex_donegames[1] = " selected";
	} else {
		$sel_showtableonindex_donegames[0] = " selected";
	}

	if ($wm2018_options['vgposthtml'] == "1") {
		$sel_vgposthtml[1] = " selected";
	} else {
		$sel_vgposthtml[0] = " selected";
	}

	// Check if CURL exists
	if (!function_exists('curl_version')) {
		// does not exist
		$curl_exists_lng = $lang->items['LANG_ACP_WM2018_TPL_OPTIONS_45'];
	} else {
		$curl_exists_lng = "";
	}

	//Anzahl Nutzer
	$maxnutzer = $db->query_first("SELECT count(userid) FROM bb" . $n . "_users");

	$vICONselected[0] = '';
	$vICONselected[$wm2018_options['viconid']] = "checked=\"checked\"";

	$result = $db->query("SELECT * FROM bb" . $n . "_icons ORDER BY iconorder ASC");
	$iconcount = 0;
	$vchoice_posticons = '';
	while ($rowv = $db->fetch_array($result)) {
		$row_iconid = $rowv['iconid'];
		if (!isset($vICONselected[$row_iconid])) {
			$vICONselected[$row_iconid] = '';
		}

		$rowv['icontitle'] = getlangvar($rowv['icontitle'], $lang);
		$rowv['iconpath'] = replaceImagefolder($rowv['iconpath']);
		eval("\$vchoice_posticons .= \"" . $tpl->get("wm2018_iconbit") . "\";");
		if ($iconcount == 5) {
			$vchoice_posticons .= '<br />';
			$iconcount = 0;
		} else {
			$iconcount++;
		}

	}

	/* BBCode aufbereiten */
	$bbcode_smilies = getclickysmilies_vgacp(10, $smilie_table_rows);
	$bbcode_buttons = getcodebuttons_vgacp();
	$message = $wm2018_options['message'];

	/* Boards f�r Posting holen */
	$result = $db->query("SELECT boardid, parentid, boardorder, title, invisible, isboard FROM bb" . $n . "_boards ORDER by parentid ASC, boardorder ASC");
	while ($row = $db->fetch_array($result)) {
		$boardcache[$row['parentid']][$row['boardorder']][$row['boardid']] = $row;
	}

	$vglboard_options = makeboardselect(0, 1, $wm2018_options['vboardid'], "%s *");

	/* Username holen */
	$user_info = $db->query_first("SELECT username FROM bb" . $n . "_users WHERE userid = '" . $wm2018_options['vgpostuid'] . "'");
	$vgusername = htmlconverter($user_info['username']);

	/* Thread Topic holen */
	$thread_topic = $db->query_first("SELECT topic FROM bb" . $n . "_threads WHERE threadid = '" . $wm2018_options['vgposttid'] . "' AND boardid = '" . $wm2018_options['vboardid'] . "'");
	if ($thread_topic['topic']) {
		$vgthreadtopic = htmlconverter($thread_topic['topic']);
	} else {
		$vgthreadtopic = '';
		$wm2018_options['vgposttid'] = 0;
	}

	eval("\$lang->items['LANG_ACP_WM2018_TPL_OPTIONS_20'] = \"" . $lang->get4eval("LANG_ACP_WM2018_TPL_OPTIONS_20") . "\";");
	eval("\$tpl->output(\"" . $tpl->get('wm2018_options', 1) . "\");");
}

if ($action == "punkte") {
	$result_punkte = $db->query("SELECT * FROM bb" . $n . "_wm2018_punkte ORDER BY punkteid ASC");
	while ($row_punkte = $db->fetch_array($result_punkte)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		eval("\$wm2018_punkte_viewbit .= \"" . $tpl->get('wm2018_punkte_viewbit', 1) . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get('wm2018_punkte_view', 1) . "\");");
}

if ($action == "punkteedit") {
	if ($_POST['send'] == 'send') {
		$db->query("UPDATE bb" . $n . "_wm2018_punkte SET wert = '" . intval($_POST['wert']) . "' WHERE punkteid = '" . intval($_POST['punkteid']) . "'");
		header("Location: wm2018_admin.php?action=punkte&sid={$session['hash']}");
		exit();
	}
	$punkte = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '" . intval($_REQUEST['punkteid']) . "'");
	eval("\$tpl->output(\"" . $tpl->get('wm2018_punkte_edit', 1) . "\");");
}

// //unn�tig f�r WM 2018
// //fuer eventuelle Korrekturen am Achtelfinale
// if ($action == "correct8") {
// 	$spiele_mit_dritten = array(38, 39, 40, 41);

// 	$erfolgsmeldung = '';
// 	$wm2018_correct8_erfolgsmeldung = '';

// 	if (isset($_POST['values_are_sent']) && trim($_POST['values_are_sent']) == "true") {
// 		//da hat jemand im ACP eine Mannschaft ge�ndert
// 		foreach ($spiele_mit_dritten as $key => $spielid) {
// 			if (isset($_POST['changeteam_' . $spielid]) && intval($_POST['changeteam_' . $spielid]) != null && intval($_POST['changeteam_' . $spielid]) != 0) {
// 				$newteam_id = intval($_POST['changeteam_' . $spielid]);
// 				$db->unbuffered_query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = " . $newteam_id . " WHERE gameid = '" . $spielid . "';");
// 				$erfolgsmeldung .= "<font color='green'>{$lang->items['LANG_ACP_WM2018_CORRECT8_10']} " . $spielid . " {$lang->items['LANG_ACP_WM2018_CORRECT8_11']}</font><br>";
// 			}
// 		}
// 	}

// 	if ($erfolgsmeldung != '') {
// 		eval("\$wm2018_correct8_erfolgsmeldung = \"" . $tpl->get('wm2018_correct8_erfolgsmeldung', 1) . "\";");
// 	}

// 	function bestedritte_alle($groupids) {
// 		global $db, $n, $wm2018_correct8_bit_select_bit, $tpl, $lang;

// 		$wm2018_correct8_bit_select_bit = '';

// 		$db->query("TRUNCATE TABLE bb" . $n . "_wm2018_bestedrittetmp;");
// 		foreach ($groupids as $groupid) {
// 			$counter = 0;
// 			$result = $db->query("SELECT teamid, td, punkte, g FROM bb" . $n . "_wm2018_teams WHERE gruppe = '" . $groupid . "' ORDER BY punkte DESC, td DESC, g DESC LIMIT 3");
// 			while ($row = $db->fetch_array($result)) {
// 				if (++$counter > 2) {
// 					$db->query("INSERT INTO bb" . $n . "_wm2018_bestedrittetmp (`teamid`, `punkte`, `td`, `g`) VALUES ('" . $row['teamid'] . "', '" . $row['punkte'] . "', '" . $row['td'] . "', '" . $row['g'] . "');");
// 				}
// 			}
// 		}

// 		$result = $db->query("SELECT teamid FROM bb" . $n . "_wm2018_bestedrittetmp ORDER BY punkte DESC, td DESC, g DESC LIMIT 3;");
// 		while ($row = $db->fetch_array($result)) {
// 			$sql2 = "SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $row['teamid'] . "' LIMIT 1;";
// 			$result2 = $db->query($sql2);
// 			while ($row2 = $db->fetch_array($result2)) {
// 				$mannschaft_id = $row['teamid'];
// 				$mannschaft = $row2['name'];
// 				eval("\$wm2018_correct8_bit_select_bit .= \"" . $tpl->get('wm2018_correct8_bit_select_bit', 1) . "\";");
// 			}

// 		}
// 	}

// 	$spiele_mit_dritten_team1 = array("{$lang->items['LANG_ACP_WM2018_CORRECT8_9']} B", "{$lang->items['LANG_ACP_WM2018_CORRECT8_9']} D", "{$lang->items['LANG_ACP_WM2018_CORRECT8_9']} A", "{$lang->items['LANG_ACP_WM2018_CORRECT8_9']} C");
// 	$spiele_mit_dritten_team2 = array("A/C/D", "B/E/F", "C/D/E", "A/B/F");
// 	$spiele_mit_dritten_dritte_aus_gruppen = array(array("A", "C", "D"), array("B", "E", "F"), array("C", "D", "E"), array("A", "B", "F"));

// 	foreach ($spiele_mit_dritten as $key => $spielid) {
// 		$spiel_team_1 = $spiele_mit_dritten_team1[$key];
// 		$spiel_team_2 = "Dritter " . $spiele_mit_dritten_team2[$key];
// 		$result = $db->unbuffered_query("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid='" . $spielid . "'");
// 		while ($row = $db->fetch_array($result)) {
// 			$wm2018_correct8_bit_select = '';
// 			$sql2 = "SELECT name, flagge FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $row['team_1_id'] . "' LIMIT 1;";
// 			$result2 = $db->unbuffered_query($sql2);
// 			if ($db->num_rows($result2) == 0) {
// 				// Spiel steht noch nicht fest
// 				$spiel_team_1_name = "{$lang->items['LANG_ACP_WM2018_CORRECT8_8']} <img src=\"../images/wm2018/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_ACP_WM2018_CORRECT8_8']}\" title=\"{$lang->items['LANG_ACP_WM2018_CORRECT8_8']}\" />";
// 			} else {
// 				while ($row2 = $db->fetch_array($result2)) {
// 					$spiel_team_1_name = $row2['name'] . " <img src=\"../images/wm2018/flaggen/{$row2['flagge']}\" border=\"0\" alt=\"{$row2['name']}\" title=\"{$row2['name']}\" />";
// 				}
// 			}

// 			$sql2 = "SELECT name, flagge FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $row['team_2_id'] . "' LIMIT 1;";
// 			$result2 = $db->unbuffered_query($sql2);
// 			if ($db->num_rows($result2) == 0) {
// 				$spiel_team_2_name = "{$lang->items['LANG_ACP_WM2018_CORRECT8_8']} <img src=\"../images/wm2018/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_ACP_WM2018_CORRECT8_8']}\" title=\"{$lang->items['LANG_ACP_WM2018_CORRECT8_8']}\" />";
// 			} else {
// 				while ($row2 = $db->fetch_array($result2)) {
// 					$spiel_team_2_name = $row2['name'] . " <img src=\"../images/wm2018/flaggen/{$row2['flagge']}\" border=\"0\" alt=\"{$row2['name']}\" title=\"{$row2['name']}\" />";

// 					bestedritte_alle($spiele_mit_dritten_dritte_aus_gruppen[$key]);

// 					eval("\$wm2018_correct8_bit_select .= \"" . $lang->items['LANG_ACP_WM2018_CORRECT8_3'] . " " . $tpl->get('wm2018_correct8_bit_select', 1) . "\";");
// 				}
// 			}
// 		}
// 		eval("\$wm2018_correct8_bit .= \"" . $tpl->get('wm2018_correct8_bit', 1) . "\";");
// 	}
// 	$punkte = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '" . intval($_REQUEST['punkteid']) . "'");
// 	eval("\$tpl->output(\"" . $tpl->get('wm2018_correct8', 1) . "\");");
// }

if ($action == "results") {
	$allids2[] = array();
	$allnames2[] = array();
	$allflags2[] = array();
	$result_teams = $db->query("SELECT * FROM bb" . $n . "_wm2018_teams ORDER BY teamid ASC");
	while ($row_teams = $db->fetch_array($result_teams)) {
		$allids2[] = $row_teams['teamid'];
		$allnames2[] = $row_teams['name'];
		$allflags2[] = $row_teams['flagge'];
	}
	$result_games = $db->query("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE team_1_id IS NOT NULL AND team_2_id IS NOT NULL ORDER BY datetime ASC");
	while ($row_games = $db->fetch_array($result_games)) {
		$rowclass = getone($count++, "firstrow", "secondrow");
		$date = formatdate($wbbuserdata['dateformat'], $row_games['datetime'], 1);
		$date = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $date);
		$time = formatdate($wbbuserdata['timeformat'], $row_games['datetime']);
		for ($i = 0; $i < count($allids2); $i++) {
			if ($row_games['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row_games['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		eval("\$wm2018_results_viewbit .= \"" . $tpl->get('wm2018_results_viewbit', 1) . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get('wm2018_results_view', 1) . "\");");
}

if ($action == "result_add") {
	// check if result can be written or if waiting for others
	$result = $db->query("SELECT gameid FROM bb" . $n . "_wm2018_spiele WHERE team_1_id AND team_2_id AND game_goals_1 != '' AND game_goals_2 != '' AND gameid < " . intval($_REQUEST['gameid']) . " ORDER BY datetime ASC");

	$entry_games_until = intval($_REQUEST['gameid']) - 1;
	if (intval($_REQUEST['gameid']) > $gameid_vorrundenendspiel && $db->num_rows($result) != $entry_games_until) {
		// error
		eval("\$tpl->output(\"" . $tpl->get('wm2018_result_add_error', 1) . "\");");
	} else {
		// Check, ob das Spiel schon vorbei ist:
		$result = $db->query_first("SELECT datetime FROM bb" . $n . "_wm2018_spiele WHERE gameid = " . intval($_REQUEST['gameid']) . " LIMIT 1;");
		if ($result['datetime'] + 6300 < time()) {
			// proceed
			$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");
			$result = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
			$result_1 = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $result['team_1_id'] . "'");
			$result_2 = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $result['team_2_id'] . "'");
			eval("\$tpl->output(\"" . $tpl->get('wm2018_result_add', 1) . "\");");
		} else {
			eval("\$tpl->output(\"" . $tpl->get('wm2018_result_add_error_gamestillrunning', 1) . "\");");
		}
	}
}

if ($action == "result_save") {
	if ($_POST['send'] == 'send' && $_POST['mode'] == 'save') {
		//hier zun�chst pr�fen, ob dieses Spiel bereits eingetragen wurde. Wenn ja, dann verweigere die Speicherung!
		//
		$do_not_proceed = false;
		$result_checkgameexistance = $db->query("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid = '" . intval($_POST['gameid']) . "' LIMIT 1;");
		while ($row_checkgameexistance = $db->fetch_array($result_checkgameexistance)) {
			if ($row['game_goals_1'] > 0) {
				//Ergebnis steht schon drin
				$do_not_proceed = true;
			}
		}
		//
		//
		$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");

		if (!$do_not_proceed) {
			// Reset "Tageswertung" *Anfang*

			// check, ob heute schon geresettet wurde
			$result_lastreset = $db->query_first("SELECT lasttageswertungreset FROM bb" . $n . "_wm2018_options LIMIT 1;");

			// Wenn nein, dann fahre ein Update
			if (date("m", $result_lastreset['lasttageswertungreset']) < date("m", time())) {
				$db->query("DROP TABLE IF EXISTS bb" . $n . "_wm2018_vortag");
				$db->query("CREATE TABLE bb" . $n . "_wm2018_vortag (userid int(5), punkte int(10), pos int(3) default NULL auto_increment, PRIMARY KEY (pos));");
				$db->query("ALTER TABLE bb" . $n . "_wm2018_vortag ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;");
				$db->query("ALTER TABLE bb" . $n . "_wm2018_vortag ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;");
				$db->query("UPDATE bb" . $n . "_wm2018_options SET lasttageswertungreset = '" . time() . "';");
				$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_wm2018_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, ((tipps_richtig+tipps_tendenz)/tipps_falsch) DESC,tipps_gesamt DESC Limit 0,{$wm2018_options['topuser']}");

				while ($row_topuser = $db->fetch_array($result_topuser)) {
					//insert values vortag
					$wm2018_rank_merk = $wm2018_rank_merk + 1;
					if ($wm2018_punkte_merk != $row_topuser['punkte']) {
						$wm2018_rank = $wm2018_rank_merk;
						$wm2018_punkte_merk = $row_topuser['punkte'];
					}
					$db->query("INSERT INTO bb" . $n . "_wm2018_vortag (userid, punkte, pos) VALUES ('" . $row_topuser['userid'] . "', '" . $row_topuser['punkte'] . "', '" . $wm2018_rank . "');");
				}
			}
			// Reset "Tageswertung" *Ende*

			// Alle Usertipps zu diesem Spiel auslesen
			$result_usertipps = $db->query("SELECT * FROM bb" . $n . "_wm2018_usertipps WHERE gameid = '" . intval($_POST['gameid']) . "' ORDER BY userid ASC");
			while ($row_usertipps = $db->fetch_array($result_usertipps)) {
				// +++++++++++++++++++ 1. Pr�fung
				// Tipp exakt richtig ?
				$ende = 0;
				$punkteplus = 0;
				$tipp = 0;
				$ghplus = 0;
				if ($row_usertipps['goals_1'] == $_POST['game_goals_1'] && $row_usertipps['goals_2'] == intval($_POST['game_goals_2'])) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '1'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
					if ($wm2018_options['gh_aktiv'] == 1) {
						$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_richtig'];
					}
					$tipp = 1;
					$ende = 1;
				}
				// +++++++++++++++++++ 2. Pr�fung
				// Spiel unentschieden, Tipp unentschieden, Tendenz aktiviert und richtig ?
				if ($ende == 0) {
					if ($wm2018_options['tendenz'] == 1) {
						if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && (intval($_POST['game_goals_1']) == intval($_POST['game_goals_2']))) {
							$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
							$punkteplus = $punkteplus + $punkte4user['wert'];
							if ($wm2018_options['gh_aktiv'] == 1) {
								$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_tendenz'];
							}
							$tipp = 2;
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++ 3. Pr�fung
				// Spiel unentschieden, Tipp unentschieden, Tendenz deaktiviert und Tipp falsch ?
				if ($ende == 0) {
					if ($wm2018_options['tendenz'] == 0) {
						if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && (intval($_POST['game_goals_1']) == intval($_POST['game_goals_2']))) {
							$tipp = 3;
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++ 4. Pr�fung
				// Spiel unentschieden, Tipp Sieg
				if ($ende == 0) {
					if (($_POST['game_goals_1'] == $_POST['game_goals_2']) && ($row_usertipps['goals_1'] != $row_usertipps['goals_2'])) {
						$tipp = 3;
						$ende = 1;
					}
				}
				// +++++++++++++++++++ 5. Pr�fung
				// Spiel Sieg, Tipp Sieg (falsch), Tendenz aktiviert und richtig ?
				if ($ende == 0) {
					if ($wm2018_options['tendenz'] == 1) {
						if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
							$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
							$punkteplus = $punkteplus + $punkte4user['wert'];
							if ($wm2018_options['gh_aktiv'] == 1) {
								$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_tendenz'];
							}
							$tipp = 2;
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++ 6. Pr�fung
				// Spiel Sieg, Tipp Sieg (falsch), Tendenz deaktiviert und Tipp falsch ?
				if ($ende == 0) {
					if ($wm2018_options['tendenz'] == 0) {
						if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
							$tipp = 3;
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++ 7. Pr�fung
				// Spiel Sieg, Tipp Niederlage
				// Siel Niederlage, Tipp Sieg
				// Spiel Sieg, Tipp unentschieden
				if ($ende == 0) {
					if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || ($_POST['game_goals_1'] != $_POST['game_goals_2']) && ($row_usertipps['goals_1'] == $row_usertipps['goals_2'])) {
						$tipp = 3;
						$ende = 1;
					}
				}
				if ($wm2018_options['gk_jn'] == 1) {
					if (intval($_POST['game_gk_jn']) == $row_usertipps['gk']) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '3'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
					}
				}
				if ($wm2018_options['rk_jn'] == 1) {
					if (intval($_POST['game_rk_jn']) == $row_usertipps['rk']) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '4'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
					}
				}
				if ($wm2018_options['elfer_jn'] == 1) {
					if (intval($_POST['game_elfer_jn']) == $row_usertipps['elfer']) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '5'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
					}
				}
				if ($tipp == 1) {
					$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_richtig=tipps_richtig+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
				}

				if ($tipp == 2) {
					$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_tendenz=tipps_tendenz+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
				}

				if ($tipp == 3) {
					$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_falsch=tipps_falsch+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
				}

				if ($wm2018_options['gh_aktiv'] == 1 && $ghplus > 0) {
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben+{$ghplus} WHERE userid = '" . $row_usertipps['userid'] . "'");
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . $row_usertipps['userid'] . "','" . time() . "','" . $lang->items['LANG_ACP_WM2018_PHP_1'] . " #" . intval($_POST['gameid']) . ")','" . $ghplus . "','" . $lang->items['LANG_ACP_WM2018_PHP_2'] . "')");
				}
			}
			// Link zum Spiel pr�fen
			if (isset($_POST['gamelink'])) {
				$gamelink = htmlconverter($_POST['gamelink']);
			} else {
				$gamelink = '';
			}

			if (!preg_match("/[a-zA-Z]:\/\//si", $gamelink)) {
				$gamelink = "http://" . $gamelink;
			}

			// Speichern des Spielergebnisses
			$db->query("UPDATE bb" . $n . "_wm2018_spiele SET game_goals_1 = '" . intval($_POST['game_goals_1']) . "', game_goals_2 = '" . intval($_POST['game_goals_2']) . "', game_gk = '" . intval($_POST['game_gk_jn']) . "', game_rk = '" . intval($_POST['game_rk_jn']) . "', game_elfer = '" . intval($_POST['game_elfer_jn']) . "', gamelink = '" . addslashes($gamelink) . "', gamecomment = '" . addslashes($_POST['gamecomment']) . "' WHERE gameid = '" . intval($_POST['gameid']) . "'");
			// Update der Teamdaten bei Vorrundenspielen
			if (intval($_POST['gameid']) <= $gameid_vorrundenendspiel) {
				// Tordifferenz berechnen
				$td1 = intval($_POST['game_goals_1']) - intval($_POST['game_goals_2']);
				$td2 = intval($_POST['game_goals_2']) - intval($_POST['game_goals_1']);
				if (intval($_POST['game_goals_1']) == intval($_POST['game_goals_2'])) {
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, u=u+1, td=td+{$td1}, punkte=punkte+1 WHERE teamid = '" . intval($_POST['team1']) . "'");
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, u=u+1, td=td+{$td2}, punkte=punkte+1 WHERE teamid = '" . intval($_POST['team2']) . "'");
				} elseif (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, g=g+1, td=td+$td1, punkte=punkte+3 WHERE teamid = '" . intval($_POST['team1']) . "'");
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, v=v+1, td=td+$td2 WHERE teamid = '" . intval($_POST['team2']) . "'");
				} elseif (intval($_POST['game_goals_1']) < intval($_POST['game_goals_2'])) {
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, v=v+1, td=td+$td1 WHERE teamid = '" . intval($_POST['team1']) . "'");
					$db->query("UPDATE bb" . $n . "_wm2018_teams SET spiele=spiele+1, g=g+1, td=td+$td2, punkte=punkte+3 WHERE teamid = '" . intval($_POST['team2']) . "'");
				}
			}

			// Achtelfinale aufbauen
			$check_8_gameids = array(34, 36, 38, 40, 44, 42, 48, 46);
			$gruppenids = array("A", "B", "C", "D", "E", "F", "G", "H");
			$savegameids1 = array(50, 51, 49, 52, 54, 56, 53, 55);
			$savegameids2 = array(51, 50, 52, 49, 56, 54, 55, 53);
			if (in_array(intval($_POST['gameid']), $check_8_gameids)) {
				for ($i = 0; $i < count($check_8_gameids); $i++) {
					if (intval($_POST['gameid']) == $check_8_gameids[$i]) {
						$result = $db->query("SELECT teamid FROM bb" . $n . "_wm2018_teams WHERE gruppe = '" . $gruppenids[$i] . "' ORDER BY punkte DESC, td DESC, g DESC LIMIT 2");
						while ($row = $db->fetch_array($result)) {
							$teamids[] = $row['teamid'];
						}

						$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_1_id = '" . $teamids['0'] . "' WHERE gameid = '" . $savegameids1[$i] . "'");

						$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '" . $teamids['1'] . "' WHERE gameid = '" . $savegameids2[$i] . "'");
					}
				}
			}

			/*
					//Sonderlocken seit EM 2016: beste Dritte der jeweiligen Gruppen
					function bestedritte($groupids, $currentgameid) {
						global $db, $n;

						$db->query("TRUNCATE TABLE bb" . $n . "_wm2018_bestedrittetmp;");
						foreach ($groupids as $groupid) {
							$counter = 0;
							$result = $db->query("SELECT teamid, td, punkte, g FROM bb" . $n . "_wm2018_teams WHERE gruppe = '" . $groupid . "' ORDER BY punkte DESC, td DESC, g DESC LIMIT 3");
							while ($row = $db->fetch_array($result)) {
								if (++$counter < 3) {
									continue;
								}
								$db->query("INSERT INTO bb" . $n . "_wm2018_bestedrittetmp (`teamid`, `punkte`, `td`, `g`) VALUES ('" . $row['teamid'] . "', '" . $row['punkte'] . "', '" . $row['td'] . "', '" . $row['g'] . "');");
							}
						}

						$result = $db->query("SELECT teamid FROM bb" . $n . "_wm2018_bestedrittetmp ORDER BY punkte DESC, td DESC, g DESC");
						while ($row = $db->fetch_array($result)) {
							// $docontinue -> ist das gefunde team schon in einem anderen Spiel?
							$docontinue = false;
							if ($currentgameid != 32) {
								if ($currentgameid >= 34) {
									$result = $db->query("SELECT team_2_id FROM bb" . $n . "_wm2018_spiele WHERE gameid = '38';");
									while ($row2 = $db->fetch_array($result)) {
										if ($row2['team_2_id'] == $row['teamid']) {
											$docontinue = true;
										}
									}
								}

								if ($currentgameid >= 36) {
									$result = $db->query("SELECT team_2_id FROM bb" . $n . "_wm2018_spiele WHERE gameid = '39';");
									while ($row2 = $db->fetch_array($result)) {
										if ($row2['team_2_id'] == $row['teamid']) {
											$docontinue = true;
										}
									}
								}

								if ($currentgameid >= 36) {
									$result = $db->query("SELECT team_2_id FROM bb" . $n . "_wm2018_spiele WHERE gameid = '39';");
									while ($row2 = $db->fetch_array($result)) {
										if ($row2['team_2_id'] == $row['teamid']) {
											$docontinue = true;
										}
									}

									$result = $db->query("SELECT team_2_id FROM bb" . $n . "_wm2018_spiele WHERE gameid = '41';");
									while ($row2 = $db->fetch_array($result)) {
										if ($row2['team_2_id'] == $row['teamid']) {
											$docontinue = true;
										}
									}
								}

								if ($docontinue) {
									continue;
								} else {
									return $row['teamid'];
								}

							} else {
								return $row['teamid'];
							}
						}

				if (intval($_POST['gameid']) == 32) {
					//Dritter A/C/D in 2. 38
					// $bestteam_id = bestedritte(array("A", "C", "D"), 32);
					$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '" . $bestteam_id . "' WHERE gameid = '38'");
				} elseif (intval($_POST['gameid']) == 34) {
					//Dritter C/D/E in 2. 40
					// $bestteam_id = bestedritte(array("C", "D", "E"), 34);
					$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '" . $bestteam_id . "' WHERE gameid = '40'");
				} elseif (intval($_POST['gameid']) == 36) {
					//Dritter B/E/F in 2. 39
					// $bestteam_id = bestedritte(array("B", "E", "F"), 36);
					$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '" . $bestteam_id . "' WHERE gameid = '39'");
					//Dritter A/B/F in 2. 41
					// $bestteam_id = bestedritte(array("A", "B", "F"), 36);
					$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '" . $bestteam_id . "' WHERE gameid = '41'");
				}
			*/

			// Vorrunde vorbei, jetzt wird die KO-Runde aufgebaut

			// Viertelfinale aufbauen
			$checkgameids1 = array(54, 59, 56, 51);
			$checkgameids2 = array(53, 60, 55, 52);
			$savegameids = array($gameid_viertelfinal1, $gameid_viertelfinal2, $gameid_viertelfinal3, $gameid_viertelfinal4);
			// Team 1 eintragen
			if (in_array($_POST['gameid'], $checkgameids1)) {
				for ($i = 0; $i < count($checkgameids1); $i++) {
					if ($_POST['gameid'] == $checkgameids1[$i]) {
						if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
							$teamid = intval($_POST['team1']);
						}

						if (intval($_POST['game_goals_1']) < intval($_POST['game_goals_2'])) {
							$teamid = intval($_POST['team2']);
						}
						$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_1_id = '{$teamid}' WHERE gameid = '" . $savegameids[$i] . "'");
					}
				}
			}

			// Team 2 eintragen
			if (in_array(intval($_POST['gameid']), $checkgameids2)) {
				for ($i = 0; $i < count($checkgameids2); $i++) {
					if (intval($_POST['gameid']) == $checkgameids2[$i]) {
						if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
							$teamid = intval($_POST['team1']);
						}
						if (intval($_POST['game_goals_1']) < intval($_POST['game_goals_2'])) {
							$teamid = intval($_POST['team2']);
						}
						$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '{$teamid}' WHERE gameid = '" . $savegameids[$i] . "'");
					}
				}
			}

			// Halbfinale aufbauen
			if (intval($_POST['gameid']) == $gameid_viertelfinal1) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_1_id = '{$team_g}' WHERE gameid = '{$gameid_halbfinal1}'");
			} elseif (intval($_POST['gameid']) == $gameid_viertelfinal2) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '{$team_g}' WHERE gameid = '{$gameid_halbfinal1}'");
			} elseif (intval($_POST['gameid']) == $gameid_viertelfinal3) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_1_id = '{$team_g}' WHERE gameid = '{$gameid_halbfinal2}'");
			} elseif (intval($_POST['gameid']) == $gameid_viertelfinal4) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '{$team_g}' WHERE gameid = '{$gameid_halbfinal2}'");
			}

			// Finale aufbauen
			if (intval($_POST['gameid']) == $gameid_halbfinal1) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_1_id = '{$team_g}' WHERE gameid = '{$gameid_finale}'");
			} elseif (intval($_POST['gameid']) == $gameid_halbfinal2) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
				} else {
					$team_g = intval($_POST['team2']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_spiele SET team_2_id = '{$team_g}' WHERE gameid = '{$gameid_finale}'");
			}

			// Finale abschlie�en
			if (intval($_POST['gameid']) == $gameid_finale) {
				if (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team1']);
					$team_v = intval($_POST['team2']);
				}
				if (intval($_POST['game_goals_1']) < intval($_POST['game_goals_2'])) {
					$team_g = intval($_POST['team2']);
					$team_v = intval($_POST['team1']);
				}
				$db->query("UPDATE bb" . $n . "_wm2018_options SET 1st = '{$team_g}', 2nd = '{$team_v}'");
				if ($wm2018_options['winnertipp_jn'] == 1) {
					$punkte4user_em = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '6'");
					$punkte4user_vem = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '7'");
					$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte = punkte + {$punkte4user_em['wert']} WHERE tipp_wm = '{$team_g}'");
					$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte = punkte + {$punkte4user_vem['wert']} WHERE tipp_vwm = '{$team_v}'");
					// Guthabenhack aktiv ?
					if ($wm2018_options['gh_aktiv'] == 1) {
						$result = $db->query("SELECT * FROM bb" . $n . "_wm2018_userpunkte WHERE tipp_wm = '{$team_g}'");
						while ($row = $db->fetch_array($result)) {
							$db->query("UPDATE bb" . $n . "_users SET guthaben = guthaben + {$wm2018_options['gh_gut_wmtipp_richtig']} WHERE userid = '" . $row['userid'] . "'");
							$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . $row['userid'] . "','" . time() . "','" . $lang->items['LANG_ACP_WM2018_PHP_3'] . "','" . $wm2018_options['gh_gut_wmtipp_richtig'] . "','" . $lang->items['LANG_ACP_WM2018_PHP_2'] . "')");
						}
						$result = $db->query("SELECT * FROM bb" . $n . "_wm2018_userpunkte WHERE tipp_vwm = '{$team_v}'");
						while ($row = $db->fetch_array($result)) {
							$db->query("UPDATE bb" . $n . "_users SET guthaben = guthaben + {$wm2018_options['gh_gut_wmtipp_richtig']} WHERE userid = '" . $row['userid'] . "'");
							$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . $row['userid'] . "','" . time() . "','" . $lang->items['LANG_ACP_WM2018_PHP_4'] . "','" . $wm2018_options['gh_gut_wmtipp_richtig'] . "','" . $lang->items['LANG_ACP_WM2018_PHP_2'] . "')");
						}
					}
				}
			}

			/* Anfang Posting erstellen vgpost */
			if ($wm2018_options['po_aktiv'] == 1) {
				$spiel_erg = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid = '" . intval($_POST['gameid']) . "'");
				$vgp_gameid = $spiel_erg['gameid'];
				$vgp_gruppe = $spiel_erg['gruppe'];
				$vgp_stadion = $spiel_erg['stadion'];
				$vgp_datum = formatdate($wbbuserdata['dateformat'], $spiel_erg['datetime']);
				$vgp_zeit = formatdate($wbbuserdata['timeformat'], $spiel_erg['datetime']);

				if ($spiel_erg['game_gk'] == 1) {
					$vgp_gk = $lang->items['LANG_ACP_GLOBAL_YES'];
				} else {
					$vgp_gk = $lang->items['LANG_ACP_GLOBAL_NO'];
				}

				if ($spiel_erg['game_rk'] == 1) {
					$vgp_rk = $lang->items['LANG_ACP_GLOBAL_YES'];
				} else {
					$vgp_rk = $lang->items['LANG_ACP_GLOBAL_NO'];
				}

				if ($spiel_erg['game_elfer'] == 1) {
					$vgp_elfer = $lang->items['LANG_ACP_GLOBAL_YES'];
				} else {
					$vgp_elfer = $lang->items['LANG_ACP_GLOBAL_NO'];
				}

				$vgp_tore1 = $spiel_erg['game_goals_1'];
				$vgp_tore2 = $spiel_erg['game_goals_2'];
				$vgp_glink = $spiel_erg['gamelink'];
				$vgp_comment = stripcrap(wbb_trim($spiel_erg['gamecomment']));
				$vgp_comment = parseURL($vgp_comment);
				$vgp_anztipp = $spiel_erg['tipps'];
				$spiel_name1 = $db->query_first("SELECT name, flagge  FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . intval($spiel_erg['team_1_id']) . "'");
				$vgp_flagge1 = '[img]images/wm2018/flaggen/' . $spiel_name1['flagge'] . '[/img]';
				$spiel_name2 = $db->query_first("SELECT name, flagge  FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . intval($spiel_erg['team_2_id']) . "'");
				$vgp_flagge2 = '[img]images/wm2018/flaggen/' . $spiel_name2['flagge'] . '[/img]';

				$vgp_user_ranking_01 = '';
				$vgp_user_ranking_02 = '';
				$vgp_user_ranking_03 = '';
				$vgp_user_ranking_04 = '';
				$vgp_user_ranking_05 = '';
				$vgp_user_ranking_06 = '';
				$vgp_user_ranking_07 = '';
				$vgp_user_ranking_08 = '';
				$vgp_user_ranking_09 = '';
				$vgp_user_ranking_10 = '';
				$vgp_count = 0;
				$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_wm2018_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, tipps_gesamt DESC Limit 0, 10");
				$wm2018_rank_merk = 0;
				while ($row_topuser = $db->fetch_array($result_topuser)) {
					$vgp_count++;

					// ** Ranking Start *//
					$wm2018_rank_merk = $wm2018_rank_merk + 1;
					if ($wm2018_punkte_merk != $row_topuser['punkte']) {
						$wm2018_rank = $wm2018_rank_merk;
						$wm2018_punkte_merk = $row_topuser['punkte'];
					}
					if ($wm2018_rank == 1) {
						$wm2018_userrank = "[img]images/wm2018/wm2018_rank_1.gif[/img]";
					}

					if ($wm2018_rank == 2) {
						$wm2018_userrank = "[img]images/wm2018/wm2018_rank_2.gif[/img]";
					}

					if ($wm2018_rank == 3) {
						$wm2018_userrank = "[img]images/wm2018/wm2018_rank_3.gif[/img]";
					}

					if ($wm2018_rank > 3) {
						$wm2018_userrank = "[b]{$wm2018_rank}[/b]";
					}

					// Tageswertung *Anfang*
					$vortag = $db->query_first("SELECT userid,pos,punkte FROM bb" . $n . "_wm2018_vortag WHERE userid = '" . intval($row_topuser['userid']) . "'");

					if (!isset($vortag['pos']) || $vortag['pos'] > $wm2018_rank) {
						$tagtendenz = "[img]./images/wm2018/hoch.jpg[/IMG]";
					} elseif ($vortag['pos'] == $wm2018_rank) {
						$tagtendenz = "[img]./images/wm2018/gleich.gif[/IMG]";
					} else {
						$tagtendenz = "[img]./images/wm2018/runter.jpg[/IMG]";
					}

					// Tageswertung *Ende*

					if ($vgp_count == 1) {
						$vgp_user_ranking_01 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 2) {
						$vgp_user_ranking_02 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 3) {
						$vgp_user_ranking_03 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 4) {
						$vgp_user_ranking_04 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 5) {
						$vgp_user_ranking_05 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 6) {
						$vgp_user_ranking_06 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 7) {
						$vgp_user_ranking_07 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 8) {
						$vgp_user_ranking_08 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 9) {
						$vgp_user_ranking_09 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					if ($vgp_count == 10) {
						$vgp_user_ranking_10 = $wm2018_userrank . '  [url=' . $url2board . '/wm2018.php?action=showusertippsdetail&userid=' . $row_topuser['userid'] . ']' . $row_topuser['username'] . '[/URL] Punkte: ' . $row_topuser['punkte'] . ' | Anzahl Tipps: ' . $row_topuser['tipps_gesamt'] . $tagtendenz;
					}

					// ** Ranking Ende *//
				}

				if ($wm2018_options['vboardid'] != 0) {
					$time = time();
					$boardid = $wm2018_options['vboardid'];

					/* Thread erstellen */
					$posting_thema = '';
					if ($wm2018_options['vgthema'] != '') {
						$posting_thema = strtr($wm2018_options['vgthema'], array('{vgp_name1}' => $vgp_name1, '{vgp_name2}' => $vgp_name2));
					} else {
						$posting_thema = 'WM2018 - Ergebnis';
					}

					$posting_prefix = '';
					if ($wm2018_options['vprefix'] != '') {
						$posting_prefix = $wm2018_options['vprefix'];
					} else {
						$posting_prefix = '';
					}

					/* Username holen */
					$user_info = $db->query_first("SELECT username FROM bb" . $n . "_users WHERE userid = '" . $wm2018_options['vgpostuid'] . "'");
					$vgp_username = $user_info['username'];

					if (intval($wm2018_options['vgposttid']) == 0) {
						$db->query("INSERT INTO bb" . $n . "_threads (boardid,prefix,topic,iconid,starttime,starterid,starter,lastposttime,lastposterid,lastposter,attachments,pollid,important,visible)
								VALUES ('" . $boardid . "', '" . addslashes($posting_prefix) . "', '" . addslashes($posting_thema) . "', '" . $wm2018_options['viconid'] . "', '" . $time . "', '" . $wm2018_options['vgpostuid'] . "', '" . addslashes($user_info['username']) . "', '" . $time . "', '" . $wm2018_options['vgpostuid'] . "', '" . addslashes($user_info['username']) . "', '0', '0', '0', '1')");
						$threadid = $db->insert_id();
					} else {
						$threadid = $wm2018_options['vgposttid'];
					}

					$b_thread = strtr($wm2018_options['message'], array('{vgp_gameid}' => $vgp_gameid, '{vgp_gruppe}' => $vgp_gruppe, '{vgp_stadion}' => $vgp_stadion, '{vgp_datum}' => $vgp_datum, '{vgp_zeit}' => $vgp_zeit, '{vgp_gk}' => $vgp_gk, '{vgp_rk}' => $vgp_rk, '{vgp_elfer}' => $vgp_elfer, '{vgp_glink}' => $vgp_glink, '{vgp_comment}' => $vgp_comment, '{vgp_anztipp}' => $vgp_anztipp, '{vgp_name1}' => $vgp_name1, '{vgp_tore1}' => $vgp_tore1, '{vgp_flagge1}' => $vgp_flagge1, '{vgp_name2}' => $vgp_name2, '{vgp_tore2}' => $vgp_tore2, '{vgp_flagge2}' => $vgp_flagge2, '{vgp_username}' => $vgp_username, '{vgp_user_ranking_01}' => $vgp_user_ranking_01, '{vgp_user_ranking_02}' => $vgp_user_ranking_02, '{vgp_user_ranking_03}' => $vgp_user_ranking_03, '{vgp_user_ranking_04}' => $vgp_user_ranking_04, '{vgp_user_ranking_05}' => $vgp_user_ranking_05, '{vgp_user_ranking_06}' => $vgp_user_ranking_06, '{vgp_user_ranking_07}' => $vgp_user_ranking_07, '{vgp_user_ranking_08}' => $vgp_user_ranking_08, '{vgp_user_ranking_09}' => $vgp_user_ranking_09, '{vgp_user_ranking_10}' => $vgp_user_ranking_10));
					$b_thread = parseURL($b_thread);

					/* Post erstellen */
					$subjekt = $posting_thema;
					$db->query("INSERT INTO bb" . $n . "_posts (threadid,userid,username,iconid,posttopic,posttime,message,attachments,allowsmilies,allowhtml,allowbbcode,allowimages,showsignature,ipaddress,visible)
							VALUES ('" . $threadid . "', '" . $wm2018_options['vgpostuid'] . "', '" . addslashes($user_info['username']) . "', '" . $wm2018_options['viconid'] . "', '" . addslashes($subjekt) . "', '" . $time . "', '" . addslashes($b_thread) . "', '0', '1', '" . $wm2018_options['vgposthtml'] . "', '1', '1', '1', '" . addslashes($REMOTE_ADDR) . "', '1')");
					$postid = $db->insert_id();

					/* Board updaten */
					$boardstr = $db->query_first("SELECT parentlist FROM bb" . $n . "_boards WHERE boardid = '" . $boardid . "'");
					$parentlist = $boardstr['parentlist'];
					if (intval($wm2018_options['vgposttid']) == 0) {
						/* update board info */
						$db->unbuffered_query("UPDATE bb" . $n . "_boards SET threadcount=threadcount+1, postcount=postcount+1, lastthreadid='{$threadid}', lastposttime='" . $time . "', lastposterid='" . $wm2018_options['vgpostuid'] . "', lastposter='" . addslashes($user_info['username']) . "' WHERE boardid IN ($parentlist,$boardid)", 1);
					} else {
						/* update thread info */
						$db->unbuffered_query("UPDATE bb" . $n . "_threads SET lastposttime = '" . $time . "', lastposterid = '" . $wm2018_options['vgpostuid'] . "', lastposter = '" . addslashes($user_info['username']) . "', replycount = replycount+1 WHERE threadid = '{$threadid}'", 1);

						/* update board info */
						$db->unbuffered_query("UPDATE bb" . $n . "_boards SET postcount=postcount+1, lastthreadid='{$threadid}', lastposttime='" . $time . "', lastposterid='" . $wm2018_options['vgpostuid'] . "', lastposter='" . addslashes($user_info['username']) . "' WHERE boardid IN ({$parentlist},{$boardid})", 1);
					}
					$db->unbuffered_query("UPDATE bb" . $n . "_users SET userposts=userposts+1 WHERE userid = '" . $wm2018_options['vgpostuid'] . "'", 1);

					/* Statistik updaten */
					if (intval($wm2018_options['vgposttid']) == 0) {
						$db->unbuffered_query("UPDATE bb" . $n . "_stats SET threadcount=threadcount+1, postcount=postcount+1", 1);
					} else {
						$db->unbuffered_query("UPDATE bb" . $n . "_stats SET postcount=postcount+1", 1);
					}
				}
			}
			/* Ende Posting erstellen vgpost */
		}
		// Weiterleitung auf die Ergebnis�bersicht
		header("Location: wm2018_admin.php?action=results&sid={$session['hash']}");
		exit();

	}
	// ++++++++++++++++++++++++++++++++++++
	if ($_POST['send'] == 'send' && $_POST['mode'] == 'confirm') {
		$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");
		$result_1 = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . intval($_POST['team1']) . "'");
		$result_2 = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . intval($_POST['team2']) . "'");
		$gameid = intval($_POST['gameid']);
		$tore1 = intval($_POST['game_goals_1']);
		$tore2 = intval($_POST['game_goals_2']);
		$error = '';
		if (!isset($tore1) || !isset($tore2)) {
			$error .= $lang->get("LANG_ACP_WM2018_PHP_5");
		}

		if ($wm2018_options['gk_jn'] == '1' && $_POST['game_gk_jn'] == '-1') {
			$error .= $lang->get("LANG_ACP_WM2018_PHP_6");
		}

		if ($wm2018_options['rk_jn'] == '1' && $_POST['game_rk_jn'] == '-1') {
			$error .= $lang->get("LANG_ACP_WM2018_PHP_7");
		}

		if ($wm2018_options['elfer_jn'] == '1' && $_POST['game_elfer_jn'] == '-1') {
			$error .= $lang->get("LANG_ACP_WM2018_PHP_8");
		}

		if ($gameid > $gameid_vorrundenendspiel && ($tore1 == $tore2)) {
			$error .= $lang->get("LANG_ACP_WM2018_PHP_9");
		}

		if ($error) {
			eval("\$tpl->output(\"" . $tpl->get('wm2018_error', 1) . "\");");
			exit();
		}
		if ($wm2018_options['gk_jn'] == '1' && intval($_POST['game_gk_jn']) == '1') {
			$confirm_gk = $lang->get("LANG_ACP_WM2018_PHP_YES");
		}

		if ($wm2018_options['gk_jn'] == '1' && intval($_POST['game_gk_jn']) == '0') {
			$confirm_gk = $lang->get("LANG_ACP_WM2018_PHP_NO");
		}

		if ($wm2018_options['rk_jn'] == '1' && intval($_POST['game_rk_jn']) == '1') {
			$confirm_rk = $lang->get("LANG_ACP_WM2018_PHP_YES");
		}

		if ($wm2018_options['rk_jn'] == '1' && intval($_POST['game_rk_jn']) == '0') {
			$confirm_rk = $lang->get("LANG_ACP_WM2018_PHP_NO");
		}

		if ($wm2018_options['elfer_jn'] == '1' && intval($_POST['game_elfer_jn']) == '1') {
			$confirm_elfer = $lang->get("LANG_ACP_WM2018_PHP_YES");
		}

		if ($wm2018_options['elfer_jn'] == '1' && intval($_POST['game_elfer_jn']) == '0') {
			$confirm_elfer = $lang->get("LANG_ACP_WM2018_PHP_NO");
		}

		if (isset($_POST['gamelink'])) {
			$gamelink = htmlconverter($_POST['gamelink']);
		} else {
			$gamelink = '';
		}

		if ($gamelink && !preg_match("/[a-zA-Z]:\/\//si", $gamelink)) {
			$gamelink = "http://" . $gamelink;
		}

		$gamecomment = addslashes($_POST['gamecomment']);
		$gamecomment2 = nl2br($gamecomment);
		eval("\$tpl->output(\"" . $tpl->get('wm2018_result_confirm', 1) . "\");");
	}
}

if ($action == "result_edit") {
	if ($_POST['send'] == 'send') {
		$gamelink = wbb_trim($_POST['gamelink']);
		if (isset($_POST['gamelink'])) {
			$gamelink = htmlconverter($_POST['gamelink']);
		} else {
			$gamelink = '';
		}

		if ($gamelink && !preg_match("/[a-zA-Z]:\/\//si", $gamelink)) {
			$gamelink = "http://" . $gamelink;
		}

		if (isset($_POST['result_gk']) && (trim($_POST['result_gk']) == 0 || trim($_POST['result_gk']) == 1)) {
			$result_gk = intval($_POST['result_gk']);
		} else {
			$result_gk = 0;
		}

		if (isset($_POST['result_rk']) && (trim($_POST['result_rk']) == 0 || trim($_POST['result_rk']) == 1)) {
			$result_rk = intval($_POST['result_rk']);
		} else {
			$result_rk = 0;
		}

		if (isset($_POST['result_elfer']) && (trim($_POST['result_elfer']) == 0 || trim($_POST['result_elfer']) == 1)) {
			$result_elfer = intval($_POST['result_elfer']);
		} else {
			$result_elfer = 0;
		}

		if (isset($_POST['game_goals_1'])) {
			$game_goals_1 = intval($_POST['game_goals_1']);
		} else {
			$game_goals_1 = 0;
		}

		if (isset($_POST['game_goals_2'])) {
			$game_goals_2 = intval($_POST['game_goals_2']);
		} else {
			$game_goals_2 = 0;
		}

		//Punkteneuberechnung *Anfang*

		// ziehe Punkte f�r dieses Spiel ab
		// Suche bisherige Ergebnisse zu diesem Spiel

		$current_game_details = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid = '" . intval($_POST['gameid']) . "' LIMIT 1");

		$result_usertipps = $db->query("SELECT * FROM bb" . $n . "_wm2018_usertipps WHERE gameid = '" . intval($_POST['gameid']) . "' ORDER BY userid ASC");
		while ($row_usertipps = $db->fetch_array($result_usertipps)) {
			// +++++++++++++++++++ 1. Pr�fung
			// Tipp exakt richtig ?
			$ende = 0;
			$punkteplus = 0;
			$tipp = 0;
			$ghminus = 0;
			if ($row_usertipps['goals_1'] == $current_game_details['game_goals_1'] && $row_usertipps['goals_2'] == $current_game_details['game_goals_2']) {
				$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '1'");
				$punkteplus = $punkteplus + $punkte4user['wert'];
				if ($wm2018_options['gh_aktiv'] == 1) {
					$ghminus = $ghminus + $wm2018_options['gh_gut_normtipp_richtig'];
				}
				$tipp = 1;
				$ende = 1;
			}
			// +++++++++++++++++++ 2. Pr�fung
			// Spiel unentschieden, Tipp unentschieden, Tendenz aktiviert und richtig ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 1) {
					if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && ($current_game_details['game_goals_1'] == $current_game_details['game_goals_2'])) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
						if ($wm2018_options['gh_aktiv'] == 1) {
							$ghminus = $ghminus + $wm2018_options['gh_gut_normtipp_tendenz'];
						}
						$tipp = 2;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 3. Pr�fung
			// Spiel unentschieden, Tipp unentschieden, Tendenz deaktiviert und Tipp falsch ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 0) {
					if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && ($current_game_details['game_goals_1'] == $current_game_details['game_goals_2'])) {
						$tipp = 3;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 4. Pr�fung
			// Spiel unentschieden, Tipp Sieg
			if ($ende == 0) {
				if (($current_game_details['game_goals_1'] == $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] != $row_usertipps['goals_2'])) {
					$tipp = 3;
					$ende = 1;
				}
			}
			// +++++++++++++++++++ 5. Pr�fung
			// Spiel Sieg, Tipp Sieg (falsch), Tendenz aktiviert und richtig ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 1) {
					if (($current_game_details['game_goals_1'] < $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || ($current_game_details['game_goals_1'] > $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
						if ($wm2018_options['gh_aktiv'] == 1) {
							$ghminus = $ghminus + $wm2018_options['gh_gut_normtipp_tendenz'];
						}
						$tipp = 2;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 6. Pr�fung
			// Spiel Sieg, Tipp Sieg (falsch), Tendenz deaktiviert und Tipp falsch ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 0) {
					if (($current_game_details['game_goals_1'] < $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || ($current_game_details['game_goals_1'] > $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
						$tipp = 3;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 7. Pr�fung
			// Spiel Sieg, Tipp Niederlage
			// Siel Niederlage, Tipp Sieg
			// Spiel Sieg, Tipp unentschieden
			if ($ende == 0) {
				if (($current_game_details['game_goals_1'] < $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2']) || ($current_game_details['game_goals_1'] > $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || ($current_game_details['game_goals_1'] != $current_game_details['game_goals_2']) && ($row_usertipps['goals_1'] == $row_usertipps['goals_2'])) {
					$tipp = 3;
					$ende = 1;
				}
			}
			if ($wm2018_options['gk_jn'] == 1) {
				if (intval($current_game_details['game_gk']) == $row_usertipps['gk']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '3'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($wm2018_options['rk_jn'] == 1) {
				if (intval($current_game_details['game_rk']) == $row_usertipps['rk']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '4'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($wm2018_options['elfer_jn'] == 1) {
				if (intval($current_game_details['game_elfer']) == $row_usertipps['elfer']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '5'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($tipp == 1) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte-{$punkteplus}, tipps_richtig=tipps_richtig-1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($tipp == 2) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte-{$punkteplus}, tipps_tendenz=tipps_tendenz-1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($tipp == 3) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte-{$punkteplus}, tipps_falsch=tipps_falsch-1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($wm2018_options['gh_aktiv'] == 1 && $ghminus > 0) {
				$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-{$ghminus} WHERE userid = '" . $row_usertipps['userid'] . "'");
				$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . $row_usertipps['userid'] . "','" . time() . "','" . $lang->items['LANG_ACP_WM2018_PHP_9'] . " #" . intval($_POST['gameid']) . ")','" . $ghminus . "','" . $lang->items['LANG_ACP_WM2018_PHP_10'] . "')");
			}
		}

		// Trage die neuen Ergebnisse ein:
		$db->query("UPDATE bb" . $n . "_wm2018_spiele SET gamelink = '" . addslashes($gamelink) . "', gamecomment = '" . addslashes($_POST['gamecomment']) . "', game_gk = '" . intval($result_gk) . "', game_rk = '" . intval($result_rk) . "', game_elfer = '" . intval($result_elfer) . "', game_goals_1 = '" . $game_goals_1 . "', game_goals_2 = '" . $game_goals_2 . "' WHERE gameid = '" . intval($_POST['gameid']) . "';");

		// Berechne nun die Punkte neu f�r dieses Spiel:
		$result_usertipps = $db->query("SELECT * FROM bb" . $n . "_wm2018_usertipps WHERE gameid = '" . intval($_POST['gameid']) . "' ORDER BY userid ASC");
		while ($row_usertipps = $db->fetch_array($result_usertipps)) {
			// +++++++++++++++++++ 1. Pr�fung
			// Tipp exakt richtig ?
			$ende = 0;
			$punkteplus = 0;
			$tipp = 0;
			$ghplus = 0;
			if ($row_usertipps['goals_1'] == $_POST['game_goals_1'] && $row_usertipps['goals_2'] == intval($_POST['game_goals_2'])) {
				$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '1'");
				$punkteplus = $punkteplus + $punkte4user['wert'];
				if ($wm2018_options['gh_aktiv'] == 1) {
					$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_richtig'];
				}
				$tipp = 1;
				$ende = 1;
			}
			// +++++++++++++++++++ 2. Pr�fung
			// Spiel unentschieden, Tipp unentschieden, Tendenz aktiviert und richtig ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 1) {
					if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && (intval($_POST['game_goals_1']) == intval($_POST['game_goals_2']))) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
						if ($wm2018_options['gh_aktiv'] == 1) {
							$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_tendenz'];
						}
						$tipp = 2;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 3. Pr�fung
			// Spiel unentschieden, Tipp unentschieden, Tendenz deaktiviert und Tipp falsch ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 0) {
					if (($row_usertipps['goals_1'] == $row_usertipps['goals_2']) && (intval($_POST['game_goals_1']) == intval($_POST['game_goals_2']))) {
						$tipp = 3;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 4. Pr�fung
			// Spiel unentschieden, Tipp Sieg
			if ($ende == 0) {
				if (($_POST['game_goals_1'] == $_POST['game_goals_2']) && ($row_usertipps['goals_1'] != $row_usertipps['goals_2'])) {
					$tipp = 3;
					$ende = 1;
				}
			}
			// +++++++++++++++++++ 5. Pr�fung
			// Spiel Sieg, Tipp Sieg (falsch), Tendenz aktiviert und richtig ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 1) {
					if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
						$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '2'");
						$punkteplus = $punkteplus + $punkte4user['wert'];
						if ($wm2018_options['gh_aktiv'] == 1) {
							$ghplus = $ghplus + $wm2018_options['gh_gut_normtipp_tendenz'];
						}
						$tipp = 2;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 6. Pr�fung
			// Spiel Sieg, Tipp Sieg (falsch), Tendenz deaktiviert und Tipp falsch ?
			if ($ende == 0) {
				if ($wm2018_options['tendenz'] == 0) {
					if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2'])) {
						$tipp = 3;
						$ende = 1;
					}
				}
			}
			// +++++++++++++++++++ 7. Pr�fung
			// Spiel Sieg, Tipp Niederlage
			// Siel Niederlage, Tipp Sieg
			// Spiel Sieg, Tipp unentschieden
			if ($ende == 0) {
				if (($_POST['game_goals_1'] < $_POST['game_goals_2']) && ($row_usertipps['goals_1'] > $row_usertipps['goals_2']) || (intval($_POST['game_goals_1']) > intval($_POST['game_goals_2'])) && ($row_usertipps['goals_1'] < $row_usertipps['goals_2']) || ($_POST['game_goals_1'] != $_POST['game_goals_2']) && ($row_usertipps['goals_1'] == $row_usertipps['goals_2'])) {
					$tipp = 3;
					$ende = 1;
				}
			}
			if ($wm2018_options['gk_jn'] == 1) {
				if (intval($_POST['game_gk_jn']) == $row_usertipps['gk']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '3'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($wm2018_options['rk_jn'] == 1) {
				if (intval($_POST['game_rk_jn']) == $row_usertipps['rk']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '4'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($wm2018_options['elfer_jn'] == 1) {
				if (intval($_POST['game_elfer_jn']) == $row_usertipps['elfer']) {
					$punkte4user = $db->query_first("SELECT wert FROM bb" . $n . "_wm2018_punkte WHERE punkteid = '5'");
					$punkteplus = $punkteplus + $punkte4user['wert'];
				}
			}
			if ($tipp == 1) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_richtig=tipps_richtig+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($tipp == 2) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_tendenz=tipps_tendenz+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($tipp == 3) {
				$db->query("UPDATE bb" . $n . "_wm2018_userpunkte SET punkte=punkte+{$punkteplus}, tipps_falsch=tipps_falsch+1 WHERE userid = '" . $row_usertipps['userid'] . "'");
			}

			if ($wm2018_options['gh_aktiv'] == 1 && $ghplus > 0) {
				$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben+{$ghplus} WHERE userid = '" . $row_usertipps['userid'] . "'");
				$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . $row_usertipps['userid'] . "','" . time() . "','" . $lang->items['LANG_ACP_WM2018_PHP_1'] . " #" . intval($_POST['gameid']) . ")','" . $ghplus . "','" . $lang->items['LANG_ACP_WM2018_PHP_2'] . "')");
			}
		}

		//Punkteneuberechnung *Ende*

		header("Location: wm2018_admin.php?action=results&sid={$session['hash']}");
		exit();
	}

	$gameid = intval($_REQUEST['gameid']);
	$wm2018_options = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_options");
	$result = $db->query_first("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	$result_1 = $db->query_first("SELECT name,flagge FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $result['team_1_id'] . "'");
	$result_2 = $db->query_first("SELECT name,flagge FROM bb" . $n . "_wm2018_teams WHERE teamid = '" . $result['team_2_id'] . "'");

	if ($wm2018_options['gk_jn'] == '1' && $result['game_gk'] == '1') {
		$selected_result_gk1 = "selected";
	} else {
		$selected_result_gk2 = "selected";
	}

	if ($wm2018_options['rk_jn'] == '1' && $result['game_rk'] == '1') {
		$selected_result_rk1 = "selected";
	} else {
		$selected_result_rk2 = "selected";
	}

	if ($wm2018_options['elfer_jn'] == '1' && $result['game_elfer'] == '1') {
		$selected_result_elfer1 = "selected";
	} else {
		$selected_result_elfer2 = "selected";
	}

	$gamecomment = htmlconverter($result['gamecomment']);

	eval("\$tpl->output(\"" . $tpl->get('wm2018_result_edit', 1) . "\");");
}

function getclickysmilies_vgacp($tableColumns = 3, $maxSmilies = -1) {
	global $db, $n, $tpl, $showsmiliesrandom, $style, $lang, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	if ($showsmiliesrandom == 1) {
		$result = $db->query("SELECT smiliepath, smilietitle, smiliecode FROM bb" . $n . "_smilies ORDER BY RAND()");
	} else {
		$result = $db->query("SELECT smiliepath, smilietitle, smiliecode FROM bb" . $n . "_smilies ORDER BY smilieorder ASC");
	}

	$totalSmilies = $db->num_rows($result);

	if (($maxSmilies == -1) || ($maxSmilies >= $totalSmilies)) {
		$maxSmilies = $totalSmilies;
	} elseif ($maxSmilies < $totalSmilies) {
		eval("\$bbcode_smilies_getmore = \"" . $tpl->get("wm2018_bbcode_smilies_getmore") . "\";");
	}

	$i = 0;
	while ($row = $db->fetch_array($result)) {
		$row['smilietitle'] = getlangvar($row['smilietitle'], $lang);
		$row['smiliepath'] = "../" . replaceImagefolder($row['smiliepath']);
		$row['smiliecode'] = addcslashes($row['smiliecode'], "'\\");
		eval("\$smilieArray[\"" . $i . "\"] = \"" . $tpl->get("bbcode_smiliebit") . "\";");
		$i++;
	}

	$tableRows = ceil($maxSmilies / $tableColumns);
	$count = 0;
	$smiliebits = '';
	for ($i = 0; $i < $tableRows; $i++) {
		$smiliebits .= "\t<tr>\n";
		for ($j = 0; $j < $tableColumns; $j++) {
			$smiliebits .= $smilieArray[$count];
			$count++;
			if ($count >= $maxSmilies) {
				$repeat = $tableColumns - ($j + 1);
				if ($repeat > 0) {
					$smiliebits .= str_repeat('<td class="tableb"></td>', $repeat);
				}

				break;
			}
		}
		$smiliebits .= "\t</tr>\n";
	}

	$lang->items['LANG_POSTINGS_SMILIE_COUNT'] = $lang->get("LANG_POSTINGS_SMILIE_COUNT", array('$maxSmilies' => $maxSmilies, '$totalSmilies' => $totalSmilies));
	eval("\$bbcode_smilies = \"" . $tpl->get("bbcode_smilies") . "\";");
	return $bbcode_smilies;
}
function getcodebuttons_vgacp() {
	global $_COOKIE, $tpl, $style, $lang, $session, $SID_ARG_1ST, $SID_ARG_2ND, $SID_ARG_2ND_UN;

	$modechecked = array('', '');
	if ($_COOKIE['bbcodemode'] == 1) {
		$modechecked[1] = "checked=\"checked\"";
	} else {
		$modechecked[0] = "checked=\"checked\"";
	}

	eval("\$bbcode_sizebits = \"" . $tpl->get("bbcode_sizebits") . "\";");
	eval("\$bbcode_fontbits = \"" . $tpl->get("bbcode_fontbits") . "\";");
	eval("\$bbcode_colorbits = \"" . $tpl->get("bbcode_colorbits") . "\";");
	eval("\$bbcode_buttons = \"" . $tpl->get("wm2018_bbcode_buttons") . "\";");
	return $bbcode_buttons;
}

?>