<?php
eval("print(\"" . $hm_boxhead_tpl . "\");");

include "./em2016_global.php";

$lang->load("EM2016");

$em2016_meister = "";
$points = 0;
$meister = array();

// alle tipps durchgehen
$result_m = $db->query("SELECT tipp_em,tipp_vem FROM bb" . $n . "_em2016_userpunkte");

while ($row = $db->fetch_array($result_m)) {
	if ($row['tipp_em'] > 0) {
		if (array_key_exists($row['tipp_em'], $meister)) {
			$meister[$row['tipp_em']] += 1;
		} else {
			$meister[$row['tipp_em']] = 1;
		}
		$points += 1;
	}
	if ($row['tipp_vem'] > 0) {
		if (array_key_exists($row['tipp_vem'], $meister)) {
			$meister[$row['tipp_vem']] += 0.5;
		} else {
			$meister[$row['tipp_vem']] = 0.5;
		}
		if ($row['tipp_em'] == 0) {
			$points += 0.5;
		}
	}
}

if ($points > 0) {
	// Teamnamen einfügen
	$count = 0;
	foreach (array_keys($meister) as $einzel) {
		list($teamname) = $db->query_first("SELECT name FROM bb" . $n . "_em2016_teams WHERE teamid = " . $einzel);

		$sort[$count][0] = $teamname;
		$sort[$count][1] = $meister[$einzel];
		$count++;
	}

	function cmp($a, $b) {
		return ($a[1] < $b[1]);
	}

	usort($sort, "cmp");

	// ausgeben
	for ($lauf = 0; ($lauf < $count) && ($lauf < 3);) {$lauf++;

		$em2016_meister .= "<tr><td class=\"tableb\"><font size=2>" . $lauf . "</font></td>";

		$em2016_meister .= "<td class=\"tablea\"><font size=2><a href=\"em2016.php?action=showusertipps\">";
		if ($lauf == 1) {
			$em2016_meister .= "<b>" . $sort[$lauf - 1][0] . "</b>";
		} else {
			$em2016_meister .= $sort[$lauf - 1][0];
		}
		$em2016_meister .= "</a></font></td>";

		$em2016_meister .= "<td class=\"tableb\"><img src=\"images/em2016/";
		if (0 == 1) {
			$em2016_meister .= "t_u.gif\" alt=\"t_u.gif";
		} else {
			$em2016_meister .= "t_m.gif\" alt=\"t_m.gif";
		}
		$em2016_meister .= "\"></td>";

		$em2016_meister .= "<td class=\"tablea\"><font size=2 color=green>" . round(($sort[$lauf - 1][1] / $points) * 100, 0) . " %</font></td>";

		$em2016_meister .= "</tr>";

	}

	eval("print(\"" . $tpl->get("em2016_sponsor_portalboxen_emmeister") . "\");");

} // (point>0)
eval("print(\"" . $hm_boxtail_tpl . "\");");
?>
