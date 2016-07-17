<br />
<form method="post" action="wm2018.php?action=tippabgabe_em">
	<input type="hidden" name="send" value="send" />
	<input type="hidden" name="gameid" value="$_REQUEST[gameid]" />
	<input type="hidden" name="sid" value="$session[hash]" />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
		<tr>
			<td class="tabletitle" colspan="3" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_TIPPABGABE_EM_1']}</u>
					</b>
					<br />{$lang->items['LANG_WM2018_TPL_TIPPABGABE_EM_2']}</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center" width="70%">
				<span class="smallfont">{$lang->items['LANG_WM2018_TPL_TIPPABGABE_EM_3']}</span>
			</td>
			<td class="tableb" align="center" width="30%">
				<select name="tipp_em">
					<option value="-1">{$lang->items['LANG_WM2018_GLOBAL_CHOICE']}</option>
					$wm2018_auswahl_emtipp
				</select>
			</td>
			<td align="center" class="tableb">
				<input type="submit" value="{$lang->items['LANG_WM2018_GLOBAL_SAVE']}" />
			</td>
		</tr>
	</table>
</form>
