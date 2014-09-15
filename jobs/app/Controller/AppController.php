<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array('Session','Cookie');
	public $helpers = array('Html', 'Form', 'Session'); 
	//public $uses = array('User','Users_profile');
	public $userInfo;
	function beforeFilter() 
	{
		parent::beforeFilter();

   $this->Cookie->name = 'networkwe_cookie';
                $this->Cookie->path = '/';
                $this->Cookie->domain = '.networkwe.com';
                $this->Cookie->time = '6 months';
                $this->Cookie->secure = false;
                $this->Cookie->key = '39lbkutg1i2l0kta6785d8qki5';
                $this->Cookie->httpOnly = true;
			

		$countryList = ClassRegistry::init('countries')->find('list', array('conditions' => array('countries.status' => '1')));
		$this->set('countryList',$countryList);
		if(isset($_COOKIE["networkwe_cookie"]["User"])){
			$this->getCurrentUser();
			$uid =$this->userInfo['users']['id'];
			$friends_Lists =$this->getCurrentUserFriends($uid);
			$this->set('friends_Lists',$friends_Lists);
			
			$this->set('uid',$uid);
		}else{
			
			$this->set('userInfo','');
		}
	//	Configure::write('debug', 0);
		
	}
	
	function _setLanguage() 
	{
		
	}
	
	public function getCurrentUser() {
		/*echo $currentUseremail = $this->Cookie->read('User.email');
                echo $currentUserid= $this->Cookie->read('User.userid');
                echo $role_id= $this->Cookie->read('User.role_id');
		*/
		
	if($_COOKIE["networkwe_cookie"]["User"]){
		$rowData = stripslashes($_COOKIE["networkwe_cookie"]["User"]);
		$mycookies =json_decode($rowData);
		$currentUseremail = $mycookies->email;
		 $currentUserid=$mycookies->userid;
		$role_id=$mycookies->role_id;
				
				//$this->set('countryList',$countryList);
		if(("search" == $this->params->controller) && ($this->params->action =="jobDetails") && (empty($currentUseremail))){
			$arr = $this->params['pass'];
            $job_id = $arr[0];
			$job_title = $arr[1];
			$this->redirect(NETWORKWE_URL.'/jobs/'.$job_id.'/'.$job_title);
		}else{
			if((!empty($currentUseremail)) AND (!empty($currentUserid)) AND ($role_id==1)) {
				//$this->loadModel('User','Users_profile');
				//$this->Users_profile->recursive=1;
				//$this->userInfo = $this->Users_profile->query("select * from users_profiles where user_id=$currentUserid");
				//$this->userInfo= $this->Users_profile->find('first',array('fields'=>array('Users_profile.user_id','Users_profile.firstname','Users_profile.lastname','Users_profile.photo','Users_profile.tags','User.id','User.email','User.role_id'),'conditions'=>array('Users_profile.user_id'=>$currentUserid)));
				//pr($this->userInfo);
				
				$this->userInfo = ClassRegistry::init('users')->find('first', array('fields' => array('
																									 users_profiles.firstname,
																									 users_profiles.lastname,
																									 users_profiles.photo,
																									 users_profiles.tags,
																									 users_profiles.user_id,
																									 users_profiles.handler,
																									 users.email,users.id','users.role_id'
																									 ),
																								
																								'joins' => array(
																												 
																												  array(
																														'alias' => 'users_profiles',
																														'table' => 'users_profiles',
																														'foreignKey' => false,
																														'conditions' => array(
																																			  'users.id = users_profiles.user_id'
																																			  ))),
																								'conditions'=>array('users.id'=> $currentUserid)));
				//pr($this->userInfo);
				
				$this->set('userInfo',$this->userInfo);
				
			}else{
				
				
			/*	
				$this->userInfo = ClassRegistry::init('users')->find('first', array('fields' => array('
																									 users_profiles.firstname,
																									 users_profiles.lastname,
																									 users_profiles.photo,
																									 users_profiles.tags,
																									 users_profiles.user_id,
																									 users.email,users.id','users.role_id'
																									 ),
																								
																								'joins' => array(
																												 
																												  array(
																														'alias' => 'users_profiles',
																														'table' => 'users_profiles',
																														'foreignKey' => false,
																														'conditions' => array(
																																			  'users.id = users_profiles.user_id'
																																			  ))),
																								'conditions'=>array('users.id'=> 220094)));
				//pr($this->userInfo);
				
				$this->set('userInfo',$this->userInfo);*/
				//$this->redirect(JOBS_URL);
				//$this->redirect(NETWORKWE_URL);
				$this->set('userInfo','');
				}
			}
			}
			else{
				
				$this->set('userInfo','');
				$this->redirect(JOBS_URL.'/search');
				}
		
	
    }
	public function getCurrentUserFriends($uid) {
		$uers_friends = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
		'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.')')));
		$friend_arrays='';
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
	public function getUserEmailID($uid) {
		if (!empty($uid)) { // logged in users
			$this->loadModel('User');
	        $user = $this->User->find('all',array('conditions'=>array('User.id'=>$uid)));
			$userEmailId = $user[0]['User'];
		}	
		return $userEmailId;
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
                $this->Session->setFlash(__('This image type is not supported.'), 'error_msg');
            }

            // Free up memory
            imagedestroy($source);
            imagedestroy($destination);
        }
    }
}
