<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	var $persistModel = true;
    public $components = array(
	'Auth' => array(
	    'authorize' => array(
		'Actions' => array('actionPath' => 'controllers')
	    )
	),
	'Session','Cookie','Email'
    );
    public $helpers = array('Html', 'Form', 'Session');

	public $userInfo;
	
   function beforeFilter() {	
	   
//echo "i m here";
		parent::beforeFilter(); 
		
		ini_set('max_execution_time', 300);
		
		 $this->Cookie->name = 'networkwe_cookie';
                $this->Cookie->path = '/';
                $this->Cookie->domain = '.networkwe.com';
                $this->Cookie->time = '6 months';
                $this->Cookie->secure = false;
                $this->Cookie->key = '39lbkutg1i2l0kta6785d8qki5';
                $this->Cookie->httpOnly = true;


		//Configure::write('debug', 2);
	
		$user_Roles = ClassRegistry::init('roles')->find('all',array('conditions'=>array('roles.id != 100')));
		$this->set('user_Roles',$user_Roles);	
				
		if(!(("company" == $this->params->controller) && ($this->name != "pub"))){			

			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
			
			
			if ($this->Session->read(@$userid)) {
				$userarray = $this->Session->read(@$userid);
				//print_r($userarray);exit;
				if (@$userarray['theme']) {
					$this->theme = $userarray['theme'];
					$this->role_id = $userarray['role_id']; 
					$uid = $userarray['userid']; 
					
					if($this->role_id == 2){					
						if($this->params->controller!='users'){
							if($this->params->controller!='recruiter'){
								$this->userInfo = ClassRegistry::init('users')->find('first', array('fields' => array('
																														 companies.id,
																														 companies.user_id,
																														 companies.title,
																														 users.*'
																														 ),
																													
																													'joins' => array(
																																	 
																																	  array(
																																			'alias' => 'companies',
																																			'table' => 'companies',
																																			'foreignKey' => false,
																																			'conditions' => array(
																																								  'users.id = companies.user_id'
																																								  ))),
																													'conditions'=>array('users.id'=> $uid)));
								
								$this->set('userInfo',$this->userInfo);
								$this->redirect("/recruiter/");
								exit;
							}
						}
						
					}
					
					if($this->role_id == 1){
						/*recenty articles by current user*/
						$user_Profile = $this->getCurrentUser($uid);
						//print_r($user_Profile);
						//exit;
						$firstname = $user_Profile['firstname'];
						$tags = $user_Profile['tags'];
						$country_id = $user_Profile['country_id'];
						if((empty($firstname)) || (empty($tags)) || (empty($country_id))){
								$this->redirect(array('controller' => 'company', 'action' => 'complete_profile'));
								exit;
						}
						$this->userInfo = ClassRegistry::init('users')->find('first', array('fields' => array('
																														 users_profiles.firstname,
																														 users_profiles.lastname,
																														 users_profiles.photo,
																														 users_profiles.tags,
																														 users_profiles.user_id,
																														 users_profiles.handler,
																														 users.*'
																														 ),
																													
																													'joins' => array(
																																	 
																																	  array(
																																			'alias' => 'users_profiles',
																																			'table' => 'users_profiles',
																																			'foreignKey' => false,
																																			'conditions' => array(
																																								  'users.id = users_profiles.user_id'
																																								  ))),
																													'conditions'=>array('users.id'=> $uid)));
						
						$this->set('userInfo',$this->userInfo);
						
						$this->set('user_Profile', $user_Profile);
						//$requserss = $this->getUserRecord($uid);
						//$this->set('requserss',$requserss);
						$user_email_id = $this->getUserEmailID($uid);
						$this->set('user_email_id',$user_email_id);
						//$chat_User_Requsers = $this->getUserChatRequests();
						//$this->set('chat_User_Requsers',$chat_User_Requsers);
							
						$assignedUsers = $this->getAssignedRecruiter($uid);
						$this->set('assignedUsers', $assignedUsers);
						/* User You may know on right side bar*/
						$this->set('uid',$uid);
						$friends_Lists =$this->getCurrentUserFriends($uid);
						$this->set('friends_Lists',$friends_Lists);
						
					}
										
			    }else {
						
					if(!(($this->params->controller=="users") || ($this->params->controller=="publices") || ($this->params->controller=="news"))){

						if(!((($this->params->action =="index") || ($this->params->action =="searchFilterAjax") || ($this->params->action =="bl_get_home_ajax") || ($this->params->action =="resend_verification") || ($this->params->action =="searchFilterUserAjax") || ($this->params->action =="searchFilter")) && ($this->params->controller=="home"))) {
							$referal = NETWORKWE_URL.$_SERVER['REQUEST_URI'];
	                                                if(isset($_GET['return_url'])){
                                                        	if(!empty($_GET['return_url'])){
                                                                	$referal = $_GET['return_url'];
                                                        	}
                                                	}
							$pos = strpos($referal, 'networkwe.com/sidebars');
				                        if ($pos === false) {
		                                                	$this->Session->write("HTTP_REFERAL", $referal);
							}
							$pos = strpos($referal, 'networkwe.com/home/sharer');
				                        if ($pos !== false) {
	                                   			$this->redirect("/users/loginagain/");
        	                                  		exit;
							}
                	                        }
					}
					$this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
					$this->theme = 'BeforeLogin';
				}

					//$this->set('email', );
					/*	$siteusers = ClassRegistry::init('users_profiles')->find('all');
						$this->set(compact('siteusers',$siteusers));*/
						$this->_configure_authentication();
						$userpic = $this->getUserPhoto();
						$userPicture = $userpic[0]['Users_profile'];
						
						$this->set('imgname', $userPicture['photo']);
						$this->set('userpic',$userPicture);
						$this->set('roleid', @$userpic['Users_profile']['role_id']);
			}
		}else {
			$this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
			$this->theme = 'BeforeLogin';
		}

    }
	public function beforeRender() {
		//$this->layout = 'load';
	}
	
	function _configure_authentication() {
		$this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers'));
		$this->Auth->loginAction = array('plugin' => false, 'admin' => false, 'controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('plugin' => false, 'admin' => false, 'controller' => 'users_profiles', 'action' => 'update');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authenticate = array('all' => array('scope' => array('User.status' => 1)),
									'Form' => array('fields' => array('username' => 'email', 'password' => 'password')));
		$this->Auth->authError = __('You are not authorized to access that location.');
		if ($this->name == 'Pages') {
			$this->Auth->allow('display');
		}
    }	
	
	protected function checkPermission($uid) {
		$cuser = $this->getCurrentUser($uid);
		
		$authorized = true;
		$hash = '';
		$return_url = '/return_url:' . base64_encode($this->request->here);
		// check login
		if (!$cuser) {
			$authorized = false;
			echo $msg = __('Please login or register');
		} else {
			if (empty($cuser['user_id'])) {
				$authorized = false;
				$msg = __('You have not confirmed your email address! Check your email (including junk folder) and click on the validation link to validate your email address');
			}
		}
		if ($authorized == false) {
			if (!empty($msg))
				$this->Session->setFlash($msg, 'default', array('class' => 'error-message'));
			$this->redirect('/pages/no-permission' . $return_url);
			exit;
		}
    }
   public function getUserSettings($uid) {
  
  $user_email_setting = ClassRegistry::init('users_settings')->find('first',array('fields'=>array('
                          users_settings.user_preference,
                          users_settings.user_id
                          '),
                        'conditions'=>array('
                             users_settings.settings_detail_id=22 AND users_settings.user_id='.$uid)
                        )
                 );
  $display_email = $user_email_setting['users_settings']['user_preference'];
  
  if (sizeof($user_email_setting) != 0) {
   return $display_email;
  }
  else {
   return 1;
  }
 }
	public function getAssignedRecruiter($uid) {
		if (!empty($uid)) { // logged in users
			$this->loadModel('Recruiter_user');
			
	        $assignedUsers = $this->Recruiter_user->find('all',array('fields'=>array('Recruiter_user.*,Recruiter.id,Recruiter.title,Recruiter.user_id'),'joins' => array(
						array(
							'alias' => 'Recruiter',
							'table' => 'companies',
							'type' => 'LEFT',
							'conditions' => '`Recruiter`.`id` = `Recruiter_user`.`company_id`'
						)),'conditions'=>array('Recruiter_user.user_id'=>$uid)));
			//$user = $user['Users_profile'];
		}	
		return $assignedUsers;
	}
	public function getCurrentUser($uid) {
		if (!empty($uid)) { // logged in users
			$this->loadModel('Users_profile');
	        $user = $this->Users_profile->find('first',array('conditions'=>array('Users_profile.user_id'=>$uid)));
			$user = $user['Users_profile'];
		}	
		return $user;
	}
	
	public function getUserEmailID($uid) {
		if (!empty($uid)) { // logged in users
			$this->loadModel('User');
	        $user = $this->User->find('all',array('conditions'=>array('User.id'=>$uid)));
			$userEmailId = $user[0]['User'];
		}	
		return $userEmailId;
	}
    public function getUserPhoto() {
		$this->Session->read(@$userid);
		$cuser = $this->Session->read(@$userid);
		$uid = @$cuser['userid'];
		$this->loadModel('Users_profile');
		$user = $this->Users_profile->find('all',array('conditions'=>array('user_id'=> $uid)));
		return $user;
    }
	
	public function getConnectionsStatus($uid) {
		$uers_connections_status = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id,connections.request'),
		'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.')')));
		return $uers_connections_status;
	}
	
	public function getCurrentUserFriends($uid) {
		$uers_friends = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
		'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.')')));
		foreach ($uers_friends as $friend_Row) {
			if ($friend_Row['connections']['friend_id'] != $uid){
				$friend_arrays[] .= $friend_Row['connections']['friend_id'];
			}
			else if($friend_Row['connections']['user_id'] != $uid){
				$friend_arrays[] .= $friend_Row['connections']['user_id'];
			}
			
		}
		return $friend_arrays;
	}
	
	
	
	/*get the latest posts from the networkwe....*/
	public function get_latest_posts() {
		
				$blog_posts_latest = ClassRegistry::init('blogs')->find('all',array('fields'=>array('
																									blogs.id,
																									blogs.post_title,
																									blogs.created,
																									users_profiles.firstname ,
																									users_profiles.lastname,
																									users_profiles.handler
																									'),
																					'joins'=>array(
																								   array('alias' => 'users_profiles',
																										 'table' => 'users_profiles',
																										 'type' => 'left',
																										 'foreignKey' => false,
																										 'conditions' => array('blogs.user_id  = users_profiles.user_id'
																															   )
																										 )
																								   ),
																					'conditions'=>array('blogs.status=2'),
																					'order'=>'blogs.id DESC',
																					'limit'=>10
																					)
																		);
			return $blog_posts_latest;
	}
	

	
	public function __imageresize($imagePath, $thumb_path, $destinationWidth, $destinationHeight) {
        // The file has to exist to be resized
        if (file_exists($imagePath)) {
            // Gather some info about the image
            $imageInfo = getimagesize($imagePath);

            // Find the intial size of the image
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];

            if ($sourceWidth > $sourceHeight) {
                $temp = $destinationWidth;
                $destinationWidth = $destinationHeight;
                $destinationHeight = $temp;
            }

            // Find the mime type of the image
            $mimeType = $imageInfo['mime'];

            // Create the destination for the new image
            $destination = imagecreatetruecolor($destinationWidth, $destinationHeight);

            // Now determine what kind of image it is and resize it appropriately
            if ($mimeType == 'image/jpeg' || $mimeType == 'image/jpg' || $mimeType == 'image/pjpeg') {
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagejpeg($destination, $thumb_path);
            } else if ($mimeType == 'image/gif') {
                $source = imagecreatefromgif($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagegif($destination, $thumb_path);
            } else if ($mimeType == 'image/png' || $mimeType == 'image/x-png') {
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $sourceWidth, $sourceHeight);
                imagepng($destination, $thumb_path);
            } else {
                $this->Session->setFlash(__('This image type is not supported.'), 'flash_error');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
    }
	
}
?>
