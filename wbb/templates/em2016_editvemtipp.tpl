<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_1']}</title>
	$headinclude
</head>

<body>
	$header
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tablea">
				<table cellpadding="0" cellspacing="0" border="0" style="width:{$style['tableinwidth']}">
					<tr class="tablea_fc">
						<td align="left">
							<span class="smallfont">
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2016.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_EM2016_TPL_MAKETIPP_2']}</a> &raquo; {$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_2']}</b>
							</span>
						</td>
						<td align="right">
							<span class="smallfont">
								<b>$usercbar</b>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br /> $em2016_header
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_3']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">{$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_4']}
					<br />
					<br />{$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_5']} $vem_flagge
					<b>$vem_name</b> $vem_flagge</span>
			</td>
		</tr>
	</table>
	<br />
	<form method="post" action="em2016.php?action=editvemtipp">
		<input type="hidden" name="send" value="send" />
		<input type="hidden" name="sid" value="$session['hash']" />
		<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
			<tr>
				<td class="tablea" align="center" width="50%">
					<span class="smallfont">{$lang->items['LANG_EM2016_TPL_EDITVEMTIPP_6']} </span>
				</td>
				<td class="tablea" align="center" width="50%">
					<select name="tipp_vem">
						<option value="-1">{$lang->items['LANG_EM2016_GLOBAL_CHOICE']}</option>
						$em2016_auswahl_vemtipp
					</select>&nbsp;
					<input type="submit" value="{$lang->items['LANG_EM2016_GLOBAL_SAVE']}" />
				</td>
			</tr>
		</table>
	</form>
	<br /> $em2016_footer $footer
</body>

</html>
