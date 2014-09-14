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
$query = "SELECT * FROM jobs_applications WHERE mail_sent_user = 0 ORDER BY id limit 0,20";
if ($result = $mysqli->query($query)) {

     while ($obj = $result->fetch_object()){
//print_r($obj);
	$appid = $obj->id;
	$userid = $obj->user_id;
	$jobid = $obj->job_id;
	$cover = $obj->cover_letter;
	$cv = $obj->cv;
	$appstatus = $obj->mail_sent_user;
	$status = $obj->status;
	//$email ="111@gulfbankers.com";
	if((!empty($userid)) && (!empty($jobid))){	
		$name= fullescape($obj->firstname);
		$pic = fullescape("http://media.networkwe.com/files/user/logo/".$obj->photo);

		$sql ="SELECT firstname FROM users_profiles WHERE user_id='".$userid."'";
		$res = $mysqli->query($sql);
		$obj1 = $res->fetch_object();
		if(!empty($obj1->firstname)){
			$name = fullescape($obj1->firstname);//,strpos($obj1->whats_today,"?")+1));
		}else{
			$name=" ";
		}


		$sql2 ="SELECT users.email, users_profiles.firstname FROM users, users_profiles WHERE users_profiles.user_id=users.id AND users_profiles.user_id='".$userid."'";
                $res2 = $mysqli->query($sql2);
                $obj2 = $res2->fetch_object();
                if(!empty($obj2->firstname)){
                        $email = $obj2->email;//,strpos($obj1->whats_today,"?")+1));
			$sql3 ="SELECT jobs.title as jTitle,companies.title as cTitle, companies.primary_email FROM jobs,companies WHERE jobs.id='".$jobid."' AND companies.id=jobs.company_id";
			$res3 = $mysqli->query($sql3);
			$obj3 = $res3->fetch_object();
			$jTitle = fullescape($obj3->jTitle);
			$cTitle = fullescape($obj3->cTitle);
			$cEmail = $obj3->primary_email;

			$json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.fullescape(MAILER_JOB_APPLICATION_USER_SUBJECT. urldecode($jTitle)." at ".urldecode($cTitle)).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.fullescape($strBody).'"},"settings":{"template":"847"},"recipients":["'.$email.'"],"attributes":{"NAME":["'.$name.'"],"CLIENT_NAME":["'.$cTitle.'"],"JOB_NAME":["'.$jTitle.'"]}}';

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_POST, true);
			curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));

			$result = curl_exec($ch);
			curl_close($ch);



			if($result=="success"){
				$mysqli->query("UPDATE jobs_applications SET  mail_sent_user = 1 WHERE id ='".$appid."'");
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
