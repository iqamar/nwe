<?php
App::uses('AppController', 'Controller');
//App::import('Vendor', 'twitteroauth', array('file' => 'twitter'.DS.'twitteroauth'.DS.'twitteroauth.php'));
App::import('Vendor', 'facebook', array('file' => 'facebook.php'));

class CompanyController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Company';
	var $uses = array('Company','User');
        var $components = array('Email');
        public $helpers = array('Facebook.Facebook');

 function beforeFilter() {
	parent::beforeFilter();

        $this->Auth->allow();
	/*$this->Auth->allow("display","aboutus","why", "what","team","contactus", "joinus","thanks","verify","already_verify","members",
                "trackRecord","executiveSearchRetained","executiveSearchContingency","profileAssessment","hrConsultancyPractice");*/

    }

	public function index() {
		
		if ($this->Session->read(@$userid)) {
		$cuser = $this->Session->read(@$userid);
		$uid = $cuser['userid'];
		$this-loadModel('Company');
		$companyListing = $this->Company->find('all');
		$this->set('companyListing',$companyListing);
		}
	}
        
        public function test(){
            echo 'here';
            $facebook = new Facebook(array(
                    'appId'  => '208209559352635',
                    'secret' => '36fc7c885d4ee34485114519ae627da8',
                    'cookie' => true
            ));
            
            if(!empty($session)) {
                    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
                    try{
                            $uid = $facebook->getUser();
                            $user = $facebook->api('/me');
                    } catch (Exception $e){}

                    if(!empty($user)){
                            /*# We have an active session, let's check if we have already registered the user
                            $query = mysql_query("SELECT * FROM users WHERE oauth_provider = 'facebook' AND oauth_uid = ". $user['id']);
                            $result = mysql_fetch_array($query);

                            # If not, let's add it to the database
                            if(empty($result)){
                                    $query = mysql_query("INSERT INTO users (oauth_provider, oauth_uid, username) VALUES ('facebook', {$user['id']}, '{$user['name']}')");
                                    $query = msyql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());
                                    $result = mysql_fetch_array($query);
                            }
                            // this sets variables in the session 
                            $_SESSION['id'] = $result['id'];
                            $_SESSION['oauth_uid'] = $result['oauth_uid'];
                            $_SESSION['oauth_provider'] = $result['oauth_provider'];
                            $_SESSION['username'] = $result['username'];*/
                    } else {
                            # For testing purposes, if there was an error, let's kill the script
                            die("There was an error.");
                    }
            } else {
                    # There's no active session, let's generate one
                    $login_url = $facebook->getLoginUrl();
                    header("Location: ".$login_url);
            }
        }
        public function complete_profile(){
			
			$userarray = $this->Session->read(@$userid);					
			$uid = $userarray['userid']; 
			
			if ($this->request->is('post')) {			
				$this->request->data['Users_profile']['id'] = $this->request->data['userid'];
				$this->request->data['Users_profile']['firstname'] = $this->request->data['firstname'];
				$this->request->data['Users_profile']['tags'] = $this->request->data['tags'];
				$this->request->data['Users_profile']['country_id'] = $this->request->data['country_id'];
				ClassRegistry::init('Users_profile')->save($this->request->data);
                                /*$this->Session->write('userid', $results['User']['id']);
                                $this->Session->write('checkUser', 'logged');
                                $this->Session->write('theme', 1);
                                $this->Session->write('email', $email);
                                $this->Session->write('role_id', $results['User']['role_id']);
                                $this->Session->write('language', 'eng');*/
                                $this->Session->write('fullname', $this->request->data['firstname']);
                                //$this->Session->write('picture', '');
                                //$this->Session->write('city', '');
                                //$this->Session->write('handler', $handler);
				$this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));
			}else{			
				$this->loadModel('Users_profile');
				$user = $this->Users_profile->find('all',array('conditions'=>array('Users_profile.user_id'=>$uid)));
				$user = $user[0]['Users_profile'];	
				 $this->set('user', $user);			
			}	
			
		}
        public function twitterAuth (){
//            $access_token = $_SESSION['access_token'];
//        
//            $consumerkey = "yUwWLQlrLo8YdZWI0GnQZg";
//            $consumersecret = "tGX7xP4n60vPAe39vATckoraTGokeXI5SNwPongwQ4g";
//            $accesstoken = "2281947637-q0BKqgm0uoMB7uUhFlAol0CI8SsSzKFP7YEGBBY";
//            $accesstokensecret = "fX7SN0Wt8tSTgjyuALPAEbxPlYb6GMPOZD3WtCuk9SmII";
//            $Oauth = new TwitterOAuth ($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
//            //$Oauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
//            
//            $content = $Oauth->get('account/rate_limit_status');
            echo $content = '<a href="./redirect.php"><img src="http://demo.networkwe.com/images/tw-icon.png" alt="Sign in with Twitter"/></a>';
            //pr($content);
           // echo "Current API hits remaining: {$content->remaining_hits}.";
            //$Credentials = $Oauth->get("account/verify_credentials");
        }
        
        public function display() {
//echo "hhhhhhhhh123";
	//	exit;

	}

	public function aboutus(){
	
	
	}

	public function members(){



	
		$users_data = ClassRegistry::init('users')->find('all', array('fields' => array('users.id, userprofiles.firstname, userprofiles.lastname, userprofiles.pic
	    				'),'limit' => 25, 'joins' => array(array('alias' => 'userprofiles', 'table' => 'userprofiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('users.id = userprofiles.login_id'))
					), 'order' => array('userprofiles.firstname')));
		$this->set('users_data', $users_data);
