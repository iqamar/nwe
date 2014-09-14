<?php

App::uses('AppController', 'Controller');

class PublicesController extends AppController {

    public $name = 'Publices';
    var $uses = array('User', 'Users_profile', 'User_profile_strength');

    function beforeFilter() {
        parent::beforeFilter();

        //$this->Auth->allow(array('user_id', 'logout','add'));
        $this->Auth->allow();
    }

    public function index() {

        $x = $this->userInfo['users']['id'];
        if ($x) {
            $arr = $this->params['pass'];
            $profile_url = $arr[0];
            if ($profile_url) {
                $user_profile_data = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.handler=' . '"' . $profile_url . '"')));
                $user_record = $user_profile_data[0]['users_profiles'];
                $user_id = $user_record['user_id'];
                $user_profile_link = "pub profile-" . $user_id;
                $this->redirect(array('controller' => 'users_profiles', 'action' => 'userprofile', $user_id));
            }
        } else {
            $arr = $this->params['pass'];
            $profile_url = $arr[0];
            $this->set('profile_url', $profile_url);

            if (!empty($profile_url)) {
                $user_profile_data = ClassRegistry::init('users_profiles')->find('first', array('conditions' => array('users_profiles.handler=' . '"' . $profile_url . '"')));
                $user_record = $user_profile_data['users_profiles'];
                $id = $user_record['user_id'];
                //$this->loadModel('Country');
                $uers_p = ClassRegistry::init('users_profiles')->find('all', array('fields' => array(
                        'users_profiles.firstname',
                        'users_profiles.lastname',
                        'users_profiles.photo',
                        'users_profiles.handler',
                        'users_profiles.tags',
                        'users_profiles.user_id',
                        'users_profiles.hiring',
                        'users_profiles.avaliable',
                        'users_profiles.mobile',
                        'users_profiles.birth_date',
                        'users_profiles.summary',
                        'users_profiles.city',
                        'users.email',
                        'industries.title',
                        'countries.name',
                        'countries.id'
                    ),
                    'joins' => array(
                        array('alias' => 'users',
                            'table' => 'users',
                            'foreignKey' => false,
                            'type' => 'LEFT',
                            'conditions' => array('users_profiles.user_id = users.id'
                            )
                        ),
                        array('alias' => 'countries',
                            'table' => 'countries',
                            'foreignKey' => false,
                            'type' => 'LEFT',
                            'conditions' => array('users_profiles.country_id = countries.id')
                        ),
                        array('alias' => 'industries',
                            'table' => 'industries',
                            'foreignKey' => false,
                            'type' => 'LEFT',
                            'conditions' => array('users_profiles.industry_id = industries.id')
                        )
                    ),
                    'conditions' => array('users_profiles.user_id' => $id)
                        )
                );

                $uers_exp = ClassRegistry::init('users_experiences')->find('all', array('fields' => array('users_experiences.id','companies.id','companies.title'),
                    'joins' => array(
                        array('alias' => 'companies',
                            'table' => 'companies',
                            'foreignKey' => false,
                            'conditions' => array('users_experiences.company_id = companies.id'
                            )
                        )
                    ),
                    'conditions' => array('users_experiences.user_id' => $id),
                    'limit' => 2,
                    'order' => 'users_experiences.end_date DESC')
                );

                $uSers_exp = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
                        'users_experiences.start_date',
                        'users_experiences.designation',
                        'users_experiences.end_date',
                        'users_experiences.location',
                        'companies.id,companies.title',
                        'companies.logo'
                    ),
                    'joins' => array(
                        array('alias' => 'companies',
                            'table' => 'companies',
                            'foreignKey' => false,
                            'conditions' => array('users_experiences.company_id = companies.id'
                            )
                        )
                    ),
                    'conditions' => array('users_experiences.user_id' => $id),
                    'order' => 'users_experiences.end_date DESC, users_experiences.created DESC'
                        )
                );

                $last_edu = ClassRegistry::init('users_qualifications')->find('all', array('fields' => array('users_qualifications.id,institutes.id,qualifications.title'),
                    'joins' => array(
                        array('alias' => 'institutes',
                            'table' => 'institutes',
                            'foreignKey' => false,
                            'conditions' => array('users_qualifications.institute_id = institutes.id'
                            )
                        ),
                        array('alias' => 'qualifications',
                            'table' => 'qualifications',
                            'foreignKey' => false,
                            'conditions' => array('users_qualifications.qualification_id = qualifications.id'
                            )
                        )
                    ),
                    'conditions' => array('users_qualifications.user_id=' . $id),
                    'limit' => 1,
                    'order' => 'users_qualifications.end_date DESC'
                        )
                );


