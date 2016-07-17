-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_options`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_options`;
CREATE TABLE `bb1_wm2018_options` (
  `wm2018aktiv` int(1) NOT NULL default '0',
  `showrssnews` int(1) NOT NULL default '1',
  `rssnews` int(5) NOT NULL default '5',
  `showemticker` int(1) NOT NULL default '1',
  `emticker_width` int(5) NOT NULL default '800',
  `nextxgames` int(3) NOT NULL default '5',
  `topuser` int(3) NOT NULL default '10',
  `tipptime` int(10) NOT NULL default '300',
  `tendenz` int(1) NOT NULL default '1',
  `gk_jn` int(1) NOT NULL default '1',
  `rk_jn` int(1) NOT NULL default '1',
  `elfer_jn` int(1) NOT NULL default '1',
  `winnertipp_jn` int(1) NOT NULL default '1',
  `lastgame4emtipp` int(3) NOT NULL default '48',
  `gh_aktiv` int(1) NOT NULL default '0',
  `gh_infos` int(1) NOT NULL default '1',
  `gh_ab_normtipp` int(5) NOT NULL default '10',
  `gh_ab_emtipp` int(5) NOT NULL default '10',
  `gh_gut_normtipp_richtig` int(5) NOT NULL default '25',
  `gh_gut_normtipp_tendenz` int(5) NOT NULL default '15',
  `gh_gut_emtipp_richtig` int(5) NOT NULL default '150',
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

INSERT INTO `bb1_wm2018_options` (`wm2018aktiv`, `showrssnews`, `rssnews`, `showemticker`, `emticker_width`, `nextxgames`, `topuser`, `tipptime`, `tendenz`, `gk_jn`, `rk_jn`, `elfer_jn`, `winnertipp_jn`, `lastgame4emtipp`, `gh_aktiv`, `gh_infos`, `gh_ab_normtipp`, `gh_ab_emtipp`, `gh_gut_normtipp_richtig`, `gh_gut_normtipp_tendenz`, `gh_gut_emtipp_richtig`, `1st`, `2nd`, `3rd`, `ebay_rel_aktiv`, `ebay_pub_id`, `ebay_cat`) VALUES (1, 1, 5, 1, 800, 4, 10, 300, 1, 1, 1, 1, 1, 48, 0, 1, 10, 10, 25, 15, 150, 0, 0, 0, 0, 178702, 0);

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
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (6, 'Europameister', 10);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (7, 'Vize-Europameister', 10);

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
(1, 'A',  1465585200, 'St. Denis',  '1',  '2',  0,  0,  0,  '', '', '', '', 0),
(2, 'A',  1465650000, 'Lens', '3',  '4',  0,  0,  0,  '', '', '', '', 0),
(3, 'B',  1465671600, 'Marseille',  '5',  '6',  0,  0,  0,  '', '', '', '', 0),
(4, 'B',  1465660800, 'Bordeaux', '7',  '8',  0,  0,  0,  '', '', '', '', 0),
(5, 'C',  1465758000, 'Lille',  '9',  '10', 0,  0,  0,  '', '', '', '', 0),
(6, 'C',  1465747200, 'Nizza',  '11', '12', 0,  0,  0,  '', '', '', '', 0),
(7, 'D',  1465822800, 'Toulouse', '13', '14', 0,  0,  0,  '', '', '', '', 0),
(8, 'D',  1465736400, 'Paris',  '15', '16', 0,  0,  0,  '', '', '', '', 0),
(9, 'E',  1465844400, 'Lyon', '17', '18', 0,  0,  0,  '', '', '', '', 0),
(10,  'E',  1465833600, 'St. Denis',  '19', '20', 0,  0,  0,  '', '', '', '', 0),
(11,  'F',  1465930800, 'St. Etienne',  '21', '22', 0,  0,  0,  '', '', '', '', 0),
(12,  'F',  1465920000, 'Bordeaux', '23', '24', 0,  0,  0,  '', '', '', '', 0),
(13,  'A',  1466017200, 'Marseille',  '1',  '3',  0,  0,  0,  '', '', '', '', 0),
(14,  'A',  1466006400, 'Paris',  '2',  '4',  0,  0,  0,  '', '', '', '', 0),
(15,  'B',  1466082000, 'Lens', '5',  '7',  0,  0,  0,  '', '', '', '', 0),
(16,  'B',  1465995600, 'Lille',  '6',  '8',  0,  0,  0,  '', '', '', '', 0),
(17,  'C',  1466103600, 'St. Denis',  '9',  '11', 0,  0,  0,  '', '', '', '', 0),
(18,  'C',  1466092800, 'Lyon', '10', '12', 0,  0,  0,  '', '', '', '', 0),
(19,  'D',  1466190000, 'Nizza',  '13', '15', 0,  0,  0,  '', '', '', '', 0),
(20,  'D',  1466179200, 'St. Etienne',  '14', '16', 0,  0,  0,  '', '', '', '', 0),
(21,  'E',  1466254800, 'Bordeaux', '17', '19', 0,  0,  0,  '', '', '', '', 0),
(22,  'E',  1466168400, 'Toulouse', '18', '20', 0,  0,  0,  '', '', '', '', 0),
(23,  'F',  1466276400, 'Paris',  '21', '23', 0,  0,  0,  '', '', '', '', 0),
(24,  'F',  1466265600, 'Marseille',  '22', '24', 0,  0,  0,  '', '', '', '', 0),
(25,  'A',  1466362800, 'Lille',  '4',  '1',  0,  0,  0,  '', '', '', '', 0),
(26,  'A',  1466362800, 'Lyon', '2',  '3',  0,  0,  0,  '', '', '', '', 0),
(27,  'B',  1466449200, 'St. Etienne',  '8',  '5',  0,  0,  0,  '', '', '', '', 0),
(28,  'B',  1466449200, 'Toulouse', '6',  '7',  0,  0,  0,  '', '', '', '', 0),
(29,  'C',  1466524800, 'Paris',  '12', '9',  0,  0,  0,  '', '', '', '', 0),
(30,  'C',  1466524800, 'Marseille',  '10', '11', 0,  0,  0,  '', '', '', '', 0),
(31,  'D',  1466535600, 'Bordeaux', '16', '13', 0,  0,  0,  '', '', '', '', 0),
(32,  'D',  1466535600, 'Lens', '14', '15', 0,  0,  0,  '', '', '', '', 0),
(33,  'E',  1466622000, 'Nizza',  '20', '17', 0,  0,  0,  '', '', '', '', 0),
(34,  'E',  1466622000, 'Lille',  '18', '19', 0,  0,  0,  '', '', '', '', 0),
(35,  'F',  1466611200, 'Lyon', '24', '21', 0,  0,  0,  '', '', '', '', 0),
(36,  'F',  1466611200, 'St. Denis',  '22', '23', 0,  0,  0,  '', '', '', '', 0),
(37,  '8',  1466859600, 'St. Etienne', 'W-A',  'S-C',  0,  0,  0,  '', '', '', '', 0),
(38,  '8',  1466870400, 'Paris', 'W-B',  'D-A/C/D',  0,  0,  0,  '', '', '', '', 0),
(39,  '8',  1466881200, 'Lens',  'W-D',  'D-B/E/F',  0,  0,  0,  '', '', '', '', 0),
(40,  '8',  1466946000, 'Lyon', 'W-A',  'D-C/D/E',  0,  0,  0,  '', '', '', '', 0),
(41,  '8',  1466956800, 'Lille', 'W-C',  'D-A/B/F',  0,  0,  0,  '', '', '', '', 0),
(42,  '8',  1466967600, 'Toulouse', 'W-F',  'S-E',  0,  0,  0,  '', '', '', '', 0),
(43,  '8',  1467043200, 'St. Denis',  'W-E',  'S-D',  0,  0,  0,  '', '', '', '', 0),
(44,  '8',  1467054000, 'Nizza',  'S-B',  'S-F',  0,  0,  0,  '', '', '', '', 0),
(45,  '4',  1467313200, 'Marseille',  'W-37', 'W-39', 0,  0,  0,  '', '', '', '', 0),
(46,  '4',  1467399600, 'Lille',  'W-38', 'W-42', 0,  0,  0,  '', '', '', '', 0),
(47,  '4',  1467486000, 'Bordaux',  'W-41', 'W-43', 0,  0,  0,  '', '', '', '', 0),
(48,  '4',  1467572400, 'St. Denis',  'W-40', 'W-44', 0,  0,  0,  '', '', '', '', 0),
(49,  '2',  1467831600, 'Lyon', 'W-45', 'W-46', 0,  0,  0,  '', '', '', '', 0),
(50,  '2',  1467918000, 'Marseille',  'W-47', 'W-48', 0,  0,  0,  '', '', '', '', 0),
(51,  '1',  1468177200, 'St. Denis',  'W-49', 'W-50', 0,  0,  0,  '', '', '', '', 0);

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

INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (1, 'Frankreich', 'A', 'fr.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (2, 'Rum&auml;nien', 'A', 'rou.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (3, 'Albanien', 'A', 'alb.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (4, 'Schweiz', 'A', 'ch.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (5, 'England', 'B', 'gb.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (6, 'Russland', 'B', 'ru.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (7, 'Wales', 'B', 'wal.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (8, 'Slowakei', 'B', 'svk.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (9, 'Deutschland', 'C', 'de.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (10, 'Ukraine', 'C', 'ukr.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (11, 'Polen', 'C', 'pol.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (12, 'Nordirland', 'C', 'nir.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (13, 'Spanien', 'D', 'es.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (14, 'Tschechien', 'D', 'cze.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (15, 'T&uuml;rkei', 'D', 'tur.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (16, 'Kroatien', 'D', 'hr.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (17, 'Belgien', 'E', 'be.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (18, 'Italien', 'E', 'it.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (19, 'Irland', 'E', 'irl.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (20, 'Schweden', 'E', 'swe.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (21, 'Portugal', 'F', 'pt.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (22, 'Island', 'F', 'isl.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (23, '&Ouml;sterreich', 'F', 'aut.png', 0, 0, 0, 0, 0, 0);
INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES (24, 'Ungarn', 'F', 'hun.png', 0, 0, 0, 0, 0, 0);

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
  `tipp_em` int(5) NOT NULL default '0',
  `tipp_vem` int(5) NOT NULL default '0'
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

DROP TABLE IF EXISTS `bb1_wm2018_bestedrittetmp`;
CREATE TABLE `bb1_wm2018_bestedrittetmp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `teamid` int(11) NOT NULL,
  `punkte` int(11) NOT NULL,
  `td` int(11) NOT NULL,
  `g` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- v1d
-- 

ALTER TABLE `bb1_wm2018_vortag` ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;
ALTER TABLE `bb1_wm2018_vortag` ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;