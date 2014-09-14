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




/**$lastUser=  $mysqli->query("SELECT max(user_id) maxi FROM cron_users");
$u = $lastUser->fetch_object();
if($u->maxi>1){
 $q ="INSERT INTO cron_users (user_id, first_name, last_name, email) SELECT users.id, users_profiles.firstname, users_profiles.lastname, users.email FROM users, users_profiles WHERE users.id=users_profiles.user_id AND users.id >".$u->maxi;
	$mysqli->query($q);

}
**/


//$mysqli->query("UPDATE cron_users SET daily_jobs_alert = 0");
$mysqli->query("TRUNCATE table cron_daily_jobs");
//$query ='SELECT jobs.id as jId, jobs.title as jTitle, companies.title as cTitle, companies.logo as cLogo FROM jobs, companies WHERE STR_TO_DATE(NOW(), "%Y-%m-%d") = STR_TO_DATE(jobs.created, "%Y-%m-%d") AND jobs.company_id=companies.id AND jobs.status=2 LIMIT 0, 10';


echo $query ='SELECT distinct jobs.id as jId, jobs.title as jTitle, companies.title as cTitle, companies.logo as cLogo FROM jobs, companies WHERE jobs.created BETWEEN DATE_ADD(NOW(), INTERVAL -6 day) AND NOW() AND jobs.status=2 AND jobs.company_id = companies.id LIMIT 0, 10';
if ($result = $mysqli->query($query)) {
	while ($obj = $result->fetch_object()){
		$mysqli->query("INSERT INTO cron_daily_jobs Values ('','".$obj->jId."','".$obj->jTitle."','".$obj->cTitle."','".$obj->cLogo."')");
	}
	//exec('php sendDailyJobsAlerts.php');
}

$mysqli->close();
 
?>
