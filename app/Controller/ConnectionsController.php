<?php
App::uses('AppController', 'Controller');
class ConnectionsController extends AppController {

    var $helpers = array('Form', 'html','Paginator');
    var $components = array('Auth','Email');
	var $uses = array('User','Connection','Users_profile');
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
		if ($this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$logged_user = $this->userInfo['users']['id'];
			if ($this->params['pass']) {
				$paramenter = $this->params['pass'];
				$uid = $paramenter[0];
				$this->set('user_profile_id',$paramenter[0]);
				$user_info = $this->getCurrentUser($paramenter[0]);
				$this->set('user_name',$user_info['firstname']);
			}else {
				$uid = $this->userInfo['users']['id'];
				$this->set('user_profile_id',$uid);
			}
				$total_connections = $this->Connection->find('all',
									array('fields'=>array('Connection.id'),
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=1')
									));	
				$this->set('total_connections',sizeof($total_connections));
				
				$this->paginate = array('fields' => array('Connection.id,Connection.created,Connection.modified,Connection.friend_id,Connection.user_id,Connection.request'),
       									 'conditions' => array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.')  AND Connection.request=1'),
										 'limit' => 10,
										 'order' => array('Connection.id' => 'ASC')
										);
				
				$connections = $this->paginate('Connection');
							
				$idx_connections = $idx_request = $idx_invite = 0;
				$connections_ids="";
				$request_ids="";
				$invite_ids="";
				//echo "<pre>";
				//print_r($connections);
				
