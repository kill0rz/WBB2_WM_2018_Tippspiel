<br />
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
	<tr>
		<td class="tabletitle" colspan="2" align="center">
			<span class="smallfont">
				<b>
					<u>{$lang->items['LANG_EM2016_TPL_TIPPABGABE_RK_1']}</u>
				</b>
			</span>
		</td>
	</tr>
	<tr>
		<td class="tableb" align="center" width="70%">
			<span class="smallfont">{$lang->items['LANG_EM2016_TPL_TIPPABGABE_RK_2']}</span>
		</td>
		<td class="tableb" align="center" width="30%">
			<select name="tipp_rk">
				<option value="-1">{$lang->items['LANG_EM2016_GLOBAL_CHOICE']}</option>
				<option value="1" $tipp_rk_jn[1]>{$lang->items['LANG_EM2016_GLOBAL_YES']}</option>
				<option value="0" $tipp_rk_jn[0]>{$lang->items['LANG_EM2016_GLOBAL_NO']}</option>
			</select>
		</td>
	</tr>
</table>
