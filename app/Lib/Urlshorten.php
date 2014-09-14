<?php
/*
 * @author  :   Danish Backer
 * @date    :   04-05-2014
 * @purpose  :   Shorten Urls
 */

class Urlshorten {
    
    public static function httpsPost($postData) {
        $curlObj = curl_init();

        $jsonData = json_encode($postData);

        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);

        //change the response json string to object
        $json = json_decode($response);
        curl_close($curlObj);

        return $json;
    }
    
    public static function httpGet($params) {
        $final_url = 'https://www.googleapis.com/urlshortener/v1/url?'.http_build_query($params);

        $curlObj = curl_init($final_url);

        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));

        $response = curl_exec($curlObj);

        //change the response json string to object
        $json = json_decode($response);
        curl_close($curlObj);

        return $json;
    }
    
    /**
     * Reset internal variables for another validation run.
     *
     * @return void
     */
    protected static function _reset() {
        self::$errors = array();
    }
	
}

//Short URL Information
//https://developers.google.com/url-shortener/
/*
$apiKey = 'YOUR_KEY';
App::import('Vendor', 'Urlshortner');

//Long to Short URL
$longUrl = 'http://danish.networkwe.net/recruiter/';
$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
$info = $this->httpsPost($postData);
if($info != null)
{
    echo "Short URL is : ".$info->id."\n";
} 
$shortUrl="http://goo.gl/eDcZI";
$params = array('shortUrl' => $shortUrl, 'key' => $apiKey,'projection' => "ANALYTICS_CLICKS");
$info = httpGet($params);
if($info != null)
{
    echo "Long URL is : ".$info->longUrl."\n";
    echo "All time clicks : ".$info->analytics->allTime->shortUrlClicks."\n";
}

//Get Full Details of the short URL
$shortUrl="http://goo.gl/eDcZI";
$params = array('shortUrl' => $shortUrl, 'key' => $apiKey,'projection' => "FULL");
$info = httpGet($params);
var_dump($info);*/

/*
App::uses('HttpSocket', 'Network/Http');
                $HttpSocket = new HttpSocket();
                $sessionID = $this->Session->id();
                $params = array('key'=> $sessionID, 'email' => $email, 'userid' => $id, 'role_id' => $role_id);
                $response = $HttpSocket->post(JOBS_URL.'/users/login',$params);
$response->body
*/