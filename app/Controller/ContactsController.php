<?php
App::import('Vendor',array('JSON','Yahoo','YahooSessionStore','OAuth'));
class ContactsController extends AppController {
    var $helpers = array('Form', 'html');
    var $components = array('Auth');
	var $uses = array('User');
	public $Yahoo_API_CONFIG = array('appKey' => Yahoo_KEY, 'appSecret' => Yahoo_SECRET,'appDomain'=>Yahoo_DOMAIN,
                                                                                    'appId'=>Yahoo_ID,'appUrl'=>SITE_URL);
    function beforeFilter() {
	parent::beforeFilter();

	//$this->Auth->allow(array('login', 'logout','add'));
	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin_index':
	    // $this->Security->validatePost = false;
	}
    }					  
	
	
	
	
	
	public function index() {
		
		/*echo "test"."<br />";
		print_r($this->Yahoo_API_CONFIG);
		exit;*/
		
		/* gMAIL contact link*/
		$clientid = '916224367441-iieed7pq6n7elnqfh87l71o2sr3a9jb9.apps.googleusercontent.com';
		$clientsecret = '_hkk7tQ3Sx2u5QsUQJZxqcj5';
		$redirecturi = 'http://networkwe.com/contacts/result'; 
		$maxresults = 500; // Number of mailid you want to display.
		$this->set('clientid',$clientid);
		$this->set('redirecturi',$redirecturi);
		
		/* yahoo contact link*/
		YahooSession::clearSession();
	    $hasSession = YahooSession::hasSession($this->Yahoo_API_CONFIG['appKey'],$this->Yahoo_API_CONFIG['appSecret'] ,$this->Yahoo_API_CONFIG['appId']);
	   if($hasSession == FALSE) {
			$callback = SITE_URL.'/contacts/yahoo';    
			$auth_url = YahooSession::createAuthorizationUrl($this->Yahoo_API_CONFIG['appKey'], 
															   $this->Yahoo_API_CONFIG['appSecret'], $callback);    
	    }else{
		$auth_url=SITE_URL.'/contacts/yahoo';
	   }

	   $this->set('auth_url',$auth_url);    
		
	  /* Htomail contact link*/
		
		$client_id = '000000004C11AAD7';
		$client_secret = 'h-rGAkA5ahOLba87OJPxNNH-GHlp7rXg';
		$redirect_uri = 'http://networkwe.com/contacts/hotmail';

$urls_ = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;
		$this->set('urls_',$urls_);
	}
	
	/*Hotmail*/
	function curl_file_get_contents($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function hotmail() {
		if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
			$myemail = $this->Session->read('email');
        }
		
		$client_id = '000000004C11AAD7';
		$client_secret = 'h-rGAkA5ahOLba87OJPxNNH-GHlp7rXg';
		$redirect_uri = 'http://networkwe.com/contacts/hotmail';
		$auth_code = $_GET["code"];
		$fields=array(
		'code'=>  urlencode($auth_code),
		'client_id'=>  urlencode($client_id),
		'client_secret'=>  urlencode($client_secret),
		'redirect_uri'=>  urlencode($redirect_uri),
		'grant_type'=>  urlencode('authorization_code')
		);
		$post = '';
		foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
		$post = rtrim($post,'&');
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
		curl_setopt($curl,CURLOPT_POST,5);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		$result = curl_exec($curl);
		curl_close($curl);
		$response =  json_decode($result);
		$accesstoken = $response->access_token;
		//$accesstoken = $_SESSION['accesstoken'] ;//= $_GET['access_token'];
		$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken.'&limit=500';
		$xmlresponse =  $this->curl_file_get_contents($url);

		$xml = json_decode($xmlresponse, true);

		$msn_email = "";
		foreach($xml['data'] as $emails)
		{
		// echo $emails['name'];
		//$email_ids = implode(",",array_unique($emails['emails'])); //will get more email primary,sec etc with comma separate
		//$msn_email .= $emails[0]['emails'];
		$email[] = "'".$emails['emails']['preferred']."'";
		}
		
		
		$this->loadModel('User');
		if (sizeof($email)>1) {
		$email_array =  @implode(',', $email);
		}
		else {
		$email_array = $email[0];
		}
		
		if ($email_array) {
			$ntwe = $this->User->find('all',array('fields' => array('User.id,User.email'),'conditions' => array(array('User.email IN ('.$email_array.')'),'User.status=1')));
			$friends_Lists = $this->getCurrentUserFriends($uid);
			$friends_Lists = array_unique($friends_Lists);
			
				foreach ($ntwe as $ntw_row) {
					if (in_array($ntw_row['User']['id'],$friends_Lists)) {
						$ntw_user_email[] = $ntw_row['User']['email'];
					}
					else if($ntw_row['User']['id'] == $uid) {
						
					}
					else {
					$ntw_user_id[] = $ntw_row['User']['id'];
					$ntw_user_email[] = $ntw_row['User']['email'];
					}
					
				}

			   if (sizeof($ntw_user_id)>1) {
				 $userid_array =  @implode(',', $ntw_user_id);
			   }
			  else {
				$userid_array = $ntw_user_id[0];
			   }
			if ($ntw_user_id) {
			  $this->loadModel('Users_profile'); 
			  $users_registered = $this->Users_profile->find('all',array('fields' => array('
																						Users_profile.user_id,
																						Users_profile.firstname,
																						Users_profile.lastname,
																						Users_profile.photo,
																						Users_profile.tags,
																						users.email
																						'),
																	  'joins' => array(
																					array(
																						'alias' => 'users',
																						'table' => 'users',
																						'foreignKey' => false,
																						'conditions' => array('users.id = Users_profile.user_id')
																						)
																					),
																	  'conditions' => array('Users_profile.user_id IN('.$userid_array.')')
																	  ));
		 $this->set('users_registered',$users_registered);
			}
		}
		
		
		$result_array = array();    
		foreach($email as $key => $value)
		{
			$flag = false;
			$value = str_replace("'", "", $value);

			foreach ($ntw_user_email as $key => $emailvalue) {
				if($value == $emailvalue)
				{
					$flag = true;
				}
				
			}
			if($value == $myemail) {
					$flag = true;
			}

			if ($flag == false) {
				$result_array[] = $value;
			}
		}
		$this->set('result',$result_array);	
		
	}
	
	
	
	
	public function yahoo(){
		 if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
			$myemail = $this->Session->read('email');
        }
	   $session = YahooSession::requireSession($this->Yahoo_API_CONFIG['appKey'],$this->Yahoo_API_CONFIG['appSecret'] ,
                                                                              $this->Yahoo_API_CONFIG['appId']);
	   
 
   		$user = $session->getSessionedUser();
		
   		$contacts = $user->getContacts(0, 500);

		$contact_array = $contacts->contacts->contact;

		$total_contacts = $contacts->contacts->total;

		foreach ($contact_array as $key => $value) {
			foreach ($value->fields as $yahoo_row) {
				if ($yahoo_row->type == 'email') {
					$email[] = "'".$yahoo_row->value."'";
				}
			}
		}
		$this->loadModel('User');
		if (sizeof($email)>1) {
		$email_array =  @implode(',', $email);
		}
		else {
		$email_array = $email[0];
		}
		
		if ($email_array) {
			$ntwe = $this->User->find('all',array('fields' => array('User.id,User.email'),'conditions' => array(array('User.email IN ('.$email_array.')'),'User.status=1')));
			$friends_Lists =$this->getCurrentUserFriends($uid);
			$friends_Lists = array_unique($friends_Lists);
			
				foreach ($ntwe as $ntw_row) {
					if (in_array($ntw_row['User']['id'],$friends_Lists)) {
					}
					else if($ntw_row['User']['id'] == $uid) {
						
					}
					else {
					$ntw_user_id[] = $ntw_row['User']['id'];
					$ntw_user_email[] = $ntw_row['User']['email'];
					}
					
				}

			   if (sizeof($ntw_user_id)>1) {
				 $userid_array =  @implode(',', $ntw_user_id);
			   }
			  else {
				$userid_array = $ntw_user_id[0];
			   }
			if ($ntw_user_id) {
			  $this->loadModel('Users_profile'); 
			  $users_registered = $this->Users_profile->find('all',array('fields' => array('
																						Users_profile.user_id,
																						Users_profile.firstname,
																						Users_profile.lastname,
																						Users_profile.photo,
																						Users_profile.tags,
																						users.email
																						'),
																	  'joins' => array(
																					array(
																						'alias' => 'users',
																						'table' => 'users',
																						'foreignKey' => false,
																						'conditions' => array('users.id = Users_profile.user_id')
																						)
																					),
																	  'conditions' => array('Users_profile.user_id IN('.$userid_array.')')
																	  ));
		 $this->set('users_registered',$users_registered);
			}
		}
		
		
		$result_array = array();    
		foreach($email as $key => $value)
		{
			$flag = false;
			$value = str_replace("'", "", $value);
			foreach ($ntw_user_email as $key => $emailvalue) {
				if($value == $emailvalue)
				{
					$flag = true;
				}
			}
			if($value == $myemail) {
				$flag = true;
			}
			if ($flag == false) {
				$result_array[] = $value;
			}
		}
		
		$this->set('result',$result_array);
	}
	
	
	
	
	/*gmail contacts result*/
	
	public function result() {
		
		if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
			$myemail = $this->Session->read('email');
        }
		
		$clientid = '916224367441-iieed7pq6n7elnqfh87l71o2sr3a9jb9.apps.googleusercontent.com';
		$clientsecret = '_hkk7tQ3Sx2u5QsUQJZxqcj5';
		$redirecturi = 'http://networkwe.com/contacts/result'; 
		$maxresults = 500; // Number of mailid you want to display.
		
		$authcode = $_GET["code"];
		$fields=array(
		'code'=> urlencode($authcode),
		'client_id'=> urlencode($clientid),
		'client_secret'=> urlencode($clientsecret),
		'redirect_uri'=> urlencode($redirecturi),
		'grant_type'=> urlencode('authorization_code') );
		
		$fields_string = '';
		foreach($fields as $key=>$value){ $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string,'&');
		
		$ch = curl_init();//open connection
		curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
		curl_setopt($ch,CURLOPT_POST,5);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($result);
		$accesstoken = $response->access_token;
		if( $accesstoken!='')
		$_SESSION['token']= $accesstoken;

		//$xmlresponse= file_get_contents('http://www.google.com/m8/feeds/contacts/default/full?max-results='.$maxresults.'&oauth_token='. $_SESSION['token']);
		
		$url = 'http://www.google.com/m8/feeds/contacts/default/full?max-results='.$maxresults.'&oauth_token='. $_SESSION['token'];
		
		 $curl = curl_init();
 		 $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
 
 		  curl_setopt($curl,CURLOPT_URL,$url); //The URL to fetch. This can also be set when initializing a session with curl_init().
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
 		  curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5); //The number of seconds to wait while trying to connect.	
 
		 curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
		 curl_setopt($curl, CURLOPT_FAILONERROR, TRUE); //To fail silently if the HTTP code returned is greater than or equal to 400.
		 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
		 curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
		 curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.	
 
 		$xmlresponse = curl_exec($curl);
 		curl_close($curl);
		
		$xml= new SimpleXMLElement($xmlresponse);
		$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
		$result = $xml->xpath('//gd:email');
		
		$this->loadModel('User');
		/*to get networkwe registered users*/
		foreach($result as $title){ 
				$email[] = "'".$title->attributes()->address."'";
			}
		
		
		if (sizeof($email)>1) {
		$email_array =  @implode(',', $email);
		}
		else {
		$email_array = $email[0];
		}
		
		
		if ($email_array) {
			$ntwe = $this->User->find('all',array('fields' => array('User.id,User.email'),'conditions' => array(array('User.email IN ('.$email_array.')'),'User.status=1')));
			$friends_Lists =$this->getCurrentUserFriends($uid);
			$friends_Lists = array_unique($friends_Lists);
			
				foreach ($ntwe as $ntw_row) {
					if (in_array($ntw_row['User']['id'],$friends_Lists)) {
					}
					else if($ntw_row['User']['id'] == $uid) {
						
					}
					else {
					$ntw_user_id[] = $ntw_row['User']['id'];
					$ntw_user_email[] = $ntw_row['User']['email'];
					}
					
				}

			   if (sizeof($ntw_user_id)>1) {
				 $userid_array =  @implode(',', $ntw_user_id);
			   }
			  else {
				$userid_array = $ntw_user_id[0];
			   }
			if ($ntw_user_id) {
			  $this->loadModel('Users_profile'); 
			  $users_registered = $this->Users_profile->find('all',array('fields' => array('
																						Users_profile.user_id,
																						Users_profile.firstname,
																						Users_profile.lastname,
																						Users_profile.photo,
																						Users_profile.tags,
																						users.email
																						'),
																	  'joins' => array(
																					array(
																						'alias' => 'users',
																						'table' => 'users',
																						'foreignKey' => false,
																						'conditions' => array('users.id = Users_profile.user_id')
																						)
																					),
																	  'conditions' => array('Users_profile.user_id IN('.$userid_array.')')
																	  ));
		 $this->set('users_registered',$users_registered);
			}
		}
		
		$result_array = array();    
		foreach($email as $key => $value)
		{
			$flag = false;
			$value = str_replace("'", "", $value);
			foreach ($ntw_user_email as $key => $emailvalue) {
				if($value == $emailvalue)
				{
					$flag = true;
				}
			}
			if($value == $myemail) {
				$flag = true;
			}
			if ($flag == false) {
				$result_array[] = $value;
			}
		}
		
		$this->set('result',$result_array);
		
	}
	
	public function connection_request() {
		if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
		if ($this->request->is('get')) {
            $user_id = $_GET['user_id'];
			$selected_emails = $_GET['selected_emails'];
			
			//$selected_emails = @explode(',',$selected_emails);
			
			for ($i=0; $i<sizeof($selected_emails); $i++) {
				
				$email_con_array[] = "'".$selected_emails[$i]."'";
			}
			
			
			$email_con_array =  @implode(',', $email_con_array);
			
			$this->loadModel('User');
			$selected_user = $this->User->find('all',array('fields'=>array('User.id,User.email'),
																		   'conditions'=>array(array('User.email IN('.$email_con_array.')'),'User.status=1')));
			$friends_Lists =$this->getCurrentUserFriends($uid);
			$friends_Lists = array_unique($friends_Lists);
			$this->loadModel('Connection');
			$this->request->data = '';
			
			
			foreach ($selected_user as $request_con) {
				$user_ID = $request_con['User']['id'];
				if (in_array($user_ID,$friends_Lists)) {
				}
				else {
					$user_Email = $request_con['User']['email'];
					$this->request->data = '';
					$this->Connection->create( );
					$this->request->data['Connection']['user_id'] = $uid;
					$this->request->data['Connection']['friend_id'] = $user_ID;
					$this->request->data['Connection']['request'] = 0;
					$this->request->data['Connection']['connection_type'] = 'Both';
					$date_created= date('Y-m-d H:i:s');
					$this->request->data['Connection']['created'] = $date_created;
					$this->request->data['Connection']['modified'] = $date_created;
					if ($this->Connection->save($this->request->data)) {
						
						$requested_user_Profile = $this->getCurrentUser($user_ID);
						$requested_user = $requested_user_Profile['firstname'];
						
						$user_Profiles = $this->getCurrentUser($uid);
						$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
						$user_deisgnation = $user_Profiles['tags'];
						$connection_link = NETWORKWE_URL.'/connections/networkwe_connection/u:'.$uid.'/f:'.$user_ID.'';
						$profile_link = NETWORKWE_URL.'/pub/'.$user_Profiles['handler'];
			
						$this->Email->template = 'connection_request'; 
						// You can use customised thmls or the default ones you setup at the start 
						$this->set('connection_link', $connection_link); 
						$this->set('profile_link', $profile_link); 
						$this->set('requested_user',$requested_user);
						$this->set('fullname',$fullname);
						$this->set('user_deisgnation', $user_deisgnation);
						
						// You can use customised thmls or the default ones you setup at the start  
						$this->Email->sendAs = 'both';
						$this->Email->from ="NetworkWe<support@networkwe.com> via NetworkWe";
						$this->Email->to = $user_Email; 
						
						$this->Email->subject = $requested_user_Profile['firstname'].' please add me to your NetworkWe.';
						$this->Email->_debug = true;  
						if ($this->Email->send()) { 
						}

					} //if finished
				} // else finished
				
			}	// loop finished
			
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('connection_request');	
	}
	
	
	
	
	
	public function networkwe_request() {
		if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
		if ($this->request->is('get')) {
            $user_id = $_GET['user_id'];
			$selected_emails = $_GET['selected_emails'];
			
			//$selected_emails = @explode(',',$selected_emails);
			
			for ($i=0; $i<sizeof($selected_emails); $i++) {
				
						$email_to = $selected_emails[$i];

						$user_Profiles = $this->getCurrentUser($uid);
						$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
						$user_deisgnation = $user_Profiles['tags'];
			
						$this->Email->template = 'registration_request'; 
						$this->set('fullname',$fullname);
						$this->set('user_deisgnation', $user_deisgnation);
						
						// You can use customised thmls or the default ones you setup at the start  
						$this->Email->sendAs = 'both';
						$this->Email->from ="NetworkWe<support@networkwe.com> via NetworkWe";
						$this->Email->to = $email_to; 
						
						$this->Email->subject = 'NetworkWE Invitation';
						$this->Email->_debug = true;  
						if ($this->Email->send()) { 
						}
				
			}	// loop finished
			
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('connection_request');	
	}

}
 ?>