				foreach ($connections as $friend) {
					
					if ($friend['Connection']['request'] == 1) {
						$peoples["contacts"][$idx_connections]["id"] = $friend['Connection']['id'];
						$peoples["contacts"][$idx_connections]["created"] = $friend['Connection']['created'];	
						$peoples["contacts"][$idx_connections]["modified"] = $friend['Connection']['modified'];	
						//echo $friend['Connection']['user_id'];
						//print_r($friend);
						if ($friend['Connection']['user_id'] == $uid) {					
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['friend_id'];   
							$connections_ids .=$friend['Connection']['friend_id'].",";  
						}else {
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['user_id'];  
							$connections_ids .=$friend['Connection']['user_id'].",";   
						}
						$idx_connections++;
					}else{	
						if ($friend['Connection']['user_id'] == $uid) {	
							$peoples["invited"][$idx_invite]["id"] = $friend['Connection']['id'];
							$peoples["invited"][$idx_invite]["created"] = $friend['Connection']['created'];	
							$peoples["invited"][$idx_invite]["modified"] = $friend['Connection']['modified'];				
							$peoples["invited"][$idx_invite]["friend_id"] = $friend['Connection']['friend_id']; 
							$invite_ids .=$friend['Connection']['friend_id'].","; 
							$idx_invite++;   
						}else {
							$peoples["request"][$idx_request]["id"] = $friend['Connection']['id'];
							$peoples["request"][$idx_request]["created"] = $friend['Connection']['created'];	
							$peoples["request"][$idx_request]["modified"] = $friend['Connection']['modified'];
							$peoples["request"][$idx_request]["friend_id"] = $friend['Connection']['user_id'];   
							$request_ids .=$friend['Connection']['user_id'].",";   
							$idx_request++;
						}
					}
					
				}
				
//exit;
				if (!(empty($connections_ids))){		
					$connections_ids = trim($connections_ids,",");
					
					foreach ($peoples["contacts"] as $key => $friend) {
						
						$fri_id = $friend["friend_id"];
							$contacts = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$fri_id)));
					if ($logged_user == $uid) {	
						$contact_email = ClassRegistry::init('users')->find('all', array('fields'=>array('users.email'),
																											 'conditions'=>array('users.id='.$fri_id)));
						$contact_following = ClassRegistry::init('users_followings')->find('all', array('fields'=>array('users_followings.id,users_followings.status'),
																											 'conditions'=>array('users_followings.following_id='.$fri_id.' AND users_followings.user_id='.$uid)));
						$chat_contacts = ClassRegistry::init('cometchat_friends')->find('all', array('fields'=>array('cometchat_friends.id'),
																											 'conditions'=>array('(cometchat_friends.friend_id='.$fri_id.' AND cometchat_friends.user_id='.$uid.') OR (cometchat_friends.friend_id='.$uid.' AND cometchat_friends.user_id='.$fri_id.') AND cometchat_friends.status=2')));
						
						$peoples["contacts"][$key]["email"] = $contact_email[0]["users"]["email"];
						$peoples["contacts"][$key]["following_id"] = $contact_following[0]["users_followings"]["id"];
						$peoples["contacts"][$key]["status"] = $contact_following[0]["users_followings"]["status"];
						$peoples["contacts"][$key]["friend_in_chat"] = $chat_contacts[0]["cometchat_friends"]["id"];
					}
						$peoples["contacts"][$key]["firstname"] = $contacts[0]["users_profiles"]["firstname"];
						$peoples["contacts"][$key]["lastname"] = $contacts[0]["users_profiles"]["lastname"];
						$peoples["contacts"][$key]["tags"] = $contacts[0]["users_profiles"]["tags"];
						$peoples["contacts"][$key]["photo"] = $contacts[0]["users_profiles"]["photo"];
						$peoples["contacts"][$key]["user_id"] = $contacts[0]["users_profiles"]["user_id"];
						
					}			
				}

				$this->set('peoples',$peoples);	
				$this->loadModel('Company_user');
				$companyPagesBYuser = ClassRegistry::init('companies')->find('all',
																	 array('fields'=>array('companies.*,industries.title'),'group'=>'companies.id',
																			'joins'=>array(array(
																			'alias' => 'industries', 'table' => 'industries', 'type' => 'left', 'foreignKey' => false,
																						'conditions' => array('companies.industry_id = industries.id')),
																						   array(
																			'alias' => 'Company_user', 'table' => 'company_users', 'foreignKey' => false,
																						'conditions' => array('companies.id = Company_user.company_id'))),
																	 		'conditions'=>array('OR'=>array('companies.user_id'=> $uid,'Company_user.user_id'=>$uid))));
		
		/*echo "<pre>";
		print_r($companyPagesBYuser);
		exit;*/
				$this->set('companyPagesBYuser',$companyPagesBYuser);
				$this->set('total_pages',sizeof($companyPagesBYuser));
				
				
				$groupListing = ClassRegistry::init('groups')->find('all',array('fields' => 
																			 array(
																	'groups.*,groups_types.title'),'limit'=>20,'order'=>'groups.id DESC',
																			 'joins' => array(
																							  array(
																					'alias' => 'groups_types', 'table' => 'groups_types', 'type' => 'left', 'foreignKey' => false,
																					'conditions' => array('groups.group_type_id'=>'groups_types.id'))),
																					'conditions' => array('groups.user_id'=>$uid)
																							));
	
		$this->set('groupListing',$groupListing);
		
			/*echo "<pre>";
		print_r($groupListing);
		exit;*/
		
			
	
		}
	}
				
		public function professionals() {
			
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
				$logged_user = $this->userInfo['users']['id'];
				if ($this->params['pass']) {
					$paramenter = $this->params['pass'];
					$uid = $paramenter[0];
					$this->set('user_profile_id',$paramenter[0]);
				}else {
					$uid = $this->userInfo['users']['id'];
					$this->set('user_profile_id',$uid);
				}	
				
				$total_connections = $this->Connection->find('all',
									array('fields'=>array('Connection.id'),
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Professional" OR Connection.connection_type="Both") AND Connection.request=1')
									));	
				$this->set('total_connections',sizeof($total_connections));
				
				$this->paginate = array('fields' => array('Connection.id,Connection.created,Connection.modified,Connection.friend_id,Connection.user_id,Connection.request'),
       									 'conditions' => array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Professional" OR Connection.connection_type="Both") AND Connection.request =1'),
										 'limit' => 10,
										 'order' => array('Connection.id' => 'DESC')
										);
				
				$connections = $this->paginate('Connection');						

				$idx_connections = $idx_request = $idx_invite = 0;
				$connections_ids="";
				$request_ids="";
				$invite_ids="";
				
				foreach ($connections as $friend) {
					
					if ($friend['Connection']['request'] == 1) {
						$peoples["contacts"][$idx_connections]["id"] = $friend['Connection']['id'];
						$peoples["contacts"][$idx_connections]["created"] = $friend['Connection']['created'];	
						$peoples["contacts"][$idx_connections]["modified"] = $friend['Connection']['modified'];		
						if ($friend['Connection']['user_id'] == $uid) {					
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['friend_id'];   
							$connections_ids .=$friend['Connection']['friend_id'].",";  
						}else {
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['user_id'];  
							$connections_ids .=$friend['Connection']['user_id'].",";   
						}
						$idx_connections++;
					}
				}
				
				$inveitedconnections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Professional" OR Connection.connection_type="Both") AND Connection.request !=1')
									));	
				
				foreach ($inveitedconnections as $friend) {
					if ($friend['Connection']['request'] != 1) {
						if ($friend['Connection']['user_id'] == $uid) {	
							$peoples["invited"][$idx_invite]["id"] = $friend['Connection']['id'];
							$peoples["invited"][$idx_invite]["created"] = $friend['Connection']['created'];	
							$peoples["invited"][$idx_invite]["modified"] = $friend['Connection']['modified'];				
							$peoples["invited"][$idx_invite]["friend_id"] = $friend['Connection']['friend_id']; 
							$invite_ids .=$friend['Connection']['friend_id'].","; 
							$idx_invite++;   
						}else {
							$peoples["request"][$idx_request]["id"] = $friend['Connection']['id'];
							$peoples["request"][$idx_request]["created"] = $friend['Connection']['created'];	
							$peoples["request"][$idx_request]["modified"] = $friend['Connection']['modified'];
							$peoples["request"][$idx_request]["friend_id"] = $friend['Connection']['user_id'];   
							$request_ids .=$friend['Connection']['user_id'].",";   
							$idx_request++;
						}
					}
					
				}
	
				if (!(empty($connections_ids))){		
					$connections_ids = trim($connections_ids,",");
					
					foreach ($peoples["contacts"] as $key => $friend) {
						$fri_id = $friend["friend_id"];
							$contacts = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$fri_id)));
					if ($logged_user == $uid) {	
						$contact_email = ClassRegistry::init('users')->find('all', array('fields'=>array('
																										 users.email
																										 '),
																						 'conditions'=>array('users.id='.$fri_id
																											 )
																						 )
																			);
						$contact_following = ClassRegistry::init('users_followings')->find('all', array('fields'=>array('
																														users_followings.id,
																														users_followings.status
																														'),
																											 'conditions'=>array('users_followings.following_id='.$fri_id.' AND 
																																 users_followings.user_id='.$uid
																																 )
																											 )
																						   );
						$chat_contacts = ClassRegistry::init('cometchat_friends')->find('all', array('fields'=>array('
																													 cometchat_friends.id
																													 '),
																									 'conditions'=>array('(cometchat_friends.friend_id='.$fri_id.' AND 
																														   cometchat_friends.user_id='.$uid.') OR 
																														 (cometchat_friends.friend_id='.$uid.' AND 
																														  cometchat_friends.user_id='.$fri_id.') AND 
																														 cometchat_friends.status=2'
																														 )
																									 )
																						);
						
						$peoples["contacts"][$key]["email"] = $contact_email[0]["users"]["email"];
						$peoples["contacts"][$key]["following_id"] = $contact_following[0]["users_followings"]["id"];
						$peoples["contacts"][$key]["status"] = $contact_following[0]["users_followings"]["status"];
						$peoples["contacts"][$key]["friend_in_chat"] = $chat_contacts[0]["cometchat_friends"]["id"];
					}
						$peoples["contacts"][$key]["firstname"] = $contacts[0]["users_profiles"]["firstname"];
						$peoples["contacts"][$key]["lastname"] = $contacts[0]["users_profiles"]["lastname"];
						$peoples["contacts"][$key]["tags"] = $contacts[0]["users_profiles"]["tags"];
						$peoples["contacts"][$key]["photo"] = $contacts[0]["users_profiles"]["photo"];
						$peoples["contacts"][$key]["user_id"] = $contacts[0]["users_profiles"]["user_id"];
						
						
						}
				}
	
				if (!(empty($invite_ids))){		
					$invite_ids = trim($invite_ids,",");
					foreach ($peoples["invited"] as $key => $friend) {
						$inv_id = $friend["friend_id"];
						$invite = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$inv_id)));	
						$peoples["invited"][$key]["firstname"] = $invite[0]["users_profiles"]["firstname"];
						$peoples["invited"][$key]["lastname"] = $invite[0]["users_profiles"]["lastname"];
						$peoples["invited"][$key]["tags"] = $invite[0]["users_profiles"]["tags"];
						$peoples["invited"][$key]["photo"] = $invite[0]["users_profiles"]["photo"];
					}			
				}
		
				if (!(empty($request_ids))){		
					$request_ids = trim($request_ids,",");
					foreach ($peoples["request"] as $key => $friend) {
						$req_id = $friend["friend_id"];
						$request = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$req_id)));
						$peoples["request"][$key]["firstname"] = $request[0]["users_profiles"]["firstname"];
						$peoples["request"][$key]["lastname"] = $request[0]["users_profiles"]["lastname"];
						$peoples["request"][$key]["tags"] = $request[0]["users_profiles"]["tags"];
						$peoples["request"][$key]["photo"] = $request[0]["users_profiles"]["photo"];
					}			
				}
		
			$this->set('peoples',$peoples);
			//echo "<pre>";
			//echo "<hr/>";
			//print_r($peoples);
			//echo "<hr/>";
			//print_r($request);
			//echo "<hr/>";
			//exit;
		}
		
	}
	
	
	
	public function friends() {
			
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
				$logged_user = $this->userInfo['users']['id'];
				if ($this->params['pass']) {
					$paramenter = $this->params['pass'];
					$uid = $paramenter[0];
					$this->set('user_profile_id',$paramenter[0]);
				}else {
					$uid = $this->userInfo['users']['id'];
					$this->set('user_profile_id',$uid);
				}	
				
				$total_connections = $this->Connection->find('all',
									array('fields'=>array('Connection.id'),
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Friend" OR Connection.connection_type="Both") AND Connection.request=1')
									));	
				$this->set('total_connections',sizeof($total_connections));
				
				$this->paginate = array('fields' => array('Connection.id,Connection.created,Connection.modified,Connection.friend_id,Connection.user_id,Connection.request'),
       									 'conditions' => array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Friend" OR Connection.connection_type="Both") AND Connection.request =1'),
										 'limit' => 10,
										 'order' => array('Connection.id' => 'DESC')
										);
				
				$connections = $this->paginate('Connection');
				
				/*$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Friend" OR Connection.connection_type="Both")')
									));	*/							

				$idx_connections = $idx_request = $idx_invite = 0;
				$connections_ids="";
				$request_ids="";
				$invite_ids="";
				
				foreach ($connections as $friend) {
					
					if ($friend['Connection']['request'] == 1) {
						$peoples["contacts"][$idx_connections]["id"] = $friend['Connection']['id'];
						$peoples["contacts"][$idx_connections]["created"] = $friend['Connection']['created'];	
						$peoples["contacts"][$idx_connections]["modified"] = $friend['Connection']['modified'];		
						if ($friend['Connection']['user_id'] == $uid) {					
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['friend_id'];   
							$connections_ids .=$friend['Connection']['friend_id'].",";  
						}else {
							$peoples["contacts"][$idx_connections]["friend_id"] = $friend['Connection']['user_id'];  
							$connections_ids .=$friend['Connection']['user_id'].",";   
						}
						$idx_connections++;
					}
				}
				$inveitedconnections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND (Connection.connection_type="Friend" OR Connection.connection_type="Both") AND Connection.request !=1')
									));	
				
				foreach ($inveitedconnections as $friend) {
					if ($friend['Connection']['request'] != 1) {
						if ($friend['Connection']['user_id'] == $uid) {	
							$peoples["invited"][$idx_invite]["id"] = $friend['Connection']['id'];
							$peoples["invited"][$idx_invite]["created"] = $friend['Connection']['created'];	
							$peoples["invited"][$idx_invite]["modified"] = $friend['Connection']['modified'];				
							$peoples["invited"][$idx_invite]["friend_id"] = $friend['Connection']['friend_id']; 
							$invite_ids .=$friend['Connection']['friend_id'].","; 
							$idx_invite++;   
						}else {
							$peoples["request"][$idx_request]["id"] = $friend['Connection']['id'];
							$peoples["request"][$idx_request]["created"] = $friend['Connection']['created'];	
							$peoples["request"][$idx_request]["modified"] = $friend['Connection']['modified'];
							$peoples["request"][$idx_request]["friend_id"] = $friend['Connection']['user_id'];   
							$request_ids .=$friend['Connection']['user_id'].",";   
							$idx_request++;
						}
					}
					
				}
	
				if (!(empty($connections_ids))){		
					$connections_ids = trim($connections_ids,",");
					
					foreach ($peoples["contacts"] as $key => $friend) {
						$fri_id = $friend["friend_id"];
							$contacts = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$fri_id)));	
						if ($logged_user == $uid) {	
						$contact_email = ClassRegistry::init('users')->find('all', array('fields'=>array('
																										 users.email
																										 '),
																						 'conditions'=>array('users.id='.$fri_id
																											 )
																						 )
																			);
						$contact_following = ClassRegistry::init('users_followings')->find('all', array('fields'=>array('
																														users_followings.id,
																														users_followings.status
																														'),
																											 'conditions'=>array('users_followings.following_id='.$fri_id.' AND 
																																 users_followings.user_id='.$uid
																																 )
																											 )
																						   );
						$chat_contacts = ClassRegistry::init('cometchat_friends')->find('all', array('fields'=>array('
																													 cometchat_friends.id
																													 '),
																									 'conditions'=>array('(cometchat_friends.friend_id='.$fri_id.' AND 
																														   cometchat_friends.user_id='.$uid.') OR 
																														 (cometchat_friends.friend_id='.$uid.' AND 
																														  cometchat_friends.user_id='.$fri_id.') AND 
																														 cometchat_friends.status=2'
																														 )
																									 )
																						);
						
						$peoples["contacts"][$key]["email"] = $contact_email[0]["users"]["email"];
						$peoples["contacts"][$key]["following_id"] = $contact_following[0]["users_followings"]["id"];
						$peoples["contacts"][$key]["status"] = $contact_following[0]["users_followings"]["status"];
						$peoples["contacts"][$key]["friend_in_chat"] = $chat_contacts[0]["cometchat_friends"]["id"];
					}
						$peoples["contacts"][$key]["firstname"] = $contacts[0]["users_profiles"]["firstname"];
						$peoples["contacts"][$key]["lastname"] = $contacts[0]["users_profiles"]["lastname"];
						$peoples["contacts"][$key]["tags"] = $contacts[0]["users_profiles"]["tags"];
						$peoples["contacts"][$key]["photo"] = $contacts[0]["users_profiles"]["photo"];
						$peoples["contacts"][$key]["user_id"] = $contacts[0]["users_profiles"]["user_id"];
						
						
						}
				}
	
				if (!(empty($invite_ids))){		
					$invite_ids = trim($invite_ids,",");
					foreach ($peoples["invited"] as $key => $friend) {
						$inv_id = $friend["friend_id"];
						$invite = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$inv_id)));	
						$peoples["invited"][$key]["firstname"] = $invite[0]["users_profiles"]["firstname"];
						$peoples["invited"][$key]["lastname"] = $invite[0]["users_profiles"]["lastname"];
						$peoples["invited"][$key]["tags"] = $invite[0]["users_profiles"]["tags"];
						$peoples["invited"][$key]["photo"] = $invite[0]["users_profiles"]["photo"];
					}			
				}
		
				if (!(empty($request_ids))){		
					$request_ids = trim($request_ids,",");
					foreach ($peoples["request"] as $key => $friend) {
						$req_id = $friend["friend_id"];
						$request = ClassRegistry::init('users_profiles')->find('all',array('fields' =>array('
																												   users_profiles.firstname,
																												   users_profiles.lastname,
																												   users_profiles.tags,
																												   users_profiles.photo,
																												   users_profiles.user_id
																												   '),
																												   'conditions'=>array('users_profiles.user_id='.$req_id)));
						$peoples["request"][$key]["firstname"] = $request[0]["users_profiles"]["firstname"];
						$peoples["request"][$key]["lastname"] = $request[0]["users_profiles"]["lastname"];
						$peoples["request"][$key]["tags"] = $request[0]["users_profiles"]["tags"];
						$peoples["request"][$key]["photo"] = $request[0]["users_profiles"]["photo"];
					}			
				}
		
			$this->set('peoples',$peoples);
			//echo "<pre>";
			//echo "<hr/>";
			//print_r($peoples);
			//echo "<hr/>";
			//print_r($request);
			//echo "<hr/>";
			//exit;
		}
		
	}
	
	
