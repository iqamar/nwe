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
$query = "SELECT * FROM jobs_applications WHERE mail_sent_client = 0 ORDER BY id limit 0,20";
if ($result = $mysqli->query($query)) {

     while ($obj = $result->fetch_object()){
//print_r($obj);
	$appid = $obj->id;
	$userid = $obj->user_id;
	$jobid = $obj->job_id;
	$cover = $obj->cover_letter;
	$cv = $obj->cv;
	$appstatus = $obj->mail_sent_client;
	$status = $obj->status;
	//$email ="111@gulfbankers.com";
	if((!empty($userid)) && (!empty($jobid))){	

		$sql2 ="SELECT users.email, users_profiles.firstname, users_profiles.lastname FROM users, users_profiles WHERE users_profiles.user_id=users.id AND users_profiles.user_id='".$userid."'";
                $res2 = $mysqli->query($sql2);
                $obj2 = $res2->fetch_object();
                if(!empty($obj2->firstname)){
			$name = fullescape($obj2->firstname ." ". $obj2->lastname);
                        $email = $obj2->email;//,strpos($obj1->whats_today,"?")+1));
			$sql3 ="SELECT jobs.title as jTitle,companies.title as cTitle, jobs.contact_email, companies.primary_email FROM jobs,companies WHERE jobs.id='".$jobid."' AND companies.id=jobs.company_id";
			$res3 = $mysqli->query($sql3);
			$obj3 = $res3->fetch_object();
			$jTitle = fullescape($obj3->jTitle);
			$cTitle = fullescape($obj3->cTitle);
			$cEmail = $obj3->contact_email;
			if(empty($cEmail)){
				$cEmail = $obj3->primary_email;
			}

 		$json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.fullescape(MAILER_JOB_APPLICATION_CLIENT_SUBJECT. urldecode($jTitle)).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.fullescape($strBody).'"},"settings":{"template":"848"},"recipients":["'.$cEmail.'"],"attributes":{"NAME":["'.$name.'"],"USER_EMAIL":["'.$email.'"],"JOB_NAME":["'.$jTitle.'"],"CLIENT_NAME":["'.$cTitle.'"]}';
			 if(!empty($cv)){
				$files=',"files":{"'.$cv.'":"'.fullescape(file_get_contents("/srv/www/htdocs/media/files/resume/".$cv)).'"';
			 	if(!empty($cover)){
					$files .= ',"'.$cover.'":"'.fullescape(file_get_contents("/srv/www/htdocs/media/files/resume/".$cover)).'"';
				}
				$files .='}';
				$json_fields .= $files;
			}
					
			$json_fields  .='}';	

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_POST, true);
			curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));

			$result = curl_exec($ch);
			curl_close($ch);


			if($result=="success"){
				$mysqli->query("UPDATE jobs_applications SET mail_sent_client = 1 WHERE id ='".$appid."'");
				echo "done";
			}

		}
	}	
}		

    $result->close();
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
