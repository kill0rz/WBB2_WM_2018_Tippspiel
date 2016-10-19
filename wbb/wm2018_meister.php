<?php
eval("print(\"" . $hm_boxhead_tpl . "\");");

include "./wm2018_global.php";

$lang->load("WM2018");

$wm2018_meister = "";
$points = 0;
$meister = array();

// alle tipps durchgehen
$result_m = $db->query("SELECT tipp_wm,tipp_vwm FROM bb" . $n . "_wm2018_userpunkte");

while ($row = $db->fetch_array($result_m)) {
	if ($row['tipp_wm'] > 0) {
		if (array_key_exists($row['tipp_wm'], $meister)) {
			$meister[$row['tipp_wm']] += 1;
		} else {
			$meister[$row['tipp_wm']] = 1;
		}
		$points += 1;
	}
	if ($row['tipp_vwm'] > 0) {
		if (array_key_exists($row['tipp_vwm'], $meister)) {
			$meister[$row['tipp_vwm']] += 0.5;
		} else {
			$meister[$row['tipp_vwm']] = 0.5;
		}
		if ($row['tipp_wm'] == 0) {
			$points += 0.5;
		}
	}
}

if ($points > 0) {
	// Teamnamen einfügen
	$count = 0;
	foreach (array_keys($meister) as $einzel) {
		list($teamname) = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = " . $einzel);

		$sort[$count][0] = $teamname;
		$sort[$count][1] = $meister[$einzel];
		$count++;
	}

	function cmp($a, $b) {
		return ($a[1] < $b[1]);
	}

	usort($sort, "cmp");

	// ausgeben
	for ($lauf = 0; ($lauf < $count) && ($lauf < 3);) {
		$lauf++;

		$wm2018_meister .= "<tr><td class=\"tableb\"><font size=2>" . $lauf . "</font></td>";

		$wm2018_meister .= "<td class=\"tablea\"><font size=2><a href=\"wm2018.php?action=showusertipps\">";
		if ($lauf == 1) {
			$wm2018_meister .= "<b>" . $sort[$lauf - 1][0] . "</b>";
		} else {
			$wm2018_meister .= $sort[$lauf - 1][0];
		}
		$wm2018_meister .= "</a></font></td>";

		$wm2018_meister .= "<td class=\"tableb\"><img src=\"images/wm2018/";
		if (0 == 1) {
			$wm2018_meister .= "t_u.gif\" alt=\"t_u.gif";
		} else {
			$wm2018_meister .= "t_m.gif\" alt=\"t_m.gif";
		}
		$wm2018_meister .= "\"></td>";

		$wm2018_meister .= "<td class=\"tablea\"><font size=2 color=green>" . round(($sort[$lauf - 1][1] / $points) * 100, 0) . " %</font></td>";

		$wm2018_meister .= "</tr>";

	}

	eval("print(\"" . $tpl->get("wm2018_sponsor_portalboxen_wmmeister") . "\");");

} // (point>0)
eval("print(\"" . $hm_boxtail_tpl . "\");");
?>
