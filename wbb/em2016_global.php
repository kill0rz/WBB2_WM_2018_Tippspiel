<?php
/**
 *    MOD                  : WM-2006/2014/EM-2016 Tippspiel
 *    file                 : em2016_global.php
 *    copyright            : WM2006-Tippspiel © 2006 batida444
 *    copyright            : WM2014-Tippspiel © 2014 Viktor
 *    copyright            : EM2016-Tippspiel © 2016 @ kill0rz
 *    web                  : www.v-gn.de
 *    Boardversion         : Burning Board wBB 2.3
 */

$lang->load("EM2016");

$useremtipp = 0;
$uservemtipp = 0;
$userdatayes = 0;
$akttime = time();

$resultgruppen = $db->query("SELECT * FROM bb" . $n . "_em2016_teams ORDER BY teamid ASC");
while ($rowgruppen = $db->fetch_array($resultgruppen)) {
	$allids2[] = $rowgruppen['teamid'];
	$allnames2[] = $rowgruppen['name'];
	$allflags2[] = $rowgruppen['flagge'];
}

$allusertippgameids2 = array();
$resultusertipps = $db->query("SELECT * FROM bb" . $n . "_em2016_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' ORDER BY gameid ASC");
while ($rowusertipps = $db->fetch_array($resultusertipps)) {
	$allusertippgameids2[] = $rowusertipps['gameid'];
}

$em2016_options = $db->query_first("SELECT * FROM bb" . $n . "_em2016_options");

$fontcolor = substr($style['normalfontcolor'], 1, 6);
if (empty($fontcolor)) {
	$fontcolor = "000000";
}

$titlecolor = substr($style['tablecatbgcolor'], 1, 6);
$bgcolor = substr($style['tablebbgcolor'], 1, 6);
$bordercolor = substr($style['tablebbgcolor'], 1, 6);
$bordercolorebay = substr($style['tableabgcolor'], 1, 6);

if ($em2016_options['ebay_cat'] != 0) {
	$ebay_cat = "&CategoryID={$em2016_options['ebay_cat']}";
}

$replace_datum_komma = array(
	"<b>Heute</b>," => "<b>Heute</b>",
	"Gestern," => "Gestern",
	"<b>Morgen</b>," => "<b>Morgen</b>",
);

eval("\$em2016_ebay = \"" . $tpl->get("em2016_ebay") . "\";");
eval("\$em2016_header = \"" . $tpl->get("em2016_header") . "\";");
eval("\$em2016_footer = \"" . $tpl->get("em2016_footer") . "\";");

?>
