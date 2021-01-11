<?php 
// compresing email makes the sending faster. use " https://www.textfixer.com/html/compress-html-compression.php " to compress.
$body = '

<html><body style="margin: 0; padding: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding: 10px 0 30px 0;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;"><tr><td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;"><img src="http://sandbox.phoenix.com.ph/wp-content/uploads/2018/05/phoenix-logo_456.png" alt="Phoenix Publishing House" width="300" height="70" style="display: block;" /></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;"> <b>2-Step Authentication (OTP)</b> </td></tr><tr> <td style="padding: 20px 0 2px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> Use the code below to authenticate your account. </td></tr><tr> <td style="padding: 10px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 18px; line-height: 20px; text-indent:10px; color:#2FB45A; letter-spacing:2px;"> <b>'.$_SESSION["token"].'</b> </td></tr><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/left.gif" alt="" width="100%" height="140" style="display: block;" /></td></tr><tr><td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> 2-Step verification is 2nd layer of security to protect your data. </td></tr></table></td><td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/right.gif" alt="" width="100%" height="140" style="display: block;" /></td></tr><tr> <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> The Code above will become unusable after 5 minutes and can only be used once. Please do not reply to this email. </td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr> <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%"> Best Reguards,<br/> The IT-DCX Team. </td><td align="right" width="25%"><table border="0" cellpadding="0" cellspacing="0"><tr><td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;"><a href="https://twitter.com/alagangphoenix" style="color: #ffffff;"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" /></a></td><td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td><td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;"><a href="https://facebook.com/alagangphoenix" style="color: #ffffff;"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" /></a></td><td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td> <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; "> <a href="https://phoenix.com.ph/" style="color: #ffffff;"> <img src="https://i.ibb.co/brz856J/internet.png" alt="Website" width="30" height="30" style="display: block; opacity:40%;" border="0" /> </a> </td></tr></table></td></tr></table></td></tr></table></td></tr></table></body></html>

';

$codeStyle='style="color: #153643; font-family: Arial, sans-serif; font-size: 15px; color:#2FB45A; letter-spacing:1.2px;"';

$simpleBody='
Hello '.$_SESSION['fname'].'! <br>
A sign in attempt requires further verification to protect your data. To complete the sign in, enter the verification code.<br><br>
Verification Code: <span '.$codeStyle.' ><strong>'.$_SESSION['token'].'</strong></span> <br><br>
The Code is unusable after 5 minutes Please Don\'t reply to this email. 
Thanks, <br>
The PPH-DCX Team
';


$uncompressBody= 
' 

<html>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="http://sandbox.phoenix.com.ph/wp-content/uploads/2018/05/phoenix-logo_456.png" alt="Phoenix Publishing House" width="300" height="70" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
								<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                    				<b>2-Step Authentication (OTP)</b>
                  				</td>
								</tr>
								<tr>
                  <td style="padding: 20px 0 2px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                    Use the code below to authenticate your account.
                  </td>
								</tr>
								<tr>
									     <td style="padding: 10px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 18px; line-height: 20px; text-indent:10px; color:#2FB45A; letter-spacing:2px;">
       <b>'.$_SESSION["token"].'</b>
                  </td>
								</tr>
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="260" valign="top">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td>
																<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/left.gif" alt="" width="100%" height="140" style="display: block;" />
															</td>
														</tr>
														<tr>
												<td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                2-Step verification is 2nd layer of security to protect your data.
                               
                              </td>
														</tr>
													</table>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">
													&nbsp;
												</td>
												<td width="260" valign="top">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td>
																<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/right.gif" alt="" width="100%" height="140" style="display: block;" />
															</td>
														</tr>
														<tr>
                              <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                The Code above will become unusable after 30 minutes and can only be used once.  Please do not reply to this email.
                              </td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
                  <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                     Best Reguards,<br/>
                     The IT-DCX Team.
                  </td>
									<td align="right" width="25%">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://twitter.com/alagangphoenix" style="color: #ffffff;">
														<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://facebook.com/alagangphoenix" style="color: #ffffff;">
														<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold; ">
                          <a href="https://phoenix.com.ph/" style="color: #ffffff;">
                            <img src="https://i.ibb.co/brz856J/internet.png" alt="Website" width="30" height="30" style="display: block; opacity:40%;" border="0" />
                          </a>
                        </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>

';

?>