                $uSerEDU = ClassRegistry::init('users_qualifications')->find('all', array('fields' => array('
                                                                    users_qualifications.start_date,
                                                                    users_qualifications.end_date,
                                                                    users_qualifications.field_study,
                                                                    institutes.title,
                                                                    qualifications.title
                                                                    '),
                    'joins' => array(
                        array('alias' => 'institutes',
                            'table' => 'institutes',
                            'foreignKey' => false,
                            'conditions' => array('users_qualifications.institute_id = institutes.id'
                            )
                        ),
                        array('alias' => 'qualifications',
                            'table' => 'qualifications',
                            'foreignKey' => false,
                            'conditions' => array('users_qualifications.qualification_id = qualifications.id'
                            )
                        )
                    ),
                    'conditions' => array('users_qualifications.user_id=' . $id),
                    'limit' => 3,
                    'order' => 'users_qualifications.end_date DESC'
                        )
                );

                $parrentCats = ClassRegistry::init('skills_categories')->find('all');

                $userHaveSkills = ClassRegistry::init('skills')->find('all', array('fields' => array(
                        'DISTINCT skills.title',
                        'skills.skills_category_id',
                        'skills.id',
                        'users_skills.id',
                        'users_skills.skill_id',
                        'users_skills.user_id',
                        'users_skills.start_date',
                        'users_skills.end_date',
                        'count(skill_recommendations.recommends) as total_recommendations'
                    ),
                    'joins' => array(
                        array('alias' => 'users_skills',
                            'table' => 'users_skills',
                            'foreignKey' => false,
                            'conditions' => array('users_skills.skill_id = skills.id'
                            )
                        ),
                        array('alias' => 'skill_recommendations',
                            'table' => 'skill_recommendations',
                            'type' => 'left',
                            'foreignKey' => false,
                            'conditions' => array('skill_recommendations.user_id=' . $id . ' AND skill_recommendations.skill_id = users_skills.skill_id AND skill_recommendations.recommendation=1'
                            )
                        )
                    ),
                    'conditions' => array('users_skills.user_id' => $id),
                    'group' => 'skills.id'
                        )
                );

                $uers_RecommendedListingwithoutAjax = ClassRegistry::init('skill_recommendations')->find('all', array('fields' => array('
            skill_recommendations.recommends, 
            skill_recommendations.skill_id ,
            users_profiles.firstname,
            users_profiles.lastname,
            users_profiles.photo,
            users_profiles.handler
            '),
                    'joins' => array(
                        array('alias' => 'users_profiles',
                            'table' => 'users_profiles',
                            'foreignKey' => false,
                            'conditions' => array('skill_recommendations.recommends = users_profiles.user_id'
                            )
                        )
                    ),
                    'conditions' => array('skill_recommendations.user_id=' . $id . ' AND skill_recommendations.recommendation=1'),
                    'group' => 'skill_recommendations.id'
                        )
                );
                
                //$user_connections = ClassRegistry::init('connections')->find('all', array('fields' => array('connections.friend_id,connections.user_id'), 'conditions' => array('connections.user_id=' . $user_id . ' OR connections.friend_id=' . $user_id . ' AND connections.request=1')));
                //$totalConnectionOfCurrentUser = sizeof($user_connections);
                
                $commonUser = ClassRegistry::init('connections')->find('all',array(
                    'fields'=>array('connections.friend_id,connections.user_id,connections.request'),
                    'conditions'=>array('(connections.user_id='.$id.' OR connections.friend_id='.$id.') AND connections.request=1')
                    ));
                $totalConnectionOfCurrentUser = sizeof($commonUser);
                
                /* Starsign for the user Date of Birth*/
                $this->loadModel('Star_sign');
                $user_starsign_dob = $this->Star_sign->find('all', array('fields'=>array('Star_sign.id,Star_sign.name,Star_sign.start_date,Star_sign.end_date,Star_sign.icon'),'order'=>'Star_sign.id',
                                'conditions'=>array('Star_sign.status=2')));
                
                /**************************************      To show user following and followers          ***********************/
                $userFollowings = ClassRegistry::init('users_followings')->find('all' ,array(
                    'fields'=>array('users_followings.id,users_followings.status,count(users_followings.following_id) as total_following'),
                    'conditions'=>array('users_followings.user_id='.$id.' AND users_followings.following_type="users" AND users_followings.status=2')
                ));
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array(
                    'fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),
                    'conditions'=>array('users_followings.following_id='.$id.' AND users_followings.following_type="users" AND users_followings.status=2')
                ));		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);
                
