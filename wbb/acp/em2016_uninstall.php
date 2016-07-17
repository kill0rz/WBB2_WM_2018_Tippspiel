<?php
/***************************************************************************
 *
 *   MOD                  : WM-2006/2014/EM-2016 Tippspiel
 *   file                 : em2016_uninstall.php
 *   copyright            : WM2006-Tippspiel © 2006 @ batida444
 *   copyright            : WM2014-Tippspiel © 2014 @ Viktor
 *   copyright            : EM2016-Tippspiel © 2016 @ kill0rz
 *   web                  : www.v-gn.de
 *   Boardversion         : Burning Board wBB 2.3
 ***************************************************************************/

if (file_exists("./lib/em2016_install.lock")) {
	die("Bitte l&ouml;schen Sie die Datei acp/lib/em2016_install.lock, um die De-Installation ausf&uuml;hren zu k&ouml;nnen!");
}






$filename = "em2016_uninstall.php";

@error_reporting(7);
@set_time_limit(0);

/* page output function */
function informationPage($content, $title = '') {
	echo '<?xml version="1.0" encoding="windows-1252"?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="de" xml:lang="de">
			<head>
				<title>' . $title . '</title>
				<link rel="stylesheet" href="css/other.css" />
			</head>

			<body>
				<table align="center" width="500">
					<tr>
						<td align="center"><img src="./images/acp-logo.gif" border="0" alt="" /></td>
					</tr>
					<tr>
						<td><br /><br />' . $content . '</td>
					</tr>
				</table>
			</body>
		</html>';
}

// WBB-Funktionen includen und Datenbank &ouml;ffnen
require "./lib/config.inc.php";
require "./lib/options.inc.php";
require "./lib/class_db_mysql.php";
require "./lib/functions.php";
require "./lib/admin_functions.php";
$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

if (isset($_REQUEST['step'])) {
	$step = $_REQUEST['step'];
} else {
	$step = "";
}

// Header ausgeben
print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html;charset=iso-8859-1\">\n");
print "<link rel=\"stylesheet\" href=\"css/other.css\"></head><body align=\"center\">\n";
print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"600\" align=\"center\"><tr><td width=\"100%\" align=\"left\">\n";
print "<h2><center>EM2016-Tippspiel De-Installation</center></h2>\n<br />\n";