///echo "<pre>";
///print_r($users_data);
	/*	if(isset(print_r($this->params->params["pass"])){
				$filter_key = $this->params->params["pass"][0];
				$filter_value = $this->params->params["pass"][1];
 
		}*/

	}

	public function why(){}
	
	public function thanks(){}
	
	public function verify(){}
	
	public function verify_social(){}
	
	public function already_verify(){}
	
	public function what(){}

	public function team(){}

	public function joinus(){}
        
        public function trackRecord(){
            //echo 'track-record';
        }
        
        public function executiveSearchRetained(){
            //echo 'executive-search-retained';
        }
        
        public function executiveSearchContingency(){
            //echo 'executive-search-contingency';
        }
        
        public function profileAssessment(){
            //echo 'profile-assessments';
        }
        
        public function hrConsultancyPractice(){
            //echo 'hr-consultancy-practice';
        }
/****    Forgot password recover here**/
		public function forgot_password() {
			
		}
		public function password_changed() {
			
		}
		public function recover_password() {
			if (!empty($this->passedArgs['n']) && !empty($this->passedArgs['t'])){
				$email = $this->passedArgs['n'];
				$varcode = $this->passedArgs['t'];
				$this->set('email',$email);
				$this->set('varcode',$varcode);
			}		
			
		}
		public function invalid_account() {
			
		}
		public function reset_password() {
	
		}
                public function pending_confirmation() {
			
		}
		
	public function contactus(){
            if(!empty($this->request->data)) {
            //if(isset($this->data['myform'])){
                //$this->autoRender = false;
		  $department = $this->data['department'];
                switch ($department){
                    case 0: $AdminEmail = 'info@networkwe.com'; break;
                    case 1: $AdminEmail = 'support@networkwe.com'; break;
                    case 2: $AdminEmail = 'sales@networkwe.com'; break;
                    default : $AdminEmail = 'info@networkwe.com'; break;
                }
                $fulname = $this->data['fullname'];
                $this->set('fulname', $fulname);
                $email = $this->data['email'];
                $subject = $this->data['subject'];
                $message = $this->data['message'];
                
                $emailBody = 'The following user was trying to be in touch with us. Please revert back to this email ASAP.';
                $emailBody .= 'Name: '.$fulname.'
                    Email: '.$email.'
                        Message: '.$message;
                $this->set('emailBody', $emailBody);
                
                $this->Email->template='contactFormUser';
                $this->Email->sendAs = 'both';
                $this->Email->from = 'support@networkwe.com';
                $this->Email->to = $email; 
                $this->Email->subject = 'Contact Form Enquiry';
                $this->Email->_debug = FALSE;
                if ($this->Email->send($message)) {
                    //$this->redirect('/company/thanks');
                    $this->Session->setFlash('Email sent.', 'default', array ('class' => 'success_msg'));
                }
                else {
                    $this->Session->setFlash('Error sending email.', 'default', array ('class' => 'error_msg'));
                    //return $this->render('/elements/email/html/confirm');
                }
                
                //$this->Email->reset();
                
                $this->Email->template='contactFormAdmin';
                $this->Email->sendAs = 'both';
                $this->Email->from = $email;
                $this->Email->to = $AdminEmail; 
                $this->Email->subject = $subject;
                $this->Email->_debug = FALSE;
                $this->Email->send($emailBody);
            }
            
        }