/*	public function invite_update() {
		//print_r($_GET);
		if($this->request->is('get')){
			$action = $_GET['action'];
			$connect_id = $_GET['connect_id'];
			ClassRegistry::init('connections')->updateAll(array('request' =>$action), array('connections.id' => $connect_id));
		}	
		$this->redirect(array('controller' => 'connections', 'action' => 'peoples')); 		
		exit;
		
	}*/
	
	public function invite_update() {
		if ($this->userInfo['users']['id']) {	
		$uid = $this->userInfo['users']['id'];
		}
		if($this->request->is('get')){
			$action = $_GET['action'];
			$connect_id = $_GET['contact_id'];
			$contact_type = $_GET['contact_type'];
			if ($action == -1) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM connections WHERE connections.id=".$connect_id);	
			}
			else {
				ClassRegistry::init('connections')->updateAll(array('request' =>$action), array('connections.id' => $connect_id));
			}
			
			if ($action == 1) {
				$findConnection = $this->Connection->find('first',array('fields' => array('Connection.user_id,Connection.friend_id'),
																		'conditions'=>array('Connection.id='.$connect_id.' AND Connection.request=1')));
				$user_id = $findConnection['Connection']['user_id'];
				$friend_id = $findConnection['Connection']['friend_id'];
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
					}	
			}
			
			if ($contact_type == 3) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=0  AND (Connection.connection_type="Professional" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
			if ($contact_type == 4) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=0  AND (Connection.connection_type="Friend" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('remove_contact');
	}
	
	public function remove_contact() {
		if ($this->userInfo['users']['id']) {	
		$uid = $this->userInfo['users']['id'];
		}
		if($this->request->is('get')){
			$contact_type = $_GET['contact_type'];
			$contact_id = $_GET['contact_id'];
			$this->loadModel('Connection');
			
			$user_connection =	$this->Connection->find('first',array('fields' => array('
																						Connection.friend_id,
																						Connection.user_id
																						'),
																	  'conditions' => array('Connection.id='.$contact_id)
																	  ));
			$user_id = $user_connection['Connection']['user_id'];
			$friend_id = $user_connection['Connection']['friend_id'];
	  $chat_condition = '(cometchat_friends.user_id='.$user_id.' AND cometchat_friends.friend_id='.$friend_id.') OR (cometchat_friends.user_id='.$friend_id.' AND cometchat_friends.friend_id='.$user_id.')';
			
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM connections WHERE connections.id=".$contact_id);	
			$db->rawQuery('DELETE FROM master_activities WHERE master_activities.activity_id='.$contact_id.' AND master_activities.activity_type="connection"');
			$db->rawQuery("DELETE FROM cometchat_friends WHERE ".$chat_condition);	
			if ($contact_type == 1) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=1  AND (Connection.connection_type="Professional" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
			if ($contact_type == 2) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=1  AND (Connection.connection_type="Friend" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
			if ($contact_type == 0) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=1')
				));	
			echo $total_connections = sizeof($connections);
			}
			if ($contact_type == 3) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=0  AND (Connection.connection_type="Professional" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
			if ($contact_type == 4) {
			$connections = $this->Connection->find('all',
									array(
										'conditions'=>array('(Connection.user_id='.$uid.' OR Connection.friend_id='.$uid.') AND Connection.request=0  AND (Connection.connection_type="Friend" OR Connection.connection_type="Both")')
				));	
			echo $total_connections = sizeof($connections);
			}
			$this->autorender = false;
			$this->layout = false;
			$this->render('remove_contact');
		}	
		
	}
	
	public function people_you_know() {
		if ($this->userInfo['users']['id']) {	
		
		$uid = $this->userInfo['users']['id'];
		$friends_Lists =$this->getCurrentUserFriends($uid);
		$user_Profile = $this->getCurrentUser();
		$user_you_may_know = $this->getCloseUserFriends($uid,$friends_Lists,$user_Profile['city']);
		$this->set('user_you_may_know',$user_you_may_know);
	}
}
	
    public function add_connection() {

	if ($this->request->is('post')) {
		if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
		}
		$this->request->data['connections']['request'] = 0;
		$request_date = date("Y-m-d H:i:s");
		$this->request->data['connections']['created'] = $request_date;
		$this->request->data['connections']['modified'] = $request_date;
		$this->request->data['connections']['friend_id'] = $this->request->data['friend_id'];
		$this->request->data['connections']['user_id'] = $this->request->data['user_id'];
		//$connection_type = $this->request->data['connection_type'];
		if (ClassRegistry::init('connections')->save($this->request->data)) {
			
			$this->Session->setFlash('Record successfully added');
			
			/*Connection Email to requester*/
				$friend_id = $this->request->data['friend_id'];
				$request_user_Email = $this->getUserEmailID($friend_id);
				$request_user_Email['email'];
				$requested_user_Profile = $this->getCurrentUser($friend_id);
				$requested_user = $requested_user_Profile['firstname'];
				
				$user_id = $this->request->data['user_id'];
				$user_Email = $this->getUserEmailID($user_id);
				$user_Profiles = $this->getCurrentUser($user_id);
				$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
				$user_deisgnation = $user_Profiles['tags'];
				$connection_link = NETWORKWE_URL.'/connections/networkwe_connection/u:'.$user_id.'/f:'.$friend_id.'';
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
				$this->Email->to = $request_user_Email['email']; 
				$this->Email->subject = $requested_user_Profile['firstname'].' please add me to your NetworkWe.';
				$this->Email->_debug = true;  
				if ($this->Email->send()) { 
				$this->redirect(array('controller' => 'connections', 'action' => 'index')); 
				}
			
			if($connection_type == 'people_you_know'){
				$this->redirect(array('controller' => 'connections', 'action' => 'people_you_know','invitation sent'));
				}
			else {
				$this->redirect(array('controller' => 'connections', 'action' => 'index'));
				}
    	}

	}
}
/*Send connection request using ajax*/
	
	public function add_connect_ajax() {
		
		if ($this->request->is('post')) {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
		$this->request->data['Connection']['request'] = 0;
		$request_date = date("Y-m-d H:i:s");
		$this->request->data['Connection']['created'] = $request_date;
		$this->request->data['Connection']['modified'] = $request_date;
		$friend_id = $_POST['friend_id'];
		$user_id = $_POST['user_id'];
		$connection_type = $_POST['connection_type'];
		$request_from = $_POST['request_from'];
		if ($request_from != '') {
			$this->set('request_from',$request_from);
		}
		$this->request->data['Connection']['friend_id'] = $friend_id;
		$this->request->data['Connection']['user_id'] = $user_id;
		$this->request->data['Connection']['connection_type'] = $connection_type;
		
		$isConnectionInDB = $this->Connection->find('first',array('fields'=>array('Connection.id'),
																				  'conditions'=>array('(Connection.user_id='.$user_id.' AND Connection.friend_id='.$friend_id.')
																								OR (Connection.user_id='.$friend_id.' AND Connection.friend_id='.$user_id.')')));
		if (sizeof($isConnectionInDB) != 0) {
			$this->Connection->id = $isConnectionInDB['Connection']['id'];
			$this->set('connection_id',$isConnectionInDB['Connection']['id']);
			if ($this->Connection->save($this->request->data)) {
				$this->autorender = false;
				$this->layout = false;
				$this->render('add_connect_ajax');
			}
		}
		else {
		
			if ($this->Connection->save($this->request->data)) {
				$connection_id = $this->Connection->getInsertID();
				$this->set('connection_id',$connection_id);
			}
		}
		if (sizeof($isConnectionInDB) == 0) {
			/*Connection Email to requester*/
			$friend_id = $this->request->data['friend_id'];
			$request_user_Email = $this->getUserEmailID($friend_id);
			$request_user_Email['email'];
			$requested_user_Profile = $this->getCurrentUser($friend_id);
			$requested_user = $requested_user_Profile['firstname'];
			
			$user_id = $this->request->data['user_id'];
			$user_Email = $this->getUserEmailID($user_id);
			$user_Profiles = $this->getCurrentUser($user_id);
			$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
			$user_deisgnation = $user_Profiles['tags'];
			$connection_link = NETWORKWE_URL.'/connections/networkwe_connection/u:'.$user_id.'/f:'.$friend_id.'';
			$profile_link = NETWORKWE_URL.'/pub/'.$user_Profiles['handler'];




			$strBody="";

			$email = $request_user_Email['email'];
                        $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_CONNECTION_REQUEST_FROMNAME).'","subject":"'.$this->fullescape($requested_user_Profile['firstname']." ".MAILER_CONNECTION_REQUEST_SUBJECT).'","from":"'.MAILER_CONNECTION_REQUEST_FROMEMAIL.'","replytoid":"'.MAILER_CONNECTION_REQUEST_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"772"},"recipients":["'.$email.'"],"attributes":{"NAME":["'.$requested_user.'"],"FULLNAME":["'.$fullname.'"],"DESIGNATION":["'.$user_deisgnation.'"],"CONNECTIONLINK":["'.$connection_link.'"],"PROFILELINK":["'.$profile_link.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$email).'"]}}';

                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch,CURLOPT_POST, true);
                        curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
                        $api_result = curl_exec($ch);
                        curl_close($ch);
                        if ($api_result == "success") {
				$this->autorender = false;
				$this->layout = false;
				$this->render('add_connect_ajax');
			}
			
		}
		
		}
	}

