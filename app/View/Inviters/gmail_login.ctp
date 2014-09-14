<?php

require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';    

    session_start();

$client = new Google_Client();
$client->setApplicationName('networkwe');
$client->setScopes("http://www.google.com/m8/feeds/");
// Documentation: http://code.google.com/apis/gdata/docs/2.0/basics.html
// Visit https://code.google.com/apis/console?api=contacts to generate your
// oauth2_client_id, oauth2_client_secret, and register your oauth2_redirect_uri.
 $client->setClientId('618337304670.apps.googleusercontent.com');
 $client->setClientSecret('3XFdjIenlaXXlF_sS1R4XOPX');
 $client->setRedirectUri('http://localhost/networkwe-jobs/users/gmail_login');
 $client->setDeveloperKey('00b4903a972516897acda222e5b3ca329206fca9c3a5cc8136d27ac58bccff01');

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  $client->revokeToken();
}

if ($client->getAccessToken()) {
  $req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/default/full");
  
  $val = $client->getIo()->authenticatedRequest($req);

  
  // The contacts api only returns XML responses.
  $response = json_encode(simplexml_load_string($val->getResponseBody()));
  
  echo "<pre>" . print_r(json_decode($response, true), true) . "</pre>";
  

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $auth = $client->createAuthUrl();
}

if (isset($auth)) {
    print "<a class=login href='$auth'>Connect Me!</a>";
  } else {
    print "<a class=logout href='?logout'>Logout</a>";
}

?>