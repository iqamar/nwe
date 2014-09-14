<html>
<body>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px; color:#000;
}
h1,h2,h3,h4,h5,h6 {
	font-family: Arial, Helvetica, sans-serif; font-size:15px;
}
img{ border:0px;}
td{padding:0px;}
span{margin:0px; padding:0px;}
</style>
<table width="100%" border="0" cellspacing="0" bgcolor="#efefef">
  <tr>
    <td>
    <table  width="550"align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10px;">
  <tr>
    <td height="60" colspan="3" bgcolor="#000000">
	<table width="100%" border="0" cellspacing="13" cellpadding="1">
      <tr>
        <td width="32%"><a href="http://www.networkwe.com" target="_blank"><img src="http://media.networkwe.com/img/networkwe_logo_inner.png" alt="NetworkWe Logo" title="NetworkWe Logo" style="margin-left:4px;"></a></td>
        <td width="68%" style="text-align:right;"><strong><font color="#DFDFDF">Its all about you &amp; The world around you</font></strong></td>
        
      </tr>
    </table></td>
  </tr>   
  
  
  
  
  <tr>
  <td colspan="2" valign="top" bgcolor="#fff" style="background:#fff;">
		<table style="background:#fff;" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%" >                                        
			<tr>
				<td  style="color:#333333;padding: 10px 30px 10px 30px;min-height:50px;">

					<?php
					if(!empty($_POST["email"])){
						require_once "../config.inc.php";
						$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


						if (mysqli_connect_errno()) {
							echo '<h1 style="font-size:22px;text-align:center;">Error when unsubscribe</h1>';
						}
						$frequent =0;
						if(!empty($_POST["frequent"])){
							$frequent =1;
						}
						$relevant = 0;
						if(!empty($_POST["relevant"])){
							$relevant = 1;
                                                }

						$others=addslashes($_POST["other_reason"]);	
						$mysqli->query("UPDATE cron_users SET unsub_daily_jobs_alert = 1, unsub_daily_jobs_alert_frequent =".$frequent.", unsub_daily_jobs_alert_relevant=".$relevant.", unsub_daily_jobs_alert_others='".$others."' WHERE email ='".$_POST["email"]."'");
						echo '<h1 style="font-size:22px;text-align:center;">You Have been unsubscribed!</h1><p><br>We\'re sorry to have lost you, but hope you re-subscribe daily jobs alert at a later time.</p>';

					}else{

						echo '<h1 style="font-size:22px;text-align:center;">Invalid Email Id</h1>';
					}

					?>
						<br/><br/><br/><br/><br/>
				</td>
			</tr>
				
				
				
				
				<tr>
				<td>
					<table width="100%" border="0" cellspacing="5" cellpadding="5" style="background:#ececec; border:1px solid #cfcfcf; font-size:13px;">
						<tr>
							<td colspan="2" height="15">Thanks,</td>
						</tr>
						<tr>
							<td colspan="2" height="15">NetworkWE Team</td>
						</tr>

						<tr>
                      <td  height="25" style="font-size:13px;">To find out more about NetworkWE, please follow us</td>
                      <td ><table width="35%" cellspacing="2" cellpadding="5" border="0">
                        <tbody><tr>
                          <td>
						  <a target="_blank" href="https://www.facebook.com/NetworkWe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/facebook.png"></a>                          
                          </td><td><a target="_blank" href="https://twitter.com/networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/twitter.png"></a></td>
                          <td><a target="_blank" href="https://plus.google.com/+Networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/google-plus.png"></a></td>
                          <td><a target="_blank" href="http://www.linkedin.com/company/networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/linkedin.png"></a></td>
                          <td><a target="_blank" href="http://www.pinterest.com/networkwe/"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/pinterest.png"></a></td>
                          <td><a target="_blank" href="http://instagram.com/network_we"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/instagram.png"></a></td>
                        </tr>
                      </tbody></table></td>
                      </tr>
						</table>
					</td>
				</tr>				
				<tr>
					<td bgcolor="#000000">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;">								
						<tr>
						  <td align="center"><span  style="font-size:10px; color:#DFDFDF; text-align:center;"><a style="font-size:10px; text-decoration:none; color:#0AA51A; " target="_blank" href="http://www.networkwe.com">NetworkWe.com</a> &copy; 2014</span></td>
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