                $this->set('user_starsign_dob',$user_starsign_dob);
                $this->set('totalConnections', $totalConnectionOfCurrentUser);
                $this->set('uers_RecommendedListingwithoutAjax', $uers_RecommendedListingwithoutAjax);
                $this->set('userExperience', $uers_exp);
                $this->set('lastExperience', $last_exp);
                $this->set('uSers_exp', $uSers_exp);
                $this->set('lastEducation', $last_edu);
                $this->set('uSerEDU', $uSerEDU);
                $this->set('userRec', $uers_p);
                $this->set('parrentCats', $parrentCats);
                $this->set('userHaveSkills', $userHaveSkills);
                $this->set('friend_id', $id);

                $loggedUser = @$this->userInfo['users']['id'];
            }
            /* if ($profile_url) {
              $user_profile_data = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.handler=' . '"' . $profile_url . '"')));
              $user_record = $user_profile_data[0]['users_profiles'];
              $user_id = $user_record['user_id'];
              $this->set('profile_id', $user_id);
              if ($user_id) {
              $this->set('user_profile_data', $user_profile_data);
              $uers_experience = ClassRegistry::init('users_experiences')->find('all', array('conditions' => array('users_experiences.user_id' => $user_id), 'limit' => 2, 'order' => 'users_experiences.end_date DESC'));

              $this->set('uers_experience', $uers_experience);
              $user_last_qualification = ClassRegistry::init('users_qualifications')->find('all', array('conditions' => array('users_qualifications.user_id' => $user_id), 'limit' => 1, 'order' => 'users_qualifications.end_date DESC'));
              $this->set('user_last_qualification', $user_last_qualification);
              $user_total_experience = ClassRegistry::init('users_experiences')->find('all', array('conditions' => array('users_experiences.user_id' => $user_id), 'limit' => 3, 'order' => 'users_experiences.end_date DESC'));
              $this->set('user_total_experience', $user_total_experience);
              $user_connections = ClassRegistry::init('connections')->find('all', array('fields' => array('connections.friend_id,connections.user_id'), 'conditions' => array('connections.user_id=' . $user_id . ' OR connections.friend_id=' . $user_id . ' AND connections.request=1')));
              $totalConnectionOfCurrentUser = sizeof($user_connections);

              $this->set('total_Connections_user', $totalConnectionOfCurrentUser);
              } else {

              $this->set('wrong_profile', 'Profile not found with this name.');
              }
              } else {
              $this->set('empty_profile', 'Please specify your profile name.');
              } */
        }
    }
	public function job_details(){
		//$this->autoRender = false;
		$this->loadModel('Job');
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
		$x = @$this->userInfo['users']['id'];
        if ($x) {
            $arr = $this->params['pass'];
            $job_url_id = $arr[0];
			$job_url = $arr[1];
            if ($job_url_id) {
                
                //$this->redirect(array('controller' => 'companies', 'action' => 'view', $profile_url));
				$this->redirect(JOBS_URL.'/search/jobDetails/'.$job_url_id.'/'.$job_url);
            }
        }else{
		$arr = $this->params['pass'];
        $job_id = $arr[0];
		$job_title = $arr[1];
		$jobDetail = $this->Job->query("SELECT JS.*, CO.id, CO.title, CO.logo, COU.id, COU.name, JS.functional_area, FA.id,FA.title,NA.name,JT.type FROM jobs AS JS LEFT JOIN companies AS CO ON (JS.company_id=CO.id) LEFT JOIN countries AS COU ON (JS.country_id=COU.id) LEFT JOIN functional_areas AS FA ON (JS.functional_area=FA.id) LEFT JOIN countries AS NA ON (JS.nationality=NA.id) LEFT JOIN job_types AS JT ON (JS.job_type=JT.id) WHERE JS.id=$job_id");
		$this->set('jobDetail',$jobDetail);
		}
	}
	public function company_page(){
		$this->loadModel('Company');
		
		$x = @$this->userInfo['users']['id'];
        if ($x) {
            $arr = $this->params['pass'];
            $profile_url = $arr[0];
            if ($profile_url) {
                
                $this->redirect(array('controller' => 'companies', 'action' => 'view', $profile_url));
            }
        } else {
	
		$paramenter = $this->params['pass'];
		$companyid = $paramenter[0];
		if ($companyid) {
			$this->set('companyid',$companyid);
		
			$companyDetail = ClassRegistry::init('companies')->find('first',array('fields' =>array('
																								 companies.id,
																								 companies.title,
																								 companies.user_id,
																								 companies.logo,
																								 companies.image,
																								 companies.city,
																								 companies.weburl,
																								 companies.established,
																								 companies.company_size,
																								 countries.name,
																								 industries.title,
																								 companies_types.title
																								 '),
																				'joins' => array(array('alias' => 'countries', 
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
																								 array('alias' => 'companies_types',
																									   'table' => 'companies_types',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.company_type_id = companies_types.id'
																															 )
																									   )
																								 ),
																				'conditions' => array('companies.id'=>$companyid)
																							)
																	);	
			$this->set('companyDetail',$companyDetail);
			
			
		
		/* ******************************************* LISTING COMPANY'S UPDATES ******************************************/
		$this->loadModel('Entity_update');
			
			$this->paginate = array('fields'=>array('
																					  Entity_update.id,
																					  Entity_update.user_id,
																					  Entity_update.group_title,
																					  Entity_update.image,
																					  Entity_update.entity_type,
																					  Entity_update.update_text,
																					  Entity_update.created,
																					  companies.id,
																					  companies.logo,
																					  companies.title,
																					  likes.like,
																					  likes.content_id,
																					  likes.id,
																					  likes.user_id,
																					  count(likes.like) as total
																					  '),
																	  'joins'=>array(
																					 array('alias' => 'companies',
																						   'table' => 'companies',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=companies.id'
																											   )
																						   ),
																					 array('alias' => 'users_followings',
																						   'table' => 'users_followings',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=users_followings.following_id AND users_followings.following_type="company"'
																											   )
																						   ),
																					 array('alias' => 'likes',
																						   'table' => 'likes',
																						   'foreignKey' => false,
																						   'conditions' => array('Entity_update.id  = likes.content_id'
																												 )
																						   )
																					 ),
																	  'conditions'=>array('Entity_update.entity_id='.$companyid.' AND (Entity_update.user_id = companies.user_id OR Entity_update.user_id=users_followings.user_id) AND (Entity_update.entity_type="company" AND likes.content_type="company")'),
																	  'limit'=>5,
																	  'order'=>'Entity_update.id DESC',
																	  'group'=>'Entity_update.id'									   
																	  );
			

			//$this->set('company_Updates',$company_Updates);
			$this->set('company_Updates', $this->paginate('Entity_update'));
			

		
			
			}
		}
	}
    public function pub_profile() {
        
    }

    public function public_profile() {
        if (@$this->userInfo['users']['id']) {
            
            $uid = $this->userInfo['users']['id'];
            $user_handler_record = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id=' . $uid)));
            $this->set('handler_value', $user_handler_record[0]['users_profiles']['handler']);

            if ($this->request->is('ajax')) {
                $this->response->type('json');
                $public_profile_name = $this->request->data['handler'];
                $already_exists = $this->Users_profile->find('first', array(
                    'conditions' => array(
                        'AND' => array(
                            array('Users_profile.handler' => $public_profile_name),
                            array('Users_profile.user_id !=' => $uid)
                        )
                )));
                if (empty($already_exists)) {
                    $strength_handler = (!empty($public_profile_name)) ? 5 : 0;
                    $this->data['Userprofile'][$field] = $public_profile_name;
                    $this->User->id = $uid;
                    if ($this->Users_profile->updateAll(array('handler' => '"' . $public_profile_name . '"'), array('Users_profile.user_id' => $uid))) {
                        $this->loadModel('User_profile_strength');
                        if ($this->User_profile_strength->updateAll(array('handler' => $strength_handler), array('User_profile_strength.user_id' => $uid))) {
                            //$json = json_encode(array('message'=>'Strength successfully saved','status'=>'saved'));
                        }
                        $json = json_encode(array('message' => 'Successfully created public profile', 'status' => 'success', 'url' => NETWORKWE_URL . '/pub/' . $public_profile_name));
                    } else {
                        $json = json_encode(array('message' => 'Error saving data', 'status' => 'error', 'url' => NETWORKWE_URL . '/pub/' . $user_handler_record[0]['users_profiles']['handler']));
                    }
                } else {
                    $json = json_encode(array('message' => 'Already Exist, Please use a different name.', 'status' => 'duplicate', 'url' => NETWORKWE_URL . '/pub/' . $user_handler_record[0]['users_profiles']['handler']));
                }

                $this->autorender = false;
                $this->layout = false;
                $this->response->body($json);
                $this->set('message', $json);
                $this->render('/Elements/default_json_response');
            }
        }
    }
    public function chkemail() {
        $this->autoRender = false;
        header('Content-type: application/json');
            $primary_email = $this->request->query['primary_email'];
            if (!empty($primary_email)) {
                $topLevel = @explode('@', $primary_email);
                $topLevel = strtolower($topLevel[1]);
                $pemail = ClassRegistry::init('Company')->find('first', array('conditions' => array('LOWER(Company.primary_email) LIKE' => "%$topLevel")));
                if ($pemail) {
                    echo 'false';
                }else{
                    echo 'true';
                }

            } else {
                echo 'false';
            }
    }
    public function payment_process (){
        //$this->autorender = false;
        //$this->layout = false;
        //echo 'here';
        $this->set('paypalData', $this->request->data['Choose']);
        $this->render('/Elements/payment_process');
    }

}

?>