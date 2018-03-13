<?php
		echo '
		<div id="top_wrap">
			<div class="top_box">
				<div class="login_box">


							<tr>
								<td class="lb_type2">驗證碼 :</td>
								<td class="ver_code" valign="bottom">
									<div class="ver_box">
										<div align="left">
											<object type="application/x-shockwave-flash" data="js/securimage/securimage_play.swf?audio_file=js/securimage/securimage_play.php&amp;bgColor1=#ffffff&amp;bgColor2=#ffffff&amp;iconColor=#777777&amp;borderWidth=1&amp;borderColor=#000000" height="32" width="32">
												<param name="movie" value="js/securimage/securimage_play.swf?audio_file=js/securimage_play.php&amp;bgColor1=#ffffff&amp;bgColor2=#ffffff&amp;iconColor=#777777&amp;borderWidth=1&amp;borderColor=#000000">
											</object>
											<a onclick="document.getElementById(\'siimage\').src =\'./js/securimage/securimage_show.php?sid=\'+ Math.random();" href="#" title="Refresh Image" tabindex="-1" style="border-style: none;"><img src="js/securimage/images/refresh.png" title="更換驗證碼" border="0" /></a>不分大小寫
											<img id="siimage" style="border:1px solid #000000;" src="js/securimage/securimage_show.php?sid='.md5(uniqid()).'" title="請輸入驗證碼" border="0" />
										</div>
										<div align="left" style="float:left; text-align:left;margin-top:6px; width:100%;">
											<input type="text" id="ct_captcha" name="ct_captcha" class="lb_input2" maxlength="6" value="" style="width:120px;float:left;margin:0px;" />
											<a onclick="javascript:on_submit();return false;" href="#" class="login_btn" style="margin-left:10px;float:left;">送出</a>
										</div>
									</div>
								</td>
							</tr>

						<input type="hidden" id="session_id" name="session_id" value="'.$session_id.'"/>

				</div>
			</div>
		</div>
		';
?>
