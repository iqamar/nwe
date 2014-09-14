<?php
App::uses('AppController', 'Controller');

class GroupsController extends AppController {

/*
 * Controller name
 *
 * @var string
 */
 	var $helpers = array('Paginator');
	var $name = 'Group';
	var $uses = array('Group','Users_profile','Users_following','Country','Entity_update');
 function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow();
    }
	
	public function extractProcess(){
		$this->autoRender = false;
		if(isset($_POST["url"]))
		{
			$get_url = $_POST["url"]; 
			App::import('Vendor', 'simple_html_dom', array('file'=> 'simple_html_dom.php'));
						
			$get_content = file_get_html($get_url); 
			if($get_content->find('meta[property=og:title]')){
				foreach($get_content->find('meta[property=og:title]') as $element) 
				{
					$page_title = $element->content;
				}
			}else{
				foreach($get_content->find('title') as $element) 
				{
					$page_title = $element->plaintext;
				}
				
			}
			if($get_content->find('meta[property=og:description]')){
				foreach($get_content->find('meta[property=og:description]') as $element) 
				{
					
					$page_body = $element->content;
				}
			}elseif($get_content->find('META[name="description"]')){
				foreach($get_content->find('META[name="description"]') as $element) 
				{
					$page_body = $element->content;
					
				}
			}else{
				foreach($get_content->find('body') as $element) 
				{				
					$page_body = trim($element->plaintext);
					$pos=strpos($page_body, '', 400); //Find the numeric position to substract
					$page_body = substr($page_body,0,$pos ); //shorten text to 200 chars
				}
			}
			$image_urls = array();
			if($get_content->find('meta[property=og:image]')){
				
				foreach($get_content->find('meta[property=og:image]') as $element){
					
					if(!preg_match('/blank.(.*)/i', $element->content) && filter_var($element->content, FILTER_VALIDATE_URL))
					{
						$image_urls[] =  $element->content;
					}
					$image_urls[] =  $element->content;
				}
			}
			$output = array('title'=>$page_title, 'images'=>$image_urls, 'content'=> $page_body);
					
			echo json_encode($output); 
		}
		
	}
	
	public function index() {
		if (@$this->userInfo['users']['id']) {
		
		$uid = @$this->userInfo['users']['id'];
		$this->set('uid',$uid);
		//$this-loadModel('Group');
		
		$this->paginate = array('fields' =>array('
												 Group.id,
												 Group.title,
												 Group.logo,
												 groups_types.title,
												 users_followings.status
											   '),
								 'order'=>'Group.id DESC',
								 'limit' => 12,
								 'joins' => array(
												  array(
														'alias' => 'groups_types',
														'table' => 'groups_types',
														'type' => 'left',
														'foreignKey' => false,
														'conditions' => array('Group.group_type_id = groups_types.id'
																			  )
														),
													array(
														  'alias' => 'users_followings',
														  'table' => 'users_followings',
														  'foreignKey' => false,
														  'conditions' => array('users_followings.following_id = Group.id'
																				)
														  )
													),
								 'conditions' => array('users_followings.following_type = "groups" AND
													  (users_followings.status=2 OR users_followings.status=1) AND users_followings.user_id='.$uid
													   )
								 );
		
		
		//$groupsListing = ClassRegistry::init('groups')->find('all',);
		$groupsListing = $this->paginate('Group');
		$this->set('groupsListing',$groupsListing);
		
		
		/*just get the groups which user joined,, TO GET IDS from joined groups*/
		$groups_joined_by_you = ClassRegistry::init('users_followings')->find('all',array('fields' => array('
																											users_followings.status,
																											users_followings.following_id
																											'),
																						  'order'=>'users_followings.id DESC',
																						  'conditions' => array('users_followings.following_type = "groups" AND
																		(users_followings.status=2 OR users_followings.status=1 OR users_followings.status=0) AND users_followings.user_id='.$uid
																		)
																						  )
																			  );

		$this->set('groups_joined_by_you',$groups_joined_by_you);
		/*get the current user skill to search intrested groups for him*/
		
		$user_had_skills = ClassRegistry::init('users_skills')->find('all',array('fields' =>array('
																								  skills.title
																								  '),
																				 'order'=>'users_skills.id DESC',
																				 'joins' => array(
																								  array(
																										'alias' => 'skills',
																										'table' => 'skills', 
																										'type' => 'left',
																										'foreignKey' => false,
																										'conditions' => array('users_skills.skill_id = skills.id'
																															  )
																										)
																								  ),
																				 'conditions' => array('users_skills.user_id='.$uid
																									   )
																				 )
																	 );
		

		
		/*User group you may be intrested*/
			foreach ($user_had_skills as $skill_for_user) {
				$skill_title = $skill_for_user['skills']['title'];
				$groups_you_may_know[] = ClassRegistry::init('groups')->find('all',array('fields' =>array('
																										  groups.id,
																										  groups.title,
																										  groups.logo,
																										  groups_types.title
																										  '),
																						 'order'=>'groups.id DESC',
																						 'joins' => array(
																										  array(
																												'alias' => 'groups_types',
																												'table' => 'groups_types',
																												'foreignKey' => false,
																												'conditions' => array('groups.group_type_id = groups_types.id'
																																	  )
																												)
																										  ),
																						 'conditions' => array('groups.title LIKE "%'.$skill_title.'%" AND groups.user_id !='.$uid
																											   )
																						 )
																			 );
				
			}

		$this->set('groups_you_may_know',$groups_you_may_know);
		}
	}
	public function lists(){
		if (@$this->userInfo['users']['id']) {
			
			$uid = $this->userInfo['users']['id'];
			$this->set('uid',$uid);
			$groupListing = ClassRegistry::init('groups')->find('all',array('fields' => array('
																							  groups.id,
																							  groups.title,
																							  groups.logo,
																							  groups_types.title
																							  '),
																			'order'=>'groups.id DESC',
																			'joins' => array(
																							 array('alias' => 'groups_types',
																								   'table' => 'groups_types',
																								   'type' => 'left',
																								   'foreignKey' => false,
																								   'conditions' => array('groups.group_type_id'=>'groups_types.id'
																														 )
																								   )
																							 ),
																			'conditions' => array('groups.user_id'=>$uid)
																		)
																);
												
		
			$this->set('groupListing',$groupListing);
		}
			
	}
	
	public function search() {
		if (@$this->userInfo['users']['id']) {
		
		$uid = $this->userInfo['users']['id'];
		$this->set('uid',$uid);
		//$this-loadModel('Company');
		
		$this->paginate = array('fields' =>array('
												 Group.id,
												 Group.title,
												 Group.logo,
												 Group.user_id,
												 groups_types.title
												 '),
								'order'=>'Group.id DESC',
								'limit' => 12,
								'joins' => array(
												 array(
													   'alias' => 'groups_types',
													   'table' => 'groups_types',
													   'type' => 'left',
													   'foreignKey' => false,
													   'conditions' => array('Group.group_type_id = groups_types.id
																			 ')
													   )
												 )
								);
		
		
		//$groupsListing = ClassRegistry::init('groups')->find('all',);
		
		$groupsListing = $this->paginate('Group');
		$this->set('groupsListing',$groupsListing);
				
		
		$loggeduers_following_groups = ClassRegistry::init('users_followings')->find('all',
															array('conditions' => array('users_followings.user_id='.$uid.' AND users_followings.following_type="groups"')));
			
			$this->set('loggeduers_following_groups',$loggeduers_following_groups);
		
		}

	}
	
	
		public function join_group() {
			
		if ($this->request->is('get')) {
			
			//$this->loadModel('Group');
			$groupid = $_GET['groupid'];
			$uid = $_GET['user_id'];
			$status = $_GET['status'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$user_following_id = $_GET['user_following_id'];
			$retrive_group = ClassRegistry::init('groups')->find('first',array('fields' =>array('groups.joining_mode'),'conditions'=>array('groups.id'=>$groupid)));

			$joining_mode = $retrive_group['groups']['joining_mode'];
					
			if ($joining_mode == 'Request to Join') {
				$this->request->data['users_followings']['status'] = 1;	
				$status = 1;
			}
			else if ($joining_mode == 'Auto-Join') {
				$this->request->data['users_followings']['status'] = 2;
				$status = 2;
			}
			$this->loadModel('Users_following');
			if ($user_following_id == '') {
				$this->request->data['users_followings']['start_date'] = $start_date;
			}
			else {
				$this->request->data['users_followings']['end_date'] = $end_date;
			}
			if ($user_following_id == '') {
				$this->request->data['users_followings']['following_id'] = $groupid;
				$this->request->data['users_followings']['user_id'] = $uid;
				$this->request->data['users_followings']['status'] = $status;
				$this->request->data['users_followings']['following_type'] = 'groups';
				$comFollow = ClassRegistry::init('users_followings')->save($this->request->data);
				}
			else if ($this->Users_following->updateAll(array('status' =>$status), array('Users_following.id' => $user_following_id))) {
					
				}
				else {
					
				}
			
			}
			else {
			
			}
			$this->set('comFollow',$comFollow);
			$this->set('status',$status);
			$this->set('user_following_id',$user_following_id);
			$this->set('groupid',$groupid);
			$this->autorender = false;
			$this->layout = false;
			$this->render('join_group');
	}
	
		public function search_group() {
			
			$uid = @$this->userInfo['users']['id'];
		if ($this->request->is('get')) {
			//$this->loadModel('Group');
			$group_title = $_GET['group_title'];
			if ($group_title) {
			$comResult = ClassRegistry::init('groups')->find('all',array('fields' => array('
																						   groups.id,
																						   groups.title,
																						   groups.logo,
																						   groups_types.title
																						   '),
																		 'order'=>'groups.id DESC',
																		 'joins' => array(
																						  array(
																								'alias' => 'groups_types',
																								'table' => 'groups_types',
																								'type' => 'left',
																								'foreignKey' => false,
																								'conditions' => array('groups.group_type_id = groups_types.id'
																													  )
																								)
																						  ),
																		 'conditions'=>array('groups.title LIKE'=>'%'.$group_title.'%'
																							 )
																		 )
															 );
			}
			else {
				$comResult = ClassRegistry::init('groups')->find('all');
					}
			}
			$loggeduers_following_groups = ClassRegistry::init('users_followings')->find('all',
															array('conditions' => array('users_followings.user_id='.$uid.' AND users_followings.following_type="groups"')));
			
			$this->set('loggeduers_following_groups',$loggeduers_following_groups);
			
			$this->set('comResult',$comResult);
			$this->autorender = false;
			$this->layout = false;
			$this->render('search_group');
	}
		public function add() {

		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$user_profile = $this->userInfo['users_profiles'];
			
			$this->set('user_profile',$user_profile);
			$this->set('uid',$uid);
			$paramenter = $this->params['pass'];
			$groupid = $paramenter[0];
			
			if ($groupid) {
				
							$Update_Group_Detail = ClassRegistry::init('groups')->find('all',array('fields' => 
																			 array(
																	'groups.*,groups_types.*'),
																			 'joins' => array(
																							   array(
																				'alias' => 'groups_types', 'table' => 'groups_types', 'type' => 'left', 'foreignKey' => false,
																					'conditions' => array('groups.group_type_id = groups_types.id'))),
																			 'conditions' => array('groups.id'=>$groupid)));

																							
			    $this->set('Update_Group_Detail',$Update_Group_Detail);
				
				$this->set('groupid',$groupid);
				
/*			$this->loadModel('Company_user');
			$this->loadModel('Users_profile');
			$admin_users_to_page = $this->Company_user->find('all', array('fields'=>array('users_profiles.*,Company_user.id'),'order'=>'Company_user.id DESC',
															'joins'=>array(
																  array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
																'conditions' => array('Company_user.user_id = users_profiles.user_id AND Company_user.company_id='.$companyid))),
													'condition'=>array('Company_user.company_id='.$companyid)));

			$this->set('admin_users_to_page',$admin_users_to_page);*/
			}
			
			$group__Types = ClassRegistry::init('groups_types')->find('all',array('fields'=>array(
																									  'groups_types.id','groups_types.title','groups_types.status'),
																		  							  'conditions'=>array('groups_types.status=2')));
			
			$this->set('group__Types',$group__Types);
			
			$group_countries = ClassRegistry::init('Country')->find('all',array('fields'=>array(
																			'Country.name','Country.id')));
			$this->set('group_countries',$group_countries);
	
		}
			if ($this->request->is('post')) {
				$this->loadModel('Group');
				
				$this->request->data['Group']['user_id'] = $uid;
				$this->request->data['Group']['status'] = 2;
				$groupid = $this->request->data['Group']['groupid'];

				$fileName = $this->request->data['Group']['image'];
			
				$fileLogo = $this->request->data['Group']['logo'];
				
				$old_data_images = ClassRegistry::init('groups')->find('all',
																	 array('fields'=>array('groups.image,groups.logo'),
																	 		'conditions'=>array('groups.id'=> $groupid)));
				if ($old_data_images) {
					foreach ($old_data_images as $get_image_company) {
						
						$image = $get_image_company['groups']['image'];
						$logo = $get_image_company['groups']['logo'];
					}
				}
				
				$imageName = $imageName['name'];
				
				$typess = $fileName['type'];
			
					$imageTypes = array("image/gif", "image/jpeg", "image/png","image/jpg");
					$uploadFolder = "files/group/";
					$uploadPath = MEDIA_PATH . $uploadFolder;
						
							if ($fileName['name']) {
								$imageName = date('His').$fileName['name'];
								$full_image_path = $uploadPath . 'original/' . $imageName;
								if (move_uploaded_file($fileName['tmp_name'], $full_image_path)) {
									$data['image'] = $imageName;
									 $this->request->data['Group']['image'] = $data['image'];
									 
									 $source_image = $uploadPath.'original/'.$data['image'];
									$destination_logo_path = $uploadPath.'cover/'.$data['image'];
									$this->__imageresize($source_image, $destination_logo_path, 237, 653);
									 
								} 
								else {
									$mesg = "There was a problem uploading Cover image. Please try again";
									$error = 1;
								}
								
							}
						if ($fileLogo['name']) {
							if ($fileLogo['type'] == "image/gif" || $fileLogo['type'] == "image/jpeg" || $fileLogo['type'] == "image/png" || $fileLogo['type'] == "image/jpg") {
								$logoName = date('His').$fileLogo['name'];
								
								$full_logo_path = $uploadPath . 'original/' . $logoName;
								if (move_uploaded_file($fileLogo['tmp_name'], $full_logo_path)) {
									$data['logo'] = $logoName;
									$this->request->data['Group']['logo'] = $data['logo'];
									 
									$source_image = $uploadPath.'original/'.$data['logo'];
									$destination_logo_path = $uploadPath.'logo/'.$data['logo'];
									$this->__imageresize($source_image, $destination_logo_path, 100, 100);
																	
									$destination_thumb_path = $uploadPath.'thumbnail/'.$data['logo'];
									$this->__imageresize($source_image, $destination_thumb_path, 100, 100);
									
									$destination_icon_path = $uploadPath.'icon/'.$data['logo'];
									$this->__imageresize($source_image, $destination_icon_path, 60, 60);
								} 
								else {
									$mesg = "There was a problem uploading Logo. Please try again";
									$error = 1;
								}
							}
							else {
				
								$mesg = "Unacceptable Logo type";
								$error = 1;
							}
						}
						
					if ($imageName == '') {
						if($image) {
						$this->request->data['Group']['image'] = $image;
						}
						else {
							$this->request->data['Group']['image'] = '';
						}
					}
					if ($logoName == '') {
						$this->request->data['Group']['logo'] = $logo;
					}
					
				if ($error == 0) {
						
						if ($groupid != '') {
							$this->Group->id = $groupid;
							if ($this->Group->save($this->request->data)) {
								$mesg = "Group has been updated successfully";
								$this->Session->setFlash($mesg,'success_msg');
							$this->redirect(array('controller'=>'groups','action'=>'index'));
							}
						}
						elseif ($this->Group->save($this->request->data)) {
							$group_id = $this->Group->getInsertID();
							$this->loadModel('Users_following');
							$this->request->data = '';
							$this->request->data['Users_following']['following_id'] = $group_id;
							$this->request->data['Users_following']['user_id'] = $uid;
							$this->request->data['Users_following']['following_type'] = "groups";
							$this->request->data['Users_following']['status'] = 2;
							$created_date = date("Y-m-d H:i:s");
							$this->request->data['Users_following']['start_date'] = $created_date;
							if ($this->Users_following->save($this->request->data)) {
								$mesg = "Group has been created successfully";
								$this->Session->setFlash($mesg,'success_msg');
							$this->redirect(array('controller'=>'groups','action'=>'index'));
							}
						}
						else {
								echo "data not saved";
								exit;
						}
					}
					else {
						$this->Session->setFlash($mesg,'error_msg');
						$this->redirect(array('controller'=>'groups','action'=>'add',$groupid));	
					}
					
			}
	}
	public function jobs() {
		
		
		$paramenter = $this->request->params['pass'];
		$groupid = $paramenter[0];
		
		if ($groupid != '') {
			$this->set('groupid',$groupid);
			if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$this->set('uid',$uid);
			}
			/*Group Detail*/
					$groupDetail = ClassRegistry::init('groups')->find('first',array('fields' =>array('
																									groups.id,
																									groups.title,
																									groups.logo,
																									groups.user_id,
																									groups.created,
																									groups.group_mode,
																									groups.joining_mode,
																									groups_types.title
																									'),
																				   'joins' => array(
																									array('alias' => 'groups_types',
																										  'table' => 'groups_types', 
																										  'type' => 'left',
																										  'foreignKey' => false,
																										  'conditions' => array('groups.group_type_id = groups_types.id'
																																)
																										  )
																									),
																				   'conditions' => array('groups.id'=>$groupid)
																							)
																	   );	
			$this->set('groupDetail',$groupDetail);
			$this->loadModel('Users_following');
			$users_following_thisGroup = $this->Users_following->find('all',array(
																				  'conditions'=>array('Users_following.following_id='.$groupid.' AND Users_following.following_type ="groups"')));
			foreach ($users_following_thisGroup as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid && $user_follow_page['Users_following']['following_id'] == $groupid) {
				$user_group_id = $user_follow_page['Users_following']['id'];
				$status = $user_follow_page['Users_following']['status'];
				}
				
			}
			$this->set('user_group_id',$user_group_id);
			$this->set('status',$status);
			$this->set('users_following_thisGroup',sizeof($users_following_thisGroup));
			
			$count_following_thisGroup = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$groupid.'
												AND Users_following.following_type="groups" AND Users_following.status=2')));
			$this->set('count_following_thisGroup',sizeof($count_following_thisGroup));
			/*to check current user for updation of this group*/
			$check_user_ToGroup = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$groupid.' AND Users_following.user_id='.$uid.' 
												AND Users_following.following_type="groups" AND Users_following.status=2')));
			
			$this->set('check_user_ToGroup',sizeof($check_user_ToGroup));
			/*groups updates listing start*/
			
			$users_following_group = $this->Users_following->find('all',array('fields'=>array('
																							  Users_following.user_id,
																							  users_profiles.firstname,
																							  users_profiles.lastname, users_profiles.photo,
																							  users_profiles.handler,
																							  users_profiles.tags,groups.user_id,
																							  Users_following.start_date
																							  '),
																			  'order'=>'Users_following.id DESC',
																			  'joins' => array(
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('Users_following.user_id = users_profiles.user_id'
																														   )
																									 ),
																							   array('alias' => 'groups',
																									 'table' => 'groups',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('Users_following.following_id = groups.id'
																														   )
																									 )
																							   ),
																			  'conditions'=>array('Users_following.following_id='.$groupid.' AND Users_following.following_type="groups"'
																								  )
																			  )
																  );
	
			$this->set('users_following_group',$users_following_group);
			
			$this->loadModel('Company');
			$this->loadModel('Job');
			$this->loadModel('jobs_group');
					
			
			$this->jobs_group->bindModel(array('belongsTo'=>array('Group'=>array('foreignKey'=>false,'conditions'=>array('jobs_group.group_id=Group.id')),'Job'=>array('foreignKey'=>false,'fields'=>array('Job.id,Job.company_id,Job.title,Job.city,Job.country_id,Job.modified'),'conditions'=>array('jobs_group.job_id=Job.id')),'Company'=>array('foreignKey'=>false,'type'=>'LEFT','fields'=>array('Company.id,Company.logo'),'conditions'=>array('Job.company_id=Company.id')))));
			$conditions = array('jobs_group.group_id'=>$groupid);
			$this->paginate = array('conditions'=>$conditions,'order'=>'Job.modified desc', 'limit'=>10);
			
			$this->set('data',$this->paginate('jobs_group'));
			
			 
				}
			
			
			
			
	}
	
		public function view() {
		$paramenter = $this->params['pass'];
		$groupid = $paramenter[0];
		$this->loadModel('Entity_update');
		if ($groupid) {
			$this->set('groupid',$groupid);
			if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$this->set('uid',$uid);
			}
			$groupDetail = ClassRegistry::init('groups')->find('first',array('fields' =>array('
																							groups.id,
																							groups.title,
																							groups.logo,
																							groups.user_id,
																							groups.created,
																							groups.group_mode,
																							groups.joining_mode,
																							groups.summary,
																							groups.image,
																							groups.description,
																							groups.status,
																							groups.weburl,
																							countries.name,
																							groups_types.title,
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.handler
																							'),
																		   'joins' => array(
																							array('alias' => 'countries',
																								  'table' => 'countries',
																								  'type' => 'left',
																								  'foreignKey' => false,
																								  'conditions' => array('groups.country_id = countries.id'
																														)
																								  ),
																							array('alias' => 'groups_types',
																								  'table' => 'groups_types',
																								  'type' => 'left',
																								  'foreignKey' => false,
																								  'conditions' => array('groups.group_type_id = groups_types.id'
																														)
																								  ),
																							array('alias' => 'users_profiles',
																								  'table' => 'users_profiles',
																								  'type' => 'left',
																								  'foreignKey' => false,
																								  'conditions' => array('groups.user_id = users_profiles.user_id'
																														)
																								  )
																							),
																		   'conditions' => array('groups.id'=>$groupid)
																		   )
															   );	
			$this->set('groupDetail',$groupDetail);
			$this->loadModel('Users_following');
			$users_following_thisGroup = $this->Users_following->find('all',array('
																				  conditions'=>array('Users_following.following_id='.$groupid.' AND 
																									 Users_following.following_type ="groups"'
																									 )
																				  )
																	  );
			
			foreach ($users_following_thisGroup as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid && $user_follow_page['Users_following']['following_id'] == $groupid) {
						$user_group_id = $user_follow_page['Users_following']['id'];
						$status = $user_follow_page['Users_following']['status'];
				}
				
			}

			$this->set('user_group_id',$user_group_id);
			$this->set('status',$status);
			$this->set('users_following_thisGroup',sizeof($users_following_thisGroup));
			
			$count_following_thisGroup = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$groupid.'
												AND Users_following.following_type="groups" AND Users_following.status=2')));
			$this->set('count_following_thisGroup',sizeof($count_following_thisGroup));
			/*to check current user for updation of this group*/
			$check_user_ToGroup = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$groupid.' AND Users_following.user_id='.$uid.' 
												AND Users_following.following_type="groups" AND Users_following.status=2')));
			
			$this->set('check_user_ToGroup',sizeof($check_user_ToGroup));
			/*groups updates listing start*/

			$group_updates = $this->Entity_update->find('all',array('fields'=>array('
																					Entity_update.id,
																					Entity_update.image,
																					Entity_update.group_title,
																					Entity_update.entity_type,
																					Entity_update.update_text,
																					Entity_update.user_id,
																					Entity_update.created,
																					users_profiles.firstname,
																					users_profiles.lastname,
																					users_profiles.tags,
																					users_profiles.handler,
																					users_profiles.photo
																					'),
																	'joins'=>array(array('alias' => 'users_profiles',
																						 'table' => 'users_profiles',
																						 'foreignKey' => false,
																						 'conditions'=>array('Entity_update.user_id=users_profiles.user_id'
																											 )
																						 ),
																				   array('alias' => 'users_followings',
																						 'table' => 'users_followings',
																						 'foreignKey' => false,
																						 'conditions'=>array('Entity_update.entity_id=users_followings.following_id AND users_followings.following_type="groups"'
																											 )
																						 )
																				   ),
																	'conditions'=>array('Entity_update.entity_id ='.$groupid.' AND (Entity_update.entity_type="groups" OR Entity_update.entity_type="news")'),
																	'order'=>'Entity_update.id DESC','group'=>'Entity_update.id'));	
														  
			$this->set('group_updates',$group_updates);
			
			 $user_comments = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('
																									   entity_comments.created,
																									   entity_comments.comments,
																									   entity_comments.content_id,
																									   entity_comments.id,
																									   entity_comments.user_id,
																									   entity_updates.group_title, 
																									   users_profiles.firstname,
																									   users_profiles.lastname,
																									   users_profiles.photo,
																									   users_profiles.handler
																									   '),
																					   'order'=>'entity_comments.id DESC',
																					   'joins' => array(
																										array('alias' => 'entity_updates',
																											  'table' => 'entity_updates',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('entity_comments.content_id = entity_updates.id'
																																	)
																											  ),
																										array('alias' => 'users_profiles',
																											  'table' => 'users_profiles',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('entity_comments.user_id = users_profiles.user_id'
																																	)
																											  )
																										),
																					   'conditions'=>array('entity_comments.content_type="groups" AND entity_updates.entity_id='.$groupid
																										   )
																					   )
																		   );
			 $this->set('user_comments',$user_comments);
			 
			 $likes_on_Update = ClassRegistry::init('likes')->find('all', array('fields'=>array('likes.*'),
																								'order'=>'likes.id DESC',
																								'conditions'=>array('likes.content_type="groups"')));

				$this->set('likes_on_Update',$likes_on_Update);

				}
			
					/*who likes on update*/
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							likes.content_id,
																							likes.user_id
																							'),
																				   'order'=>'likes.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('likes.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('likes.content_type="groups" AND likes.like=1')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
		/*who share an update*/
		$shareOnUpdates = $this->Entity_update->find('all', array('fields'=>array('
																					users_profiles.firstname,
																					users_profiles.lastname,
																					users_profiles.photo,
																					users_profiles.tags,
																					users_profiles.user_id,
																					Entity_update.share
																					'),
																  'order'=>'Entity_update.id DESC',
																  'joins'=> array(
																				 array(
																					   'alias'=> 'users_profiles',
																					   'table'=> 'users_profiles',
																					   'foreignKey'=> false,
																					'conditions'=> array('Entity_update.user_id = users_profiles.user_id'
																									  ))),
																  'conditions'=>array('Entity_update.entity_type="groups" AND Entity_update.share !=0')
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
			
			
			/*Count comments individually*/
		$updates_comments_count= ClassRegistry::init('entity_comments')->find('all', array('fields' => array(
																				'entity_comments.content_id,count(entity_comments.content_id) as commenttotal'),
										'conditions'=>array('entity_comments.content_type="groups"'),'order'=>'entity_comments.id DESC','group'=>'entity_comments.content_id'));

	$this->set('updates_comments_count',$updates_comments_count);
				/*Group update posting*/
			if ($this->request->is('post')){
				$error = 0;
				$uid = $this->request->data['Entity_update']['user_id'];
				$group_title = $this->request->data['Entity_update']['group_title'];
				$this->request->data['Entity_update']['share_with'] = $this->request->data['Entity_update']['share_with'];
				
				if(!empty($this->request->data['Entity_update']['link_content'])){
					$txt = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $this->request->data['Entity_update']['update_text']);
					
					$this->request->data['Entity_update']['update_text'] = $txt.'<div class="clear"></div>'.$this->request->data['Entity_update']['link_content'];
				}else{
					$this->request->data['Entity_update']['update_text'] = $this->request->data['Entity_update']['update_text'];
				}
				$this->request->data['Entity_update']['user_id'] = $this->request->data['Entity_update']['user_id'];
				$this->request->data['Entity_update']['entity_id'] = $this->request->data['Entity_update']['entity_id'];
				$this->request->data['Entity_update']['group_title'] = $this->request->data['Entity_update']['title_group'];
				$this->request->data['Entity_update']['entity_type'] = "groups";
				$this->request->data['Entity_update']['created'] = date("Y-m-d H:i:s");

				$entity_id = $this->request->data['Entity_update']['entity_id'];
				/*file uploading*/
				$filename = $this->request->data['Entity_update']['image'];
				$this->request->data['Entity_update']['image'] = $filename['name'];
				$photo = $this->request->data['Entity_update']['image'];
				$imagename = $filename['name'];
				$typess = $filename['type'];
				
				$imageTypes = array("image/gif", "image/jpeg", "image/png","image/jpg");
				
				$uploadFolder = "files/update/original/";
				$uploadPath = MEDIA_PATH . $uploadFolder;
				 if ($filename['name'] != '') {
						if ($filename['type'] == 'image/gif' || $filename['type'] == 'image/png' || $filename['type'] == 'image/jpg'|| $filename['type'] == 'image/jpeg') {
							$imageName = $filename['name'];
							if (file_exists($uploadPath . '/' . $imageName)) {
							$imageName = date('His') . $imageName;
							}
							$full_image_path = $uploadPath . '/' . $imageName;
							
							if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
							 $data['image'] = $this->request->data['Entity_update']['image'];
							 $this->request->data['Entity_update']['image'] = $data['image'];
							} 
							else {
								echo "problem";
								$this->Session->setFlash('There was a problem uploading file. Please try again.','error_msg');
							}
						}
						else {
							$mesg = "Unacceptable file type";
							$error = 1;
						}
				 }
					
					if ($error == 0) {
						if ($this->Entity_update->save($this->request->data)) {
							$lastid = $this->Entity_update->getInsertID();
							$this->request->data['likes']['content_type'] = 'groups';
							$this->request->data['likes']['created'] = date("Y-m-d H:i:s");
							$this->request->data['likes']['like'] = 0;
							$this->request->data['likes']['user_id'] = $uid;
							$this->request->data['likes']['content_id'] = $lastid;
							if (ClassRegistry::init('likes')->save($this->request->data)) {
								$mesg = "Your update has been posted successfully";
								$this->Session->setFlash($mesg,'success_msg');
								$this->redirect(array('controller' => 'groups', 'action' => 'view',$entity_id,$group_title));
							}
						
						}
						else {
							echo "not saved";
							$mesg = "File not saved";
							$this->Session->setFlash($mesg,'error_msg');
							$this->redirect(array('controller' => 'groups', 'action' => 'view',$entity_id,$group_title));
						}
					}
					else {
							$this->Session->setFlash($mesg,'error_msg');
							$this->redirect(array('controller' => 'groups', 'action' => 'view',$entity_id,$group_title));
					}
			} // post end here
			
	}
	
	   /*add comments to group discussion*/
	public function add_comments() {
		if ($this->request->is('post')) {
			$user_id = $_POST['user_id'];
			$content_id = $_POST['content_id'];
			$comment_text = $_POST['comments'];
			$created_date = date("Y-m-d H:i:s");
			$company_admin_id = $_POST['admin_id'];
			$this->request->data['entity_comments']['user_id'] = $user_id;
			$this->request->data['entity_comments']['content_type'] = "groups";
			$this->request->data['entity_comments']['content_id'] = $content_id;
			$this->request->data['entity_comments']['created'] = $created_date;
			$this->request->data['entity_comments']['modified'] = $created_date;
			$this->request->data['entity_comments']['comments'] = $comment_text;
			if (ClassRegistry::init('entity_comments')->save($this->request->data)){
				//$last_comment_id = $this->Comment->getInsertID();
				$comments_this_groups = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('
																												 entity_comments.comments,
																												 entity_comments.id,
																												 entity_comments.user_id,
																												 entity_comments.created,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler
																												 '),
																								 'joins'=>array(
																												array('alias' => 'users_profiles',
																													  'table' => 'users_profiles',
																													  'type' => 'left',
																													  'foreignKey' => false,
																													  'conditions' => array('entity_comments.user_id = users_profiles.user_id'
																																			)
																													  )
																												),
																								 'conditions'=>'entity_comments.content_id='.$content_id.' AND entity_comments.content_type="groups"'
																								 )
																					 );
				$this->set('comments_this_groups',$comments_this_groups);
				$this->set('total_commentsOnUpdate',sizeof($comments_this_groups));
				$this->set('company_admin_id',$company_admin_id);
				$this->set('content_id',$content_id);
			}
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('add_comments');
	}
	
		public function delete_update() {
		if ($this->request->is('get')) {
			$update_id = $_GET['update_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM entity_updates WHERE id=".$update_id);
			$db->rawQuery("DELETE FROM likes WHERE content_id=".$update_id.' AND content_type= "groups"');
			$db->rawQuery("DELETE FROM entity_comments WHERE content_id=".$update_id.' AND content_type= "groups"');
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_update');
		}
		
	}
	public function delete_comment() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM entity_comments WHERE id=".$comment_id.' AND content_type= "groups"');
			$comments_this_company = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('entity_comments.content_id
																												  '),
																	 'conditions'=>array('entity_comments.content_id='.$content_id.' AND entity_comments.content_type="groups"')
																	 )
																				  );
			echo $total_comments = sizeof($comments_this_company);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_update');
		}
		
	}
	
	public function members() {
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$this->set('uid',$uid);
			}
		if ($this->params['pass']) {
		$paramenter = $this->params['pass'];
		$groupid = $paramenter[0];
			if ($groupid) {
				
					/*Group Detail*/
					$groupDetail = ClassRegistry::init('groups')->find('first',array('fields' =>array('
																									groups.id,
																									groups.title,
																									groups.logo,
																									groups.user_id,
																									groups.created,
																									groups.group_mode,
																									groups.joining_mode,
																									groups_types.title
																									'),
																				   'joins' => array(
																									array('alias' => 'groups_types',
																										  'table' => 'groups_types', 
																										  'type' => 'left',
																										  'foreignKey' => false,
																										  'conditions' => array('groups.group_type_id = groups_types.id'
																																)
																										  )
																									),
																				   'conditions' => array('groups.id'=>$groupid)
																							)
																	   );	
			$this->set('groupDetail',$groupDetail);
			/*count user followed this company*/
			$this->loadModel('Users_following');
			$count_following_thisGroup = $this->Users_following->find('all',array('conditions'=>array('
																									  Users_following.following_id='.$groupid.' AND Users_following.following_type ="groups" AND Users_following.status=2'
																									  )
																				  )
																	  );
			$this->set('count_following_thisGroup',sizeof($count_following_thisGroup));
			
			$users_following_thisGroup = $this->Users_following->find('all',array('conditions'=>array('Users_following.following_id='.$groupid.' AND 
																									 Users_following.following_type ="groups"'
																									 )
																				  )
																	  );
						
			
		 foreach ($users_following_thisGroup as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid && $user_follow_page['Users_following']['following_id'] == $groupid) {
						$user_group_id = $user_follow_page['Users_following']['id'];
						$status = $user_follow_page['Users_following']['status'];
				}
				
			}

			$this->set('user_group_id',$user_group_id);
			$this->set('status',$status);
			$this->set('users_following_thisGroup',sizeof($users_following_thisGroup));
			
		/*Group followed by users*/
		
					$group_members = $this->Users_following->find('all',array('fields'=>array('
																							  Users_following.id,
																							  users_profiles.firstname,
																							  users_profiles.lastname,
																							  users_profiles.photo,
																							  users_profiles.user_id,
																							  users_profiles.handler,
																							  users_profiles.tags
																									  '),
																			  'joins'=>array(
																							 array('alias' => 'users_profiles',
																								   'table' => 'users_profiles',
																								   'foreignKey' => false,
																								   'conditions'=>array('Users_following.user_id = users_profiles.user_id'
																													   )
																								   )
																							 ),
																			  'conditions'=>array('Users_following.following_id ='.$groupid.' AND (Users_following.following_type="groups" AND Users_following.status=2)'),
																			  'order'=>'Users_following.id DESC'
																			  )
																  );	
														  
			$this->set('group_members',$group_members);
			
					/*Group User in pending status for the group*/
		
					$group_members_approve = $this->Users_following->find('all',array('fields'=>array('
																									  Users_following.id,
																									  Users_following.user_id,
																									  users_profiles.firstname,
																									  users_profiles.lastname,
																									  users_profiles.photo,
																									  users_profiles.user_id,
																									  users_profiles.handler,
																									  users_profiles.tags
																									  '),
																					  'joins'=>array(
																									 array('alias' => 'users_profiles',
																										   'table' => 'users_profiles',
																										   'foreignKey' => false,
																										   'conditions'=>array('Users_following.user_id = users_profiles.user_id')
																										   )
																									 ),
																					  'conditions'=>array('Users_following.following_id ='.$groupid.' AND (Users_following.following_type="groups" AND Users_following.status=1)'),
																					  'order'=>'Users_following.id DESC'
																					  )
																		  );	
														  
			$this->set('group_members_approve',$group_members_approve);
			
			}

		}
	}
	
	public function approve_for_joining() {
		if ($this->request->is('post')) {
			$paramenter = $this->params['pass'];
			$groupid = $paramenter[0];
			$this->loadModel('Users_following');
			$member_id = $this->request->data['Users_following']['member_id'];
			$group_title = $this->request->data['Users_following']['group_title'];
			$this->request->data['Users_following']['following_type'] = "groups";
			$this->request->data['Users_following']['status'] = 2;
			$created_date = date("Y-m-d H:i:s");
			$this->request->data['Users_following']['start_date'] = $created_date;
			$this->Users_following->id = $member_id;
			if ($this->Users_following->save($this->request->data)) {
				$message = "Member hase been approved sucessfully";
			$this->redirect(array('controller'=>'groups','action'=>'members',$groupid,$group_title,'mesg'=>$message));
			}
			else {
				
				echo "Member not approved";
				exit;
			}
		}
	}
	
			/****Follow the group//***/
	public function follow_group(){
		$this->loadModel('Users_following');
		if ($this->request->is('post')) {
			$status = $_POST["status"];
			$user_id = $_POST["user_id"];
			$group_id = $_POST["group_id"];
			$user_follow_id = $_POST["user_follow_id"];
			$find_following_companies = $this->Users_following->find('all',array('conditions' => array(
							  'Users_following.user_id='.$user_id.' AND Users_following.following_type="groups" AND Users_following.following_id='.$group_id)));
			//print_r($find_following_companies);
			if ($user_follow_id != '') {
				if($this->Users_following->updateAll(array('Users_following.status' =>$status), array('Users_following.id' => $user_follow_id))) {
					
					$this->set('status',$status);
					$this->set('user_follow_id',$user_follow_id);
					$this->set('uid',$user_id);
					$this->set('group_id',$group_id);
				}
				else {
				echo "not updated";
				}
			}
			else {
				$date_to_created = date("Y-m-d H:i:s");
				$this->request->data['Users_following']['user_id'] = $user_id;
				$this->request->data['Users_following']['following_id'] = $group_id;
				$this->request->data['Users_following']['following_type'] = "groups";
				$this->request->data['Users_following']['status'] = $status;
				$this->request->data['Users_following']['start_date'] = $date_to_created;
				if ($this->Users_following->save($this->request->data)) {
					$user_follow_id = $this->Users_following->getInsertID();
					$this->set('status',$status);
					$this->set('user_follow_id',$user_follow_id);
					$this->set('uid',$user_id);
					$this->set('group_id',$group_id);
				}
				
			}
			$total_following_groups = $this->Users_following->find('all',array('conditions' => array(
							  'Users_following.following_type="groups" AND Users_following.following_id='.$group_id.' AND Users_following.status=2')));
			$this->set('total_following_groups',sizeof($total_following_groups));
	  }
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('follow_group');
	}		
	
	/*Search Group by Ajax while typing group name*/
	
	public function group_search() {
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
		}
		if ($this->request->is('get')) {
					//$this->loadModel('Users_profile');
					$search_str = $_GET['search_str'];
					if ($search_str) {
						
						$search_Result_Groups = ClassRegistry::init('groups')->find('all',array('fields'=>array('groups.title, groups.id,groups.user_id'),
																								'joins'=>array(
																					 	array('alias' => 'users_followings', 'table' => 'users_followings', 'foreignKey' => false,
																						   			'conditions'=>array('users_followings.following_id = groups.id'))),
																									'limit'=>10,'order'=>'groups.id DESC','group'=>'users_followings.following_id',
																									'conditions'=>array('groups.title LIKE '=>'%'.$search_str.'%',
																							   'users_followings.user_id='.$uid.' AND users_followings.following_type="groups"')));
					}
		}
		$this->set('search_Result_Groups',$search_Result_Groups);
		$this->autorender = false;
		$this->layout = false;
		$this->render('group_search');
		
	}
	public function Updatedelete() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$group__ID = $paramenter[1];
			$update__ID = $paramenter[0];
			if ($update__ID !=0) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM entity_updates WHERE id=".$update__ID);

				$this->redirect(array('controller'=>'groups','action'=>'view',$group__ID));
			}
	}
	public function delete() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$group__ID = $paramenter[0];
			if ($group__ID !=0) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM groups WHERE id=".$group__ID);
				$db->rawQuery("DELETE FROM users_followings WHERE following_id=".$group__ID." AND following_type='groups'");
				$db->rawQuery("DELETE FROM entity_updates WHERE entity_id=".$group__ID." AND share_with='groups'");
				$mesg = "Your Group deleted successfully";
				$this->Session->setFlash($mesg,'success_msg');
				$this->redirect(array('controller'=>'groups','action'=>'search'));
			}
	}
	
   public function share() {
		$uid = @$this->userInfo['users']['id'];
	
		if ($uid) {

			
		if ($this->request->is('post')) {
			$share = $this->request->data['user_share'];
			$orignaltext = $this->request->data['update_text'];
			$sharetext = $this->request->data['share_text'];
			$updatedText = $orignaltext;
				if ($sharetext) {
					$updatedText .= "<br />".$sharetext;
				}
			$groupid = $this->request->data['entity_id'];
			$this->request->data['Entity_update']['share_with'] = $this->request->data['share_with'];
			$this->request->data['Entity_update']['update_text'] = $updatedText;
			$this->request->data['Entity_update']['user_id'] = $this->request->data['user_id'];
			$this->request->data['Entity_update']['entity_type'] = $this->request->data['content_type'];
			$this->request->data['Entity_update']['image'] = $this->request->data['photo'];
			$this->request->data['Entity_update']['share'] = $share;
			$this->request->data['Entity_update']['created'] = $this->request->data['comment_date'];
			$this->request->data['Entity_update']['entity_id'] = $this->request->data['entity_id'];
			//$this->request->data['Statusupdate']['share_date'] = date("d-m-Y");
			//$this->request->data['shares']['share'] = $share;
			$this->loadModel('Entity_update');
			if (ClassRegistry::init('Entity_update')->save($this->request->data)) {
				$lastid = $this->Entity_update->getInsertID();
					$this->request->data['likes']['content_type'] = 'groups';
					$this->request->data['likes']['created'] = date("Y-m-d H:i:s");
					$this->request->data['likes']['like'] = 0;
					$this->request->data['likes']['user_id'] = $uid;
					$this->request->data['likes']['content_id'] = $lastid;
					if (ClassRegistry::init('likes')->save($this->request->data)) {
						
						$mesg = "Re-shared your Update Successfully";
						$this->Session->setFlash($mesg,'success_msg');
						$this->redirect(array('controller' => 'groups', 'action' => 'view',$groupid));
					}
				
				}
			}
		}

	}
}