if (!$step) {

	informationPage('<b>Herzlich Willkommen bei der De-Installation des EM2016-Tippspiels f&uuml;r das wBB2.3</b><br /><br />
  <table>
  <tr>
  <td>Mit diesem Script kannst Du das EM2016-Tippspiel wieder sauber aus Deinem Forum entfernen.</td>
  </tr>
  <tr>
  <td>Folgende Dinge f&uuml;hrt dieses Script aus:</td>
  </tr>
  <tr>
  <td>- L&ouml;schen der Sprachvariablen<br />- L&ouml;schen der Gruppenrechte und Gruppenvariablen<br />- L&ouml;schen der ACP-Menueintr&auml;ge<br />- L&ouml;schen der Board-Templates<br />- L&ouml;schen der Tabellen in der Datenbank</td>
  </tr>
</table>
  <br />
 ');

	// WBB-Version checken
	list($wbbversion) = $db->query_first("SELECT value FROM bb" . $n . "_options WHERE varname = 'boardversion'");
	if (version_compare($wbbversion, "2.3.0") < 0) {
		print "Diese De-Installation braucht ein Woltlab Burning Board in der Version 2.3.x oder h&ouml;her!<p />";
		print "Ihre WBB-Version ist " . $wbbversion . ".<p />";
		print "<b>De-Installation wird abgebrochen.</b>";
		print "</td></tr></table></body></html>";
		exit();
	}

	print "<b>Wichtige Hinweise:</b>";
	print "<br />Voraussetzung f&uuml;r diese De-Installation ist die WBB-Version 2.3.x - wenn Sie eine andere WBB-Version ";
	print "einsetzen, brechen Sie die De-Installation hier ab!<p/>";

	print "<a href=\"./$filename?step=delete\">De-Installation fortsetzen</a>";
	print "</td></tr></table></body></html>";
	exit();
}

if ($step == "delete") {
	informationPage('<b>De-Installation l&auml;uft... Bitte warten...</b>');
	print "<br /><b>Board-Templates werden gel&ouml;scht...</b>";
	$result = $db->query("SELECT * FROM bb" . $n . "_templates WHERE templatename LIKE 'em2016_%'");
	while ($row = $db->fetch_array($result)) {
		$db->query("DELETE FROM bb" . $n . "_templates WHERE templateid = '" . $row['templateid'] . "'");
	}

	print "<br />Board-Templates erfolgreich gel&ouml;scht...";
	print "<br /><br /><b>Gruppenrechte werden gel&ouml;scht...</b>";
	@$db->query("DELETE FROM bb" . $n . "_groupvariablegroups WHERE title='USER_EM2016'");
	@$db->query("DELETE FROM bb" . $n . "_groupvariablegroups WHERE title='ADMIN_EM2016'");
	print "<br/ >Gruppenrechte erfolgreich gel&ouml;scht...";
	print "<br /><br /><b>Gruppenvariablen werden gel&ouml;scht...</b>";
	@$db->query("DELETE FROM bb" . $n . "_groupvariables WHERE variablename='can_em2016_see'");
	@$db->query("DELETE FROM bb" . $n . "_groupvariables WHERE variablename='can_em2016_use'");
	@$db->query("DELETE FROM bb" . $n . "_groupvariables WHERE variablename='a_can_em2016_edit'");
	print "<br/ >Gruppenvariablen erfolgreich gel&ouml;scht...";
	print "<br /><br /><b>ACP-Menueintr&auml;ge werden gel&ouml;scht...</b>";
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitemgroups WHERE title='EM2016'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_INDEX'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_OPTIONS'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_PUNKTE'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_RESULTS'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_RESULTS'");
	@$db->query("DELETE FROM bb" . $n . "_acpmenuitems WHERE languageitem='EM2016_CORRECT8'");
	print "<br/ >ACP-Menueintr&auml;ge erfolgreich gel&ouml;scht...";
	print "<br /><br /><b>Sprachvariablen werden gel&ouml;scht...</b>";
	@$db->query("DELETE FROM bb" . $n . "_languages WHERE itemname like '%_EM2016_%'");
	@$db->query("DELETE FROM bb" . $n . "_languagecats WHERE catname = 'em2016'");
	@$db->query("DELETE FROM bb" . $n . "_languagecats WHERE catname = 'acp_em2016'");
	@$db->query("DELETE FROM bb" . $n . "_languagecats WHERE catname = 'em2016_de'");
	@$db->query("DELETE FROM bb" . $n . "_languagecats WHERE catname = 'em2016_en'");
	print "<br/ >Sprachvariablen erfolgreich gel&ouml;scht...";
	print "<br /><br /><b>Tabellen werden aus der Datenbank entfernt...</b>";
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_options");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_punkte");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_spiele");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_teams");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_userpunkte");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_usertipps");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_bestedrittetmp");
	@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_vortag");
	print "<br />Tabellen erfolgreich aus der Datenbank entfernt...";

	print "<br /><br />Wenn auf dieser Seite keine Fehlermeldungen erschienen sind, wurde das EM2016-Tippspiel ";
	print "erfolgreich de-installiert.<br />\n";
	print "<br /><b>WICHTIG: Falls Fehlermeldungen erschienen sind, gab es Probleme</b> - in diesem Fall wende Dich bitte an ";
	print "<b>kill0rz</b> im Supportthread f&uuml;r das Tippspiel auf <a href=\"http://www.v-gn.de/wbb\" target=\"_blank\">www.v-gn.de/wbb</a>";

	print "<br /><br /><a href=\"./$filename?step=delete2\">De-Installation fortsetzen</a>";
	print "</td></tr></table></body></html>";
	exit();
}

if ($step == "delete2") {
	informationPage('<b>Letzte T&auml;tigkeiten f&uuml;r die komplette De-Installation</b>');
	print "<br />Um die De-Installation erfolgreich abzuschlie&szlig;en, musst Du nun noch selber einmal Hand anlegen und folgende ";
	print "Dinge vom Server l&ouml;schen:";
	print "<br /><br />- L&ouml;schen des Verzeichnisses <b>em2016</b> inklusive aller Dateien und Unterverzeichnisse im /images-Ordner";
	print "<br />- L&ouml;schen aller ACP-Templates aus dem Verzeichnis /acp/templates, die mit <b>em2016_</b> beginnen";
	print "<br />- L&ouml;schen der Dateien <b>em2016.php</b> und <b>em2016_global.php</b> aus dem Hauptverzeichnis";
	print "<br />- L&ouml;schen der Datei <b>em2016_admin.php</b> aus dem ACP-Verzeichnis /acp";
	print "<br />- und ganz zum Schlu&szlig; nach Abschluss dieser De-Installation:";
	print "<br />- L&ouml;schen der Datei <b>em2016_uninstall.php</b> aus dem ACP-Verzeichnis /acp";
	print "<br /><br />Danach ist das EM2016-Tippspiel komplett und sauber aus Deinem Forum entfernt.";
	print "<br /><br />Ich hoffe, das Tippspiel hat Dir und Deinen Usern viel Spa&szlig; gemacht.";
	print "<br />Greetz<br />G&uuml;nni, Viktor und kill0rz";
	print "</td></tr></table></body></html>";
	exit();
}
?>
