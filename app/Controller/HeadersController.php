  <?php
  App::uses('AppController', 'Controller');
  
  /* MADE CHANGES in getNotification and getTotalNotification functions by Farman ON  12-06-2014 04:58 PM*/
  
  class HeadersController extends AppController {
  
	  public $name = 'Headers';
	  public $uses = null;
  
	  function beforeFilter() {
	  parent::beforeFilter();
	  $this->Auth->allow();
	  switch ($this->request->params['action']) {
		  case 'index':
		  case 'admin_index':
	  }
		  //pr($this->cake_sessions->getActiveUsers());
	  }
	  
	  
	  
	  	public function getNotification() {
			$user_activitiess = "";
		if (!empty($this -> request -> params['requested'])) {
			//$cuser = $this->Session->read(@$userid);
			$uid = @$this->userInfo['users']['id'];
			$friends_Lists = $this->getCurrentUserFriends($uid);
			
			$user_notifications = ClassRegistry::init('clear_notifications')->find('first',array('fields' => array('
																											 clear_notifications.created
																											 '),
																						   'conditions' => array('clear_notifications.user_id ='.$uid)
																						   ));
			
			$condition  = '';
			
			$condition = '((master_activities.post_owner ='.$uid.' AND master_activities.activity_type IN ("likes","comments","connection"))';
				
			if ($friends_Lists) {
				if (sizeof($friends_Lists) > 1)
					$your_connection = @implode(',',$friends_Lists);
					else 
					$your_connection = $friends_Lists[0];
				$condition .= ' OR (master_activities.activity_type="updates" AND master_activities.post_owner IN ('.$your_connection.'))';
			}
			$condition .= ')';
			if ($user_notifications) {
				
			$clear_date = $user_notifications['clear_notifications']['created'];
			
			$clear_date = "'".$clear_date."'";
			
			if (empty($clear_date)) 
				$clear_date = '0000-00-00 00:00:00';
			 	$condition .= ' AND master_activities.created >'.$clear_date;
			  
			}
			$user_activitiess = ClassRegistry::init('master_activities')->find('all',array('fields' => array('
																											 master_activities.id,
																											 master_activities.activity_id,
																											 master_activities.activity_type,
																											 master_activities.user_id,
																											 master_activities.created,
																											 master_activities.post_owner,
																											 master_activities.viewed
																											 '
																											 ),
																						   'conditions' => array($condition),
																						   'limit' => 20, 
																						   'order'=>'master_activities.created DESC'));
			
			return $user_activitiess;
		}
		else {
			return $user_activitiess;
			
		}
	}
	
	public function getVeiwedNotification() {
		
		$uid = @$this->userInfo['users']['id']; 
		$userViewedNotify = '';
		if (!empty($this -> request -> params['requested'])) {
		$userViewedNotify = ClassRegistry::init('users_viewings')->find('all',array('fields' => array('users_viewings.viewings_id'
																											 ),
																						   'conditions' => array('users_viewings.user_id='.$uid.' 
																												 AND users_viewings.viewings_type="updates"'),
																						   'order'=>'users_viewings.id DESC'));
			return $userViewedNotify;
		}
		else {
			return $userViewedNotify;
		}
		
	}
	public function getTotalNotification() {
			
			$uid = @$this->userInfo['users']['id']; 	
			$friends_Lists =$this->getCurrentUserFriends($uid);
			if (sizeof($friends_Lists)>1) {
				$friends_List = @implode(',',$friends_Lists);
			}
			else {
				$friends_List = $friends_Lists[0];
			}
			$total_notification = "";
			$your_notification = 0;
			$total_notification2 = "";
		if (!empty($this->request->params['requested'])) {
			
			$user_notifications = ClassRegistry::init('clear_notifications')->find('first',array('fields' => array('
																											 clear_notifications.created
																											 '),
																						   'conditions' => array('clear_notifications.user_id ='.$uid)
																						   ));
			
			
			$condition  = '';
			
			$condition = '((master_activities.post_owner ='.$uid.' AND master_activities.activity_type IN ("likes","comments","connection"))';
			
				
			if ($friends_Lists) {
				$condition .= ' OR (master_activities.activity_type="updates" AND master_activities.post_owner IN ('.$friends_List.'))';
			}
			$condition .= ')';
			if ($user_notifications) {
				$clear_date = $user_notifications['clear_notifications']['created'];
			
				$clear_date = "'".$clear_date."'";
				$condition .= ' AND master_activities.created >'.$clear_date;
			}
			
			//$condition .= ' AND ;
			
			//print_r($condition);
			
			$total_notification = ClassRegistry::init('master_activities')->find('all',array('fields' => array('
																											 master_activities.id
																											 '
																											 ),
																						   'conditions' => array($condition),
																						   'order'=>'master_activities.created DESC'));

			$userAlreadyViewed = ClassRegistry::init('users_viewings')->find('all',array('fields'=>array('users_viewings.viewings_id'),
																		'conditions'=>array(' users_viewings.user_id='.$uid.' AND users_viewings.viewings_type= "updates"')));
			foreach ($userAlreadyViewed as $view_Row) { 
					$viewed_array[] = $view_Row['users_viewings']['viewings_id'];
			}
			
			foreach ($total_notification as $viewd_data) {
					$activity_id = $viewd_data['master_activities']['id'];
						if (in_array($activity_id,$viewed_array)) {
							
						}
						else {

							$your_notification++;
						}
			}

			return $your_notification;
		}
		else {
			return $your_notification;
			
		}	
										
	}
		
	public function view_activity() {
		if($this->request->is('post')){
			$id = $_POST['id'];
			$uid = $_POST['user_id'];
			if ($id != 0) {
				$view = 1;
				$userAlreadyViewed = ClassRegistry::init('users_viewings')->find('first',array('fields'=>array('users_viewings.id'),
																								'conditions'=>array('users_viewings.id='.$id.' AND users_viewings.user_id='.$uid.' AND users_viewings.viewings_type="updates"')));
				
				if (sizeof($userAlreadyViewed) == 0) {
					//echo sizeof($userAlreadyViewed);
					$this->request->data['users_viewings']['viewings_id'] = $id;
					$this->request->data['users_viewings']['user_id'] = $uid;
					$this->request->data['users_viewings']['viewings_type'] = "updates";
					$this->request->data['users_viewings']['viewings_counts'] = 1;
					$view_date = date('Y-m-d H:i:s');
					$this->request->data['users_viewings']['start_date'] = $view_date;
					$this->request->data['users_viewings']['end_date'] = $view_date;
					if (ClassRegistry::init('users_viewings')->save($this->request->data)) { 
					}
				}
				
				//ClassRegistry::init('master_activities')->updateAll(array('viewed' =>$view), array('master_activities.id' => $id));
			}
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('decline');
	}
	  
	  
	  	public function getUserConnections()  {
		$user_notifications ="";
		if (@$this->userInfo['users']['id']) { 
			
			$uid = @$this->userInfo['users']['id'];
			$uers_chat_connections = ClassRegistry::init('cometchat_friends')->find('all',array(
																								'conditions'=>array('AND'=>array(
																																 'cometchat_friends.friend_id' => $uid,
																																  'cometchat_friends.status'=>0
																																  ))));
			
			$uers_connections = ClassRegistry::init('connections')->find('all',array(
																					 'conditions'=>array('AND'=>array(
																													  'connections.friend_id' => $uid,
																													  'connections.request'=>0
																													  ))));
			if (sizeof($uers_chat_connections)>0){
				$user_notifications = 	$user_notifications + sizeof($uers_chat_connections);
			}
			if (sizeof($uers_connections)>0) {
				$user_notifications += sizeof($uers_connections);
			}
	
		}
		return $user_notifications;
	}
	
	  public function getUserRecord() {
		
		$uid = @$this->userInfo['users']['id']; 
		if (!empty($uid)) {
		  $requsers = ClassRegistry::init('users_profiles')->find('all', array('fields' => array('
																								 users_profiles.firstname,
																								 users_profiles.lastname,
																								 users_profiles.photo,
																								 users_profiles.tags,
																								 users_profiles.handler,
																								 connections.friend_id,
																								 connections.request,
																								 connections.created,
																								 connections.id,
																								 users.email,users.id'
																								 ),
																							'limit'=>15,
																							'order'=>'users_profiles.id DESC',
																							'joins' => array(
																											 array(
																												   'alias' => 'connections',
																													'table' => 'connections',
																													'foreignKey' => false,
																										 			'conditions' => array(
																																'connections.user_id = users_profiles.user_id')),
																											  array(
																													'alias' => 'users',
																													'table' => 'users',
																													'foreignKey' => false,
																										 			'conditions' => array(
																																		  'users.id = users_profiles.user_id'
																																		  ))),
																							'conditions'=>array('connections.friend_id = '.$uid.' AND connections.request=0')));
			return $requsers;
	  }
	  else {
		  echo "Empty Result";	
	  }
	}
	/*connection request response*/
	
	public function getRequestResponse() {
		
		$uid = @$this->userInfo['users']['id']; 
		if (!empty($uid)) {
		  $requsers_res = ClassRegistry::init('users_profiles')->find('all', array('fields' => array('
																								 users_profiles.firstname,
																								 users_profiles.lastname,
																								 users_profiles.photo,
																								 users_profiles.tags,
																								 users_profiles.handler,
																								 connections.friend_id,
																								 connections.request,
																								 connections.created,
																								 connections.id'
																								 ),
																							'limit'=>5,
																							'order'=>'users_profiles.id DESC',
																							'joins' => array(
																											 array(
																												   'alias' => 'connections',
																													'table' => 'connections',
																													'foreignKey' => false,
																										 			'conditions' => array(
																																'connections.friend_id = users_profiles.user_id'))),
																							'conditions'=>array('connections.user_id = '.$uid)));
			return $requsers_res;
	  }
	  else {
		  echo "Empty Result";	
	  }
	}
	
	/*Sill Endoursement for user*/
	public function getUserSkillRecommendation(){
    	if (@$this->userInfo['users']['id']) {
			
			$uid = @$this->userInfo['users']['id'];
			if (!empty($uid)) {
				$recommend_Users_for_skill = ClassRegistry::init('skill_recommendations')->find('all',array(
																											'fields'=>array(
																															'DISTINCT skill_recommendations.recommends'),
																											'limit'=>2,
																											'order'=>'skill_recommendations.id DESC',
																											'conditions'=>array(
																																'skill_recommendations.user_id='.$uid.'
																																AND skill_recommendations.recommendation=1'
																															)));
	
				foreach ($recommend_Users_for_skill as $skill_users_record) {
					$recommends_Resultant_Array[] .=$skill_users_record['skill_recommendations']['recommends'];
				}
				if ($recommends_Resultant_Array) {
					if (sizeof($recommends_Resultant_Array)>1) {
						$recommends_Resultant_Array = @implode(',',$recommends_Resultant_Array);
						if ($recommends_Resultant_Array) {
		  				$skills_Recommended_for_User = ClassRegistry::init('skill_recommendations')->find('all',array(
																													 'fields' =>array('users_profiles.photo, 												                                                                                                                                       users_profiles.firstname,
																																	   users_profiles.lastname,
																																	   skills.title, skill_recommendations.skill_id,
																																	   skill_recommendations.recommendation,  
																																	   skill_recommendations.start_date'),
																													 'limit'=>2,
																													 'order'=>'skill_recommendations.id DESC',
																													 'joins' => array(
																																	  array('alias' => 'skills',
																																			'table' => 'skills',
																																			'foreignKey' => false,
																																			'conditions' => array(
																																	 'skill_recommendations.skill_id = skills.id')),
																																		array('alias' => 'users_profiles',
																																	 		  'table' => 'users_profiles',
																																	  		  'foreignKey' => false,
																																	  		  'conditions' => array(
																													 'skill_recommendations.recommends = users_profiles.user_id'
																													))),
																													 'conditions'=>array(
																									array('skill_recommendations.recommends IN ('.$recommends_Resultant_Array.')'),
																																		 'skill_recommendations.recommendation'=>1
																																		 )));
						}
				}
				else {
					$skills_Recommended_for_User = ClassRegistry::init('skill_recommendations')->find('all', array('fields' =>
																												   array('users_profiles.photo,
																														 users_profiles.firstname, 
																														 users_profiles.lastname, skills.title, 
																														 skill_recommendations.skill_id, 
																														 skill_recommendations.recommendation, 
																														 skill_recommendations.start_date' ),
																												   'limit'=>2,
																												   'order'=>'skill_recommendations.id DESC',
																												   'joins' => array(
																															  array('alias' => 'skills',
																																	'table' => 'skills',
																																	'foreignKey' => false,
																																	'conditions' => array(
																															  'skill_recommendations.skill_id = skills.id')),
																															   array('alias' => 'users_profiles',
																																	 'table' => 'users_profiles',
																																	 'foreignKey' => false,
																																	 'conditions' => array(                   	   
                                                                                                                     'skill_recommendations.recommends = users_profiles.user_id'))),																																																															
											'conditions'=>array('skill_recommendations.recommends='.$recommends_Resultant_Array[0].' AND skill_recommendations.recommendation=1')));	
		  		}
			}
		}
	 }
	return $skills_Recommended_for_User;
	}
	/*Chat Request*/
	public function getUserChatRequests() {
		if (@$this->userInfo['users']['id']) {
			
			$uid = @$this->userInfo['users']['id'];
			if (!empty($uid)) {
				$chat_User_Requsers = ClassRegistry::init('cometchat_friends')->find('all', array('fields' => array(
																												 'users_profiles.firstname,
																												  users_profiles.lastname,
																												  users_profiles.photo,
																												  users_profiles.tags,
																												  users_profiles.handler,
																												  cometchat_friends.status,
																												  cometchat_friends.id,
																												  cometchat_friends.invite_date'
																												  ),
																							   'order'=>'users_profiles.id DESC',
																							   'joins' => array(
																												array('alias' => 'users_profiles',
																													  'table' => 'users_profiles',
																													  'foreignKey' => false,
																							   'conditions' => array('cometchat_friends.user_id = users_profiles.user_id '))),
																		         		'conditions'=>array('cometchat_friends.friend_id='.$uid
																									 )));
	
			return $chat_User_Requsers;
			}
		}
	
	}
	
	
	public function decline() {

		if($this->request->is('post')){
			$action = $_POST['action'];
			$connect_id = $_POST['connect_id'];
			$uid = $_POST['user_id'];
			/* new changes by farman on 05-05-2014 start*/
			if ($action == -1) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM connections WHERE connections.id=".$connect_id);	
			}
			else {
				ClassRegistry::init('connections')->updateAll(array('request' =>$action), array('connections.id' => $connect_id));
			}
			if ($action == 1) {
				$findConnection = ClassRegistry::init('connections')->find('first',array('fields' => array('connections.user_id,connections.friend_id'),
																		'conditions'=>array('connections.id='.$connect_id.' AND connections.request=1')));
				
				$user_id = $findConnection['connections']['user_id'];
				$friend_id = $findConnection['connections']['friend_id'];
				if ($user_id == $uid) {
					$post_owner = $friend_id;
				}
				else {
					$post_owner = $user_id;
				}
					$created_date = date("Y-m-d H:i:s");
					$this->request->data = '';
					$this->request->data['master_activities']['status'] = 1; 
					$this->request->data['master_activities']['activity_id'] = $connect_id; 
					$this->request->data['master_activities']['activity_type'] = "connection";
					$this->request->data['master_activities']['viewed'] = 0;
					$this->request->data['master_activities']['user_id'] = $uid;
					$this->request->data['master_activities']['post_owner'] = $post_owner;
					$this->request->data['master_activities']['created'] = $created_date;
					if (ClassRegistry::init('master_activities')->save($this->request->data)) {
						echo 1;
					}	
			}
			/* new changes by farman on 05-05-2014 end*/
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('decline');
	}
	
		public function chat_request() {
		if($this->request->is('post')){
			$action = $_POST['action'];
			$chat_id = $_POST['chat_id'];
			/* new changes by farman on 05-05-2014 start*/
			if ($action == -1) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM cometchat_friends WHERE cometchat_friends.id=".$chat_id);	
			}
			else {	
				ClassRegistry::init('cometchat_friends')->updateAll(array('status' =>$action), array('cometchat_friends.id' => $chat_id));
			}
			/* new changes by farman on 05-05-2014 end*/
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('chat_request');
	}
	
	/*latest comments on activities*/
	
	public function commentsOnActivity() {
		
			
			$uid = @$this->userInfo['users']['id'];
			if ($uid) {
				$currentUser_Connections = ClassRegistry::init('connections')->find('all',array('fields'=>array(
																												'connections.friend_id,
																												 connections.user_id'
																												),
																								'conditions'=>array(
																													'(connections.user_id='.$uid.' OR
																													  connections.friend_id='.$uid.') AND
																													connections.request=1'),
																								'order'=>'connections.created DESC'));
		
			foreach ($currentUser_Connections as $CurrnettUser) {
				if ($CurrnettUser['connections']['friend_id'] != $uid){
				 	$user_Connection_Array[] .= $CurrnettUser['connections']['friend_id'];
			 	}
			 	if ($CurrnettUser['connections']['user_id'] != $uid){
				 	$user_Connection_Array[] .= $CurrnettUser['connections']['user_id'];
			 	}
		  	}
			$user_Connection_Array = @implode(',',$user_Connection_Array);
			/*comments from user*/
			if ($user_Connection_Array) {
			$currentUser_Connections = ClassRegistry::init('comments')->find('all',array('fields'=>array(
																										'comments.comment_text,
																										 comments.comment_type,
																										 comments.content_id,
																										 comments.user_id,
																										 comments.created,
																										 users_profiles.firstname,
																										 users_profiles.id,
																										 users_profiles.photo,
																										 users_profiles.handler'
																										),
																							   'joins' => array(
																												array('alias' => 'users_profiles',
																													  'table' => 'users_profiles',
																													  'foreignKey' => false,
																							   'conditions' => array('comments.user_id = users_profiles.user_id '))),
																						 
																								'conditions'=>array(
																													array('comments.user_id IN('.$user_Connection_Array.')')),
																								'order'=>'comments.created DESC',
																								'limit'=>2));

			return $currentUser_Connections;
			}
		}
	}
	public function getActivity($content_id,$comment_type) {
			if ($comment_type == 'news') {
				$content_array = ClassRegistry::init('news')->find('all',array('fields'=>array(
																			  'news.heading,
																			   news.id'
																			  ),
															  'conditions'=>array(
																				  'news.id='.$content_id
																				  )
															  ));
				$content_array = $content_array[0]['news'];
			}
			else if ($comment_type == 'blog') {
				$content_array = ClassRegistry::init('blogs')->find('all',array('fields'=>array(
																			  'blogs.post_title,
																			   blogs.id'
																			  ),
															  'conditions'=>array(
																				  'blogs.id='.$content_id
																				  )
															  ));
				$content_array = $content_array[0]['blogs'];
				
			}
			else if ($comment_type == 'company') {
				$content_array = ClassRegistry::init('companies')->find('all',array('fields'=>array(
																			  'companies.title,
																			   companies.id'
																			  ),
															  'conditions'=>array(
																				  'companies.id='.$content_id
																				  )
															  ));
				$content_array = $content_array[0]['companies'];
				
			}
			else if ($comment_type == 'updates') {
				$content_array = ClassRegistry::init('statusupdates')->find('all',array('fields'=>array(
																			  'statusupdates.user_text,
																			   statusupdates.id'
																			  ),
															  'conditions'=>array(
																				  'statusupdates.id='.$content_id
																				  )
															  ));
				$content_array = $content_array[0]['statusupdates'];
				
			}
		return $content_array;
		
	}
	
	public function getMessagesCount(){
		$this->loadModel('msg_inbox');
      
		$uid = @$this->userInfo['users']['id'];
		
		$this->autoRender = false;
		$unreadCount = $this->msg_inbox->find('count',array('conditions'=>array('AND'=>array('msg_inbox.to_user_id'=>$uid,'msg_inbox.status'=>2,'msg_inbox.unread'=>1))));
		//echo $unreadCount;
		return $unreadCount;
	}
	
  }
  
  ?>