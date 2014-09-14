<?php

//App::import('Vendor', 'OAuth/OAuthClient'));
App::import('Vendor', 'twitteroauth', array('file' => 'twitter'.DS.'twitteroauth'.DS.'twitteroauth.php'));

class OauthController extends AppController {

    var $helpers = array('Form', 'html');
    var $components = array('Auth');
    //var $uses = array('User','Comment','Connection','Statusupdate','Post','Users_following');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        /*switch ($this->request->params['action']) {
                case 'index':
                case 'admin_index':	
        }*/
    }
	   
    public function index() {
        $access_token = $_SESSION['access_token'];
        
        $consumerkey = "DtlM138EJ3ZWHkj1tfVBg";
        $consumersecret = "SCyzsdTFyy7tlukLMg9vzZ3L4GM6p0dbvA3DYQTBQzg";
        $accesstoken = "1875238705-xGuBpV54e0kK9hoRl0gMeMnnuAXhHrcd9elz0gn";
        $accesstokensecret = "N0GSL8IAAiXZwa4QJDNQgh9BmIKAdYWj05QW1rpEEnHwz";
        //$Oauth = new TwitterOAuth ($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
        $Oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $Credentials = $Oauth->get("account/verify_credentials");
        pr($Credentials);
        //die();

    }
        
    /*public function linkedin (){
            
    }*/


} 
?>