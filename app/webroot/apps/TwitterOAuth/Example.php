<?php

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
    'screen_name' => 'maiahmac',
    'count' => 5,
    'exclude_replies' => true
);

/**
 * Send a GET call with set parameters
 */
$response = $tw->get('statuses/user_timeline', $params);
//echo "<pre>";
//print_r($response[0]->user);

$profile_image_url = $response[0]->user->profile_image_url;
$fullname = $response[0]->user->name;
$location = $response[0]->user->location;
echo '<table border="1">'.
	'<tr><td><img src="'.$profile_image_url.'"></td>'.
	'<td>'.$fullname.'<br/>'.$location.'</td></tr></table>';		  


/**
 * Creates a new list for the authenticated user
 * https://dev.twitter.com/docs/api/1.1/post/lists/create
 */
$params = array(
    'name' => 'TwOAuth',
    'mode' => 'private',
    'description' => 'Test List',
);

/**
 * Send a POST call with set parameters
 */
//$response = $tw->post('lists/create', $params);

//var_dump($response);

?>

//https://graph.facebook.com/patilstar?fields=id,name,picture,location
