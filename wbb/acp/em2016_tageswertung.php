<?php
$filename = "em2016_tageswertung.php";

@error_reporting(7);
@set_time_limit(0);
// @set_magic_quotes_runtime(0);

// WBB-Funktionen includen und Datenbank öffnen
require "./lib/config.inc.php";
require "./lib/options.inc.php";
require "./lib/class_db_mysql.php";
require "./lib/functions.php";
require "./lib/admin_functions.php";
$db = new db($sqlhost, $sqluser, $sqlpassword, $sqldb, $phpversion);

// Header ausgeben
echo "<h2><center>EM-Tippspiel Reset Tageswertung</center></h2>\n<br />\n";

@$db->query("DROP TABLE IF EXISTS bb" . $n . "_em2016_vortag");
@$db->query("CREATE TABLE bb" . $n . "_em2016_vortag (userid int(5), punkte int(10), pos int(3) default NULL auto_increment, PRIMARY KEY (pos));");
@$db->query("ALTER TABLE bb" . $n . "_em2016_vortag ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;");
@$db->query("ALTER TABLE bb" . $n . "_em2016_vortag ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;");

$em2016_options = $db->query_first("SELECT * FROM bb" . $n . "_em2016_options");

$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_em2016_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, ((tipps_richtig+tipps_tendenz)/tipps_falsch) DESC,tipps_gesamt DESC  Limit 0,{$em2016_options['topuser']}");

$em2016_rank_merk = 0;
$em2016_punkte_merk = 0;
$em2016_rank = 1;
while ($row_topuser = $db->fetch_array($result_topuser)) {
	//insert values vortag
	$em2016_rank_merk = $em2016_rank_merk + 1;
	if ($em2016_punkte_merk != $row_topuser['punkte']) {
		$em2016_rank = $em2016_rank_merk;
		$em2016_punkte_merk = $row_topuser['punkte'];
	}
	$db->query("INSERT INTO bb" . $n . "_em2016_vortag (userid, punkte, pos) VALUES ('" . $row_topuser['userid'] . "', '" . $row_topuser['punkte'] . "', '" . $em2016_rank . "');");
}

echo "OK";

?>
