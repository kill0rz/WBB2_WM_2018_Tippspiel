<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
	<tr class="tabletitle_fc">
		<td align="center" style="background-image:url(images/back.gif)">
			<span>
				<b><a href="em2016.php{$SID_ARG_1ST}">{$lang->items['LANG_EM2016_TPL_HEADER_1']}</a></b> |
				<if($wbbuserdata['can_em2016_use']==1)>
					<then>
						<b><a href="em2016.php?action=maketipp{$SID_ARG_2ND}">{$lang->items['LANG_EM2016_TPL_HEADER_2']}</a></b> | </then>
					</if>
					<b><a href="em2016.php?action=showresults&amp;auswahl=1{$SID_ARG_2ND}">{$lang->items['LANG_EM2016_TPL_HEADER_3']}</a></b> |
					<b><a href="board.php?boardid={$em2016_options['diskussionsthreadid']}" target="_blank">Fragen&amp;Talk zum Spiel</a></b> |
					<b><a href="em2016.php?action=showusertippsdetail&amp;userid=$wbbuserdata[userid]{$SID_ARG_2ND}">Meine Tipps</a></b> |
					<b><a href="em2016.php?action=showusertipps{$SID_ARG_2ND}">{$lang->items['LANG_EM2016_TPL_HEADER_4']}</a></b>
			</span>
		</td>
	</tr>
	<tr>
		<td bgcolor="green">
			<font size="3" color="yellow">
				<div id=counter1 style="visibility: visible; position: relative" align=center></div>
				<script language=JavaScript type=text/javascript>
				var em = new Date(" July 10, 2016 21:00:00");
				goal1 = new Date(em.getTime());
				var jetzta = new Date();
				servernow1 = new Date(jetzta.getTime());
				clientnow1 = new Date();
				countdownTimer1 = window.setTimeout("countdown1()", 1000);
				function countdown1() {
					now1 = new Date();
					seconds1 = Math.floor((goal1.getTime() - servernow1.getTime() - now1.getTime() + clientnow1.getTime()) / 1000);
					if (seconds1 < 0) {
						seconds1 = 0;
					}
					days1 = Math.floor(seconds1 / 60 / 60 / 24);
					hours1 = Math.floor((seconds1 - days1 * 24 * 60 * 60) / 60 / 60);
					minutes1 = Math.floor((seconds1 - (days1 * 24 + hours1) * 60 * 60) / 60);
					seconds1 = (seconds1 - ((days1 * 24 + hours1) * 60 + minutes1) * 60);
					if (seconds1 < 10) {
						seconds1 = "0" + seconds1;
					}
					if (minutes1 < 10) {
						minutes1 = "0" + minutes1;
					}
					daystring1 = "Tage";
					if (days1 == 1) {
						daystring1 = "Tag";
					}
					hoursstring1 = "Stunden";
					if (hours1 == 1) {
						hoursstring1 = "Stunde";
					}
					minutesstring1 = "Minuten";
					if (minutes1 == 1) {
						minutesstring1 = "Minute";
					}
					value1 = "EM Endspiel in <b>" + days1 + "</b> " + daystring1 + " | <b>" + hours1 + "</b>  " + hoursstring1 + " | <b>" + minutes1 + " </b> " + minutesstring1 + " | <b>" + seconds1 + "</b> Sekunden";
					if (document.getElementById) {
						document.getElementById("counter1").innerHTML = value1;
					} else if (document.all) {
						document.all["counter1"].innerHTML = value1;
					}
					countdownTimer = window.setTimeout("countdown1()", 1000);
				}
				</script>
			</font>
		</td>
	</tr>
	<if($em2016_options['showemticker']==1)>
		<then>
			<tr>
				<td class="tableb" align="center">
					<span class="smallfont">
						<iframe src="http://www.fussballportal.de/c4u_ticker.php?mouse_stop=1&amp;speed=10&amp;category=em-2016&amp;box_width=$em2016_options[emticker_width]&amp;bg_color=$bgcolor&amp;bg_box_color=$bgcolor&amp;border_color=$bgcolor&amp;link_color=$fontcolor&amp;link_color_over=$fontcolor" name="iframe" width="$em2016_options[emticker_width]" height="24" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"><a href="http://www.fussballportal.de" target="_blank">Fussball Datenbank auf www.fussballportal.de</a></iframe>
					</span>
				</td>
			</tr>
		</then>
	</if>
</table>
<if($em2016_options['ebay_rel_aktiv']==1)>
	<then>
		$em2016_ebay
	</then>
</if>