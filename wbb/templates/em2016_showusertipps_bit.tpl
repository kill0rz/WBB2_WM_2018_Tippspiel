<tr>
	<td class="$rowclass" align="center">
		<span class="smallfont"><a href="em2016.php?action=showusertippsdetail&amp;userid=$row[userid]{$SID_ARG_2ND}">$row[username]</a></span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[tipps_gesamt]</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[tipps_richtig]</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[tipps_falsch]</span>
	</td>
	<if($em2016_options['tendenz']==1)>
		<then>
			<td class="$rowclass" align="center">
				<span class="smallfont">$row[tipps_tendenz]</span>
			</td>
		</then>
	</if>
	<if($em2016_options['winnertipp_jn']==1)>
		<then>
			<td class="$rowclass" align="center">
				<span class="smallfont">$image_emtipp</span>
			</td>
			<td class="$rowclass" align="center">
				<span class="smallfont">$image_vemtipp</span>
			</td>
		</then>
	</if>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[punkte]</span>
	</td>
</tr>
