<?php
define("MAILER_SEND_API","http://api.falconide.com/falconapi/web.send.json");
define("MAILER_API_KEY","53082152a4def15d06f42c42affbce77");
define("MAILER_REGISTER_REPLYTO","support@networkwe.com");
define("MAILER_REGISTER_SUBJECT","Confirm Registration For NetworkWE");
define("MAILER_REGISTER_FROMNAME","NetworkWE");
define("MAILER_REGISTER_FROMEMAIL","info@networkwe.com");


$url = MAILER_SEND_API;

$email = "111@gulfbankers.com";
//$email = "patilstar@gmail.com";
$confirmlink="http://www.networkwe.com/users/verify/t:ccd3dc9967bb546ea601a2e292e7c2e5/n:it@gulfbankers.com";
$strBody = '<html><body><style type="text/css">body,td,th {font-family: Arial, Helvetica, sans-serif;font-size: 14px; color:#000;}h1,h2,h3,h4,h5,h6 {font-family: Arial, Helvetica, sans-serif; font-size:15px;}img{ border:0px;}td{padding:0px;}span{margin:0px; padding:0px;}</style><table  bgcolor="#fff" width1="550"align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10px;"><tr><td height="60" colspan="3" bgcolor="#000000"><table width="100%" border="0" cellspacing="13" cellpadding="1"><tr><td width="32%"><a href="http://www.networkwe.com" target="_blank"><img src="http://media.networkwe.com/img/networkwe_logo_inner.png" alt="NetworkWe Logo" title="NetworkWe Logo" style="margin-left:4px;"></a></td><td width="68%" style="text-align:right;"><strong><font color="#DFDFDF">Its all about you &amp; The world around you</font></strong></td></tr></table></td></tr><tr><td colspan="3" valign="top" style="border:1px solid #000;" bgcolor="#fff"><table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td  style="color:#333333;padding: 10px 30px 10px 30px;min-height:50px;"><h1 style="font-size:22px;text-align:center;">Welcome to NetworkWE</h1><p><hr><h1>Thanks for signing up.</h1>To Sign into your account, please verify your email address by clicking the link below.</p></td></tr><tr><td  style="color:#000000;padding: 10px 35px 10px 35px; line-height:20px;"><strong>Activate Your NetworkWE Account</strong><br /><p>Click <a href="'.$confirmlink.'" style="font-size:14px;color:#1F79C7;text-decoration:none;">here</a> to activate your account</p><p >OR</p><p>copy paste the following link in the browser&nbsp;</p> <a style="color:#0AA51A; font-size:11px; text-decoration:none;">'.$confirmlink.'</a></td></tr><tr><td  style="border-top:1px solid #efefef;color:#6D6D6D;padding: 10px 35px 10px 35px; line-height:28px;"><strong>Your NetworkWE account details</strong><table bgcolor="#fff"><tr><td >Your username (Email):</td><td><span><a style="color:#0AA51A; text-decoration:none;">&nbsp;&nbsp;&nbsp;'.$email.'</a></span></td></tr><tr><td >Your password:</td><td><span style="color:#0AA51A;">&nbsp;&nbsp;&nbsp;Your chosen password</span></td></tr></table></td></tr><tr><td  style="border-top:1px solid #efefef;color:#333;padding: 10px 35px 10px 35px; line-height:15px;"><strong>Here are 4 quick ways to get started:</strong><br /><p><b style="font-size:12px;">1. Spruce up your profile</b><br/><span style="font-size:12px;">Say who you are and what you love. Don\'t forget a photo!</span></p><p><b style="font-size:12px;">2. Check out Updates</b><br/><span style="font-size:12px;">For regular News and Updates check out our Home page.</span></p><p><b style="font-size:12px;">3. Check out Blogs, Tweets</b><br/><span style="font-size:12px;">Write your blog posts and tweets</span></p><p><b style="font-size:12px;">4. Browse all the latest vacancies</b><br/>';
$strBody .='<span style="font-size:12px;">Find the your next job that match your skills, perform a job search and save, refer, share, apply jobs online.</span></p><h1 style="font-size:22px;text-align:center;">Happy networking!</h1></td></tr><tr height="150px;"><td><table width="100%" border="0" cellspacing="5" cellpadding="5" style="background:#ececec; border:1px solid #cfcfcf; font-size:13px;"><tr><td colspan="2" height="15">Thanks,</td></tr><tr><td colspan="2" height="15">NetworkWE Support Team</td></tr><tr><td  height="25" style="font-size:13px;">To find out more about NetworkWE, please follow us</td><td ><table width="35%" cellspacing="2" cellpadding="5" border="0"><tbody><tr><td><a target="_blank" href="https://www.facebook.com/NetworkWe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/facebook.png"></a></td><td><a target="_blank" href="https://twitter.com/networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/twitter.png"></a></td><td><a target="_blank" href="https://plus.google.com/+Networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/google-plus.png"></a></td><td><a target="_blank" href="http://www.linkedin.com/company/networkwe"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/linkedin.png"></a></td><td><a target="_blank" href="http://www.pinterest.com/networkwe/"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/pinterest.png"></a></td><td><a target="_blank" href="http://instagram.com/network_we"><img width="28" height="28" src="http://creatives.networkwe.net/newsletter/launching/instagram.png"></a></td></tr></tbody></table></td></tr></table></td></tr><tr><td colspan="3" bgcolor="#000000"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;"><tr><td align="center" height="20px"><span  style="padding:10px;font-size:10px; color:#DFDFDF; text-align:center;"><a style="font-size:10px; text-decoration:none; color:#0AA51A; " target="_blank" href="http://www.networkwe.com">NetworkWe.com</a> &copy; 2014</span></td></tr></table></td></tr></table></body></html>';

$json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.fullescape($strBody).'"},"recipients":["'.$email.'"]}';


//$json_fields = str_replace('%22]%22', '%22]',str_replace('%22[%22', '[%22',str_replace('"', '%22',$json_fields)));
//echo $json_fields;
// $url .= "?data=".$json_fields;
$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));

$result = curl_exec($ch);

curl_close($ch);
print_r($result);

function fullescape($in) 
{ 
  $out = '';
  $out = urlencode($in);	 
  $out = str_replace('+','%20',$out); 
  $out = str_replace('_','%5F',$out); 
  $out = str_replace('.','%2E',$out); 
  $out = str_replace('-','%2D',$out); 
  return $out; 
}
 
?>
