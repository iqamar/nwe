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

$query ="SELECT users_profiles.birth_date, users_profiles.firstname, users_profiles.photo, users.email FROM users_profiles LEFT JOIN users ON(users.id=users_profiles.user_id) WHERE DAYOFYEAR(users_profiles.birth_date) = DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, \"%Y-%m-%d\")),'".$currntDate."'))";
//echo $query = "SELECT users_profiles.firstname, users_profiles.photo, users.email FROM users_profiles LEFT JOIN users ON(users.id=users_profiles.user_id) WHERE DAYOFYEAR(users_profiles.birth_date) = DAYOFYEAR('YEAR(STR_TO_DATE(users_profiles.birth_date, \"%m/%d/%Y\")) ".$currntDate."')";
if ($result = $mysqli->query($query)) {

     while ($obj = $result->fetch_object()){
	$email = $obj->email;
	//$email ="111@gulfbankers.com";
	if(!empty($email)){	
		$name= fullescape($obj->firstname);
		$pic = fullescape("http://media.networkwe.com/files/user/logo/".$obj->photo);

		$sql ="SELECT whats_today FROM daily_horoscopes WHERE DATE_FORMAT(created,'%m-%d-%Y') = DATE_FORMAT(NOW(),'%m-%d-%Y')";
		$res = $mysqli->query($sql);
		$obj1 = $res->fetch_object();
		if(!empty($obj1->whats_today)){
			$specialText = fullescape(substr($obj1->whats_today,strpos($obj1->whats_today,"?")+1));
		}else{
			$specialText = fullescape('You are always curious and responsive to changes. Routine life is not the way you choose to live. Traveling is your favorite hobby because excitement is what you are after. You will not stand being around the one you dislike. Your love comes and goes quickly. You can be deeply in love but soon after you will be looking around for the next one.');
		}

		$json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.fullescape($strBody).'"},"settings":{"template":"770"},"recipients":["'.$email.'"],"attributes":{"NAME":["'.$name.'"],"PICTURE":["'.$pic.'"],"SPECIALBIRTHDAY":["'.$specialText.'"]}}';
		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));

		$result = curl_exec($ch);

		curl_close($ch);


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
