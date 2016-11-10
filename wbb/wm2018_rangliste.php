<?php
eval('print("' . $hm_boxhead_tpl . '");');

include './wm2018_global.php';

$krone = '';
$count = 0;
$lang->load('WM2018');

$result_topuser = $db->query('SELECT u.username,p.* FROM bb' . $n . '_wm2018_userpunkte p LEFT JOIN bb' . $n . "_users u USING (userid) ORDER BY punkte DESC, tipps_gesamt DESC Limit 0,{$wm2018_options['topuser']}");
while ($row_topuser = $db->fetch_array($result_topuser)) {
	$rowclass = getone($count++, 'tablea', 'tableb');
	if ($count == 1) {
		$krone = '<img src="images/wm2018/krone.gif" alt="krone.gif"><br>';
	} else {
		$krone = '';
	}

	eval('$wm2018_topuser .= "' . $tpl->get('wm2018_sponsor_wm2018_topuser') . '";');
}

eval('print("' . $tpl->get('wm2018_sponsor_portalboxen_wmtippbest5') . '");');
eval('print("' . $hm_boxtail_tpl . '");');
?>
