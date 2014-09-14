<?php

if(!(isset($_GET["handle"]))){
	echo "Handle missing";
	exit;	
}

if(empty($_GET["handle"])){
	echo "Invalid handle missing";
	exit;	
}


$handle = $_GET["handle"];


require_once __DIR__ . '/TwitterOAuth/TwitterOAuth.php';
require_once __DIR__ . '/TwitterOAuth/Exception/TwitterException.php';


use TwitterOAuth\TwitterOAuth;

date_default_timezone_set('UTC');


/**
 * Array with the OAuth tokens provided by Twitter when you create application
 *
 * output_format - Optional - Values: text|json|array|object - Default: object
 */
$config = array(
    'consumer_key' => 'sdUtuFnzxeT3FX2RkRUnjw',
    'consumer_secret' => '5A8aeBsuCal5u4d8uuDQrb5TxgTHUBhTCH2oEHNg',
    'oauth_token' => '1875238705-bDyyjVlj4PKVkLr9RXIi4GEE2mx7yR4OtuYBaw5',
    'oauth_token_secret' => 'KopGkueVAfixWXcmibNSYcDliVhAHykKuMFPosP1OjMPs',
    'output_format' => 'object'
);

/**
 * Instantiate TwitterOAuth class with set tokens
 */
$tw = new TwitterOAuth($config);


/**
 * Returns a collection of the most recent Tweets posted by the user
 * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
 */
$params = array(
    'screen_name' => $handle,
    'count' => 5,
    'exclude_replies' => true
);

/**
 * Send a GET call with set parameters
 */
$response = $tw->get('statuses/user_timeline', $params);
//echo "<pre>";
//print_r($response[0]->user);


if(!(isset($response[0]))){
	echo -1;
	exit;	
}

if(empty($response[0]->user->name)){
	echo -1;
	exit;	
}



$fullname = explode(" ",$response[0]->user->name);
$location =  explode(",",$response[0]->user->location);


$userData["id"] = $response[0]->user->id;
$userData["screen_name"] = $response[0]->user->screen_name;
$userData["first_name"] = $fullname[0];
unset($fullname[0]);
$userData["last_name"] = implode(" ",$fullname);
$userData["profile_photo"] = $response[0]->user->profile_image_url;
$userData["city"] = $location[0];
unset($location[0]);
$userData["counrty"] = implode(" ",$location);
echo "1$$".json_encode($userData);
   
?>