public function email_exist(){}
 
		public function migrateUser(){
            
           
               $data['varcode'] = "1223234gdg234io23xc234";
		$data['email'] =  "111@gulfbankers.com";
		$data['fulname'] = "Deepak Patil";
		$ms ='http://demo.networkwe.com/company/verify/t:'.$data['varcode'].'/n:'.$data['email'].'';
		
		
			$this->Email->template = 'migrate'; 
           
            
            $this->set('confirmlink', $ms); 
			$this->set('email', $data['email']);
		
            $this->set('data', $ms); 
			$this->Email->sendAs = 'both';
			$this->Email->from = 'support@networkwe.com';
            $this->Email->to = $data['email']; 
            $this->Email->subject = 'Forum International delightly launches new website netwoerkwe.com';
            $this->Email->_debug = true;  
            if ($this->Email->send()) { 
  			 $this->Session->setFlash('Please Check your email for validation Link');
			 echo "mail sent";
			// $this->redirect('/company/thanks');
			}else{
				echo "mail not sent";
			}
exit;

        }
		
	public function press($id=0){
		
	  
		if($id){
			
			$sql = ClassRegistry::init('press_releases')->find('all',array('joins' => array(
																							  array('alias' => 'category_presses',
																									'table' => 'category_presses',
																									'type' => 'RIGHT', 
																									'foreignKey' => false,
																									'conditions' => array('press_releases.id = category_presses.press_id')
																									),
																							  array('alias' => 'press_categories',
																									'table' => 'press_categories',
																									'type' => 'RIGHT',
																									'foreignKey' => false,
																									'conditions' => array('category_presses.category_id = press_categories.id'
																														  )
																									)
																							  ),
																					'conditions' => array('category_presses.category_id ='.$id.' AND press_releases.publish=1')));
			
			
			$this->set('data',$sql);		
		}else{
			
			$sql = ClassRegistry::init('press_releases')->find('all',array('order'=>'press_releases.created DESC', 'limit'=>10,'conditions'=>array('press_releases.publish=1')));		
			
			$this->set('data',$sql);
			
		}
		
		$cat = ClassRegistry::init('press_categories')->find('all',array('order'=>'press_categories.category ASC', 'limit'=>10));
		$this->set('cat',$cat);
	}
	public function press_view($id) {
	 	$this->loadModel('press_release');
		$this->loadModel('Country');

		if ($id !=0) {
			$this->press_release->bindModel(array('belongsTo'=>array('Country'=>array('foreignKey'=>false,'type'=>'RIGHT','conditions'=>array('press_release.country=Country.id')))));
			$press_detail=$this->press_release->find('first',array('conditions'=>array('press_release.publish'=>1, 'press_release.id'=>$id)));
			
	    $this->set('press',$press_detail);	
			
	}
  }
		
}
?>
