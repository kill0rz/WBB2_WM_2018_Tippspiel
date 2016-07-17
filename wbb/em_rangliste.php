<?php
eval('print("' . $hm_boxhead_tpl . '");');

include './em2016_global.php';

$krone = '';
$count = 0;
$lang->load('EM2016');

$result_topuser = $db->query('SELECT u.username,p.* FROM bb' . $n . '_em2016_userpunkte p LEFT JOIN bb' . $n . "_users u USING (userid) ORDER BY punkte DESC, tipps_gesamt DESC Limit 0,{$em2016_options['topuser']}");
while ($row_topuser = $db->fetch_array($result_topuser)) {
	$rowclass = getone($count++, 'tablea', 'tableb');
	if ($count == 1) {
		$krone = '<img src="images/em2016/krone.gif" alt="krone"><br>';
	} else {
		$krone = '';
	}

	eval('$em2016_topuser .= "' . $tpl->get('em2016_sponsor_em2016_topuser') . '";');
}

eval('print("' . $tpl->get('em2016_sponsor_portalboxen_emtippbest5') . '");');
eval('print("' . $hm_boxtail_tpl . '");');
?>
