<?php
require_once "config.inc.php";

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//$query ="SELECT users_profiles.birth_date, users_profiles.firstname, users_profiles.photo, users.email FROM users_profiles LEFT JOIN users ON(users.id=users_profiles.user_id) WHERE DAYOFYEAR(users_profiles.birth_date) = DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, \"%Y-%m-%d\")),'".$currntDate."'))";
//$mysqli->query($query);

//date_default_timezone_set('Asia/Dubai');
//for($day =15; $day<26;$day++){

$today =date("n/j/Y");
$horoscopes = simplexml_load_file(HOROSCOPE_GET_API.$today);
/*echo "<pre>";
print_r($horoscopes);
exit;*/
foreach ($horoscopes->channel->item as $horoscope){
	$title = substr($horoscope->title,0, strpos($horoscope->title, ' '));
	$paragraph = $horoscope->description;
	$mysqli->query("UPDATE star_signs SET todays_horoscope = '".  addslashes($paragraph)."' WHERE name ='".$title."'");

//	$mysqli->query("INSERT INTO daily_horoscopes(id,star_signs,text,whats_today,created) VALUES('','".$title."','".$paragraph."'i)i
	$todays[$title] = addslashes($paragraph);

	//$start = strpos($html, '<p>');
		//$end = strpos($html, '</p>', $start);
		//$paragraph = substr($html, $start, $end-$start+4);
}
echo $sql = "INSERT INTO daily_horoscopes(id, Aries, Taurus, Gemini, Cancer, Leo, Virgo, Libra, Scorpio, Sagittarius, Capricorn, Aquarius, Pisces, Panchang, whats_today, created) VALUES (NULL, '".$todays['Aries']."', '".$todays['Taurus']."', '".$todays['Gemini']."', '".$todays['Cancer']."', '".$todays['Leo']."', '".$todays['Virgo']."', '".$todays['Libra']."', '".$todays['Scorpio']."', '".$todays['Sagittarius']."', '".$todays['Capricorn']."', '".$todays['Aquarius']."', '".$todays['Pisces']."', '".$todays['Panchang']."', '".$todays["What's"]."', CURRENT_TIMESTAMP)"; 
$mysqli->query($sql);
?>