public function send_congrate_message() {
	if ($this->request->is('post')) {
		if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
		}
		$user_id = $_POST['user_id'];
		$friend_id = $_POST['friend_id'];
		$subject_id = $_POST['subject_id'];
		$subject_type = $_POST['subject_type'];
		$user_message = $_POST['user_message'];
		$this->request->data['users_messages']['status'] = 2;
		$created_date = date('Y-m-d H:i:s');
		$this->request->data['users_messages']['created'] = $created_date;
		$this->request->data['users_messages']['modified'] = $created_date;
		$this->request->data['users_messages']['friend_id'] = $friend_id;
		$this->request->data['users_messages']['user_id'] = $user_id;
		$this->request->data['users_messages']['subject_id'] = $subject_id;
		$this->request->data['users_messages']['subject_type'] = $subject_type;
		$this->request->data['users_messages']['user_message'] = $user_message;
		if (ClassRegistry::init('users_messages')->save($this->request->data)) {
				$this->Email->template = 'congrate_message'; 
				// You can use customised thmls or the default ones you setup at the start 
				$userProfile = $this->getCurrentUser($uid);
				$userEmail = $this->getUserEmailID($uid);
				$friendProfile = $this->getUserEmailID($friend_id);
				$friendName = $this->getCurrentUser($friend_id);
				$friendProfile['email']; 
				$userProfile['firstname']; 
				$this->set('user_message', $user_message); 
				$this->set('userName',$userProfile['firstname']);
				$this->set('friendName',$friendName['firstname']);
				
				// You can use customised thmls or the default ones you setup at the start  
				$this->Email->sendAs = 'both';
				$this->Email->from = $userProfile['firstname']."<".$userEmail['email']."> via NetworkWe";
				$this->Email->to = $friendProfile['email']; 
				$this->Email->subject = $userProfile['firstname'].' say Congratulation on your new job.';
				$this->Email->_debug = true;  
				if ($this->Email->send()) { 
				//$this->redirect(array('controller' => 'connections', 'action' => 'index')); 
				}	
		
		}
		else {
			echo "your message does not send, please try again";	
		}
	}
			/*user congrates messages on new jobs listing*/
			$whoSendYouCongrats = ClassRegistry::init('users_messages')->find('all', array('fields' =>array(
																									'users_messages.id,
																									users_messages.subject_id,
																									users_messages.user_message,
																									users_messages.created,
																									users_profiles.firstname,
																									users_profiles.lastname ,
																									users_profiles.photo,
																									users_profiles.tags'
																									),
																						   'order'=>'users_messages.id DESC',
																						   'joins' => array(
																											array(
																												  'alias' => 'users_profiles',
																												  'table' => 'users_profiles',
																												  'foreignKey' => false,
																												  'conditions' => array(
																												'users_messages.user_id = users_profiles.user_id'
																												))),
																						   'conditions'=>'users_messages.subject_id='.$subject_id
																						   ));
			$this->set('whoSendYouCongrats',$whoSendYouCongrats);
			$this->autorender = false;
			$this->layout = false;
			$this->render('send_congrate_message');
	
}
public function view () {
	if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
		
			$whoSendYouCongrats = ClassRegistry::init('users_messages')->find('all', array('fields' =>array(
																									'users_messages.id,users_messages.user_message, users_messages.created, users_profiles.firstname, users_profiles.lastname ,users_profiles.photo,users_profiles.tags'),'order'=>'users_messages.id DESC',
																							'joins' => array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false, 'conditions' => array('users_messages.user_id = users_profiles.user_id'))),																					
																							'conditions' => array('users_messages.friend_id='.$uid)));
			$this->set('whoSendYouCongrats',$whoSendYouCongrats);
		}	
	
}

