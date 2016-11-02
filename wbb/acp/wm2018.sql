-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_options`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_options`;
CREATE TABLE `bb1_wm2018_options` (
  `wm2018aktiv` int(1) NOT NULL default '0',
  `showrssnews` int(1) NOT NULL default '1',
  `rssnews` int(5) NOT NULL default '5',
  `showwmticker` int(1) NOT NULL default '1',
  `wmticker_width` int(5) NOT NULL default '800',
  `nextxgames` int(3) NOT NULL default '4',
  `nonaddedgamescount` int(3) NOT NULL default '4',
  `topuser` int(3) NOT NULL default '10',
  `tipptime` int(10) NOT NULL default '300',
  `tendenz` int(1) NOT NULL default '1',
  `gk_jn` int(1) NOT NULL default '1',
  `rk_jn` int(1) NOT NULL default '1',
  `elfer_jn` int(1) NOT NULL default '1',
  `winnertipp_jn` int(1) NOT NULL default '1',
  `lastgame4wmtipp` int(3) NOT NULL default '48',
  `gh_aktiv` int(1) NOT NULL default '0',
  `gh_infos` int(1) NOT NULL default '1',
  `gh_ab_normtipp` int(5) NOT NULL default '10',
  `gh_ab_wmtipp` int(5) NOT NULL default '10',
  `gh_gut_normtipp_richtig` int(5) NOT NULL default '25',
  `gh_gut_normtipp_tendenz` int(5) NOT NULL default '15',
  `gh_gut_wmtipp_richtig` int(5) NOT NULL default '150',
  `1st` int(3) NOT NULL default '0',
  `2nd` int(3) NOT NULL default '0',
  `3rd` int(3) NOT NULL default '0',
  `ebay_rel_aktiv` int(1) NOT NULL default '0',
  `ebay_pub_id` int(11) NOT NULL default '178702',
  `ebay_cat` int(11) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_options`
-- 

INSERT INTO `bb1_wm2018_options` (`wm2018aktiv`, `showrssnews`, `rssnews`, `showwmticker`, `wmticker_width`, `nextxgames`, `nonaddedgamescount`, `topuser`, `tipptime`, `tendenz`, `gk_jn`, `rk_jn`, `elfer_jn`, `winnertipp_jn`, `lastgame4wmtipp`, `gh_aktiv`, `gh_infos`, `gh_ab_normtipp`, `gh_ab_wmtipp`, `gh_gut_normtipp_richtig`, `gh_gut_normtipp_tendenz`, `gh_gut_wmtipp_richtig`, `1st`, `2nd`, `3rd`, `ebay_rel_aktiv`, `ebay_pub_id`, `ebay_cat`) VALUES (1, 1, 5, 1, 800, 4, 4, 10, 300, 1, 1, 1, 1, 1, 48, 0, 1, 10, 10, 25, 15, 150, 0, 0, 0, 0, 178702, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_punkte`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_punkte`;
CREATE TABLE `bb1_wm2018_punkte` (
  `punkteid` int(2) unsigned NOT NULL auto_increment,
  `desc` varchar(100) NOT NULL default '',
  `wert` int(5) NOT NULL default '0',
  PRIMARY KEY  (`punkteid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Daten für Tabelle `bb1_wm2018_punkte`
-- 

INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (1, 'Exaktes Ergebnis', 10);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (2, 'Tendenz richtig', 5);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (3, 'Gelbe Karten', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (4, 'Rote Karten', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (5, 'Elfmeter', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (6, 'Weltmeister', 10);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (7, 'Vize-Weltmeister', 10);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_spiele`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_spiele`;
CREATE TABLE `bb1_wm2018_spiele` (
  `gameid` int(5) unsigned NOT NULL auto_increment,
  `gruppe` varchar(5) NOT NULL default '',
  `datetime` int(11) NOT NULL default '0',
  `stadion` varchar(50) NOT NULL default '',
  `team_1_id` varchar(5) NOT NULL default '0',
  `team_2_id` varchar(5) NOT NULL default '0',
  `game_gk` int(1) NOT NULL default '0',
  `game_rk` int(1) NOT NULL default '0',
  `game_elfer` int(1) NOT NULL default '0',
  `game_goals_1` char(2) NOT NULL default '',
  `game_goals_2` char(2) NOT NULL default '',
  `gamelink` varchar(250) NOT NULL default '',
  `gamecomment` text NOT NULL,
  `tipps` int(5) NOT NULL default '0',
  PRIMARY KEY  (`gameid`)
) ENGINE=MyISAM AUTO_INCREMENT=52 ;

-- 
-- Daten für Tabelle `bb1_wm2018_spiele`
-- 

INSERT INTO `bb1_wm2018_spiele` (`gameid`, `gruppe`, `datetime`, `stadion`, `team_1_id`, `team_2_id`, `game_gk`, `game_rk`, `game_elfer`, `game_goals_1`, `game_goals_2`, `gamelink`, `gamecomment`, `tipps`) VALUES
(1, 'A',  1528992000, 'Moskau',  '1',  '0',  0,  0,  0,  '', '', '', '', 0),
(2, 'A',  1529067600, 'Jekaterinburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(3, 'B',  1529078400, 'Sotschi',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(4, 'B',  1529089200, 'Sankt Petersburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(5, 'C',  1529146800, 'Kasan',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(6, 'D',  1529157600, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(7, 'C',  1529168400, 'Saransk',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(8, 'D',  1529179200, 'Kaliningrad',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(9, 'E',  1529240400, 'Rostow am Don',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(10, 'F',  1529251200, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(11, 'E',  1529262000, 'Samara',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(12, 'F',  1529326800, 'Nischni Nowgorod',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(13,  'G',  1529337600, 'Sotschi',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(14,  'G',  1529348400, 'Wolgograd',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(15,  'H',  1529413200, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(16,  'H',  1529424000, 'Saransk',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(17,  'A',  1529434800, 'Sankt Petersburg',  '1',  '0',  0,  0,  0,  '', '', '', '', 0),
(18,  'B',  1529499600, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(19,  'A',  1529510400, 'Rostow am Don',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(20,  'B',  1529521200, 'Kasan',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(21,  'C',  1529586000, 'Kaliningrad',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(22,  'C',  1529596800, 'Samara',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(23,  'D',  1529607600, 'Nischni Nowgorod',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(24,  'E',  1529672400, 'Sankt Petersburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(25,  'D',  1529683200, 'Wolgograd',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(26,  'E',  1529694000, 'Jekaterinburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(27,  'G',  1529758800, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(28,  'F',  1529769600, 'Sotschi',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(29,  'F',  1529780400, 'Rostow am Don',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(30,  'G',  1529845200, 'Nischni Nowgorod',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(31,  'H',  1529856000, 'Kasan',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(32,  'H',  1529866800, 'Kaliningrad',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(33,  'A',  1529938800, 'Samara',  '0',  '1',  0,  0,  0,  '', '', '', '', 0),
(34,  'A',  1529938800, 'Wolgograd',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(35,  'B',  1529953200, 'Saransk',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(36,  'B',  1529953200, 'Jekaterinburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(37,  'C',  1530025200, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(38,  'C',  1530025200, 'Sotschi',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(39,  'D',  1530039600, 'Sankt Petersburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(40,  'D',  1530039600, 'Rostow am Don',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(41,  'F',  1530111600, 'Kasan',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(42,  'F',  1530111600, 'Kaliningrad',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(43,  'E',  1530126000, 'Moskau',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(44,  'E',  1530126000, 'Nischni Nowgorod',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(45,  'H',  1530198000, 'Wolgograd',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(46,  'H',  1530198000, 'Samara',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(47,  'G',  1530212400, 'Jekaterinburg',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(48,  'G',  1530212400, 'Saransk',  '0',  '0',  0,  0,  0,  '', '', '', '', 0),
(49,  '8',  1530370800, 'Sotschi',  'W-C',  'S-D',  0,  0,  0,  '', '', '', '', 0),
(50,  '8',  1530385200, 'Kasan',  'W-A',  'S-B',  0,  0,  0,  '', '', '', '', 0),
(51,  '8',  1530457200, 'Moskau',  'W-B',  'S-A',  0,  0,  0,  '', '', '', '', 0),
(52,  '8',  1530471600, 'Nischni Nowgorod',  'W-D',  'S-C',  0,  0,  0,  '', '', '', '', 0),
(53,  '8',  1530543600, 'Samara',  'W-G',  'S-H',  0,  0,  0,  '', '', '', '', 0),
(54,  '8',  1530558000, 'Rostow am Don',  'W-E',  'S-F',  0,  0,  0,  '', '', '', '', 0),
(55,  '8',  1530630000, 'Sankt Petersburg',  'W-H',  'S-G',  0,  0,  0,  '', '', '', '', 0),
(56,  '8',  1530644400, 'Moskau',  'W-F',  'S-E',  0,  0,  0,  '', '', '', '', 0),
(57,  '4',  1530889200, 'Nischni Nowgorod',  'W-54', 'W-53', 0,  0,  0,  '', '', '', '', 0),
(58,  '4',  1530903600, 'Kasan',  'W-59', 'W-60', 0,  0,  0,  '', '', '', '', 0),
(59,  '4',  1530975600, 'Sotschi',  'W-56', 'W-55', 0,  0,  0,  '', '', '', '', 0),
(60,  '4',  1530990000, 'Samara',  'W-51', 'W-52', 0,  0,  0,  '', '', '', '', 0),
(61,  '2',  1531249200, 'Sankt Petersburg',  'W-58', 'W-57', 0,  0,  0,  '', '', '', '', 0),
(62,  '2',  1531335600, 'Moskau',  'W-60', 'W-59', 0,  0,  0,  '', '', '', '', 0),
(63,  '3',  1531580400, 'Sankt Petersburg',  'L-61', 'L-62', 0,  0,  0,  '', '', '', '', 0),
(64,  '1',  1531670400, 'Moskau',  'W-61', 'W-62', 0,  0,  0,  '', '', '', '', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_teams`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_teams`;
CREATE TABLE `bb1_wm2018_teams` (
  `teamid` int(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `gruppe` varchar(10) NOT NULL default '',
  `flagge` varchar(50) NOT NULL default '',
  `spiele` int(2) NOT NULL default '0',
  `g` int(2) NOT NULL default '0',
  `v` int(2) NOT NULL default '0',
  `u` int(2) NOT NULL default '0',
  `td` int(2) NOT NULL default '0',
  `punkte` int(3) NOT NULL default '0',
  PRIMARY KEY  (`teamid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 ;

-- 
-- Daten für Tabelle `bb1_wm2018_teams`
-- 

INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES
(1, 'Russland', 'A',  'ru.png', 0,  0,  0,  0,  0,  0),
(2, 'unknown',  'A',  'unknown.png',  0,  0,  0,  0,  0,  0),
(3, 'unknown',  'A',  'unknown.png',  0,  0,  0,  0,  0,  0),
(4, 'unknown',  'A',  'unknown.png',  0,  0,  0,  0,  0,  0),
(5, 'unknown',  'B',  'unknown.png',  0,  0,  0,  0,  0,  0),
(6, 'unknown',  'B',  'unknown.png',  0,  0,  0,  0,  0,  0),
(7, 'unknown',  'B',  'unknown.png',  0,  0,  0,  0,  0,  0),
(8, 'unknown',  'B',  'unknown.png',  0,  0,  0,  0,  0,  0),
(9, 'unknown',  'C',  'unknown.png',  0,  0,  0,  0,  0,  0),
(10,  'unknown',  'C',  'unknown.png',  0,  0,  0,  0,  0,  0),
(11,  'unknown',  'C',  'unknown.png',  0,  0,  0,  0,  0,  0),
(12,  'unknown',  'C',  'unknown.png',  0,  0,  0,  0,  0,  0),
(13,  'unknown',  'D',  'unknown.png',  0,  0,  0,  0,  0,  0),
(14,  'unknown',  'D',  'unknown.png',  0,  0,  0,  0,  0,  0),
(15,  'unknown',  'D',  'unknown.png',  0,  0,  0,  0,  0,  0),
(16,  'unknown',  'D',  'unknown.png',  0,  0,  0,  0,  0,  0),
(17,  'unknown',  'E',  'unknown.png',  0,  0,  0,  0,  0,  0),
(18,  'unknown',  'E',  'unknown.png',  0,  0,  0,  0,  0,  0),
(19,  'unknown',  'E',  'unknown.png',  0,  0,  0,  0,  0,  0),
(20,  'unknown',  'E',  'unknown.png',  0,  0,  0,  0,  0,  0),
(21,  'unknown',  'F',  'unknown.png',  0,  0,  0,  0,  0,  0),
(22,  'unknown',  'F',  'unknown.png',  0,  0,  0,  0,  0,  0),
(23,  'unknown',  'F',  'unknown.png',  0,  0,  0,  0,  0,  0),
(24,  'unknown',  'F',  'unknown.png',  0,  0,  0,  0,  0,  0),
(25,  'unknown',  'G',  'unknown.png',  0,  0,  0,  0,  0,  0),
(26,  'unknown',  'G',  'unknown.png',  0,  0,  0,  0,  0,  0),
(27,  'unknown',  'G',  'unknown.png',  0,  0,  0,  0,  0,  0),
(28,  'unknown',  'G',  'unknown.png',  0,  0,  0,  0,  0,  0),
(29,  'unknown',  'H',  'unknown.png',  0,  0,  0,  0,  0,  0),
(30,  'unknown',  'H',  'unknown.png',  0,  0,  0,  0,  0,  0),
(31,  'unknown',  'H',  'unknown.png',  0,  0,  0,  0,  0,  0),
(32,  'unknown',  'H',  'unknown.png',  0,  0,  0,  0,  0,  0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_userpunkte`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_userpunkte`;
CREATE TABLE `bb1_wm2018_userpunkte` (
  `userid` int(5) NOT NULL default '0',
  `punkte` int(10) NOT NULL default '0',
  `tipps_gesamt` int(5) NOT NULL default '0',
  `tipps_richtig` int(5) NOT NULL default '0',
  `tipps_falsch` int(5) NOT NULL default '0',
  `tipps_tendenz` int(5) NOT NULL default '0',
  `tipp_wm` int(5) NOT NULL default '0',
  `tipp_vwm` int(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_userpunkte`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_usertipps`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_usertipps`;
CREATE TABLE `bb1_wm2018_usertipps` (
  `userid` int(11) NOT NULL default '0',
  `gameid` int(5) NOT NULL default '0',
  `goals_1` int(2) NOT NULL default '0',
  `goals_2` int(2) NOT NULL default '0',
  `gk` smallint(5) NOT NULL default '0',
  `rk` smallint(5) NOT NULL default '0',
  `elfer` smallint(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_usertipps`
-- 

--DROP TABLE IF EXISTS `bb1_wm2018_bestedrittetmp`;
--CREATE TABLE `bb1_wm2018_bestedrittetmp` (
--  `ID` int(11) NOT NULL AUTO_INCREMENT,
--  `teamid` int(11) NOT NULL,
--  `punkte` int(11) NOT NULL,
--  `td` int(11) NOT NULL,
--  `g` int(11) NOT NULL,
--  PRIMARY KEY (`ID`)
--) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `bb1_wm2018_vortag`;
CREATE TABLE `bb1_wm2018_vortag` (
  `pos` int(3) NOT NULL AUTO_INCREMENT,
  `userid` int(5) DEFAULT NULL,
  `punkte` int(10) DEFAULT NULL,
  PRIMARY KEY (`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tabellenstruktur für Tabelle `bb1_wm2018_options` ändern
-- 

ALTER TABLE `bb1_wm2018_options` ADD `po_aktiv` int(1) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `vgposttid` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `vgpostuid` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `viconid` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `vgthema` varchar(100) NOT NULL default 'Ergebnis: {vgp_name1} - {vgp_name2}';
ALTER TABLE `bb1_wm2018_options` ADD `message` text NOT NULL;
ALTER TABLE `bb1_wm2018_options` ADD `vboardid` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `vprefix` varchar(50) NOT NULL default 'WM2018';
ALTER TABLE `bb1_wm2018_options` ADD `vgposthtml` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `diskussionsthreadid` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `bb1_wm2018_options` ADD `lasttageswertungreset` int(11) NOT NULL default '0';
ALTER TABLE `bb1_wm2018_options` ADD `showrssnews_method` int(11) NOT NULL default '0';

--
-- UNIQUE für Tabelle `bb1_wm2018_userpunkte` setzen
-- 

ALTER TABLE `bb1_wm2018_userpunkte` ADD UNIQUE(`userid`);
UPDATE bb1_wm2018_options SET message='Hallo,\r\n\r\nhier das Ergebnis von Spiel [B]{vgp_gameid}[/B] der Gruppe [B]{vgp_gruppe}[/B].\r\n\r\nDas Spiel fand in {vgp_stadion}, am {vgp_datum} um {vgp_zeit} Uhr statt.\r\n\r\n[CENTER][B]{vgp_name1}[/B] {vgp_flagge1} - [B]{vgp_name2}[/B] {vgp_flagge2}[/CENTER]\r\n[CENTER][SIZE=16][B]{vgp_tore1}[/B] - [B]{vgp_tore2}[/B][/SIZE][/CENTER]\r\n\r\nGelbe-Karten: [B]{vgp_gk}[/B]\r\nRote-Karten; [B]{vgp_rk}[/B]\r\nElfmeter: [B]{vgp_elfer} [/B]\r\n\r\nEs haben [B]{vgp_anztipp}[/B] User am Tipp für das Spiel teilgenommen.\r\n\r\nHier mehr zum Spiel: {vgp_glink}\r\n\r\nMein Kommentar zum Spiel:\r\n {vgp_comment}\r\n\r\n[B][SIZE=16][CENTER]Aktuelles Top-User-Ranking:[/CENTER][/SIZE][/B]\r\n[CENTER]{vgp_user_ranking_01} [/CENTER]\r\n[CENTER]{vgp_user_ranking_02} [/CENTER]\r\n[CENTER]{vgp_user_ranking_03} [/CENTER]\r\n[CENTER]{vgp_user_ranking_04} [/CENTER]\r\n[CENTER]{vgp_user_ranking_05} [/CENTER]\r\n[CENTER]{vgp_user_ranking_06} [/CENTER]\r\n[CENTER]{vgp_user_ranking_07} [/CENTER]\r\n[CENTER]{vgp_user_ranking_08} [/CENTER]\r\n[CENTER]{vgp_user_ranking_09} [/CENTER]\r\n[CENTER]{vgp_user_ranking_10} [/CENTER]';
ALTER TABLE `bb1_wm2018_vortag` ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;
ALTER TABLE `bb1_wm2018_vortag` ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;