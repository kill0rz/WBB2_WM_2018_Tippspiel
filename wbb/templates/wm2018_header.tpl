<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
	<tr class="tabletitle_fc">
		<td align="center" style="background-image:url(images/back.gif)">
			<span>
				<b><a href="wm2018.php{$SID_ARG_1ST}">{$lang->items['LANG_WM2018_TPL_HEADER_1']}</a></b> |
				<if($wbbuserdata['can_wm2018_use']==1)>
					<then>
						<b><a href="wm2018.php?action=maketipp{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_HEADER_2']}</a></b> | </then>
					</if>
					<b><a href="wm2018.php?action=showresults{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_HEADER_3']}</a></b> |
					<b><a href="board.php?boardid={$wm2018_options['diskussionsthreadid']}" target="_blank">Fragen&amp;Talk zum Spiel</a></b> |
					<b><a href="wm2018.php?action=showusertippsdetail&amp;userid=$wbbuserdata[userid]{$SID_ARG_2ND}">Meine Tipps</a></b> |
					<b><a href="wm2018.php?action=showusertipps{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_HEADER_4']}</a></b>
			</span>
		</td>
	</tr>
	<tr>
		<td bgcolor="green">
			<font size="3" color="yellow">
				<div id=counter1 style="visibility: visible; position: relative" align=center></div>
				<script language=JavaScript type=text/javascript>
					var wm = new Date("July 15, 2018 17:00:00");
					var goal1 = new Date(wm.getTime());
					var jetzta = new Date();
					var servernow1 = new Date(jetzta.getTime());
					var clientnow1 = new Date();
					var countdownTimer1 = window.setTimeout(countdown1(), 1000);

					function countdown1() {
						var now1 = new Date();
						var seconds1 = Math.floor((goal1.getTime() - servernow1.getTime() - now1.getTime() + clientnow1.getTime()) / 1000);
						if (seconds1 < 0) {
							seconds1 = 0;
						}
						var days1 = Math.floor(seconds1 / 60 / 60 / 24);
						var hours1 = Math.floor((seconds1 - days1 * 24 * 60 * 60) / 60 / 60);
						var minutes1 = Math.floor((seconds1 - (days1 * 24 + hours1) * 60 * 60) / 60);
						seconds1 = (seconds1 - ((days1 * 24 + hours1) * 60 + minutes1) * 60);
						if (seconds1 < 10) {
							seconds1 = "0" + seconds1;
						}
						if (minutes1 < 10) {
							minutes1 = "0" + minutes1;
						}
						var daystring1 = "Tage";
						if (days1 == 1) {
							daystring1 = "Tag";
						}
						var hoursstring1 = "Stunden";
						if (hours1 == 1) {
							hoursstring1 = "Stunde";
						}
						var minutesstring1 = "Minuten";
						if (minutes1 == 1) {
							minutesstring1 = "Minute";
						}

						if (wm < jetzta) {
							var value1 = "Die WM wurde am " + wm.getDate() + "." + (wm.getMonth()+1) + "." + wm.getFullYear() + " beendet.";
						}else{
							var value1 = "WM-Endspiel in <b>" + days1 + "</b> " + daystring1 + " | <b>" + hours1 + "</b>  " + hoursstring1 + " | <b>" + minutes1 + " </b> " + minutesstring1 + " | <b>" + seconds1 + "</b> Sekunden";
						}

						if (document.getElementById) {
							document.getElementById("counter1").innerHTML = value1;
						} else if (document.all) {
							document.all["counter1"].innerHTML = value1;
						}
						var countdownTimer = window.setTimeout("countdown1()", 1000);
					}
				</script>
			</font>
		</td>
	</tr>
	<if($wm2018_options['showwmticker']==1)>
		<then>
			<tr>
				<td class="tableb" align="center">
					<span class="smallfont">
						<iframe src="http://www.fussballportal.de/c4u_ticker.php?mouse_stop=1&amp;speed=10&amp;category=wm-2018&amp;box_width=$wm2018_options[wmticker_width]&amp;bg_color=$bgcolor&amp;bg_box_color=$bgcolor&amp;border_color=$bgcolor&amp;link_color=$fontcolor&amp;link_color_over=$fontcolor" name="iframe" width="$wm2018_options[wmticker_width]" height="24" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"><a href="http://www.fussballportal.de" target="_blank">Fussball Datenbank auf www.fussballportal.de</a></iframe>
					</span>
				</td>
			</tr>
		</then>
	</if>
</table>
<if($wm2018_options['ebay_rel_aktiv']==1)>
	<then>
		$wm2018_ebay
	</then>
</if>