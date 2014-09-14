<?php 
App::uses('AppModel', 'Model');
App::uses('Job', 'Model');
App::uses('User_profile_strength', 'Model');
class Sidebar extends AppModel {

	public $useTable = false;
	public $displayField = 'title';
	
	function yourBirthDayMessages($uid) {
		
	$your_birthday_message = ClassRegistry::init('users_messages')->find('all',array('fields'=>array('
																									 users_messages.user_id,
																									 users_messages.friend_id
																									 '),
																					 'conditions'=>array('users_messages.subject_type="birthday" AND users_messages.created >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND users_messages.user_id='.$uid)
																					 )
																		 );	
	return $your_birthday_message;
	}
	
	function usersHaveBirthdays($friends_Lists) {
		
		if ($friends_Lists) {
			$friends_Lists = @implode(',',$friends_Lists);

                        $currentdate = date("-m-d");
                        $currentdate = "'".$currentdate."'";

                        $commingdate = date("-m-d",strtotime("+10 day"));
                        $commingdate = "'".$commingdate."'";
                        $user_birthday = ClassRegistry::init('users_profiles')->find('all',array('fields'=>array('
																													   users_profiles.birth_date,
																													   DAYOFYEAR(users_profiles.birth_date) - DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, "%Y-%m-%d")),"'.$currentdate.'")) as numDays,
																													   users_profiles.firstname,
																													   users_profiles.lastname,
																													   users_profiles.tags,
																													   users_profiles.photo,
																													   users_profiles.city,
																													   users_profiles.user_id
																													   '),
                                                                                                                                                                                   'conditions'=>array(array('users_profiles.user_id IN ('.$friends_Lists.')'),'DAYOFYEAR(users_profiles.birth_date) >= DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, "%Y-%m-%d")),"'.$currentdate.'")) AND DAYOFYEAR(users_profiles.birth_date) < DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, "%Y-%m-%d")),"'.$commingdate.'"))'),
																																												   'order'=>'DAYOFYEAR(users_profiles.birth_date) - DAYOFYEAR(CONCAT(YEAR(STR_TO_DATE(users_profiles.birth_date, "%Y-%m-%d")),"'.$currentdate.'")) ASC' ));
		}
						
	return $user_birthday;
		
	}
	
	function usersBirthdayMessages() {
		
	$user_birthday_message = ClassRegistry::init('users_messages')->find('all',array('fields'=>array('
																										   users_messages.user_message,
																										   users_messages.user_id,
																										   users_messages.friend_id,
																										   users_messages.created,
																										   users_profiles.firstname,
																										   users_profiles.lastname,
																										   users_profiles.photo,
																										   users_profiles.user_id
																											'),
																						   'joins'=>array(
																								  array('alias' => 'users_profiles',
																										'table' => 'users_profiles',
																										'type' => 'left',
																										'foreignKey' => false,
																										'conditions' => array('users_messages.user_id  = users_profiles.user_id'
																														  )
																										)
																								 ),
																			
																		'conditions'=>array('users_messages.subject_type="birthday" AND users_messages.created >= DATE_ADD(CURDATE(), INTERVAL -10 DAY)')
																						));	
	return $user_birthday_message;
	}


	function userRelatedJobs($user_country_id,$city) {
		$Job = new Job();
			//$this->loadModel('Job');
			
			//$this->loadModel('Country');
			
		$user_Job_List = $Job->find("all", array(
			"fields" => array(
							  "Job.title,
							  Job.id,
							  Job.city,
							  Job.created,
							  Job.modified,
							  countries.name,
							  companies.logo,
							  companies.id"
							  ),
			"joins" => array(
				array(
					"table" => "countries",
					"alias" => "countries",
					"type" => "LEFT",
					"conditions" => array(
						"Job.country_id = countries.id"
					)
				),
				array(
					"table" => "companies",
					"alias" => "companies",
					"type" => "LEFT",
					"conditions" => array(
						"Job.company_id = companies.id"
					)
				)),
				'conditions' => array('OR'=>
									 array(
										 'Job.country_id' => $user_country_id,
										 'Job.city LIKE' => "%$user_city%"
										 )
								)
		));
		
		return $user_Job_List;
	}
	
	
	function getCloseUserFriends($uid,$friendList,$user_city='') {
		if ($friendList) {	
			$friendLists = @implode(',',$friendList).','.$uid;
			for ($i=0; $i<sizeof($friendList); $i++) {
				$user_friends_of_friends = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																								'joins' => array(array(
																													'alias' => 'User',
																													'table' => 'users',
																													'type' => 'LEFT',
																													'foreignKey' => false,
																													'conditions' => '`User.id` = `connections.friend_id`'
																														)
																												),
																								'conditions'=>array("((connections.user_id=".$friendList[$i]." AND connections.friend_id NOT IN(".$friendLists.") ) OR (connections.friend_id=".$friendList[$i]." AND connections.user_id NOT IN(".$friendLists.") )) AND connections.request !=0 AND User.role_id=1 AND User.status>0")));
				if ($user_friends_of_friends !=''){
					foreach ($user_friends_of_friends as $row) {
						$row['connections']['friend_id'];
						if (!in_array($row['connections']['friend_id'],$friendList)){
							$firend_listTotal[] = $row['connections']['friend_id'];
						}else if (!in_array($row['connections']['user_id'],$friendList)) 
						{
							$firend_listTotal[] = $row['connections']['user_id'];
						}
					
					}
				}
			}

			/*profiles for user you may know*/
				$firend_listTotal = @implode(',',$firend_listTotal);
				if ($firend_listTotal) {
					$user_you_may_know = ClassRegistry::init('users_profiles')->find('all',
																					 array('limit'=>3,
																						   'fields'=>array('
																										   users_profiles.firstname,
																										   users_profiles.lastname,
																										   users_profiles.photo,
																										   users_profiles.user_id,
																										   users_profiles.tags
																										   '),
																						   'conditions'=>array(array('users_profiles.user_id IN ('.$firend_listTotal.')'),
																																				 'users_profiles.user_id !='.$uid,
																																				 'users_profiles.firstname !='."''"
																																				 )
																						   )
																					 );
				}

			return $user_you_may_know;
			
		}
	}
	
	function getConnectionsStatus($uid) {
		$uers_connections_status = ClassRegistry::init('connections')->find('all',array('fields'=>array('
																										connections.friend_id,
																										connections.user_id,
																										connections.request'),
																						'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.')'
																											  )
																						)
																			);
		return $uers_connections_status;
	}
	
	
		function get_viewed_profiles($uid) {
		
		$profile_view_users = ClassRegistry::init('users_viewings')->find('all',array('fields'=>array('
																									   users_profiles.firstname,
																									   users_profiles.lastname,
																									   users_profiles.photo,
																									   users_profiles.tags,
																									   users_profiles.user_id,
																									   users_profiles.handler,
																									   users_viewings.start_date,
																									   users.id,
																									   users.role_id,
																									   users.status
																									   '),
																					  'limit'=>3,
																					  'order'=>'DAYOFYEAR(users_viewings.start_date) DESC',
																					    'joins' => array(
																									   array('
																										alias' => 'users_profiles',
																										'table' => 'users_profiles',
																										'type' => 'left',
																										'foreignKey' => false,
																										'conditions' => array('users_viewings.user_id = users_profiles.user_id')
																										),
																										array('
																												alias' => 'users',
																												'table' => 'users',
																												'foreignKey' => false,
																												'type' => 'LEFT',
																												'conditions' => array('users_viewings.user_id = users.id')
																										)
																								  ),
																						'conditions'=>array('users_viewings.viewings_id='.$uid.' AND 
																										   users_viewings.viewings_type="profile" AND users.status>0 AND users.role_id=1'
																										   )
																					   )
																		   );
			return $profile_view_users;

	}
	
	function get_total_viewed_profiles($uid) {
		
		$total_people_profile_viewed = ClassRegistry::init('users_viewings')->find('all',array('fields'=>array('
																									   users_viewings.id
																									   '),
																						'conditions'=>array('users_viewings.viewings_id='.$uid.' AND 
																										   users_viewings.viewings_type="profile"'
																										   )
																					   )
																		   );
			$total_views = sizeof($total_people_profile_viewed);
			return $total_views;

	}
	
	function getUserProfileStrength($uid) {

		$User_profile_strength = new User_profile_strength();
		$profile_Strength_Results = $User_profile_strength->find("first", array("fields" => array("User_profile_strength.*"),
																										'conditions' => array('User_profile_strength.user_id' => $uid)));
		return $profile_Strength_Results;
	}
	
	
	function getRelatedCompanies($uid,$friendList,$user_city = '') {
		
		if ($friendList) {
			
			if (sizeof($friendList)>1) {	
				$firend_listTotal = @implode(',',$friendList);
			}
			else {
				
			$firend_listTotal = $friendList[0];
			}
			
			if ($firend_listTotal != '') {
			$companies_you_may_know = ClassRegistry::init('companies')->find('all',array('fields' => array('
																										   DISTINCT companies.id,
																										   companies.logo, companies.title,
																										   countries.name,
																										   users_followings.following_id,
																										   users_followings.id,
																										   industries.title
																										   '),
																						 'limit'=>9,
																						 'order'=>'companies.id DESC',
																						 'group' => 'users_followings.following_id',
																						 'joins' => array(
																										  array('alias' => 'countries',
																												'table' => 'countries',
																												'type' => 'left', 
																												'foreignKey' => false,
																												'conditions' => array('companies.country_id = countries.id'
																																	  )
																												),
																										  array('alias' => 'industries',
																												'table' => 'industries',
																												'type' => 'left',
																												'foreignKey' => false,
																												'conditions' => array('companies.industry_id = industries.id'
																																	  )
																												),
																										  array('alias' => 'users_followings',
																												'table' => 'users_followings',
																												'foreignKey' => false,
																												'conditions' => array('users_followings.following_id = companies.id AND users_followings.status=2'
											)
																												)
																										  ),
																						 'conditions' => array('users_followings.following_type = "company" AND users_followings.status=2 AND users_followings.user_id IN('.$firend_listTotal.') AND companies.flag = "page"'
																																																						  )
																						 )
																			 );
			}

		}

		return $companies_you_may_know;
	}
	
	
	function get_ur_following_company($uid) {
		$companies_followed_by_U = ClassRegistry::init('users_followings')->find('all',array('fields' => array('
																									 	users_followings.following_id,
																									   	users_followings.id'
																									   ),
																							 'group'=>'users_followings.following_id DESC',
																							'conditions'=>array('users_followings.following_type = "company" AND 
																												users_followings.user_id='.$uid)
																					 ));

		return $companies_followed_by_U;
																										   
		
	}
	
	public function getRelatedGroups($uid) {

		if ($uid) {
		
		/*get the current user skill to search intrested groups for him*/
		$user_had_skills = ClassRegistry::init('users_skills')->find('all',array('fields' =>array('
																								  users_skills.skill_id,
																								  users_skills.user_id,
																								  skills.title,
																								  skills.status
																								  '),
																				 'order'=>'users_skills.id DESC',
																				 'joins' => array(
																								  array('alias' => 'skills',
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
																										  groups_types.title,
																										  groups_types.id
																										  '),
																						 'limit'=>6,
																						 'order'=>'groups.id DESC',
																						 'joins' => array(
																										  array('alias' => 'groups_types',
																												'table' => 'groups_types',
																												'foreignKey' => false,
																												'conditions' => array('groups.group_type_id = groups_types.id'
																																	  )
																												)
																										  ),
																						 'conditions' => array('groups.title LIKE "%'.$skill_title.'%"'
																											   )
																						 )
																			 );
				
	
				
			}
		return $groups_you_may_know;
		}
	}
	
		public function getUserJoinedGroups($uid) {
			if ($uid) {
				/*just get the groups which user joined,, TO GET IDS from joined groups*/
			$groups_joined_by_you = ClassRegistry::init('users_followings')->find('all',array('fields' => array('
																												users_followings.status,
																												users_followings.following_id'
																												),
																							  'order'=>'users_followings.id DESC',
																							  'conditions' => array('
																													users_followings.following_type = "groups" AND  (users_followings.status=2 OR users_followings.status=1) AND users_followings.user_id='.$uid
																													)
																							  )
																				  );
			return $groups_joined_by_you;
			}
		}
		
		
			/* right sidebar for tweets*/
	 function tweets_networkwe($friendList,$uid) {
	
			if ($friendList) {
						$friendLists = @implode(',',$friendList);	
				}
				else {
						$friendLists = $uid;
				}
					if ($friendLists) {
						$get_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																										  tweets.tweet,
																										  tweets.user_id,
																										  tweets.id,
																										  tweets.photo,
																										  tweets.created,
																										  users_profiles.firstname,
																										  users_profiles.lastname,
																										  users_profiles.photo,
																										  users_profiles.user_id,
																										  users_profiles.handler
																										  '),
																						'order'=>'tweets.created DESC',
																						'limit' =>6,
																						'joins'=>array(	
																									   array('alias' => 'users_profiles',
																											 'table' => 'users_profiles',
																											 'type' => 'left', 'foreignKey' => false, 
																											 'conditions' => array('tweets.user_id = users_profiles.user_id'
																																   )
																											 )
																									   ),																																																															
																						'conditions'=>array(
																											array('tweets.user_id IN ('.$friendLists.')'),
																											'tweets.parent_id =0 AND tweets.status=2'),
																						'group'=>'tweets.id'
																						)
																		   );
						return $get_tweets;
		
					}
		
		
	}
	
	function tweets_retweeted() {
		
				$retweeted_tweets_by_user = ClassRegistry::init('tweets')->find('all',array('fields'=>array('
																							tweets.parent_id,
																							tweets.id,tweets.user_id,
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.handler,
																							users_profiles.user_id'
																							),
																			'joins'=>array(
																						   array('alias' => 'users_profiles',
																								 'table' => 'users_profiles',
																								 'type' => 'left',
																								 'foreignKey' => false,
																								 'conditions' => array('tweets.user_id = users_profiles.user_id'
																													   )
																								 )
																						   ),
																			'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2'
																								)
																			)
																);
				return $retweeted_tweets_by_user;
	}
	
	/* right sidebar for blogs*/
	
   function get_latest_posts() {
		
				$get_latest_posts_networkwe = ClassRegistry::init('blogs')->find('all',array('fields'=>array('
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
				return $get_latest_posts_networkwe;
	}
}