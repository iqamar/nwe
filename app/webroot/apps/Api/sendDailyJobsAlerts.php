<?php
require_once "config.inc.php";
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$url = MAILER_SEND_API;
$strBody ="";

$currntDate = date('-m-d');




//$query ="SELECT users_profiles.birth_date, users_profiles.firstname, users_profiles.photo, users.email FROM users_profiles LEFT JOIN users ON(users.id=users_profiles.user_id) WHERE DAYOFYEAR(users_profiles.birth_date) = DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, \"%Y-%m-%d\")),'".$currntDate."'))";
echo $query ='SELECT job_id as jId, job_title as jTitle, company_title as cTitle, company_logo as cLogo FROM  cron_daily_jobs';
	if ($result = $mysqli->query($query)) {
		$strjobs = '<table width="100%" border="0" cellpadding="0" cellspacing="0"  style="border-top:2px solid #f4f4f4; margin-bottom:6px;">';
     		while ($obj = $result->fetch_object()){
			$strjobs .='<tr height="60"><td width="60" valign="top" style="border-bottom:2px solid #f4f4f4;"><a href="http://jobs.networkwe.com/search/jobDetails/'.$obj->jId.'/"><img src="http://media.networkwe.com/files/company/logo/'.$obj->cLogo.'" alt="" width="50" height="50"></a></td><td style="border-bottom:2px solid #f4f4f4;" valign="top"><strong><a href="http://jobs.networkwe.com/search/jobDetails/'.$obj->jId.'/" target="_blank" style="color:#c70000; text-decoration:none;">'.$obj->jTitle.'</a></strong><br/>'.$obj->cTitle.'</td></tr>';
}
		$strjobs .='</table>';

echo $strjobs;
exit;
	$sql ='SELECT id,user_id, first_name, last_name, email FROM cron_users where daily_jobs_alert=0 AND unsub_daily_jobs_alert=0 order by id limit 0, 30';
	if ($result1 = $mysqli->query($sql)) {
		$today = date("M d, Y");
		echo "<pre>";
		print_r($result1);
		 while ($obj1 = $result1->fetch_object()){
			$appid = $obj1->id;
	        	$userid = $obj1->user_id;
	        	$fname = $obj1->first_name;
		        $lname = $obj1->last_name;
        		echo $email = $obj1->email;
		
			if((!empty($userid)) && (!empty($email))){	
				echo $name= fullescape($fname." ".$lname);
				if(empty($name)){
					$name ="User";
				}
	
				echo	$json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.fullescape(MAILER_TODAY_JOBS_ALERT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.fullescape($strBody).'"},"settings":{"template":"852"},"recipients":["'.$email.'"],"attributes":{"NAME":["'.$name.'"],"JOBS":["'.fullescape($strjobs).'"],"DATE":["'.$today.'"],"UNSUB_URL":["'.fullescape(UNSUB_URL_DIALY_JOBS_ALERT."?xEmail=".$email).'"]}}';
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch,CURLOPT_POST, true);
				curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));

				$result = curl_exec($ch);
				curl_close($ch);
			//$result->close();


				if($result=="success"){
					$mysqli->query("UPDATE cron_users SET daily_jobs_alert = 1 WHERE id ='".$appid."'");
					echo "done";
				}

			}
		}	
		exec('php sendDailyJobsAlerts.php');
		//call again ....
	}
}

$mysqli->close();


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