public function updateConnection() {
if ($this->request->is('post')) {
			$uidd = $this->request->data['friend_id'];
			$req_id = $this->request->data['user_id'];
			$this->Connection->friend_id = $uidd;
			$this->Connection->user_id = $req_id;
			$this->request->data['connections']['request']=1;
			$output = $this->Connection->saveConnection($req_id,$uidd,$this->request->data['connections']['request']);
			$this->redirect(array('controller' => 'home', 'action' => 'index'));	
	}
}

public function networkwe_connection() {
	if (!empty($this->passedArgs['u']) && !empty($this->passedArgs['f'])){
		$user_id = $this->passedArgs['u'];
		$friend_id = $this->passedArgs['f'];
	$this->request->data['connections']['request']=1;
	$output = $this->Connection->saveConnection($user_id,$friend_id,$this->request->data['connections']['request']);
	$this->redirect(array('controller' => 'connections', 'action' => 'index'));
	}
}

	public function user_star() {
		$this->loadModel('Star_sign');
		if ($this->request->is('get')) {
			$star_id = $_GET["star_id"];
			$user_id = $_GET["user_id"];
			$user_starsign_detail_ajax = $this->Star_sign->find('all' ,array('conditions'=>array('Star_sign.id='.$star_id)));
			$this->set('user_starsign_detail_ajax',$user_starsign_detail_ajax);
			$user_profile = $this->getCurrentUser($user_id);
			$this->set('firstname',$user_profile['firstname']);
			$this->set('lastname',$user_profile['lastname']);
			$this->set('user_id',$user_profile['user_id']);
			$this->autorender = false;
			$this->layout = false;
			$this->render('user_star');
		}
	}
	
	public function shared_connections() {
		if ($this->request->is('get')) {
			    $user_id = $_GET['user_id'];
				$friend_id = $_GET['friend_id'];
				$connection_type = $_GET['type'];
				$commonUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$user_id.' OR connections.friend_id='.$user_id.') AND connections.request=1')));
		$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$friend_id.' OR connections.friend_id='.$friend_id.') AND connections.request=1')));
		
		if ($connection_type == 'shared') {
		
		foreach ($commonUser as $comm) {
			
			$commArray[] = $comm['connections']['friend_id'];
			$commArray[] = $comm['connections']['user_id'];
			
		}
		foreach ($reqUser as $req) {
			
			$reqArray[] = $req['connections']['friend_id'];
			$reqArray[] = $req['connections']['user_id'];
			
		}

		$commonArrays = array_intersect($commArray, $reqArray);
		foreach ($commonArrays as $key=>$commValue) {
			if ($commValue != $user_id && $commValue != $friend_id) {
				$commonUserArray[] = $commValue;
			}
		}
		
		} 
		else if ($connection_type == 'all') {
				foreach ($reqUser as $req) {
			
			$reqArray[] = $req['connections']['friend_id'];
			$reqArray[] = $req['connections']['user_id'];
			
		}
		foreach ($reqArray as $key=>$commValue) {
			if ($commValue != $friend_id) {
				$commonUserArray[] = $commValue;
			}
		}	
			
		}
		
		
		if (sizeof($commonUserArray)>1) {
		$commonUserArray =@implode(',',$commonUserArray);
		$getTotalUserShared= ClassRegistry::init('users_profiles')->find('all',array('fields'=>array('
																									 users_profiles.user_id,
																									 users_profiles.firstname,
																									 users_profiles.lastname,
																									 users_profiles.photo,
																									 users_profiles.tags,
																									 users_profiles.id
																									 '),
																					 'limit'=>10,
																					 'conditions'=>array('users_profiles.user_id IN('.$commonUserArray.')')));
		}
		else {
		$getTotalUserShared= ClassRegistry::init('users_profiles')->find('all',array('fields'=>array('
																									 users_profiles.user_id,
																									 users_profiles.firstname,
																									 users_profiles.lastname,
																									 users_profiles.photo,
																									 users_profiles.tags,
																									 users_profiles.id
																									 '),
																					 'limit'=>10,
																					 'conditions'=>array('users_profiles.user_id' => $commonUserArray[0])));
		} 
		
			}
		$this->set('getTotalUserShared',$getTotalUserShared);
		$this->autorender = false;
		$this->layout = false;
		$this->render('shared_connections');
	}
	
  function remove_connection() {
	 
	 if ($this->request->is('post')) {
		 
		 $user_id = $_POST['user_id'];
		 $friend_id = $_POST['friend_id'];
		 if ($friend_id !=0) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM connections WHERE (user_id=".$user_id." AND friend_id=".$friend_id.") OR (user_id=".$friend_id." AND friend_id=".$user_id.")");
		}
	 }
	 
	 $this->autorender = false;
	 $this->layout = false;
	 $this->render('remove_connection');
  }
 private function fullescape($in)
    {
            $out = '';
            $out = urlencode($in);
            $out = str_replace('+','%20',$out);
            $out = str_replace('_','%5F',$out);
            $out = str_replace('.','%2E',$out);
            $out = str_replace('-','%2D',$out);
            return $out;
    }

}
?>
