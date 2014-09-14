<?php
App::uses('AppController', 'Controller');

class GlobalsearchController extends AppController {

    var $components = array('Email');
    var $uses = array('User', 'Connection', 'Users_profile');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        switch ($this->request->params['action']) {
            case 'index':
            case 'admin':
                $this->Security->validatePost = false;
        }
    }

    function index($limit = 10, $offset = 0, $mode = 0, $arg1 = false) {
        //$cuser = $this->Session->read(@$userid);
        $uid = @$this->userInfo['users']['id'];
        //Configure::write('debug', 2);
        $this->loadModel('Job');
        $this->loadModel('Users_profile');
        $this->loadModel('Group');
        $this->loadModel('Company');
        $this->loadModel('Country');
        $this->loadModel('functional_area');
        $this->loadModel('Groups_type');
        $this->loadModel('Companies_type');
        $this->loadModel('Company_operating_status');
        $this->loadModel('Industry');
        $this->loadModel('Connection');

        if (isset($this->request->data)) {
            $SearchString = $this->request->data['search_str'] ? $this->request->data['search_str'] : $arg1;
            $SearchScope = $this->request->data['SearchScope'] ? $this->request->data['SearchScope'] : $mode;
            $this->set('SearchScope', $SearchScope);
            $conditions = array();
            $conditionsJobs = array();
            $conditionsUsersProfiles = array();
            $conditionsCompanies = array();
            $conditionsGroups = array();
            if (!empty($SearchString)) {
                $conditionsJobs = array('Job.title LIKE' => '%' . $SearchString . '%');
                $conditionsUsersProfiles = array('CONCAT(Users_profile.firstname, " ", Users_profile.lastname) LIKE' => '%' . $SearchString . '%');	
                $conditionsCompanies = array('Company.title LIKE' => '%' . $SearchString . '%');
                $conditionsGroups = array('Group.title LIKE' => '%' . $SearchString . '%');
            }

            $cond = array();
            $i = 1;
            switch ($SearchScope) {
                case 1 : 
                    $cond[$i++] = array('AND' => array('Users_profile.user_id !=' => $uid));
					$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>''));
					$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>'Anonymous'));
					$cond[$i++] = array('AND' => array('User.status >'=>0));
					$cond[$i++] = array('AND' => array('User.role_id ='=>1));
                    $conditionsUsersProfiles = array_merge($conditionsUsersProfiles, array('AND' => array($cond)));
                    $this->paginate = array(
                        'fields'=>array(
                            'Users_profile.id,
                                (
                                SELECT count(id) FROM `connections` AS `Connection`
                                WHERE 
                                (Connection.user_id = Users_profile.user_id AND Connection.friend_id = '.$uid.')
                                OR 
                                (Connection.user_id = '.$uid.' AND Connection.friend_id = Users_profile.user_id)
                                ) AS cnt,
                                IFNULL((
                                SELECT Connection.request FROM `connections` AS `Connection`
                                WHERE 
                                (Connection.user_id = Users_profile.user_id AND Connection.friend_id = '.$uid.')
                                OR 
                                (Connection.user_id = '.$uid.' AND Connection.friend_id = Users_profile.user_id)
                                ),0) AS request,
                                Users_profile.user_id,CONCAT(Users_profile.firstname, " ", Users_profile.lastname) AS fullname,Users_profile.country_id,Users_profile.nationality,Users_profile.photo,Users_profile.gender,Users_profile.tags,Users_profile.firstname,User.id,User.role_id,User.status'
                            ),
							'joins' => array(
						array(
							'alias' => 'User',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`User`.`id` = `Users_profile`.`user_id`'
						)
						),
                        'conditions' => $conditionsUsersProfiles, 
                        'order' => 'fullname asc',
                        'limit' => $limit
                            );
							
                    $this->set('datauser', $this->paginate('Users_profile'));
                    break;
                case 2 : 
                    $cond[$i++] = array('AND' => array('Job.status ' => '2'));
                    if (!empty($country))
                        $cond[$i++] = array('AND' => array('Job.country_id ' => $country));
                    $cond_function = array();
                    if (!empty($functionalArea))
                        $cond[$i++] = array('AND' => array('Job.functional_area ' => $functionalArea));
                    $cond[$i++] = array('AND' => array('Job.status ' => '2'));
                    $conditionsJobs = array_merge($conditionsJobs, array('AND' => array($cond)));
                    $this->paginate = array(
                        'fields' => array('Job.id,Job.title,Job.country_id,Job.functional_area,Job.city,Country.name,Company.title,Company.logo,Company.title'),
                        'conditions' => $conditionsJobs, 'limit' => $limit
                            );
                    $this->set('datajobs', $this->paginate('Job'));
                    break;
                case 3 : 
                    $cond[$i++] = array('AND' => array('Company.status ' => '2','Company.flag'=>'page'));
                    if (!empty($country))
                        $cond[$i++] = array('AND' => array('Company.country_id ' => $country));
                    $conditionsCompanies = array_merge($conditionsCompanies, array('AND' => array($cond)));
                    $this->paginate = array(
                        'fields' => array('Company.id,Company.title,Company.logo,Country.name'),
                        'conditions' => $conditionsCompanies, 'limit' => $limit
                            );
                    $this->set('datacompany', $this->paginate('Company'));
                    break;
                case 4 : 
                    $cond[$i++] = array('AND' => array('Group.status ' => '2'));
                    if (!empty($country))
                        $cond[$i++] = array('AND' => array('Group.country_id ' => $country));
                    if (!empty($group))
                        $cond[$i++] = array('AND' => array('Group.group_type_id ' => $group));
                    $conditionsGroups = array_merge($conditionsGroups, array('AND' => array($cond)));
                    $this->paginate = array('fields' => array('Group.id,Group.title,groups_types.title'),'joins' => array(
                            array(
                                'alias' => 'groups_types',
                                'table' => 'groups_types',
                                'foreignKey' => false,
                                'type' => 'LEFT',
                                'conditions' => array('groups_types.id = Group.group_type_id')
                            )
                        ),'conditions' => $conditionsGroups, 'limit' => $limit);
                    $this->set('datagroups', $this->paginate('Group'));
                    break;
                default : 
                    $cond[$i++] = array('AND' => array('Users_profile.user_id !=' => $uid));
					$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>''));
					$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>'Anonymous'));
					$cond[$i++] = array('AND' => array('User.status >'=>0));
					$cond[$i++] = array('AND' => array('User.role_id ='=>1));
					$conditionsUsersProfiles = array_merge($conditionsUsersProfiles, array('AND' => array($cond)));
                    $cond[$i++] = array('AND' => array('Job.status ' => '2'));
                    $cond[$i++] = array('AND' => array('Company.status ' => '2'));
                    $cond[$i++] = array('AND' => array('Group.status ' => '2'));
                    $datajobs = $this->Job->find('all', array('fields' => array('Job.id,Job.title,Job.country_id,Job.city,Country.name,Company.title,Company.logo'), 'conditions' => $conditionsJobs, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datajobs', $datajobs);
                    $dataUser = $this->Users_profile->find('all', array('fields' => array('Users_profile.firstname,Users_profile.id,Users_profile.user_id,Users_profile.photo,CONCAT(Users_profile.firstname, " ", Users_profile.lastname) AS fullname,Users_profile.gender,User.id,User.role_id,User.status'),
					'joins' => array(
						array(
							'alias' => 'User',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`User`.`id` = `Users_profile`.`user_id`'
						)
						), 'conditions' => $conditionsUsersProfiles,'order' => 'fullname asc', 'limit' => $limit, 'offset' => $offset));
					//pr($dataUser);
					$this->set('datauser', $dataUser);
					
                    $dataCompany = $this->Company->find('all', array('fields' => array('Company.id,Company.title,Company.logo,Country.name'), 'conditions' => $conditionsCompanies, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datacompany', $dataCompany);
                    $dataGroups = $this->Group->find('all', array('fields' => array('Group.id,Group.title,groups_types.title'), 'joins' => array(
                            array(
                                'alias' => 'groups_types',
                                'table' => 'groups_types',
                                'foreignKey' => false,
                                'type' => 'LEFT',
                                'conditions' => array('groups_types.id = Group.group_type_id')
                            )
                        ),'conditions' => $conditionsGroups, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datagroups', $dataGroups);
                    break;
            }

            if ($this->request->is('ajax')) {
                $this->layout = false;
                $this->autoRender = false;
                if ($SearchScope != 0) {
                    $this->render('/Globalsearch/single', 'ajax');
                } else {
                    $this->render('/Globalsearch/all', 'ajax');
                }
            }
        }
    }
    
    function auto_suggest($limit = 4, $offset = 0) {
       // $cuser = $this->Session->read(@$userid);
        $uid = @$this->userInfo['users']['id'];
        $this->request->params['named']['scope'] = $this->request->params['named']['scope'] ? $this->request->params['named']['scope'] : $this->request->data['search_str'];
        $this->request->params['named']['query'] = $this->request->params['named']['query'] ? $this->request->params['named']['query'] : $this->request->data['SearchScope'];
        $SearchScope = $this->request->params['named']['scope']?$this->request->params['named']['scope']:'0';
        $SearchString = $this->request->params['named']['query'];
        $this->set('SearchScope', $SearchScope);
        $conditions = array();
        $conditionsJobs = array();
        $conditionsUsersProfiles = array();
        $conditionsCompanies = array();
        $conditionsGroups = array();
        if (!empty($SearchString)) {
            $conditionsJobs = array('Job.title LIKE' => '%' . $SearchString . '%');
            $conditionsUsersProfiles = array('CONCAT(Users_profile.firstname, " ", Users_profile.lastname) LIKE' => $SearchString . '%');
            $conditionsCompanies = array('Company.title LIKE' => '%' . $SearchString . '%');
            $conditionsGroups = array('Group.title LIKE' => '%' . $SearchString . '%');
        }
        $cond = array();
        $i = 1;
        switch ($SearchScope) {
            case 1 : 
                $cond[$i++] = array('AND' => array('Users_profile.user_id !=' => $uid));
				$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>''));
				$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>'Anonymous'));
				$cond[$i++] = array('AND' => array('User.status >'=>0));
				$cond[$i++] = array('AND' => array('User.role_id ='=>1));
                $conditionsUsersProfiles = array_merge($conditionsUsersProfiles, array('AND' => array($cond)));
                $dataUser = ClassRegistry::init('Users_profile')->find('all', array('fields' => array('Users_profile.firstname,Users_profile.user_id,Users_profile.photo,CONCAT(Users_profile.firstname, " ", Users_profile.lastname) AS fullname,User.id,User.role_id,User.status'),
				'joins' => array(
						array(
							'alias' => 'User',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`User`.`id` = `Users_profile`.`user_id`'
						)
						), 'conditions' => $conditionsUsersProfiles,'order' => 'fullname asc', 'limit' => $limit, 'offset' => $offset));
                $this->set('datauser', $dataUser);
                break;
            case 2 : 
                $cond[$i++] = array('AND' => array('Job.status ' => '2'));
                $conditionsJobs = array_merge($conditionsJobs, array('AND' => array($cond)));
                $datajobs = ClassRegistry::init('Job')->find('all', array('fields' => array('Job.id,Job.title,Company.logo'), 'conditions' => $conditionsJobs, 'limit' => $limit, 'offset' => $offset));
                $this->set('datajobs', $datajobs);
                break;
            case 3 : 
                $cond[$i++] = array('AND' => array('Company.status ' => '2'));
                $dataCompany = ClassRegistry::init('Company')->find('all', array('fields' => array('Company.id,Company.title,Company.logo'), 'conditions' => $conditionsCompanies, 'limit' => $limit, 'offset' => $offset));
                $this->set('datacompany', $dataCompany);
                break;
            case 4 : 
                $cond[$i++] = array('AND' => array('Group.status ' => '2'));
                $dataGroups = ClassRegistry::init('Group')->find('all', array('fields' => array('Group.id,Group.title'), 'conditions' => $conditionsGroups, 'limit' => $limit, 'offset' => $offset));
                $this->set('datagroups', $dataGroups);
                break;
            default : 
                $cond[$i++] = array('AND' => array('Users_profile.user_id !=' => $uid));
				$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>''));
				$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>'Anonymous'));
				$cond[$i++] = array('AND' => array('User.status >'=>0));
				$cond[$i++] = array('AND' => array('User.role_id ='=>1));
                $conditionsUsersProfiles = array_merge($conditionsUsersProfiles, array('AND' => array($cond)));
                $cond[$i++] = array('AND' => array('Job.status ' => '2'));
                $cond[$i++] = array('AND' => array('Company.status ' => '2'));
                $cond[$i++] = array('AND' => array('Group.status ' => '2'));
                $datajobs = ClassRegistry::init('Job')->find('all', array('fields' => array('Job.id,Job.title,Company.logo'), 'conditions' => $conditionsJobs, 'limit' => $limit, 'offset' => $offset));
                $this->set('datajobs', $datajobs);
                $dataUser = ClassRegistry::init('Users_profile')->find('all', array('fields' => array('Users_profile.firstname,Users_profile.user_id,Users_profile.photo,CONCAT(Users_profile.firstname, " ", Users_profile.lastname) AS fullname,User.id,User.role_id,User.status'), 
				'joins' => array(
						array(
							'alias' => 'User',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`User`.`id` = `Users_profile`.`user_id`'
						)
						),'conditions' => $conditionsUsersProfiles,'order' => 'fullname asc', 'limit' => $limit, 'offset' => $offset));
                $this->set('datauser', $dataUser);
                $dataCompany = ClassRegistry::init('Company')->find('all', array('fields' => array('Company.id,Company.title,Company.logo'), 'conditions' => $conditionsCompanies, 'limit' => $limit, 'offset' => $offset));
                $this->set('datacompany', $dataCompany);
                $dataGroups = ClassRegistry::init('Group')->find('all', array('fields' => array('Group.id,Group.title'), 'conditions' => $conditionsGroups, 'limit' => $limit, 'offset' => $offset));
                $this->set('datagroups', $dataGroups);
                break;
        }
        $this->layout = false;
        $this->autoRender = false;
        $this->render('/Globalsearch/auto_suggest', 'ajax');
    }

    public function add_connection_ajax($friend_id = FALSE) {
        //Configure::write('debug', 2);
        if ($this->request->is('ajax')) {
            if (@$this->userInfo['users']['id']) {
                $uid = @$this->userInfo['users']['id'];
            }
            $friend_id = $this->request->data['friend_id']?$this->request->data['friend_id']:$friend_id;
            $this->request->data['connections']['request'] = $this->request->data['action'] ? $this->request->data['action'] : 0;
            $this->request->data['connection_type'] = $this->request->data['connection_type']?$this->request->data['connection_type'] : 'Both';
            $request_date = date("Y-m-d H:i:s");
            $this->request->data['connections']['created'] = $request_date;
            $this->request->data['connections']['modified'] = $request_date;
            $this->request->data['connections']['friend_id'] = $friend_id;
            $this->request->data['connections']['connection_type'] = $this->request->data['connection_type'];
            $this->request->data['connections']['user_id'] = $uid;
            $IsInDb = ClassRegistry::init('Connection')->find('count', array(
                /*'fields'=>array(
                    '(SELECT count(id) FROM `connections` AS `Connection`
                    WHERE 
                    (Connection.user_id = Users_profile.user_id AND Connection.friend_id = '.$uid.')
                    OR 
                    (Connection.user_id = '.$uid.' AND Connection.friend_id = Users_profile.user_id)
                    ) AS cnt')*/
                'conditions' => array(
                    'OR' => array(
                        'concat(Connection.user_id,Connection.friend_id)' => $uid.$friend_id, 
                        'concat(Connection.friend_id,Connection.user_id)' => $friend_id.$uid
                    )
                )
                ));
            if($IsInDb == 0){
                if (ClassRegistry::init('connections')->save($this->request->data)) {
                    $request_user_Email = $this->getUserEmailID($friend_id);
                    $request_user_Email['email'];
                    $requested_user_Profile = $this->getCurrentUser($friend_id);
                    $requested_user = $requested_user_Profile['firstname'];

                    $user_Email = $this->getUserEmailID($uid);
                    $user_Profiles = $this->getCurrentUser($uid);
                    $fullname = $user_Profiles['firstname'] . " " . $user_Profiles['lastname'];
                    $user_deisgnation = $user_Profiles['tags'];
                    $connection_link = NETWORKWE_URL . '/connections/networkwe_connection/u:' . $uid . '/f:' . $friend_id . '';
                    $profile_link = NETWORKWE_URL . '/pub/' . $user_Profiles['handler'];
                    $this->Email->template = 'connection_request';

                    $this->set('connection_link', $connection_link);
                    $this->set('profile_link', $profile_link);
                    $this->set('requested_user', $requested_user);
                    $this->set('fullname', $fullname);
                    $this->set('user_deisgnation', $user_deisgnation);
                    $this->set('profile_id', $this->request->data['friend_id']);

                    $this->Email->sendAs = 'both';
                    $this->Email->from = $fullname . " <" . $user_Email['email'] . "> via ".SITE_TITLE;
                    $this->Email->to = $request_user_Email['email'];
                    $this->Email->subject = $requested_user_Profile['firstname'] . ' please add me to your NetworkWe.';
                    $this->Email->_debug = true;
                    if ($this->Email->send()) {
                        $this->set('emailsent', 'true');
                    }
                    $this->set('friend_id', $friend_id);
                    $this->set('profile_link', $profile_link);
                }
            }
            $this->set('mode', 'pending');
            $this->layout = false;
            $this->autoRender = false;
            $this->render('/Globalsearch/default', 'ajax');
        }
    }
}
?>