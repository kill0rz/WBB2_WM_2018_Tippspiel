<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="wm2018.php{$SID_ARG_1ST}">{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_3']}</b>
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
	<br /> $wm2018_header
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_4']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_5']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_6']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_7']}</u>
					</b>
				</span>
			</td>
			<if($wm2018_options['tendenz']==1)>
				<then>
					<td class="tabletitle" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_8']}</u>
							</b>
						</span>
					</td>
				</then>
				</if>
				<if($wm2018_options['winnertipp_jn']==1)>
					<then>
						<td class="tabletitle" align="center">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_9']}</u>
								</b>
							</span>
						</td>
						<td class="tabletitle" align="center">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_10']}</u>
								</b>
							</span>
						</td>
					</then>
					</if>
					<td class="tabletitle" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPS_11']}</u>
							</b>
						</span>
					</td>
		</tr>
		$wm2018_showusertipps_bit
	</table>
	<br /> $wm2018_footer $footer
</body>

</html>
