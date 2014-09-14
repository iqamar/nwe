<?php

class UsersProfilesController extends AppController {

    var $name = 'Users_profiles';
    var $helpers = array('Form', 'html', 'DatePicker', 'Js');
    var $components = array('Auth', 'Email', 'RequestHandler');
    var $uses = array('User', 'Users_experience', 'Users_skill', 'Connection', 'Users_profile', 'Users_qualification', 'Skill_recommendation', 'Cometchat_friend', 'Users_following', 'Company', 'institutes', 'Country', 'Industry','Users_recommendation', 'Users_profile_strength', 'Starsign', 'Skill', 'Institutes', 'Qualifications');

    //var $components = array();

    function beforeFilter() {
        parent::beforeFilter();

        //$this->Auth->allow(array('login', 'logout','add'));
        $this->Auth->allow();
        switch ($this->request->params['action']) {
            case 'index':
            case 'admin':
                $this->Security->validatePost = false;
        }
    }

    function index() {
        $this->User->recursive = 0;
        $this->set('Users_profiles', $this->paginate($this->Users_profile));
        $this->autoRender = false;
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function view($id = null) {
        $this->_set_user($id);
    }

    function add() {
        if ($this->request->is('post')) {
            $this->Users_profile->create();
            if ($this->Users_profile->save($this->request->data)) {
                $this->Session->setFlash(___('the user has been saved'), 'flash_message');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error');
            }
        }

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function edit($id = null) {
        $this->Users_profiles->id = $id;
        if (!$this->Users_profiles->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Users_profiles->save($this->request->data)) {
                $this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
            }
        }

        $this->_set_user($id);

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function copy($id = null) {
        $this->User->id = $id;
        if (!$this->Users_profiles->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Users_profiles->create();

            if ($this->Users_profiles->save($this->request->data)) {
                $this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
                $this->redirect(array('action' => 'index'));
            } else {
                //reset id to copy
                $this->request->data['Users_profiles'][$this->User->primaryKey] = $id;
                $this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
            }
        }

        $this->_set_user($id);

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        if ($this->User->delete($id)) {
            $this->Session->setFlash(___('user deleted'), 'success_msg');
            $this->redirect(array('action' => 'index'));
        } elseif (count($this->User->validationErrors) > 0) {
            $errors_str = '<ul>';

            foreach ($this->User->validationErrors as $field => $errors) {
                foreach ($errors as $error) {
                    $errors_str .= '<li>';
                    $errors_str .= $error;
                    $errors_str .= '</li>';
                }
            }
            $errors_str .= '</ul>';

            $this->Session->setFlash(sprintf(___('the user was not deleted: %s'), $errors_str), 'error_msg');
            $this->redirect($this->referer(array('action' => 'index')));
        } else {
            $this->Session->setFlash(___('user was not deleted'), 'error_msg');
            $this->redirect($this->referer(array('action' => 'index')));
        }
    }

    function actionAll() {
        if (!empty($this->request->data['_Tech']['action'])) {
            if (isset($this->Auth)) {
                $request = $this->request;
                $request['action'] = $this->request->data['_Tech']['action'];

                if ($this->Auth->isAuthorized($this->Auth->user(), $request)) {
                    $this->setAction($this->request->data['_Tech']['action']);
                } else {
                    $this->Session->setFlash(___d('alaxos', 'not authorized'), 'error_msg');
                    $this->redirect($this->referer());
                }
            } else {
                /*
                 * Auth is not used -> grant access
                 */
                $this->setAction($this->request->data['_Tech']['action']);
            }
        } else {
            $this->Session->setFlash(___d('alaxos', 'the action to perform is not defined'), 'error_msg');
            $this->redirect($this->referer());
        }
    }

    function deleteAll() {
        $ids = Set :: extract('/User/id[id > 0]', $this->request->data);
        if (count($ids) > 0) {
            if ($this->User->deleteAll(array('User.id' => $ids), false, true)) {
                $this->Session->setFlash(___('users deleted'), 'success_msg');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(___('users were not deleted'), 'error_msg');
                $this->redirect($this->referer(array('action' => 'index')));
            }
        } else {
            $this->Session->setFlash(___('no user to delete was found'), 'error_msg');
            $this->redirect($this->referer(array('action' => 'index')));
        }
    }

    public function display() {
        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
            $data = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																								  'users_experiences.location',
																								  'users_experiences.designation',
																								  'users_experiences.start_date',
																								  'users_experiences.end_date',
																								  'users_experiences.id',
																								  'companies.id',
																								  'companies.logo',
																								  'companies.title'),
																				'joins' => array(
																								 array('alias' => 'companies',
																									   'table' => 'companies',
																									   'foreignKey' => false,
																									   'type' => 'left',
																									   'conditions' => array('users_experiences.company_id = companies.id'
																															 )
																									   )
																								 ),
																				'conditions' => array(
																									  'users_experiences.user_id' => $uid),
																				'order' => 'STR_TO_DATE(users_experiences.end_date,"%m-%Y") DESC'));

            return $data;
        }
    }

    public function userexp() {
        if ($this->Session->read($userid)) {
            $user_Array = $this->Session->read($userid);
            $uid = $user_Array['userid'];
            /* 		 $company_List = $this->Company->find('all',array('order'=>'Company.id DESC'));
              $this->set('company_List',$company_List); */
            if ($this->request->is('post')) {
                $this->loadModel('Users_experience');

                //$company_title = trim( urldecode($this->request->data["company_title"]),'["');
                //$company_title = trim($company_title,'"]');
                $company_title = $this->request->data["company_title"][0];

                $isCompanyInDB = $this->Company->find('all', array('fields' => array('Company.id'), 'conditions' => array("title like '%" . $company_title . "%'"), 'limit' => 1));
                if (isset($isCompanyInDB[0]['Company']['id'])) {
                    $company_id = $isCompanyInDB[0]['Company']['id'];
                } else {
                    $cdata["Company"]["title"] = $company_title;
                    $this->Company->create();
                    $this->Company->save($cdata);
                    $company_id = $this->Company->getInsertID();
                    unset($cdata["Company"]["title"]);
                }


                $this->request->data['Users_experience']['user_id'] = $uid;
                $this->request->data['Users_experience']['company_id'] = $company_id;
                $this->request->data['Users_experience']['location'] = $this->request->data['Users_profile']['location'];
                $this->request->data['Users_experience']['designation'] = $this->request->data['Users_profile']['designation'];

                $st_month = $this->request->data['Users_profile']['stmonth'];
                $st_year = $this->request->data['Users_profile']['styear'];
                if ($st_month == 0) {
                    $st_month = '00';
                }

                if ($st_year == 0) {
                    $st_year = '00';
                }

                $en_month = $this->request->data['Users_profile']['enmonth'];
                $en_year = $this->request->data['Users_profile']['enyear'];

                if ($en_month == 0 && $en_year == 0) {
                    $this->request->data['Users_experience']['end_date'] = $this->request->data['Users_profile']['presents'];
                    $start_date = $st_month . '-' . $st_year;
                    $this->request->data['Users_experience']['start_date'] = $start_date;
                } else {

                    if ($en_month == 0) {
                        $en_month = '00';
                    }

                    if ($en_year == 0) {
                        $en_year = '00';
                    }

                    $start_date = $st_month . '-' . $st_year;
                    $end_date = $en_month . '-' . $en_year;
                    $this->request->data['Users_experience']['start_date'] = $start_date;
                    $this->request->data['Users_experience']['end_date'] = $end_date;
                }


                if (ClassRegistry::init('Users_experience')->save($this->request->data)) {
                    //$exp_id = ClassRegistry::init('Users_experience')->getInsertID();
                    /* User profile strength start */
                    //$this->loadModel('User_profile_strength');
                    $user_Having_exp_count = ClassRegistry::init('Users_experience')->find('all', array(
                        'conditions' =>
                        array(
                            'Users_experience.user_id' => $uid
                    )));
                    if (sizeof($user_Having_exp_count) == 1) {
                        $strength_experience = 5;
                    } else if (sizeof($user_Having_exp_count) == 2) {
                        $strength_experience = 10;
                    } else if (sizeof($user_Having_exp_count) > 2) {
                        $strength_experience = 15;
                    }

                    if ($this->User_profile_strength->updateAll(array('experience' => $strength_experience), array('User_profile_strength.user_id' => $uid))) {
                        //$this->Session->setFlash('Strength successfully saved.');
                    } else {
                        echo "not saved handler strength";
                    }
                    /* User profile strength end */
                }

                $user_experience = $this->display();
                $this->set('user_experience', $user_experience);
                $this->autorender = false;
                $this->layout = false;
                $this->render('userexp');
            }
        }
    }

    public function load_edu() {
        if ($this->request->is('ajax')) {
            $edu_id = $this->request->data['edu_id'];
            $this->loadModel('Users_qualification');
            $json = ClassRegistry::init('users_qualifications')->find('first', array('fields' => array(
                    'users_qualifications.start_date',
                    'users_qualifications.end_date',
                    'users_qualifications.id',
                    'users_qualifications.field_study',
                    'users_qualifications.grade',
                    'institutes.title',
                    'institutes.logo',
                    'qualifications.title
                '),
                'joins' => array(
                    array(
                        'alias' => 'institutes',
                        'table' => 'institutes',
                        'foreignKey' => false,
                        'conditions' => array(
                            'users_qualifications.institute_id = institutes.id')),
                    array(
                        'alias' => 'qualifications',
                        'table' => 'qualifications',
                        'foreignKey' => false,
                        'conditions' => array(
                            'users_qualifications.qualification_id = qualifications.id'
                        ))),
                'conditions' => array(
                    'users_qualifications.id' => $edu_id)
            ));
            $json["users_qualifications"]["university"] = $json['institutes']['title'];
            $json["users_qualifications"]["qualification"] = $json['qualifications']['title'];
            $json = Hash::remove($json, 'institutes');
            $json = Hash::remove($json, 'qualifications');
            echo json_encode($json);
        }
        $this->autoRender = false;
        $this->layout = false;
    }

    public function load_exp() {
        if ($this->request->is('ajax')) {
            $exp_id = $this->request->data['exp_id'];
            $this->loadModel('Users_experience');
            //$current_exp = $this->Users_experience->findById($exp_id);
            $json = $this->Users_experience->find('first', array(
                'joins' => array(
                    array(
                        'table' => 'companies',
                        'alias' => 'Company',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Company.id = Users_experience.company_id'
                        )
                    )
                ),
                'conditions' => array('Users_experience.id' => $exp_id),
                'fields' => array(
                    'Users_experience.id', 'Users_experience.user_id', 'Users_experience.location', 'Users_experience.designation',
                    'Users_experience.company_id', 'Company.title', 'Users_experience.start_date', 'Users_experience.end_date'
                )
            ));
            $json["Users_experience"]["title"] = $json['Company']['title'];
            $json = Hash::remove($json, 'Company');
            echo json_encode($json);
            //$this->set('message', $json);
            //$this->render('/Elements/default_json_response');
        }
        $this->autoRender = false;
        $this->layout = false;
    }

    public function edit_exp() {
        //Configure::write('debug', 2);
        if ($this->request->is('ajax') && $this->Session->read($userid)) {
            $user_Array = $this->Session->read($userid);
            $uid = $user_Array['userid'];
            $this->loadModel('Users_experience');
            $exp_id = $this->request->data["exp_id"];
            $company_title = $this->request->data["company_title"];
            $company_title = $company_title[sizeof($company_title)-1];
            $isCompanyInDB = $this->Company->find('first', array('fields' => array('Company.id'), 'conditions' => array("title = '" . $company_title . "'")));
            if (isset($isCompanyInDB['Company']['id'])) {
                $company_id = $isCompanyInDB['Company']['id'];
            } else {
                $cdata["Company"]["title"] = $company_title;
                $this->Company->create();
                $this->Company->save($cdata);
                $company_id = $this->Company->getInsertID();
                unset($cdata["Company"]["title"]);
            }
            $this->request->data['Users_experience']['user_id'] = $uid;
            $this->request->data['Users_experience']['company_id'] = $company_id;
            $this->request->data['Users_experience']['location'] = $this->request->data['Users_profile']['location'];
            $this->request->data['Users_experience']['designation'] = $this->request->data['Users_profile']['designation'];
            $st_month = ($this->request->data['Users_profile']['stmonth'] == 0) ? '00' : $this->request->data['Users_profile']['stmonth'];
            $st_year = ($this->request->data['Users_profile']['styear'] == 0) ? '00' : $this->request->data['Users_profile']['styear'];
            $en_month = $this->request->data['Users_profile']['enmonth'];
            $en_year = $this->request->data['Users_profile']['enyear'];
            $start_date = $st_month . '-' . $st_year;
            $end_date = $en_month . '-' . $en_year;
            $this->request->data['Users_experience']['start_date'] = $start_date;
            if(isset($this->request->data['Users_profile']['presents']) && !empty($this->request->data['Users_profile']['presents'])){
                $this->request->data['Users_experience']['end_date'] = 'Present';
            } else {
                $this->request->data['Users_experience']['end_date'] = $end_date;
            }
            $this->request->data['Users_experience']['id'] = $exp_id;
            //pr($this->request->data['Users_experience']);exit;
            if (ClassRegistry::init('Users_experience')->save($this->request->data)) {
                //
            }
            /*if ($en_month == 0 && $en_year == 0) {
                $this->request->data['Users_experience']['end_date'] = $this->request->data['Users_profile']['presents'];
                $start_date = $st_month . '-' . $st_year;
                $this->request->data['Users_experience']['start_date'] = $start_date;
            } else {
                if ($en_month == 0) {
                    $en_month = '00';
                }
                if ($en_year == 0) {
                    $en_year = '00';
                }
                
            }*/
        }
        $user_experience = $this->display();
		
        $this->set('user_experience', $user_experience);
        $this->autoRender = false;
        $this->layout = false;
        $this->render('userexp');
    }

    public function updateprofile($id = null) {

        if ($this->request->is('post')) {
            $uid = $_POST['cuserid'];
            $title = $_POST['title'];
            $first = $_POST['first'];
            $last = $_POST['last'];
            $tags = $_POST['tags'];
            $birth_date = $_POST['birth_date'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $mobile = $_POST['mobile'];
            $country_id = $_POST['country_id'];
            $city = $_POST['city'];
            $address1 = $_POST['address1'];
            $address2 = $_POST['address2'];
            $fax = $_POST['fax'];
            $pobox = $_POST['pobox'];
            $industry_id = $_POST['industry_id'];

            $fields = array("title" => '"' . $title . '"', "firstname" => '"' . $first . '"', "lastname" => '"' . $last . '"', "tags" => '"' . $tags . '"', "birth_date" => '"' . $birth_date . '"', "phone" => '"' . $phone . '"', "mobile" => '"' . $mobile . '"', "country_id" => '"' . $country_id . '"', "city" => '"' . $city . '"', "address1" => '"' . $address1 . '"', "address2" => '"' . $address2 . '"', "fax" => '"' . $fax . '"', "zip" => '"' . $pobox . '"', "industry_id" => '"' . $industry_id . '"');


            if ($this->Users_profile->updateAll($fields, array('Users_profile.user_id' => $uid))) {
                echo 1;
            } else {
                echo -1;
            }
        }
        exit;
    }

    public function saveprofile($id = null) {

        if ($this->request->is('post')) {
            $uid = $_POST['cuserid'];
            $firstname = $_POST['fieldnew'];
            $field = $_POST['field'];
            $password = $_POST['password'];
            if ($field == 'email') {
                $this->loadModel('User');
                $this->data['User']['id'] = $uid;
                $this->data['password'] = $password;
                $this->data['User'][$field] = $firstname;
                $this->User->id = $uid;

                if ($this->User->updateAll(array($field => '"' . $firstname . '"'), array('User.id' => $uid))) {
                    $this->Session->setFlash('User successfully saved.');
                    echo "email value saved";
                } else {
                    echo "email not saved";
                }
            } else {
                $this->data['Users_profile']['user_id'] = $uid;
                //$this->request->data['User']['password'] = $password;
                $this->data['Users_profile'][$field] = $firstname;
                $this->Users_profile->user_id = $uid;
                //$this->Users_profile->updateAll(array($field =>$firstname), array('Users_profile.user_id' => $uid));
                if ($this->Users_profile->updateAll(array($field => '"' . $firstname . '"'), array('Users_profile.user_id' => $uid))) {
                    $this->Session->setFlash('User successfully saved.');
                    echo "field value saved";
                } else {
                    echo "not saved";
                }
            }
            die();
            $this->autorender = false;
            $this->layout = false;
            $this->render('saveprofile');
        }
    }

    public function profile_summary() {
        $user_Array = $this->Session->read($userid);
        $uid = $user_Array['userid'];
        if ($this->request->is('post')) {
            $summary = $this->request->data['Users_profile']['summary'];
            $this->request->data = '';
            $this->request->data['Users_profile']['user_id'] = $uid;
            $this->request->data['Users_profile']['summary'] = $summary;
            $photoRecords = $this->Users_profile->find('all', array('fields' => array('Users_profile.id'),
                'conditions' => array('Users_profile.user_id=' . $uid)));
            $userID = $photoRecords[0]['Users_profile'];

            $recID = $userID['id'];
            $this->Users_profile->id = $recID;
            if ($summary != '') {
                $strength_summary = 5;
            } else {
                $strength_summary = 0;
            }
            if ($this->Users_profile->save($this->data)) {
                $this->loadModel('User_profile_strength');
                if ($this->User_profile_strength->updateAll(array('summary' => $strength_summary), array('User_profile_strength.user_id' => $uid))) {
                    //$this->Session->setFlash('User successfully saved.');
                    //$this->redirect(array('controller' => 'users_profiles', 'action' => 'profile'));
                } else {
                    echo "not saved profile strength";
                }
            } else {
                echo "not saved";
            }
        }
        $cuser = $this->Session->read($userid);
        $uid = $cuser['userid'];
        $vals = $this->Users_profile->getValues($uid);
        $profile_summary_array = $vals[0]['Users_profile'];
        $profile_summary_array = $profile_summary_array['summary'];
        $this->set('profileSummary', $profile_summary_array);
        //$user = $this->Users_profile->find('all',array('conditions'=>array('user_id='.$uid)));
        $this->autorender = false;
        $this->layout = false;
        $this->render('profile_summary');
    }

    public function profile($id = null) {
        //echo $fieldVal = $this->request->data['field'];
        $cuser = $this->Session->read($userid);
        $uid = $cuser['userid'];
        $this->checkPermission($uid);
        $user = $this->getCurrentUser($uid);

        $uid = $user['user_id'];

        //$this->loadModel('ProfileFieldValue');
        //$this->loadModel('ProfileField');
        $values = array();
        if (empty($uid))
            $uid = $this->request->data['id'];

        if (empty($uid)) {
            $this->Session->setFlash('Invalid user id', 'default', array('class' => 'error-message'));
            $this->redirect($this->referer());
            exit;
        }

        if ($this->request->is('post')) {
            $availability_type = $this->request->data['availability_type'];
            $availability_type = @implode(',', $availability_type);
            $uid = $_POST['cuserid'];
            $this->data['Users_profile']['user_id'] = $uid;
            $this->data['Users_profile']['availability_type'] = $availability_type;
            $this->Users_profile->user_id = $uid;
            if ($this->Users_profile->updateAll(array('availability_type' => '"' . $availability_type . '"'), array('Users_profile.user_id' => $uid))) {
                $this->Session->setFlash('User successfully saved.');
            } else {
                echo "not saved";
            }
        }
        // get all the profile field values
        $vals = $this->Users_profile->getValues($uid);
        $this->set('profilefields', $vals);
        $countries = $this->Country->find('all');
        $industries = $this->Industry->find('all');
        $this->set('countries', $countries);
        $this->set('industries', $industries);
		
        /*$user = $this->Users_profile->find('all', array('conditions' => array('user_id=' . $uid)));
        if (!$user) {
            $this->Session->setFlash('Invalid User.');
        }*/
    }

    public function fetch_qualifications() {
        $query = $this->request->params['named']['query'] ? $this->request->params['named']['query'] : $this->params['url']['query'];
        if (!empty($query)) {
            $this->loadModel('Qualification');
            $list = $this->Qualification->find('all', array(
                'fields' => array('Qualification.title,Qualification.id'),
                'conditions' => array("Qualification.title like '%" . $query . "%'"),
                'order' => 'Qualification.title', 'limit' => 10));
            $num = count($list);
            if ($num > 0) {
                $data = array();
                foreach ($list as $item) {
                    $id = $item["Qualification"]["title"];
                    $label = $item["Qualification"]["title"];
                    $data[] = array("key" => $id, "value" => $label);
                }
                echo json_encode($data);
            }
        }
        $this->autoRender = false;
        $this->layout = false;
    }

    public function fetch_institutes() {
        //Configure::write('debug', 2);
        $query = $this->request->params['named']['query'] ? $this->request->params['named']['query'] : $this->params['url']['query'];
        if (!empty($query)) {
            $this->loadModel('Institute');
            $list = $this->Institute->find('all', array(
                'fields' => array('Institute.title,Institute.id'),
                'conditions' => array("Institute.title like '%" . $query . "%'"),
                'order' => 'Institute.title', 'limit' => 10));
            $num = count($list);
            if ($num > 0) {
                $data = array();
                foreach ($list as $item) {
                    $id = $item["Institute"]["title"];
                    $label = $item["Institute"]["title"];
                    $data[] = array("key" => $id, "value" => $label);
                }
                echo json_encode($data);
            }
        }
        $this->autoRender = false;
        $this->layout = false;
    }

    public function fetch_companies() {
        $query = $this->request->params['named']['query'] ? $this->request->params['named']['query'] : $this->params['url']['query'];
        if (!empty($query)) {
            $this->loadModel('Company');
            $list = $this->Company->find('all', array(
                'fields' => array('Company.title,Company.id'),
                'conditions' => array("Company.title like '%" . $query . "%'"),
                'order' => 'Company.title', 'limit' => 10));
            $num = count($list);
            if ($num > 0) {
                $data = array();
                foreach ($list as $item) {
                    $id = $item["Company"]["title"];
                    $label = $item["Company"]["title"];
                    $data[] = array("key" => $id, "value" => $label);
                }
                echo json_encode($data);
            }
        }
        $this->autoRender = false;
        $this->layout = false;
    }

    public function fetch_skills() {
        //print_r($this->params['url']['query']);
        //if ($this->request->is('post')) {
        $query = $this->request->params['named']['query'] ? $this->request->params['named']['query'] : $this->params['url']['query']; //$this->request->data["query"]?$this->request->data["query"]:$this->request->params['named']['query'];
        if (!empty($query)) {
            $skills_list = $this->Skill->find('all', array(
                'fields' => array('Skill.title,Skill.id'),
                'conditions' => array("Skill.title like '%" . $query . "%'"),
                'order' => 'Skill.title', 'limit' => 10));
            $num_of_skill = count($skills_list);
            if ($num_of_skill > 0) {
                $data = array();
                foreach ($skills_list as $skill) {
                    $id = $skill["Skill"]["title"];
                    $label = $skill["Skill"]["title"];
                    $data[] = array("key" => $id, "value" => $label);
                }
                echo json_encode($data);
                //exit;
            }
        }
        $this->autoRender = false;
        $this->layout = false;
        //}
        //echo "null";
        //exit;
    }

    public function update($id = null) {

        //echo $fieldVal = $this->request->data['field'];
        $cuser = $this->Session->read($userid);
        $uid = $cuser['userid'];
        $this->checkPermission($uid);
        $user = $this->getCurrentUser($uid);

        $uid = $user['user_id'];

        $values = array();
        if (empty($uid))
            $uid = $this->request->data['id'];

        if (empty($uid)) {
            $this->Session->setFlash('Invalid user id', 'default', array('class' => 'error-message'));
            $this->redirect($this->referer());
            exit;
        }

        if ($this->request->is('post')) {


            if ("basic" == $this->request->data["action"]) {
                $birth_day = $this->request->data["request"]["birth_date"];
                $birth_date = date('Y-m-d', strtotime($birth_day));
                $postData['title'] = '"' . $this->request->data["request"]["title"] . '"';
                $postData['firstname'] = '"' . $this->request->data["request"]["first"] . '"';
                $postData['lastname'] = '"' . $this->request->data["request"]["last"] . '"';
                $postData['gender'] = '"' . $this->request->data["request"]["gender"] . '"';
                $postData['birth_date'] = '"' . $birth_date . '"';
                $postData['nationality'] = '"' . $this->request->data["request"]["nationality"] . '"';
                $postData['tags'] = '"' . $this->request->data["request"]["tags"] . '"';
                $postData['marital_status'] = '"' . $this->request->data["request"]["marital_status"] . '"';
                $postData['industry_id'] = '"' . $this->request->data["request"]["industry_id"] . '"';
                $postData['phone'] = '"' . $this->request->data["request"]["phone"] . '"';
                $postData['mobile'] = '"' . $this->request->data["request"]["mobile"] . '"';
                $postData['address1'] = '"' . $this->request->data["request"]["address1"] . '"';
                $postData['address2'] = '"' . $this->request->data["request"]["address2"] . '"';
                $postData['fax'] = '"' . $this->request->data["request"]["fax"] . '"';
                $postData['zip'] = '"' . $this->request->data["request"]["pobox"] . '"';
                $postData['city'] = '"' . $this->request->data["request"]["city"] . '"';
                $postData['country_id'] = '"' . $this->request->data["request"]["country_id"] . '"';
                $postData['hide_year'] = '"' . $this->request->data["request"]["hide_year"] . '"';
				
				$postData['lastname_hide'] = '"' . $this->request->data["request"]["lastname_hide"] . '"';
				$postData['gender_hide'] = '"' . $this->request->data["request"]["gender_hide"] . '"';
				$postData['marital_status_hide'] = '"' . $this->request->data["request"]["marital_status_hide"] . '"';
				$postData['nationality_hide'] = '"' . $this->request->data["request"]["nationality_hide"] . '"';
				$postData['tags_hide'] = '"' . $this->request->data["request"]["tags_hide"] . '"';
				$postData['industry_id_hide'] = '"' . $this->request->data["request"]["industry_id_hide"] . '"';
				$postData['phone_hide'] = '"' . $this->request->data["request"]["phone_hide"] . '"';
				$postData['mobile_hide'] = '"' . $this->request->data["request"]["mobile_hide"] . '"';
				$postData['address1_hide'] = '"' . $this->request->data["request"]["address1_hide"] . '"';
				$postData['address2_hide'] = '"' . $this->request->data["request"]["address2_hide"] . '"';
				$postData['zip_hide'] = '"' . $this->request->data["request"]["zip_hide"] . '"';
				$postData['country_id_hide'] = '"' . $this->request->data["request"]["country_id_hide"] . '"';
				$postData['city_hide'] = '"' . $this->request->data["request"]["city_hide"] . '"';

                $profile_summary = '"' . $this->request->data["request"]["pro_summary"] . '"';
                if ($profile_summary != '') {
                    $postData['summary'] = $profile_summary;
                }

                if ($this->Users_profile->updateAll($postData, array('Users_profile.user_id' => $uid))) {
                    echo 1;
                } else {
                    echo -1;
                }
            } else if ("photo" == $this->request->data["action"]) {
                exit;

                if ($this->Users_profile->updateAll($postData, array('Users_profile.user_id' => $uid))) {
                    echo 1;
                } else {
                    echo -1;
                }
            }
            exit;
        } else {
            // get all the profile field values
            $vals = $this->Users_profile->getValues($uid);

            $this->set('profilefields', $vals[0]["Users_profile"]);
            $countries = $this->Country->find('all');
            $industries = $this->Industry->find('all');
            $institutes = $this->Institutes->find('all');
            $qualifcations = $this->Qualifications->find('all');
            $this->set('countries', $countries);
            $this->set('industries', $industries);
            $this->set('institue_list', $institutes);
            $this->set('qualifcation_list', $qualifcations);
            $user_qualification = $this->useredu();
            $this->set('user_qualification', $user_qualification);

            $user_experience = $this->display();
            $this->set('user_experience', $user_experience);

            $skill_List = ClassRegistry::init('skills')->find('all', array('fields' => array('skills.title,
																					   skills.id'
                ),
                'order' => 'skills.id DESC'));
            $this->set('skill_List', $skill_List);


            $company_List = $this->Company->find('all', array('fields' => array(
                    'Company.title,
																		Company.id'
                ),
                'order' => 'Company.id DESC'));
            $this->set('company_List', $company_List);

            /* User Skill */

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
                    array(
                        'alias' => 'users_skills',
                        'table' => 'users_skills',
                        'foreignKey' => false,
                        'conditions' => array(
                            'users_skills.skill_id = skills.id'
                        )),
                    array(
                        'alias' => 'skill_recommendations',
                        'table' => 'skill_recommendations',
                        'type' => 'left',
                        'foreignKey' => false,
                        'conditions' => array('skill_recommendations.user_id=' . $uid . ' AND 																		                                                                      									skill_recommendations.skill_id = users_skills.skill_id AND
																										skill_recommendations.recommendation=1'
                        ))),
                'conditions' => array('users_skills.user_id' => $uid),
                'group' => 'skills.id'
            ));
            $this->set('userHaveSkills', $userHaveSkills);

            $uers_recomend_skill = ClassRegistry::init('skill_recommendations')->find('all', array('fields' => array(
                    'skill_recommendations.recommends,
																															  skill_recommendations.skill_id,
																															  users_profiles.firstname,
																															  users_profiles.lastname,
																															  users_profiles.photo,
																															  users_profiles.handler
																															  '),
                'joins' => array(
                    array(
                        'alias' => 'users_profiles',
                        'table' => 'users_profiles',
                        'foreignKey' => false,
                        'conditions' => array(
                            'skill_recommendations.recommends = users_profiles.user_id'
                        ))),
                'conditions' => array(
                    'skill_recommendations.user_id=' . $uid . ' AND
																																   skill_recommendations.recommendation=1'),
                'group' => 'skill_recommendations.id',
                'order' => 'skill_recommendations.id DESC'
            ));
            $this->set('uers_recomend_skill', $uers_recomend_skill);

            $user = $this->Users_profile->find('all', array('conditions' => array('user_id=' . $uid)));
        }
    }

    public function hire_status($id = null) {
        //echo $fieldVal = $this->request->data['field'];
        $cuser = $this->Session->read($userid);
        $uid = $cuser['userid'];
        if ($this->request->is('post')) {
            print_r($this->request->data);
            $userProfile = $this->Users_profile->find('all', array('fields' => array(
                    'Users_profile.id'),
                'conditions' => array('Users_profile.user_id=' . $uid)));
            $user_ID = $userProfile[0]['Users_profile'];
            $my_ID = $user_ID['id'];
            $this->Users_profile->id = $my_ID;
            if ($this->Users_profile->save($this->request->data)) {
                $this->Session->setFlash('User successfully saved.');
            } else {
                echo "not saved";
            }
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('hire_status');
    }

    public function account($id = null) {
        $cuser = $this->Session->read($userid);
        $uid = $cuser['userid'];
        $this->checkPermission($uid);
        $user = $this->getCurrentUser($uid);

        $values = array();
        if (empty($uid))
            $uid = $this->request->data['id'];
        if (empty($uid)) {
            $this->Session->setFlash('Invalid user id', 'default', array('class' => 'error-message'));
            $this->redirect($this->referer());
            exit;
        }

        if ($this->request->is('post')) {
            $this->loadModel('User');
            $this->User->id = $uid;
            $user = $this->User->findById($uid);

            $usepass = $user['User']['password'];

            $oldpassword = AuthComponent::password($this->request->data['Users_profile']['oldpassword']);
            $currentpassword = AuthComponent::password($this->request->data['Users_profile']['password']);
            $conpassword = AuthComponent::password($this->request->data['Users_profile']['cpassword']);
            if ($usepass == $oldpassword) {
                $this->request->data = '';
                $this->request->data['User']['password'] = $currentpassword;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('User successfully saved.');
                    $this->redirect(array('controller' => 'users_profiles', 'action' => 'profile'));
                    //$this->redirect($this->referer());
                }
            } else {
                $this->Session->setFlash('Your old password is incorrect.');
            }
        }
    }

    public function userphoto() {

        if ($this->request->is('post')) {
            $cuser_row = $this->Session->read(@$userid);
            $cuid = $cuser_row['userid'];
            if ($this->request->data) {
                $filename = $this->request->data['Users_profile']['photo'];
                $this->request->data['Users_profile']['photo'] = $filename['name'];
                $image = $this->request->data['Users_profile']['photo'];
                $imagename = $filename['name'];
                $typess = $filename['type'];
                $imageTypes = array("image/gif", "image/jpeg", "image/png");
                $uploadOriginal = MEDIA_PATH . "files/user/original";
                $uploadLogo = MEDIA_PATH . "files/user/logo";
                $uploadThumb = MEDIA_PATH . "files/user/thumbnail";
                $uploadIcon = MEDIA_PATH . "files/user/icon";
                $image_type = '';

                if ($filename['type'] == 'image/gif' || $filename['type'] == 'image/jpeg' || $filename['type'] == 'image/png') {
                    $imageName = date('His') . $filename['name'];

                    $full_image_path = $uploadOriginal . '/' . $imageName;
                    if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
                        $data['photo'] = $imageName;
                        $this->request->data['Users_profile']['photo'] = $data['photo'];

                        $source_image = $uploadOriginal . '/' . $data['photo'];
                        $destination_logo_path = $uploadLogo . '/' . $data['photo'];
                        $this->__imageresize($source_image, $destination_logo_path, 165, 165);


                        $destination_thumb_path = $uploadThumb . '/' . $data['photo'];
                        $this->__imageresize($source_image, $destination_thumb_path, 100, 100);

                        $destination_icon_path = $uploadIcon . '/' . $data['photo'];
                        $this->__imageresize($source_image, $destination_icon_path, 50, 50);
                        $image_type = true;
                    } else {
                        echo "There was a problem uploading file. Please try again.";
                        //$this->Session->setFlash('There was a problem uploading file. Please try again.');
                    }
                } else {
                    //$this->Session->setFlash('Unacceptable file type');
                    echo "Unacceptable file type";
                }

                if ($image_type == true) {
                    $photoRecords = $this->Users_profile->find('first', array(
                        'conditions' => array('Users_profile.user_id=' . $cuid)));
                    $recID = $photoRecords['Users_profile']['id'];
                    //$recID = $photoID['id'];
                    $this->Users_profile->id = $recID;
                    if ($this->Users_profile->save($this->request->data)) {
                        $this->loadModel('User_profile_strength');
                        if ($photoRecords != '') {
                            $strength_photo = 5;
                        } else {
                            $strength_photo = 0;
                        }
                        if ($this->User_profile_strength->updateAll(array('photo' => $strength_photo), array('User_profile_strength.user_id' => $cuid))) {
                            //$this->Session->setFlash('Strength successfully saved.');
                            //$this->redirect(array('controller' =>'users_profiles' , 'action' => 'myprofile'));
                        } else {
                            echo "not saved handler strength";
                        }
                    } else {
                        $this->Session->setFlash('File not saved');
                        echo "nono";
                    }
                    //$this->redirect(array('controller' =>'users_profiles' , 'action' => 'userphoto'));
                }
            }
            $this->set('imageName', $imageName);
            $this->autorender = false;
            $this->layout = false;
            $this->render('userphoto');
        }
    }

    //Skills Functions /////////////////

    public function showskills() {
        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
            $data = ClassRegistry::init('skills_categories')->find('all', array('fields' => array('DISTINCT skills_categories.id', 'skills_categories.title', 'skills.title', 'skills.skills_category_id', 'skills.id'),
                'joins' => array(array('alias' => 'skills', 'table' => 'skills', 'foreignKey' => false, 'conditions' => array('skills_categories.id = skills.skills_category_id'))),
                'group' => 'skills.skills_category_id'));

            $this->set('exps', $data);
            $subUserSkill = ClassRegistry::init('skills')->find('all');
            $this->set('subUserSkill', $subUserSkill);
            $skill_cat = ClassRegistry::init('skills_categories')->find('all');
            $this->set('total_skills', $skill_cat);


            $subskill = ClassRegistry::init('skills')->find('all', array('fields' => array('DISTINCT skills.title', 'skills.skills_category_id', 'skills.id', 'users_skills.id', 'users_skills.start_date', 'users_skills.end_date'), 'joins' => array(
                    array('alias' => 'users_skills', 'table' => 'users_skills', 'foreignKey' => false, 'conditions' => array('users_skills.skill_id = skills.id'))), 'group' => 'skills.title', 'order' => 'users_skills.id', 'conditions' => array('users_skills.user_id=' . $uid)));
            $this->set('sub', $subskill);
        }
    }

    public function user_skill() {
        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
        if ($this->request->is('post')) {
            $st_month = $this->request->data['Users_profile']['stmonth'];
            $st_year = $this->request->data['Users_profile']['styear'];
            $en_month = $this->request->data['Users_profile']['enmonth'];
            $en_year = $this->request->data['Users_profile']['enyear'];
            $start_date = $st_month . '-' . $st_year;
            $end_date = $en_month . '-' . $en_year;
            if ($st_month == 0) {
                $st_month = '00';
            }
            if ($st_year == 0) {
                $st_year = '00';
            }
            if ($en_month == 0) {
                $en_month = '00';
            }
            if ($en_year == 0) {
                $en_year = '00';
            }

            //$skill_title = trim( urldecode($this->request->data["skill_title"]),'["');
            //$skill_title = trim($skill_title,'"]');
            $skill_title = $this->request->data["skill_title"][0];
            $this->loadModel('Skill');

            $isSkillInDB = $this->Skill->find('first', array('fields' => array('Skill.id'), 'conditions' => array("title = '" . $skill_title . "'"), 'limit' => 1));
            //echo "<pre>"; print_r($isSkillInDB);
            if (isset($isSkillInDB['Skill']['id'])) {
                $skill_id = $isSkillInDB['Skill']['id'];
            } else {
                $cdata["Skill"]["title"] = $skill_title;
                $cdata['Skill']['user_id'] = $uid;
                $cdata['Skill']['created'] = $start_date;
                $cdata['Skill']['modified'] = $start_date;
                $cdata['Skill']['status'] = 1;
                $this->Skill->create();
                $this->Skill->save($cdata);
                $skill_id = $this->Skill->getInsertID();
                unset($cdata["Skill"]["title"]);
            }

            $this->request->data['Users_skill']['skill_id'] = $skill_id;
            $this->request->data['Users_skill']['start_date'] = $start_date;
            $this->request->data['Users_skill']['end_date'] = $end_date;
            $this->request->data['Users_skill']['user_id'] = $uid;
			print_r($this->request->data['Users_skill']);
            if (ClassRegistry::init('Users_skill')->save($this->request->data)) {
                $last_skill_id = $this->Users_skill->getInsertID();
                //User profile strength start
                $this->loadModel('User_profile_strength');
                $user_Having_skill_count = ClassRegistry::init('Users_skill')->find('all', array('conditions' => array('Users_skill.user_id' => $uid)));
                if (sizeof($user_Having_skill_count) == 1) {
                    $strength_skill = 5;
                } else if (sizeof($user_Having_skill_count) == 2) {
                    $strength_skill = 10;
                } else if (sizeof($user_Having_skill_count) == 3) {
                    $strength_skill = 15;
                } else if (sizeof($user_Having_skill_count) > 3) {
                    $strength_skill = 20;
                }

                if ($this->User_profile_strength->updateAll(array('skills' => $strength_skill), array('User_profile_strength.user_id' => $uid))) {
                    // $this->Session->setFlash('Strength successfully saved.');
                } else {
                    echo "not saved handler strength";
                }
                //User profile strength end
                $skill_Ajax_List = ClassRegistry::init('users_skills')->find('all', array('fields' => array(
																											'DISTINCT skills.title', 
																											'skills.id',
																											'users_skills.id
																											'),
																						  'joins' => array(
																										   array('alias' => 'skills',
																												 'table' => 'skills',
																												 'foreignKey' => false,
																												 'conditions' => array('users_skills.skill_id = skills.id'
																																	   )
																												 )
																										   ),
																						  'order' => 'users_skills.id',
																						  'conditions' => array('users_skills.id=' . $last_skill_id)));
                $this->set('skill_Ajax_List', $skill_Ajax_List);
            }
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('user_skill');
    }

    public function user_edu() {

        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
        if ($this->request->is('post')) {


            //$institute_title = trim( urldecode($this->request->data["institute_title"]),'["');
            //$institute_title = trim($institute_title,'"]');
            $institute_title = $this->request->data["institute_title"][0];

            $isInstituteInDB = $this->Institutes->find('all', array('fields' => array('Institutes.id', 'Institutes.title'), 'conditions' => array("title = '" . $institute_title . "'"), 'limit' => 1));

            if (isset($isInstituteInDB[0]['Institutes']['id'])) {
                $institute_id = $isInstituteInDB[0]['Institutes']['id'];
            } else {
                $cdata["Institutes"]["title"] = $institute_title;
                $this->Institutes->create();
                $this->Institutes->save($cdata);
                $institute_id = $this->Institutes->getInsertID();
                unset($cdata["Institutes"]["title"]);
            }

            //$qualification_title = trim( urldecode($this->request->data["qualification_title"]),'["');
            //$qualification_title = trim($qualification_title,'"]');
            $qualification_title = $this->request->data["qualification_title"][0];
            $isQualificationInDB = $this->Qualifications->find('all', array('fields' => array('Qualifications.id'), 'conditions' => array("title = '" . $qualification_title . "'"), 'limit' => 1));

            if (isset($isQualificationInDB[0]['Qualifications']['id'])) {
                $qualification_id = $isQualificationInDB[0]['Qualifications']['id'];
            } else {
                $cdata["Qualifications"]["title"] = $qualification_title;
                $this->Qualifications->create();
                $this->Qualifications->save($cdata);
                $qualification_id = $this->Qualifications->getInsertID();
                unset($cdata["Qualifications"]["title"]);
            }
            $this->request->data['users_qualifications']['institute_id'] = $institute_id;
            $this->request->data['users_qualifications']['qualification_id'] = $qualification_id;
            $this->request->data['users_qualifications']['grade'] = $this->request->data['users_qualifications']['grade'];
            $this->request->data['users_qualifications']['field_study'] = $this->request->data['users_qualifications']['field_study'];
            $this->request->data['users_qualifications']['user_id'] = $uid;

            $st_month = $this->request->data['users_qualifications']['stmonth'];
            $st_year = $this->request->data['users_qualifications']['styear'];

            $en_month = $this->request->data['users_qualifications']['enmonth'];
            $en_year = $this->request->data['users_qualifications']['enyear'];

            if ($st_month == 0) {
                $st_month = '00';
            }

            if ($st_year == 0) {
                $st_year = '00';
            }

            if ($en_month == 0) {
                $en_month = '00';
            }

            if ($en_year == 0) {
                $en_year = '00';
            }

            $start_date = $st_month . '-' . $st_year;
            $end_date = $en_month . '-' . $en_year;

            $this->request->data['users_qualifications']['start_date'] = $start_date;
            $this->request->data['users_qualifications']['end_date'] = $end_date;

            if (ClassRegistry::init('users_qualifications')->save($this->request->data)) {

                /* User profile strength start */
                $this->loadModel('User_profile_strength');
                $user_Having_qualification_count = ClassRegistry::init('users_qualifications')->find('all', array(
                    'conditions' =>
                    array(
                        'users_qualifications.user_id' => $uid
                )));
                if (sizeof($user_Having_qualification_count) == 1) {
                    $strength_qualification = 5;
                } else if (sizeof($user_Having_qualification_count) == 2) {
                    $strength_qualification = 10;
                } else if (sizeof($user_Having_qualification_count) > 2) {
                    $strength_qualification = 15;
                }

                if ($this->User_profile_strength->updateAll(array('qualification' => $strength_qualification), array('User_profile_strength.user_id' => $uid))) {
                    //$this->Session->setFlash('Strength successfully saved.');
                } else {
                    echo "not saved handler strength";
                }
                /* User profile strength end */

                $user_qualification = $this->useredu();
                $this->set('user_qualification', $user_qualification);
            }
        }


        $this->autorender = false;
        $this->layout = false;
        $this->render('user_edu');
    }

    public function useredu() {
        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
            $Institue_List = ClassRegistry::init('institutes')->find('all', array('order' => 'institutes.id DESC'));
            $this->set('Institue_List', $Institue_List);

            $qualifications_List = ClassRegistry::init('qualifications')->find('all', array('order' => 'qualifications.id DESC'));
            $this->set('qualifications_List', $qualifications_List);

            $data = ClassRegistry::init('users_qualifications')->find('all', array('conditions' => array(
                    'users_qualifications.user_id' => $uid),
                'limit' => 3,
                'order' => 'users_qualifications.end_date DESC'));

            $data = ClassRegistry::init('users_qualifications')->find('all', array('fields' => array(
																									'users_qualifications.start_date',
																									'users_qualifications.end_date',
																									'users_qualifications.id',
																									'users_qualifications.field_study',
																									'users_qualifications.grade',
																									'institutes.title',
																									'institutes.logo',
																									'qualifications.title'
																									),
																								'joins' => array(
																												array(
																													'alias' => 'institutes',
																													'table' => 'institutes',
																													'foreignKey' => false,
																													'conditions' => array(
																														'users_qualifications.institute_id = institutes.id')),
																												array(
																													'alias' => 'qualifications',
																													'table' => 'qualifications',
																													'foreignKey' => false,
																													'conditions' => array(
																													'users_qualifications.qualification_id = qualifications.id'
																										))),
																								'conditions' => array('users_qualifications.user_id' => $uid),
																								'order' => 'STR_TO_DATE(users_qualifications.end_date,"%m-%Y") DESC'));

            return $data;
        }
    }

    public function getchild() {
        if ($this->request->isAjax()) {
            print_r($this->request->data);
            exit;
            if (!empty($this->request->data)) {
                $data = $this->request->data['childskill'];
                echo $childskill = $data['childskill'];
                $tSUB = ClassRegistry::init('skills')->find('all', array('joins' => array(array('alias' => 'skills_categories', 'table' => 'skills_categories', 'foreignKey' => false, 'conditions' => array('skills.skills_category_id LIKE %$childskill%')))));
                $this->set('tSUB', $tSUB);
                //$this->render('getchild');
            } else {
                echo "no data";
            }
        }
    }

    public function delete_skill() {
        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
        if ($this->request->is('get')) {
            $skill_id = $_GET['skill_id'];
            /* User profile strength start */
            $this->loadModel('User_profile_strength');
            $user_Having_skill_count = ClassRegistry::init('Users_skill')->find('all', array(
                'conditions' =>
                array(
                    'Users_skill.user_id' => $uid
            )));
            if (sizeof($user_Having_skill_count) == 1) {
                $strength_skill = (5 - 5);
            } else if (sizeof($user_Having_skill_count) == 2) {
                $strength_skill = (10 - 5);
            } else if (sizeof($user_Having_skill_count) == 3) {
                $strength_skill = (15 - 5);
            } else if (sizeof($user_Having_skill_count) > 3) {
                $strength_skill = (20 - 5);
            }

            $db = ConnectionManager::getDataSource('default');
            $db->rawQuery("DELETE FROM users_skills WHERE id=" . $skill_id);

            if ($this->User_profile_strength->updateAll(array('skills' => $strength_skill), array('User_profile_strength.user_id' => $uid))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
            /* User profile strength end */
            $this->autorender = false;
            $this->layout = false;
            $this->render('delete_skill');
        }
    }

    public function edit_skill($id = null) {

        if ($this->request->is('ajax')) {
            $id = $_GET['childskill'];
            $this->Userskill->id = $id;
            $datas = ClassRegistry::init('users_skills')->findById($id);
            $this->view = 'edit_skill';

            $this->set('id', $id);
            $cuserskill = ClassRegistry::init('users_skills')->find('all', array('fields' => array('users_skills.*,skills.title'),
                'joins' => array(
                    array('alias' => 'skills', 'table' => 'skills', 'foreignKey' => false, 'conditions' => array('users_skills.skill_id = skills.id'))),
                'conditions' => array('users_skills.id=' . $id)));
            $this->set('cuserskill', $cuserskill);
            $this->set('subUserSkill', $subUserSkill);
            $skill_cat = ClassRegistry::init('skills_categories')->find('all');
            $this->set('total_skills', $skill_cat);
            $this->autorender = false;
            $this->layout = false;
            $this->render('edit_skill');
        } elseif ($this->request->is('post')) {
            $id = $this->request->data['Users_profile']['id'];
            $this->Users_skill->id = $id;
            $this->request->data['Users_skill']['skill_id'] = $this->request->data['Users_profile']['skill_id'];
            $this->request->data['Users_skill']['start_date'] = $this->request->data['Users_profile']['start_date'];
            $this->request->data['Users_skill']['end_date'] = $this->request->data['Users_profile']['end_date'];
            $this->request->data['Users_skill']['user_id'] = $this->request->data['Users_profile']['user_id'];

            if (ClassRegistry::init('Users_skill')->save($this->request->data)) {
                $this->Session->setFlash('Skill sucsessfully added');
                $this->redirect(array('controller' => 'users_profiles', 'action' => 'showskills'));
            }

            //$this->loadModel();
            ClassRegistry::init('Users_skill')->save($this->request->data);
            //$this->Userexp->save($this->request->data);
            //exit;
            $this->redirect(array('controller' => 'users_profiles', 'action' => 'showskills'));
            //$this->set('exps',$data);
        }
    }

    public function edit_edu($id = null) {
        if ($this->request->is('ajax') && $this->Session->read($userid)) {
            //pr($this->request->data);
            $user_Array = $this->Session->read($userid);
            $uid = $user_Array['userid'];
            $this->loadModel('Users_qualification');
            $edu_id = $this->request->data["edu_id"];
            $this->loadModel('Institute');
            $institute_title = $this->request->data["institute_title"][0];
            $isInDB = $this->Institute->find('first', array('fields' => array('Institute.id'), 'conditions' => array("title = '" . $institute_title . "'")));
            if (isset($isInDB['Institute']['id'])) {
                $institute_id = $isInDB['Institute']['id'];
				
            } else {
                $cdata["Institute"]["title"] = $institute_title;
                $this->Institute->create();
                $this->Institute->save($cdata);
                $institute_id = $this->Institute->getInsertID();
			
                unset($cdata["Institute"]["title"]);
            }
            $this->loadModel('Qualification');
            $qualification_title = $this->request->data["qualification_title"][0];
            $isInDB = $this->Qualification->find('first', array('fields' => array('Qualification.id'), 'conditions' => array("title = '" . $qualification_title . "'")));
            if (isset($isInDB['Qualification']['id'])) {
                $qualification_id = $isInDB['Qualification']['id'];
            } else {
                $cdata["Qualification"]["title"] = $qualification_title;
                $this->Qualification->create();
                $this->Qualification->save($cdata);
                $qualification_id = $this->Qualification->getInsertID();
                unset($cdata["Qualification"]["title"]);
            }

            $this->request->data['Users_qualification']['id'] = $edu_id;
            $this->request->data['Users_qualification']['user_id'] = $uid;
            $this->request->data['Users_qualification']['institute_id'] = $institute_id;
            $this->request->data['Users_qualification']['qualification_id'] = $qualification_id;

            $this->request->data['Users_qualification']['grade'] = $this->request->data['users_qualifications']['grade'];
            $this->request->data['Users_qualification']['field_study'] = $this->request->data['users_qualifications']['field_study'];
            $this->request->data['Users_qualification']['user_id'] = $uid;

            $st_month = $this->request->data['users_qualifications']['stmonth'];
            $st_year = $this->request->data['users_qualifications']['styear'];
            $en_month = $this->request->data['users_qualifications']['enmonth'];
            $en_year = $this->request->data['users_qualifications']['enyear'];
            if ($st_month == 0) {
                $st_month = '00';
            }
            if ($st_year == 0) {
                $st_year = '00';
            }
            if ($en_month == 0) {
                $en_month = '00';
            }
            if ($en_year == 0) {
                $en_year = '00';
            }
            $start_date = $st_month . '-' . $st_year;
            $end_date = $en_month . '-' . $en_year;
            $this->request->data['Users_qualification']['start_date'] = $start_date;
            $this->request->data['Users_qualification']['end_date'] = $end_date;
            if (ClassRegistry::init('Users_qualification')->save($this->request->data)) {
                //$this->Session->setFlash('Skill sucsessfully added');
            }
            //pr($this->request->data['Users_qualification']);
        }
        $user_qualification = $this->useredu();
        $this->set('user_qualification', $user_qualification);
        $this->autoRender = false;
        $this->layout = false;
        $this->render('user_edu');

        /* if ($this->request->is('ajax')) {
          $id = $_GET['iD'];
          $counter = $_GET['counter'];
          $Institue_List = ClassRegistry::init('institutes')->find('all',array('order'=>'institutes.id DESC'));
          $this->set('Institue_List',$Institue_List);

          $qualifications_List = ClassRegistry::init('qualifications')->find('all',array('order'=>'qualifications.id DESC'));
          $this->set('qualifications_List',$qualifications_List);

          $this->Users_qualification->id = $id;
          $data = ClassRegistry::init('users_qualifications')->find('all',array('fields'=>array('users_qualifications.*,institutes.weburl'),
          'joins'=>array(array('alias' => 'institutes', 'table' => 'institutes', 'foreignKey' => false, 'conditions' => array('users_qualifications.institute_id = institutes.id'))),
          'conditions'=>array('users_qualifications.id='.$id)));
          $this->view = 'edit_edu';
          $this->set('userEduRec', $data);
          $this->set('id', $id);
          $this->set('cnt', $counter);
          $this->autorender = false;
          $this->layout = false;
          $this->render('edit_edu');
          } elseif ($this->request->is('post')) {
          $id = $this->request->data['Users_profile']['id'];
          $this->request->data['Users_qualification']['institute_id'] = $this->request->data['Users_profile']['institute_id'];
          $this->request->data['Users_qualification']['qualification_id'] = $this->request->data['Users_profile']['qualification_id'];
          $this->request->data['Users_qualification']['grade'] = $this->request->data['Users_profile']['grade'];
          $this->request->data['Users_qualification']['field_study'] = $this->request->data['Users_profile']['field_study'];
          $this->request->data['Users_qualification']['link'] = $this->request->data['Users_profile']['link'];
          $this->request->data['Users_qualification']['start_date'] = $this->request->data['Users_profile']['start_date'];
          $this->request->data['Users_qualification']['end_date'] = $this->request->data['Users_profile']['end_date'];
          $this->request->data['Users_qualification']['user_id'] = $this->request->data['Users_profile']['user_id'];
          $this->request->data['Users_qualification']['id'] = $id;
          $this->Users_qualification->id = $id;
          if (ClassRegistry::init('Users_qualification')->save($this->request->data)) {
          $this->Session->setFlash('Skill sucsessfully added');

          }
          $this->redirect(array('controller' => 'users_profiles', 'action' => 'useredu'));
          //$this->set('exps',$data);
          } */
    }

    public function delete_experience() {

        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
        if ($this->request->is('get')) {
            $exp_id = $_GET['exp_id'];
            $this->loadModel('Users_experience');
            /* User profile strength start */
            $this->loadModel('User_profile_strength');
            $user_Having_qualifiction_count = ClassRegistry::init('users_experiences')->find('all', array(
                'conditions' =>
                array(
                    'users_experiences.user_id' => $uid
            )));
            if (sizeof($user_Having_qualifiction_count) == 1) {
                $strength_qualification = (5 - 5);
            } else if (sizeof($user_Having_qualifiction_count) == 2) {
                $strength_qualification = (10 - 5);
            } else if (sizeof($user_Having_qualifiction_count) > 2) {
                $strength_qualification = (15 - 5);
            }
            $total_edu = sizeof($user_Having_qualifiction_count);

            $db = ConnectionManager::getDataSource('default');
            $db->rawQuery("DELETE FROM users_experiences WHERE id=" . $exp_id);

            if ($this->User_profile_strength->updateAll(array('qualification' => $strength_qualification), array('User_profile_strength.user_id' => $uid))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }

            $this->autorender = false;
            $this->layout = false;
            $this->render('delete_experience');
        }
    }

    public function delete_education() {

        if ($this->Session->read('userid')) {
            $uid = $this->Session->read('userid');
        }
        if ($this->request->is('get')) {
            $edu_id = $_GET['edu_id'];
            $this->loadModel('Users_qualification');
            /* User profile strength start */
            $this->loadModel('User_profile_strength');
            $user_Having_qualifiction_count = ClassRegistry::init('Users_qualification')->find('all', array(
                'conditions' =>
                array(
                    'Users_qualification.user_id' => $uid
            )));
            if (sizeof($user_Having_qualifiction_count) == 1) {
                $strength_qualification = (5 - 5);
            } else if (sizeof($user_Having_qualifiction_count) == 2) {
                $strength_qualification = (10 - 5);
            } else if (sizeof($user_Having_qualifiction_count) > 2) {
                $strength_qualification = (15 - 5);
            }
            $total_edu = sizeof($user_Having_qualifiction_count);

            $db = ConnectionManager::getDataSource('default');
            $db->rawQuery("DELETE FROM users_qualifications WHERE id=" . $edu_id);

            if ($this->User_profile_strength->updateAll(array('qualification' => $strength_qualification), array('User_profile_strength.user_id' => $uid))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }

            $this->autorender = false;
            $this->layout = false;
            $this->render('delete_education');
        }
    }

    public function _set_user($id) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        /*
         * Test allowing to not override submitted data
         */
        if (empty($this->request->data)) {
            $this->request->data = $this->User->findById($id);
        }

        $this->set('user', $this->request->data);

        return $this->request->data;
    }

    function admin_index() {

        $this->User->recursive = 0;
        /* echo "<pre>";
          print_r($this->User);
          exit; */
        $this->set('users', $this->paginate($this->User, $this->AlaxosFilter->get_filter()));

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function admin_view($id = null) {
        $profileData = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('user_id' => $id)));
        $this->set('users_profiles', $profileData[0]['users_profiles']);
        //$data = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('user_id' =>$id)));
        //  $this->set('users_profiles', $data[0]['users_profiles']);
        // $this->_set_user($id);
    }

    function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
            }
        }

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function admin_edit($id = null) {
        // $userEditProfile =  ClassRegistry::init('users')->find('all', array('conditions' => array('id' => $id)));
        $userEditProfile = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('user_id' => $id)));
        $this->set('user', $userEditProfile[0]['users_profiles']);


        //$this->User->id = $id;
//        ClassRegistry::init('users')->id = $id;
//	if (!ClassRegistry::init('users')->exists()) {
//	    throw new NotFoundException(___('invalid id for user'));
//	}
//
//	if ($this->request->is('post') || $this->request->is('put')) {
//	    if ($this->User->save($this->request->data)) {
//		$this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
//		$this->redirect(array('action' => 'index'));
//	    } else {
//		$this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
//	    }
//	}
//
//	$this->_set_user($id);
//
//	$roles = $this->User->Role->find('list');
//	$this->set(compact('roles'));
    }

    function admin_copy($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->create();

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
                $this->redirect(array('action' => 'index'));
            } else {
                //reset id to copy
                $this->request->data['User'][$this->User->primaryKey] = $id;
                $this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
            }
        }

        $this->_set_user($id);

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function admin_delete($id = null) {
        /* if (!$this->request->is('post')) {
          throw new MethodNotAllowedException();
          } */

        echo $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(___('invalid id for user'));
        }

        if ($this->User->delete($id)) {
            $this->Session->setFlash(___('user deleted'), 'flash_message', array('plugin' => 'alaxos'));
            $this->redirect(array('action' => 'index'));
        } elseif (count($this->User->validationErrors) > 0) {
            $errors_str = '<ul>';

            foreach ($this->User->validationErrors as $field => $errors) {
                foreach ($errors as $error) {
                    $errors_str .= '<li>';
                    $errors_str .= $error;
                    $errors_str .= '</li>';
                }
            }
            $errors_str .= '</ul>';

            $this->Session->setFlash(sprintf(___('the user was not deleted: %s'), $errors_str), 'flash_error', array('plugin' => 'alaxos'));
            $this->redirect($this->referer(array('action' => 'index')));
        } else {
            $this->Session->setFlash(___('user was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
            $this->redirect($this->referer(array('action' => 'index')));
        }
    }

    function admin_actionAll() {
        if (!empty($this->request->data['_Tech']['action'])) {
            if (isset($this->Auth)) {
                $request = $this->request;
                $request['action'] = $this->request->data['_Tech']['action'];

                if ($this->Auth->isAuthorized($this->Auth->user(), $request)) {
                    $this->setAction($this->request->data['_Tech']['action']);
                } else {
                    $this->Session->setFlash(___d('alaxos', 'not authorized'), 'flash_error', array('plugin' => 'alaxos'));
                    $this->redirect($this->referer());
                }
            } else {
                /*
                 * Auth is not used -> grant access
                 */
                $this->setAction($this->request->data['_Tech']['action']);
            }
        } else {
            $this->Session->setFlash(___d('alaxos', 'the action to perform is not defined'), 'flash_error', array('plugin' => 'alaxos'));
            $this->redirect($this->referer());
        }
    }

    function admin_deleteAll() {
        $ids = Set :: extract('/User/id[id > 0]', $this->request->data);
        if (count($ids) > 0) {
            if ($this->User->deleteAll(array('User.id' => $ids), false, true)) {
                $this->Session->setFlash(___('users deleted'), 'flash_message', array('plugin' => 'alaxos'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(___('users were not deleted'), 'flash_error', array('plugin' => 'alaxos'));
                $this->redirect($this->referer(array('action' => 'index')));
            }
        } else {
            $this->Session->setFlash(___('no user to delete was found'), 'flash_error', array('plugin' => 'alaxos'));
            $this->redirect($this->referer(array('action' => 'index')));
        }
    }

    /* User profile method */
	public function show_recommendation() {
		if ($this->request->is('get')) {
           $id = $_GET["id"];
           $type = $_GET["type"];
			$this->loadModel(Users_profile);
			$user_recommends = $this->Users_profile->get_recommendations($id,$type);
			$this->set('user_recommends',$user_recommends);
		}
		$this->autorender = false;
        $this->layout = false;
        $this->render('show_recommendation');
		
	}
    public function userprofile() {
        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $uid = $cuser['userid'];
            if ($this->request->is('get')) {
                $arr = $this->params['pass'];
                $urlID = $arr[0];
                //$userarr = explode('-',$urlID);
                $id = $urlID;
                $this->set('requested_user_id', $id);

                /* Check user for views for the current post */
                $this->loadModel('Users_viewing');
                $ip = $_SERVER["REMOTE_ADDR"];
                $datetime = date("Y-m-d H:i:s");

                $this->request->data['Users_viewing']['user_id'] = $uid;
                $this->request->data['Users_viewing']['viewings_id'] = $id;
                $this->request->data['Users_viewing']['viewings_type'] = "profile";
                $this->request->data['Users_viewing']['start_date'] = $datetime;
                $this->request->data['Users_viewing']['viewings_counts'] = 1;

                $checkCounters = ClassRegistry::init('users_viewings')->find('all', array('fields' => array('
																									 users_viewings.id,
																									 users_viewings.viewings_counts
																									 '),
                    'conditions' => array(
                        'users_viewings.user_id=' . $uid . '
																										 AND users_viewings.viewings_id=' . $id . ' AND
																										 users_viewings.viewings_type="profile"'
                    )
                        )
                );

                if ($checkCounters) {
                    foreach ($checkCounters as $view_profile_row) {
                        $view_id = $view_profile_row['users_viewings']['id'];
                        $counts = $view_profile_row['users_viewings']['viewings_counts'];
                    }
                    $counters = $counts + 1;
                    $this->request->data['Users_viewing']['viewings_counts'] = $counters;
                    $this->Users_viewing->id = $view_id;
                    if (ClassRegistry::init('Users_viewing')->save($this->request->data)) {
                        //$this->Session->setFlash('Counter successfully saved.');
                    } else {
                        echo "not updated";
                    }
                } else {

                    if (ClassRegistry::init('Users_viewing')->save($this->request->data)) {
                        //echo "field value saved";
                    } else {
                        echo "field value not saved";
                    }
                }

                $uers_p = ClassRegistry::init('users_profiles')->find('first', array('fields' => array(
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
																										'users_profiles.marital_status',
																										'users_profiles.gender',
																										'users_profiles.zip',
																										'users_profiles.address1',
																										'users_profiles.address2',
																										'users_profiles.phone',
																										'users_profiles.hide_year',
																										'users_profiles.lastname_hide',
																										'users_profiles.gender_hide',
																										'users_profiles.marital_status_hide',
																										'users_profiles.mobile_hide',
																										'users_profiles.phone_hide',
																										'users_profiles.tags_hide',
																										'users_profiles.address1_hide',
																										'users_profiles.address2_hide',
																										'users_profiles.country_id_hide',
																										'users_profiles.industry_id_hide',
																										'users_profiles.zip_hide',
																										'users_profiles.nationality_hide',
																										'users_profiles.city_hide',
																										'users.email',
																										'industries.title',
																										'nationality.name',
																										'nationality.id',
																										'countries.name',
																										'countries.id'
																										),
																					 'joins' => array(
																										array('alias' => 'users',
																											'table' => 'users',
																											'foreignKey' => false,
																											'conditions' => array('users_profiles.user_id = users.id'
																											)
																										),
																										array('alias' => 'countries',
																											'table' => 'countries',
																											'foreignKey' => false,
																											'type' => 'LEFT',
																											'conditions' => array('users_profiles.country_id = countries.id')
																										),
																										array('alias' => 'nationality',
																										
																										'table' => 'countries',
																										'foreignKey' => false,
																										'type' => 'LEFT',
																										'conditions' => array('users_profiles.nationality = nationality.id')
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


                $uers_exp = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																										  'users_experiences.id',
																										  'companies.id',
																										  'companies.title'
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
																						'limit' => 2,
																						'order' => 'STR_TO_DATE(users_experiences.end_date,"%m-%Y") DESC'
																						)
																		   );

                $uSers_exp[] = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																									   'users_experiences.start_date',
																									   'users_experiences.id',
																									   'users_experiences.designation',
																									   'users_experiences.end_date',
																									   'companies.id',
																									   'companies.title',
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
																			'conditions' => array('users_experiences.user_id='.$id.' AND users_experiences.end_date ="Present"'),
																					 'order' => 'STR_TO_DATE(users_experiences.start_date,"%m-%Y") DESC'
                    )
            );


            $uSers_exp[] = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																									   'users_experiences.start_date',
																									   'users_experiences.id',
																									   'users_experiences.designation',
																									   'users_experiences.end_date',
																									   'companies.id',
																									   'companies.title',
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
																			'conditions' => array('users_experiences.user_id='.$id.' AND users_experiences.end_date !="Present"'),
																					 'order' => 'STR_TO_DATE(users_experiences.end_date,"%m-%Y") DESC'
                    )
            );
			
			
			$total_user_experience = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																												   'users_experiences.start_date',
																												   'users_experiences.end_date'
																												   ),
																								 'conditions' => array('users_experiences.user_id='.$id)
                    )
            );
			$this->set('total_user_experience',$total_user_experience);

                $last_edu = ClassRegistry::init('users_qualifications')->find('all', array('fields' => array('
																									  users_qualifications.id,
																									  institutes.id,
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
																						'order' => 'STR_TO_DATE(users_qualifications.end_date,"%m-%Y") DESC'
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
            }
        }
        $userSkillRecords = ClassRegistry::init('users_skills')->find('all', array('fields' => array('
																								   DISTINCT users_skills.skill_id
																								   '),
            'conditions' => array('users_skills.user_id' => $id
            )
                )
        );
        if ($userSkillRecords) {
            foreach ($userSkillRecords as $assignSkill) {
                $skillArray[] .=$assignSkill['users_skills']['skill_id'];
            }
            $skillArray = @implode(',', $skillArray);

            $recommendsRecords = ClassRegistry::init('skill_recommendations')->find('all', array('conditions' => array('skill_recommendations.user_id' => $id, 'skill_recommendations.recommends' => $uid,
                    array('skill_recommendations.skill_id IN (' . $skillArray . ')'
                    )
                )
                    )
            );
            $this->set('recommendsRecords', $recommendsRecords);
        }

        /* Skill Recommendation for userprofile */

        $uers_RecommendedListingwithoutAjax = ClassRegistry::init('skill_recommendations')->find('all', array('fields' => array('
																															   skill_recommendations.recommends,
																															   skill_recommendations.skill_id,
																															   users_profiles.firstname,
																															   users_profiles.lastname,
																															   users_profiles.photo
																															   '),
            'joins' => array(
                array('alias' => 'users_profiles',
                    'table' => 'users_profiles',
                    'foreignKey' => false,
                    'conditions' => array(
                        'skill_recommendations.recommends = users_profiles.user_id'
                    )
                )
            ),
            'conditions' => array('skill_recommendations.user_id=' . $id . ' AND skill_recommendations.recommendation=1'
            )
                )
        );

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


        $currenUserL = $this->Session->read(@$userid);
        $loggedUser = $currenUserL['userid'];

        $chatRequest = ClassRegistry::init('cometchat_friends')->find('all', array('conditions' => array('
																									  (cometchat_friends.friend_id=' . $id . ' AND
																									   cometchat_friends.user_id=' . $loggedUser . ') OR
																									  (cometchat_friends.friend_id=' . $loggedUser . ' AND
																									   cometchat_friends.user_id=' . $id . ')'
            )
                )
        );

        $this->set('chatRequest', $chatRequest);

        $checkRequest = ClassRegistry::init('connections')->find('all', array('conditions' => array('
																								 (connections.friend_id=' . $id . ' AND connections.user_id=' . $loggedUser . ') OR (connections.friend_id=' . $loggedUser . ' AND connections.user_id=' . $id . ')'
            )
                )
        );
        $this->set('checkRequest', $checkRequest);

        $commonUser = ClassRegistry::init('connections')->find('all', array('fields' => array('
																						   connections.friend_id,
																						   connections.user_id
																						   '),
            'conditions' => array('(connections.user_id=' . $loggedUser . ' OR connections.friend_id=' . $loggedUser . ') AND connections.request=1'
            )
                )
        );
        $reqUser = ClassRegistry::init('connections')->find('all', array('fields' => array('
																						connections.friend_id,
																						connections.user_id
																						'),
            'conditions' => array('(connections.user_id=' . $id . ' OR connections.friend_id=' . $id . ') AND connections.request=1'
            )
                )
        );


        foreach ($reqUser as $req) {

            $reqArray[] = $req['connections']['friend_id'];
            $reqArray[] = $req['connections']['user_id'];
        }

        //$commonArrays = array_intersect($commArray, $reqArray);
        foreach ($reqArray as $key => $commValue) {
            if ($commValue != $id) {
                $commonUserArray[] = $commValue;
            }
        }

        $totalConnectionOfRequestUser = sizeof($reqUser);
        $this->set('totalUserRequestedConnections', $totalConnectionOfRequestUser);

        /* shared connection total start */
        foreach ($commonUser as $commShared) {

            $commArrayShared[] = $commShared['connections']['friend_id'];
            $commArrayShared[] = $commShared['connections']['user_id'];
        }
        foreach ($reqUser as $reqShared) {

            $reqArrayShared[] = $reqShared['connections']['friend_id'];
            $reqArrayShared[] = $reqShared['connections']['user_id'];
        }

        $commonArraysShared = array_intersect($commArrayShared, $reqArrayShared);

        foreach ($commonArraysShared as $key => $commValueShared) {
            if ($commValueShared != $loggedUser && $commValueShared != $id) {
                $commonSharedUserArray[] = $commValueShared;
            }
        }

        $shared_Users = sizeof($commonSharedUserArray);
        $this->set('shared_Users', $shared_Users);

        /* shared connection total end */
        if (sizeof($commonUserArray) > 1) {
            $commonUserArray = @implode(',', $commonUserArray);
            $getTotalUser = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id IN(' . $commonUserArray . ')')));
        } else {
            $getTotalUser = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id' => $commonUserArray[0])));
        }
        $this->set('getTotalUser', $getTotalUser);

        /*         * ************************************      To show user following and followers          ********************** */
        $userFollowings = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																									 users_followings.id,
																									 users_followings.status,
																									 count(users_followings.following_id) as total_following
																									 '),
            'conditions' => array('users_followings.user_id=' . $id . ' AND users_followings.following_type="users" AND users_followings.status=2'
            )
                )
        );

        $userFollows = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																								  users_followings.id,
																								  users_followings.status ,
																								  count(users_followings.user_id) as total_follow
																								  '),
            'conditions' => array('users_followings.following_id=' . $id . ' AND users_followings.following_type="users" AND users_followings.status=2'
            )
                )
        );


        $userFollowingsbyYou = $userFollowings[0][0];
        $userFollowingsbyYou = $userFollowingsbyYou['total_following'];
        $this->set('following', $userFollowingsbyYou);

        $userFollowYou = $userFollows[0][0];
        $userFollowYou = $userFollowYou['total_follow'];
        $this->set('followers', $userFollowYou);

        $checkUserFollowings = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																										  users_followings.id,
																										  users_followings.status
																										  '),
            'conditions' => array('users_followings.user_id=' . $uid . ' AND users_followings.following_id=' . $id . ' AND users_followings.following_type="users"'
            )
                )
        );
        $this->set('checkUserFollowings', $checkUserFollowings);

        $userFollowTable = $checkUserFollowings[0]['users_followings'];
        $following_id = $userFollowTable['id'];
        $this->set('following_id', $following_id);
        $status = $userFollowTable['status'];
        $this->set('following_status', $status);

        $this->set('userFollowings', $userFollowings);

        /* Text recommendation for user */
        $this->loadModel(Users_recommendation);
        $user_commendations_text = ClassRegistry::init('Users_recommendation')->find('all', array('fields' => array('
																												  Users_recommendation.recommended_text,
																												  Users_recommendation.created,
																												  users_profiles.firstname,
																												  users_profiles.lastname,
																												  users_profiles.photo,
																												   users_profiles.tags
																												  '),
																								  'order' => 'Users_recommendation.id',
																								  'joins' => array(
																												   array('alias' => 'users_profiles',
																														 'table' => 'users_profiles',
																														 'foreignKey' => false,
																								'conditions' => array('Users_recommendation.user_id = users_profiles.user_id'
																												  )
																								)
																												   ),
																								  'conditions' => array('Users_recommendation.friend_id' => $id
																														)
																								  )
																					 );

        $this->set('user_commendations_text', $user_commendations_text);
		$given_recommendation = ClassRegistry::init('Users_recommendation')->find('all',array('fields'=>array('Users_recommendation.id'),
																											  'conditions'=>array('Users_recommendation.user_id' => $id)
																											  )
																				  );
		$this->set('count_given_recommendation',sizeof($given_recommendation));
		
        if ($id) {
            $req_user_profile = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('
																											users_profiles.user_id' => $id
                )
                    )
            );

            $request_profile = $req_user_profile[0]['users_profiles'];
            $requested_user_name = $request_profile['firstname'];
            $this->set('requested_user_name', $requested_user_name);

            /* check current user for Text recommendation for the requested user */
            $recommendations_text_for_user = ClassRegistry::init('Users_recommendation')->find('all', array('conditions' => array(
                    'Users_recommendation.friend_id' => $id,
                    'Users_recommendation.user_id' => $loggedUser
            )));
            $counts_for_texts = sizeof($recommendations_text_for_user);
            //$this->paginate=array('conditions'=>$condition, 'limit'=>1);

            $this->set('counts_for_texts', $counts_for_texts);
        }

        /* User following companies START **********COMPANIES****** */
        $uers_following_companies = $this->Users_following->find('all', array('fields' => array('
																								Users_following.id,
																								Users_following.status,
																								Users_following.user_id,
																								Users_following.following_id,
																								companies.id,
																								companies.title,
																								companies.logo
																								   '),
																			  'order' => 'Users_following.id DESC',
																			  'joins' => array(
																							   array('alias' => 'companies',
																									 'table' => 'companies',
																									 'foreignKey' => false,
																									 'conditions' => array('Users_following.following_id = companies.id'
																														   )
																									 )
																							   ),
																			  'conditions' => array('Users_following.user_id=' . $id . ' AND
																										Users_following.following_type = "company" AND (Users_following.status=2 AND companies.flag="page")'
            )
                )
        );


        $this->set('uers_following_companies', $uers_following_companies);

        /* User following companies END **********COMPANIES****** */
        foreach ($uers_following_companies as $companies_id_row) {

            $company_Array[] = $companies_id_row['Users_following']['following_id'];
        }
        $company_Array = @implode(',', $company_Array);
        if ($company_Array) {
            $loggeduers_following_companies = $this->Users_following->find('all', array('conditions' => array(
                    array('Users_following.following_id IN (' . $company_Array . ')'),
                    'Users_following.user_id=' . $loggedUser . ' AND
																											  Users_following.following_type="company"'
                )
                    )
            );

            $this->set('loggeduers_following_companies', $loggeduers_following_companies);
        }

        /* User group joined */
        $groupsListing = ClassRegistry::init('groups')->find('all', array('fields' =>
            array('
																				  groups.id,
																				  groups.title,
																				  groups.logo,
																				  groups_types.title,
																				  users_followings.status,
																				  users_followings.id
																				  '),
            'limit' => 20,
            'order' => 'groups.id DESC',
            'joins' => array(
                array('alias' => 'groups_types',
                    'table' => 'groups_types',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('groups.group_type_id = groups_types.id'
                    )
                ),
                array('alias' => 'users_followings',
                    'table' => 'users_followings',
                    'foreignKey' => false,
                    'conditions' => array('users_followings.following_id = groups.id'
                    )
                )
            ),
            'conditions' => array('users_followings.following_type = "groups" AND
																								   users_followings.status=2 AND users_followings.user_id=' . $id
            )
                )
        );

        $this->set('groupsListing', $groupsListing);

        /* Starsign for the user Date of Birth */
        $this->loadModel('Star_sign');
        $user_starsign_dob = $this->Star_sign->find('all', array('fields' => array('
																			 Star_sign.id,
																			 Star_sign.name,
																			 Star_sign.start_date,
																			 Star_sign.end_date,
																			 Star_sign.icon
																			 '),
            'order' => 'Star_sign.id',
            'conditions' => array('Star_sign.status=2'
            )
                )
        );
        $this->set('user_starsign_dob', $user_starsign_dob);

        $following_users = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																								 users_followings.id,
																								 users_followings.status,
																								 users_followings.following_id,
																								 users_followings.user_id,
																								 users_profiles.firstname,
																								 users_profiles.lastname ,
																								 users_profiles.photo,
																								 users_profiles.handler,
																								 users_profiles.user_id,
																								 users_profiles.tags
																								 '),
																						'joins' => array(
																							array('alias' => 'users_profiles',
																								'table' => 'users_profiles',
																								'type' => 'left',
																								'foreignKey' => false,
																								'conditions' => array('users_followings.following_id = users_profiles.user_id'
																								)
																							)
																						),
																						'conditions' => array('users_followings.user_id=' . $id . ' AND users_followings.following_type ="users" AND users_followings.status=2'
																						)
																							)
																					);
        $this->set('following_users', $following_users);

        /* User followers */

        $follower_users = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																										users_followings.id,
																										users_followings.status,
																										users_followings.user_id,
																										users_followings.following_id,
																										users_profiles.firstname,
																										users_profiles.lastname ,
																										users_profiles.photo,
																										users_profiles.handler,
																										users_profiles.user_id,
																										users_profiles.tags
																										'),
																						'joins' => array(
																								array('alias' => 'users_profiles',
																									'table' => 'users_profiles',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('users_followings.user_id = users_profiles.user_id'
																									)
																								)
           																					 ),
            																			'conditions' => array('users_followings.following_id=' . $id . ' AND users_followings.following_type = "users" AND users_followings.status=2')));
        $this->set('follower_users', $follower_users);
		
		/*Current User following*/
		$your_following_users = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																											users_followings.id,
																											users_followings.following_id'
																											),
																					 'conditions' => array('users_followings.user_id=' .$uid. ' AND users_followings.following_type = "users" AND users_followings.status=2')));
		 $this->set('your_following_users', $your_following_users);
																					 
    }

    public function add_recommendation_text() {
        $this->loadModel(Users_recommendation);
        if ($this->request->is('post')) {
            $user_id = $_POST['user_id'];
            $friend_id = $_POST['friend_id'];
            $created = $_POST['created'];
            $modified = $_POST['modified'];
            $recommended_text = $_POST['recommended_text'];
            $this->request->data['Users_recommendation']['user_id'] = $user_id;
            $this->request->data['Users_recommendation']['friend_id'] = $friend_id;
            $this->request->data['Users_recommendation']['created'] = $created;
            $this->request->data['Users_recommendation']['modified'] = $modified;
            $this->request->data['Users_recommendation']['recommended_text'] = $recommended_text;
            if ($this->Users_recommendation->save($this->request->data)) {
                $user_commendations_text_ajax = ClassRegistry::init('Users_recommendation')->find('all', array('fields' => array('
																																   Users_recommendation.id,
																																   Users_recommendation.created,
																																   Users_recommendation.recommended_text,
																																   users_profiles.firstname,
																																   users_profiles.lastname,
																																   users_profiles.photo,
																																   users_profiles.tags
																																   '),
																											   'joins' => array(
																																array('alias' => 'users_profiles',
																																	  'table' => 'users_profiles',
																																	  'foreignKey' => false,
																																	  'conditions' => array('Users_recommendation.user_id = users_profiles.user_id'
                            )
                        )
                    ),
																											   'conditions' => array('Users_recommendation.friend_id' => $friend_id
                    )
                        )
                );

                $this->set('user_commendations_text_ajax', $user_commendations_text_ajax);
            } else {
                echo "text recommendation not saved";
            }
            $this->autorender = false;
            $this->layout = false;
            $this->render('add_recommendation_text');
        }
    }

    public function recommend_skill() {
        if ($this->request->is('post')) {
            $useridd = $_POST['userid'];
            $recommends = $_POST['recommends'];
            $recommendation = $_POST['recommendation'];
            $recommend_id = $_POST['recommend_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $skill = $_POST['skill'];
            $status = $_POST['status'];
            $this->request->data['Skill_recommendation']['user_id'] = $useridd;
            $this->request->data['Skill_recommendation']['recommends'] = $recommends;
            $this->request->data['Skill_recommendation']['recommendation'] = $recommendation;
            $this->request->data['Skill_recommendation']['skill_id'] = $skill;
            $this->request->data['Skill_recommendation']['status'] = $status;
            $this->request->data['Skill_recommendation']['start_date'] = $start_date;
            $this->request->data['Skill_recommendation']['end_date'] = $end_date;

            if ($recommend_id != '') {
                if ($recommendation == 1) {
                    $this->Skill_recommendation->updateAll(array('recommendation' => $recommendation, 'start_date' => '"' . $start_date . '"', 'end_date' => '"0000-00-00 00:00:00"', 'status' => 2), array('Skill_recommendation.id' => $recommend_id));
                } else {
                    $this->Skill_recommendation->updateAll(array('recommendation' => $recommendation, 'end_date' => '"' . $end_date . '"', 'start_date' => '"0000-00-00 00:00:00"', 'status' => 0), array('Skill_recommendation.id' => $recommend_id));
                }
                $this->Session->setFlash('Recommended successfully updated.');
            } else {
                ClassRegistry::init('Skill_recommendation')->save($this->request->data);
                $recommend_id = $this->Skill_recommendation->getInsertID();
                $this->Session->setFlash('Recommended successfully saved.');
            }
            $this->set('recommend_idd', $recommend_id);
            $this->set('recommendations', $recommendation);
            $this->set('skillid', $skill);
            $this->set('useridd', $useridd);
            if ($recommendation == 1) {
                $user_haveSkills = ClassRegistry::init('skill_recommendations')->find('all', array('conditions' => array('skill_recommendations.user_id=' . $useridd . ' AND skill_recommendations.recommendation=1 AND skill_recommendations.skill_id=' . $skill)));
            } else if ($recommendation == 0) {
                $user_haveSkills = ClassRegistry::init('skill_recommendations')->find('all', array('conditions' => array('skill_recommendations.user_id=' . $useridd . ' AND skill_recommendations.recommendation=1 AND skill_recommendations.skill_id=' . $skill)));
            }
            if ($user_haveSkills) {
                foreach ($user_haveSkills as $skillRow) {
                    $recommendedUsers[] .= $skillRow['skill_recommendations']['recommends'];
                }

                $recommendedUsers = @implode(',', $recommendedUsers);

                $uers_RecommendedListing = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id IN (' . $recommendedUsers . ')')));
                $this->set('uers_RecommendedListing', $uers_RecommendedListing);
            } else {
                
            }
            $this->autorender = false;
            $this->layout = false;
            $this->render('recommend_skill');
        }
    }

    /* my profile method */

    public function myprofile() {
        /* View Cache */
        $cacheAction = true;
        $cacheAction = array(
            'view' => 5000
                );
        $cacheAction = "1 hour";
        /* View Cache */

        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $id = $cuser['userid'];
            //$this->loadModel('Country');
            $uers_p = ClassRegistry::init('users_profiles')->find('first', array('fields' => array(
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
																									'users_profiles.marital_status',
																									'users_profiles.gender',
																									'users_profiles.zip',
																									'users_profiles.address1',
																									'users_profiles.address2',
																									'users_profiles.phone',
																									'users_profiles.hide_year',
																									'users_profiles.lastname_hide',
																									'users_profiles.gender_hide',
																									'users_profiles.marital_status_hide',
																									'users_profiles.mobile_hide',
																									'users_profiles.phone_hide',
																									'users_profiles.tags_hide',
																									'users_profiles.address1_hide',
																									'users_profiles.address2_hide',
																									'users_profiles.country_id_hide',
																									'users_profiles.industry_id_hide',
																									'users_profiles.zip_hide',
																									'users_profiles.nationality_hide',
																									'users_profiles.city_hide',
																									'users.email',
																									'industries.title',
																									'nationality.name',
																									'nationality.id',
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
																									array('alias' => 'nationality',
																										
																										'table' => 'countries',
																										'foreignKey' => false,
																										'type' => 'LEFT',
																										'conditions' => array('users_profiles.nationality = nationality.id')
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

			
            $uers_exp = ClassRegistry::init('users_experiences')->find('all', array('fields' => array('
																									  users_experiences.id',
																									  'companies.id',
																									  'companies.title'
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
																					'limit' => 2,
																					'order' => 'STR_TO_DATE(users_experiences.end_date,"%m-%Y") DESC'
																					)
																	   );


			$uSers_exp[] = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																									   'users_experiences.start_date',
																									   'users_experiences.id',
																									   'users_experiences.designation',
																									   'users_experiences.end_date',
																									   'companies.id',
																									   'companies.title',
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
																			'conditions' => array('users_experiences.user_id='.$id.' AND users_experiences.end_date ="Present"'),
																					 'order' => 'STR_TO_DATE(users_experiences.start_date,"%m-%Y") DESC'
                    )
            );


            $uSers_exp[] = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																									   'users_experiences.start_date',
																									   'users_experiences.id',
																									   'users_experiences.designation',
																									   'users_experiences.end_date',
																									   'companies.id',
																									   'companies.title',
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
																			'conditions' => array('users_experiences.user_id='.$id.' AND users_experiences.end_date !="Present"'),
																					 'order' => 'STR_TO_DATE(users_experiences.end_date,"%m-%Y") DESC'
                    )
            );
			
			
			$total_user_experience = ClassRegistry::init('users_experiences')->find('all', array('fields' => array(
																												   'users_experiences.start_date',
																												   'users_experiences.end_date'
																												   ),
																								 'conditions' => array('users_experiences.user_id='.$id)
                    )
            );
			$this->set('total_user_experience',$total_user_experience);
            $last_edu = ClassRegistry::init('users_qualifications')->find('all', array('fields' => array('
																									  users_qualifications.id,
																									  institutes.id,
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
																					  'order' => 'STR_TO_DATE(users_qualifications.end_date,"%m-%Y") DESC'
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
        }

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


        $currenUserL = $this->Session->read(@$userid);
        $loggedUser = $currenUserL['userid'];
        // $checkRequest = ClassRegistry::init('connections')->find('all',array('conditions'=>array('OR'=>array('AND'=>array('connections.friend_id' => $id,'connections.user_id'=>$loggedUser),'AND'=>array('connections.friend_id' => $loggedUser,'connections.user_id'=>$id)))));
        $checkRequest = ClassRegistry::init('connections')->find('all', array('conditions' => array('
																								 (connections.friend_id=' . $id . ' AND
																								  connections.user_id=' . $loggedUser . ')
																								 OR (connections.friend_id=' . $loggedUser . ' AND
																									 connections.user_id=' . $id . ')')));
        $this->set('checkRequest', $checkRequest);

$countTotalUsers =  ClassRegistry::init('connections')->find('count', array('fields' => array('
                                                                                                                                                                                   connections.friend_id,
                                                                                                                                                                                   connections.user_id,
                                                                                                                                                                                   connections.request
                                                                                                                                                                                   '),
            'conditions' => array('
                                                                                                                                                                                           (connections.user_id=' . $loggedUser . ' OR
                                                                                                                                                                                                connections.friend_id=' . $loggedUser . ') AND
                                                                                                                                                                                           connections.request=1'
            )));
        $commonUser = ClassRegistry::init('connections')->find('all', array('fields' => array('
																						   connections.friend_id,
																						   connections.user_id,
																						   connections.request
																						   '),
            'conditions' => array('
																							   (connections.user_id=' . $loggedUser . ' OR
																								connections.friend_id=' . $loggedUser . ') AND
																							   connections.request=1'
            )
                )
        );
        $reqUser = ClassRegistry::init('connections')->find('all', array('fields' => array('
																						connections.friend_id
																						'),
            'conditions' => array('connections.user_id=' . $id . ' AND connections.request=1'
            ), 'limit' => 10
                )
        );
        //$result[]='';
        //$totalConnectionOfCurrentUser = sizeof($commonUser);
		$totalConnectionOfCurrentUser = $countTotalUsers;
        /* To count total connection for user profile strength */

        /* User profile strength start */
        $this->loadModel('User_profile_strength');
        if ($totalConnectionOfCurrentUser != 0) {
            if (sizeof($totalConnectionOfCurrentUser) <= 10) {
                $strength_connection = 1;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 20 && sizeof($totalConnectionOfCurrentUser) > 10) {
                $strength_connection = 2;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 30 && sizeof($totalConnectionOfCurrentUser) > 20) {
                $strength_connection = 3;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 40 && sizeof($totalConnectionOfCurrentUser) > 30) {
                $strength_connection = 4;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 50 && sizeof($totalConnectionOfCurrentUser) > 40) {
                $strength_connection = 5;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 60 && sizeof($totalConnectionOfCurrentUser) > 50) {
                $strength_connection = 6;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 70 && sizeof($totalConnectionOfCurrentUser) > 60) {
                $strength_connection = 7;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 80 && sizeof($totalConnectionOfCurrentUser) > 70) {
                $strength_connection = 8;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 90 && sizeof($totalConnectionOfCurrentUser) > 80) {
                $strength_connection = 9;
            } else if (sizeof($totalConnectionOfCurrentUser) <= 100 && sizeof($totalConnectionOfCurrentUser) > 90) {
                $strength_connection = 10;
            } else if (sizeof($totalConnectionOfCurrentUser) > 100) {
                $strength_connection = 10;
            }

            if ($this->User_profile_strength->updateAll(array('connections' => $strength_connection), array('User_profile_strength.user_id' => $loggedUser))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
        } else {

            if ($this->User_profile_strength->updateAll(array('connections' => 0), array('User_profile_strength.user_id' => $loggedUser))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved connection strength";
            }
        }
        /* User profile strength end */

        $this->set('totalConnections', $totalConnectionOfCurrentUser);
        if (sizeof($commonUser) >= sizeof($reqUser)) {

            foreach ($commonUser as $cfid) {
                $fid = $cfid['connections']['friend_id'];
                $useid = $cfid['connections']['user_id'];
                foreach ($reqUser as $rfid) {
                    if ($rfid['connections']['friend_id'] == $fid) {
                        $result[] = $fid;
                    }
                }
                if ($useid != $loggedUser) {
                    $result[] .= $useid;
                }
            }
        } else {

            foreach ($reqUser as $cfid) {
                $fid = $cfid['connections']['friend_id'];
                foreach ($commonUser as $rfid) {
                    $useid = $rfid['connections']['user_id'];
                    if ($rfid['connections']['friend_id'] == $fid) {
                        $result[] = $fid;
                    }
                }
                if ($useid != $loggedUser) {
                    $result[] .= $useid;
                }
            }
        }

        if (sizeof($result) > 1) {
            $result = @implode(',', $result);
            $getTotalUser = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id IN(' . $result . ')')));
        } else {
            $getTotalUser = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id' => $result[0])));
        }

        $this->set('getTotalUser', $getTotalUser);

        /*         * ************************************      To show user following and followers          ********************** */
        $userFollowings = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																											 users_followings.id,
																											 users_followings.status,
																											 count(users_followings.following_id) as total_following
																											 '),
            'conditions' => array('users_followings.user_id=' . $id . ' AND users_followings.following_type="users" AND users_followings.status=2'
            )
                )
        );

        $userFollows = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																								  users_followings.id,
																								  users_followings.status ,
																								  count(users_followings.user_id) as total_follow
																								  '),
            'conditions' => array('users_followings.following_id=' . $id . ' AND users_followings.following_type="users" AND users_followings.status=2'
            )
                )
        );


        $userFollowingsbyYou = $userFollowings[0][0];
        $userFollowingsbyYou = $userFollowingsbyYou['total_following'];
        $this->set('following', $userFollowingsbyYou);

        $userFollowYou = $userFollows[0][0];
        $userFollowYou = $userFollowYou['total_follow'];
        $this->set('followers', $userFollowYou);
        $this->loadModel('User_profile_strength');
        /* User profile strength start ///////////////***FOLLOWERS* */
        if ($userFollowYou != 0) {
            if ($userFollowYou <= 10) {
                $strength_followers = 1;
            } else if ($userFollowYou <= 20 && $userFollowYou > 10) {
                $strength_followers = 2;
            } else if ($userFollowYou <= 30 && $userFollowYou > 20) {
                $strength_followers = 3;
            } else if ($userFollowYou <= 40 && $userFollowYou > 30) {
                $strength_followers = 4;
            } else if ($userFollowYou <= 50 && $userFollowYou > 40) {
                $strength_followers = 5;
            } else if ($userFollowYou <= 60 && $userFollowYou > 50) {
                $strength_followers = 6;
            } else if ($userFollowYou <= 70 && $userFollowYou > 60) {
                $strength_followers = 7;
            } else if ($userFollowYou <= 80 && $userFollowYou > 70) {
                $strength_followers = 8;
            } else if ($userFollowYou <= 90 && $userFollowYou > 80) {
                $strength_followers = 9;
            } else if ($userFollowYou <= 100 && $userFollowYou > 90) {
                $strength_followers = 10;
            } else if ($userFollowYou > 100) {
                $strength_followers = 10;
            }


            if ($this->User_profile_strength->updateAll(array('followers' => $strength_followers), array('User_profile_strength.user_id' => $id))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
        } else {
            if ($this->User_profile_strength->updateAll(array('followers' => 0), array('User_profile_strength.user_id' => $id))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
        }
        /* User profile strength end **********FOLLOWERS****** */


        /* User profile strength start ///////////////***FOLLOWERS* */
        if ($userFollowingsbyYou != 0) {
            if ($userFollowingsbyYou <= 10) {
                $strength_following = 1;
            } else if ($userFollowingsbyYou <= 20 && $userFollowingsbyYou > 10) {
                $strength_following = 2;
            } else if ($userFollowingsbyYou <= 30 && $userFollowingsbyYou > 20) {
                $strength_following = 3;
            } else if ($userFollowingsbyYou <= 40 && $userFollowingsbyYou > 30) {
                $strength_following = 4;
            } else if ($userFollowingsbyYou <= 50 && $userFollowingsbyYou > 40) {
                $strength_following = 5;
            } else if ($userFollowingsbyYou <= 60 && $userFollowingsbyYou > 50) {
                $strength_following = 6;
            } else if ($userFollowingsbyYou <= 70 && $userFollowingsbyYou > 60) {
                $strength_following = 7;
            } else if ($userFollowingsbyYou <= 80 && $userFollowingsbyYou > 70) {
                $strength_following = 8;
            } else if ($userFollowingsbyYou <= 90 && $userFollowingsbyYou > 80) {
                $strength_following = 9;
            } else if ($userFollowingsbyYou <= 100 && $userFollowingsbyYou > 90) {
                $strength_following = 10;
            } else if ($userFollowingsbyYou > 100) {
                $strength_following = 10;
            }

            if ($this->User_profile_strength->updateAll(array('following' => $strength_following), array('User_profile_strength.user_id' => $id))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
        } else {
            if ($this->User_profile_strength->updateAll(array('following' => 0), array('User_profile_strength.user_id' => $id))) {
                //$this->Session->setFlash('Strength successfully saved.');
            } else {
                echo "not saved handler strength";
            }
        }
        /* User profile strength end **********FOLLOWERS****** */

        /* User following companies START **********COMPANIES****** */
        $uers_following_companies = $this->Users_following->find('all', array('fields' => array('
																								   Users_following.id,
																								   Users_following.status,
																								   Users_following.following_id,
																								   companies.id,
																								   companies.title,
																								   companies.logo
																								   '),
            'order' => 'Users_following.id DESC',
            'joins' => array(
                array('alias' => 'companies',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'conditions' => array('Users_following.following_id = companies.id'
                    )
                )
            ),
            'conditions' => array('Users_following.user_id=' . $id . ' AND Users_following.following_type="company" AND (Users_following.status=2 AND companies.flag="page")'
            )
                )
        );

        $this->set('uers_following_companies', $uers_following_companies);

        /* User following companies END **********COMPANIES****** */

        /* Text recommendation for user */
        $this->loadModel(Users_recommendation);
        $user_commendations_text = ClassRegistry::init('Users_recommendation')->find('all', array('fields' => array('
																												  Users_recommendation.recommended_text,
																												  Users_recommendation.created,
																												  users_profiles.firstname,
																												  users_profiles.lastname,
																												  users_profiles.photo,
																												  users_profiles.handler,
																												  users_profiles.tags
																												  '),
																									'order' => 'Users_recommendation.id',
																									'joins' => array(
																										array('alias' => 'users_profiles',
																											'table' => 'users_profiles',
																											'foreignKey' => false,
																								'conditions' => array('Users_recommendation.user_id = users_profiles.user_id'
																											)
																										)
																									),
																									'conditions' => array('Users_recommendation.friend_id' => $id
																									)
																										)
																								);

        $this->set('user_commendations_text', $user_commendations_text);
		$given_recommendation = ClassRegistry::init('Users_recommendation')->find('all',array('fields'=>array('Users_recommendation.id'),
																											  'conditions'=>array('Users_recommendation.user_id' => $id)
																											  )
																				  );
		$this->set('count_given_recommendation',sizeof($given_recommendation));
        /* Text recommendation END **********Text recommendation****** */


        /* User group joined */
        $groupsListing = ClassRegistry::init('groups')->find('all', array('fields' => array('
																						   groups.id,
																						   groups.title,
																						   groups.logo,
																						   groups_types.title,
																						   users_followings.status,
																						   users_followings.id
																						   '),
            'limit' => 20,
            'order' => 'groups.id DESC',
            'joins' => array(
                array('alias' => 'groups_types',
                    'table' => 'groups_types',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('groups.group_type_id = groups_types.id'
                    )
                ),
                array('alias' => 'users_followings',
                    'table' => 'users_followings',
                    'foreignKey' => false,
                    'conditions' => array('users_followings.following_id = groups.id'
                    )
                )
            ),
            'conditions' => array('users_followings.following_type = "groups" AND users_followings.status =2 AND users_followings.user_id=' . $id
            )
                )
        );

        $this->set('groupsListing', $groupsListing);

        /* Starsign for the user Date of Birth */
        $this->loadModel('Star_sign');
        $user_starsign_dob = $this->Star_sign->find('all', array('fields' => array('Star_sign.id,Star_sign.name,Star_sign.start_date,Star_sign.end_date,Star_sign.icon'), 'order' => 'Star_sign.id',
            'conditions' => array('Star_sign.status=2')));
        $this->set('user_starsign_dob', $user_starsign_dob);

        $following_users = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																								 users_followings.id,
																								 users_followings.status,
																								 users_followings.following_id,
																								 users_followings.user_id,
																								 users_profiles.firstname,
																								 users_profiles.lastname ,
																								 users_profiles.photo,
																								 users_profiles.handler,
																								 users_profiles.user_id,
																								 users_profiles.tags
																								 '),
            'joins' => array(
                array('alias' => 'users_profiles',
                    'table' => 'users_profiles',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('users_followings.following_id = users_profiles.user_id'
                    )
                )
            ),
            'conditions' => array('users_followings.user_id=' . $id . ' AND users_followings.following_type ="users" AND users_followings.status=2'
            )
                )
        );
        $this->set('following_users', $following_users);

        /* User followers */

        $follower_users = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																											users_followings.id,
																											users_followings.status,
																											users_followings.user_id,
																											users_followings.following_id,
																											users_profiles.firstname,
																											users_profiles.lastname ,
																											users_profiles.photo,
																											users_profiles.handler,
																											users_profiles.user_id,
																											users_profiles.tags
																											'),
            'joins' => array(
                array('alias' => 'users_profiles',
                    'table' => 'users_profiles',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('users_followings.user_id = users_profiles.user_id'
                    )
                )
            ),
            'conditions' => array('users_followings.following_id=' . $id . ' AND users_followings.following_type = "users" AND users_followings.status=2')));
        $this->set('follower_users', $follower_users);
    }

    public function user_following() {
        $this->loadModel('Users_following');
        if ($this->request->is('get')) {
            $status = $_GET['status'];
            $id = $_GET['id'];
			if ($status && $id) {
				$following_record = $this->Users_following->find('first',array('fields'=>array('Users_following.following_id,Users_following.user_id'),
																							   'conditions'=>array('Users_following.id='.$id.' AND Users_following.following_type="users" AND Users_following.status=2')));
				$following_id = $following_record['Users_following']['following_id'];
				$user_id = $following_record['Users_following']['user_id'];
				if ($following_id && $user_id) {
				$retweeted_tweets_byuser = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.id'),
																			'conditions'=>array('tweets.parent_id =0 AND tweets.status=2 AND tweets.user_id='.$following_id)));
					foreach ($retweeted_tweets_byuser as $retweeted_by_user) {
						$content_array[] = $retweeted_by_user['tweets']['id'];
					}
					if ($content_array) {
						if (sizeof($content_array)>1) {
						$content_IDS = @implode(',',$content_array);
						}
						else {
						$content_IDS = $content_array;
						}
					}
					if ($content_IDS) {
						$db = ConnectionManager::getDataSource('default');
						$db->rawQuery('DELETE FROM tweets WHERE parent_id IN('.$content_IDS.') AND tweets.user_id='.$user_id);
					}
				}
			}
			
            $this->request->data['Users_following']['status'] = $status;
            $start_date = date("Y-m-d");
            $this->request->data['Users_following']['start_date'] = $start_date;
            $this->Users_following->id = $id;
            if ($this->Users_following->save($this->request->data)) {
                
            } else {
                echo "not saved";
            }
        }
        $this->set('status', $status);
        $this->set('follow_id', $id);
        $this->autorender = false;
        $this->layout = false;
        $this->render('user_following');
    }

    public function user_followers() {
        $this->loadModel('Users_following');
        if ($this->request->is('get')) {
            $status = $_GET['status'];
            $id = $_GET['id'];
            $user_id = $_GET['user_id'];
            $following_id = $_GET['following_id'];
			if ($status == 0 && $user_id) {
					$retweeted_tweets_byuser = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.id'),
																					'conditions'=>array('tweets.parent_id =0 AND tweets.status=2 AND tweets.user_id='.$user_id)));
					foreach ($retweeted_tweets_byuser as $retweeted_by_user) {
						$content_array[] = $retweeted_by_user['tweets']['id'];
					}
					if ($content_array) {
						if (sizeof($content_array)>1) {
						$content_IDS = @implode(',',$content_array);
						}
						else {
						$content_IDS = $content_array;
						}
					}
					if ($content_IDS) {
						$db = ConnectionManager::getDataSource('default');
						$db->rawQuery('DELETE FROM tweets WHERE parent_id IN('.$content_IDS.') AND tweets.user_id='.$following_id);
					}
							
				}
			
            $following_chk = $this->Users_following->find('all', array('fields' => array('Users_following.id'),
																						 'conditions' => array('Users_following.user_id=' . $following_id . ' AND Users_following.following_id=' . $user_id
																											   )
																						 )
														  );
			
            $this->request->data['Users_following']['status'] = $status;
            $start_date = date("Y-m-d");
            $this->request->data['Users_following']['start_date'] = $start_date;

            if ($following_chk) {
                $follow_array = $following_chk[0]['Users_following'];
                $id = $follow_array['id'];
                $this->Users_following->id = $id;
            } else {
                $this->request->data['Users_following']['following_type'] = 'users';
                $this->request->data['Users_following']['user_id'] = $following_id;
                $this->request->data['Users_following']['following_id'] = $user_id;
            }
            if ($this->Users_following->save($this->request->data)) {
                $id = $this->Users_following->getInsertID();
            } else {
                echo "not saved";
            }
        }
        $this->set('status', $status);
        $this->set('follow_id', $id);
        $this->autorender = false;
        $this->layout = false;
        $this->render('user_followers');
    }

    public function user_star() {
        $this->loadModel('Star_sign');
        if ($this->request->is('get')) {
            $star_id = $_GET["star_id"];
            $user_id = $_GET["user_id"];
            $user_starsign_detail_ajax = $this->Star_sign->find('all', array('conditions' => array('Star_sign.id=' . $star_id)));
            $this->set('user_starsign_detail_ajax', $user_starsign_detail_ajax);
            $user_profile = $this->getCurrentUser($user_id);
            $this->set('firstname', $user_profile['firstname']);
            $this->set('lastname', $user_profile['lastname']);
            $this->set('user_id', $user_profile['user_id']);
            $this->autorender = false;
            $this->layout = false;
            $this->render('user_star');
        }
    }

    public function companies_follow() {
        $this->loadModel('Users_following');
        if ($this->request->is('post')) {
            $following_id = $_POST["following_id"];
            $status = $_POST["status"];
            $user_id = $_POST["user_id"];
            $company_id = $_POST["company_id"];
            $result_id = $_POST["result_id"];
            $find_following_companies = $this->Users_following->find('all', array('conditions' => array(
                    'Users_following.user_id=' . $user_id . ' AND Users_following.following_type="company" AND Users_following.following_id=' . $company_id)));
            if ($find_following_companies) {
                if ($this->Users_following->updateAll(array('Users_following.status' => $status), array('Users_following.id' => $following_id))) {
                    $this->set('status', $status);
                    $this->set('following_id', $following_id);
                    $this->set('uid', $user_id);
                    $this->set('company_id', $company_id);
                    $this->set('result_id', $result_id);
                } else {
                    echo "not updated";
                }
            } else {
                $date_to_created = date("Y-m-d H:i:s");
                $this->request->data['Users_following']['user_id'] = $user_id;
                $this->request->data['Users_following']['following_id'] = $company_id;
                $this->request->data['Users_following']['following_type'] = "company";
                $this->request->data['Users_following']['status'] = $status;
                $this->request->data['Users_following']['start_date'] = $date_to_created;
                if ($this->Users_following->save($this->request->data)) {
                    $following_id = $this->Users_following->getInsertID();
                    $this->set('status', $status);
                    $this->set('following_id', $following_id);
                    $this->set('uid', $user_id);
                    $this->set('company_id', $company_id);
                    $this->set('result_id', $result_id);
                }
            }
            $this->set('status', $status);
            $this->set('following_id', $following_id);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('company_follow');
    }

    /* photo taking with  webcam uploading */

    public function upload() {

        if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
            exit;
        }

        $folder = MEDIA_PATH . 'files/user/original/';
        $filename = md5($_SERVER['REMOTE_ADDR'] . rand()) . '.jpg';

        $original = $folder . $filename;

        // The JPEG snapshot is sent as raw input:
        $input = file_get_contents('php://input');

        if (md5($input) == '7d4df9cc423720b7f1f3d672b89362be') {
            // Blank image. We don't need this one.
            exit;
        }

        $result = file_put_contents($original, $input);                    /* for large image saving */
        if (!$original) {
            echo '{
			"error"		: 1,
			"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
			}';
            exit;
        }

        $info = getimagesize($original);
        if ($info['mime'] != 'image/jpeg') {
            unlink($original);
            exit;
        }

        // Moving the temporary file to the originals folder:
        rename($original, MEDIA_PATH . 'files/user/original/' . $filename);
        $original = MEDIA_PATH . 'files/user/original/' . $filename;

        // Using the GD library to resize
        // the image into a thumbnail:

        $origImage = imagecreatefromjpeg($original);
        $newImage = imagecreatetruecolor(154, 110);
        imagecopyresampled($newImage, $origImage, 0, 0, 0, 0, 154, 110, 520, 370);

        imagejpeg($newImage, MEDIA_PATH . 'files/user/original/' . $filename);

        /* uploading to Database....... */
        $this->Users_profile->create();
        if ($this->Session->read(@$userid)) {
            $currentUser = $this->Session->read(@$userid);
            $id = $currentUser['userid'];
            $this->request->data['Users_profile']['photo'] = $filename;

            if ($this->Users_profile->updateAll(array('photo' => '"' . $filename . '"'), array('Users_profile.user_id' => $id))) {

                $source_image = MEDIA_PATH . 'files/user/original/' . $filename;

                $destination_logo_path = MEDIA_PATH . 'files/user/logo/' . $filename;
                $this->__imageresize($source_image, $destination_logo_path, 165, 165);


                $destination_thumb_path = MEDIA_PATH . 'files/user/thumbnail/' . $filename;
                $this->__imageresize($source_image, $destination_thumb_path, 100, 100);

                $destination_icon_path = MEDIA_PATH . 'files/user/icon/' . $filename;
                $this->__imageresize($source_image, $destination_icon_path, 50, 50);

                /* User profile strength start */
                $this->loadModel('User_profile_strength');
                if ($filename != '') {
                    $strength_photo = 5;
                } else {
                    $strength_photo = 0;
                }
                if ($this->User_profile_strength->updateAll(array('photo' => $strength_photo), array('User_profile_strength.user_id' => $id))) {
                    //$this->Session->setFlash('Strength successfully saved.');
                } else {
                    echo "not saved handler strength";
                }
                /* User profile strength end */
            } else {
                
            }
        }
        echo '{"status":1,"message":"Success!","filename":"' . $filename . '"}';

        //$this->redirect(array('controller'=>'users_profiles','action'=>'update'));
        exit;
    }

    /* photo taking with  webcam Browsing */

    public function browse() {

        header('Content-type: application/json');

        $perPage = 24;

        // Scanning the thumbnail folder for JPG images:
        $g = glob('files/users/*.jpg');

        if (!$g) {
            $g = array();
        }

        $names = array();
        $modified = array();

        // We loop though the file names returned by glob,
        // and we populate a second file with modifed timestamps.

        for ($i = 0, $z = count($g); $i < $z; $i++) {
            $path = explode('/', $g[$i]);
            $names[$i] = array_pop($path);

            $modified[$i] = filemtime($g[$i]);
        }

        // Multisort will sort the array with the filenames
        // according to their timestamps, given in $modified:

        array_multisort($modified, SORT_DESC, $names);

        $start = 0;

        // browse.php can also paginate results with an optional
        // GET parameter with the filename of the image to start from:

        if (isset($_GET['start']) && strlen($_GET['start']) > 1) {
            $start = array_search($_GET['start'], $names);

            if ($start === false) {
                // Such a phototure was not found
                $start = 0;
            }
        }

        // nextStart is returned alongside the filenames,
        // so the script can pass it as a $_GET['start']
        // parameter to this script if "Load More" is clicked

        $nextStart = '';

        if ($names[$start + $perPage]) {
            $nextStart = $names[$start + $perPage];
        }

        $names = array_slice($names, $start, $perPage);

        // Formatting and returning the JSON object:

        echo json_encode(array(
            'files' => $names,
            'nextStart' => $nextStart
        ));
    }

    public function user_send_message() {
        if ($this->request->is('post')) {
            //print_r($this->request->data);
            $data['reciver'] = $this->request->data['reciver'];
            $data['sender'] = $this->request->data['sender'];
            $data['subject'] = $this->request->data['subject'];
			$data['friendname'] = $this->request->data['recivername'];
			$data['user_id'] = $this->request->data['user_id'];
            $data['message'] = $this->request->data['message'];
			$user_Profiles = $this->getCurrentUser($data['user_id']);
			$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
            $this->Email->template = 'message';
			

            $this->set('subject', $data['subject']);
            $this->set('email', $data['sender']);
			$this->set('friendname', $data['friendname']);
			$this->set('sendername', $fullname);
			$this->set('user_designation', $user_Profiles['tags']);
            $this->set('data', $data['message']);
            $this->Email->sendAs = 'both';
            $this->Email->from = "NetworkWE<".$data['sender'].">";
            $this->Email->to = $data['reciver'];
            $this->Email->subject = $data['subject'];
            $this->Email->_debug = true;
            if ($this->Email->send()) {
                $this->Session->setFlash('your message has been sent.');
                $this->redirect('/users_profiles/myprofile/email_sent');
            }
        }
    }

    // chat invitation for user
    public function invite_for_chat() {
        if ($this->request->is('post')) {
            //print_r($this->request->data);
            $data['user_id'] = $this->request->data['user_id'];
            $data['friend_id'] = $this->request->data['friend_id'];
            $data['invite_date'] = $this->request->data['invite_date'];
            $data['status'] = $this->request->data['status'];
            if (ClassRegistry::init('cometchat_friends')->save($this->data)) {
				
				$friend_id = $data['friend_id'];
				$request_user_Email = $this->getUserEmailID($friend_id);
				$request_user_Email['email'];
				$requested_user_Profile = $this->getCurrentUser($friend_id);
				$requested_user = $requested_user_Profile['firstname'];
				
				$user_id = $data['user_id'];
				$user_Email = $this->getUserEmailID($user_id);
				$user_Profiles = $this->getCurrentUser($user_id);
				$fullname = $user_Profiles['firstname']." ".$user_Profiles['lastname'];
				$user_deisgnation = $user_Profiles['tags'];
				$connection_link = NETWORKWE_URL.'/users_profiles/networkwe_chat/u:'.$user_id.'/f:'.$friend_id.'';
				$profile_link = NETWORKWE_URL.'/pub/'.$user_Profiles['handler'];
				
				$this->Email->template = 'chat_request'; 
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
				
				$this->Email->subject = $requested_user_Profile['firstname'].' please add me to your NetworkWe Chat Connection.';
				$this->Email->_debug = true;  
				if ($this->Email->send()) { 
					
					$this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));
				}
            }
        }
    }
	
	public function networkwe_chat() {
		if (!empty($this->passedArgs['u']) && !empty($this->passedArgs['f'])){
			$user_id = $this->passedArgs['u'];
			$friend_id = $this->passedArgs['f'];
			$this->loadModel('Cometchat_friend');
			
			$this->request->data['Cometchat_friend']['status'] = 2;
			$this->request->data['Cometchat_friend']['friend_id'] = $friend_id;
			$this->request->data['Cometchat_friend']['user_id'] = $user_id;
			$date_accept = date('Y-m-d H:i:s');
			$this->request->data['Cometchat_friend']['accept_date'] = $date_accept;
			//$output = $this->Connection->saveConnection($user_id,$friend_id,$this->request->data['connections']['request']);
			$isChatInDB = $this->Cometchat_friend->find('first',array('fields'=>array('Cometchat_friend.id'),
																					  'conditions'=>array('
																			(Cometchat_friend.user_id ='.$user_id.' AND Cometchat_friend.friend_id ='.$friend_id.') OR (Cometchat_friend.user_id ='.$friend_id.' AND Cometchat_friend.friend_id ='.$user_id.')')
																			  ));
			$id = $isChatInDB['Cometchat_friend']['id'];	
			$this->Cometchat_friend->id = $id;
			if ($this->Cometchat_friend->save($this->request->data)) {
				$this->redirect(array('controller' => 'users_profiles', 'action' => 'userprofile',$friend_id));
			}
		}
	}
    public function chat_invitation() {

        $this->loadModel('Cometchat_friend');

        if ($this->request->is('post')) {

            $id = $_POST['invite_id'];
            $accept_date = $_POST['accept_date'];
            $this->Cometchat_friend->id = $id;
            $this->request->data['Cometchat_friend']['status'] = 2;
            $this->request->data['Cometchat_friend']['accept_date'] = $accept_date;
            if ($this->Cometchat_friend->save($this->request->data)) {
                //$this->redirect(array('controller' => 'home', 'action' => 'index'));
                $this->redirect($this->referer(array('action' => 'myprofile'), true));
            } else {
                echo "not saved";
                exit;
            }
        }
    }

    // skill recommended for current user
    function recommended_profiles() {
        if ($this->request->is('get')) {
            $skill_id = $_GET['id'];
            $user_id = $_GET['user_id'];
            $recommend_Users_for_skill = ClassRegistry::init('skill_recommendations')->find('all', array('fields' => array('skill_recommendations.recommends'),
                'conditions' => array('skill_recommendations.user_id=' . $user_id . ' AND skill_recommendations.recommendation=1 AND skill_recommendations.skill_id=' . $skill_id)));
            foreach ($recommend_Users_for_skill as $usersIDS) {
                $resultArray[] .=$usersIDS['skill_recommendations']['recommends'];
            }
            if (sizeof($resultArray) > 1) {
                $resultArray = @implode(',', $resultArray);
                $recommend_Users_for_skill = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id IN (' . $resultArray . ')')));
            } else {
                $recommend_Users_for_skill = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id =' . $resultArray[0])));
            }

            $this->set('recommend_Users_for_skill', $recommend_Users_for_skill);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('recommended_profiles');
    }

    public function search_skill() {
        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $uid = $cuser['userid'];

            $user_Had_Skills = ClassRegistry::init('users_skills')->find('all', array('fields' => array('users_skills.skill_id'),
                'conditions' => array('users_skills.user_id=' . $uid)));
            foreach ($user_Had_Skills as $user_had_row) {

                $skills_Array[] = $user_had_row['users_skills']['skill_id'];
            }
            $skills_Array_imploded = @implode(',', $skills_Array);
        }
        if ($this->request->is('get')) {
            //$this->loadModel('Users_profile');
            $search_str = $_GET['search_str'];
            if ($search_str) {
                if ($skills_Array_imploded) {
                    $search_Result_Skills = ClassRegistry::init('skills')->find('all', array('fields' => array('skills.title, skills.id'), 'limit' => 10, 'order' => 'skills.id DESC',
                        'conditions' => array('skills.title LIKE ' => '%' . $search_str . '%', array('skills.id NOT IN (' . $skills_Array_imploded . ') AND skills.status=2'))));
                } else {
                    $search_Result_Skills = ClassRegistry::init('skills')->find('all', array('fields' => array('skills.title, skills.id'), 'limit' => 10, 'order' => 'skills.id DESC', 'conditions' => array('skills.title LIKE ' => '%' . $search_str . '%', 'skills.status=2')));
                }
                $this->set('search_Result_Skills', $search_Result_Skills);
            }
        }

        $this->autorender = false;
        $this->layout = false;
        $this->render('search_skill');
    }

    /*
     * by Danish 29-01-2013
     */

    public function search_result($limit = 10, $offset = 0, $mode = 0, $arg1 = false) {

        //pr($this->request->data);
        //exit;
        $this->loadModel('Job');
        $this->loadModel('Users_profile');
        $this->loadModel('Group');
        $this->loadModel('Company');
        $this->loadModel('Country');
        $this->loadModel('Functional_area');
        $this->loadModel('Groups_type');
        $this->loadModel('Companies_type');
        $this->loadModel('Company_operating_status');
        $this->loadModel('Industry');

        /*
         * companies_types
          company_operating_statuses
          industries
         * $companies_type = $this->Company->find('all',array('fields'=>array('Company.title,companies_types.title'),
          'joins'=>array(array('alias' => 'companies_types', 'table' => 'companies_types', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('companies_types.id  = Company.company_type_id'))),
          'order'=>'Company.id DESC')); */

        $this->Job->recursive = 0;
        $this->Users_profile->recursive = 0;
        $this->Group->recursive = 0;
        $this->Company->recursive = 0;

        $countryList = $this->Country->find('list');
        $this->set('countryList', $countryList);
        $Functional_area = $this->Functional_area->find('list');
        $this->set('FunctionalAreaList', $Functional_area);
        $Groups_type = $this->Groups_type->find('list');
        $this->set('GroupsTypeList', $Groups_type);
        $Companies_type = $this->Companies_type->find('list');
        $this->set('CompaniesTypeList', $Companies_type);
        $Company_operating_status = $this->Company_operating_status->find('list');
        $this->set('CompanyOperatingStatusList', $Company_operating_status);
        $Industry = $this->Industry->find('list');
        $this->set('IndustryList', $Industry);

        if (isset($this->request->data)) {
            $SearchString = $this->request->data['search_str'] ? $this->request->data['search_str'] : $arg1;
            $SearchScope = $this->request->data['SearchScope'] ? $this->request->data['SearchScope'] : $mode;
            $country = $this->request->data['location'];
            $nationality = $this->request->data['nationality'];
            $functionalArea = $this->request->data['functionalArea'];

            $companies = $this->request->data['companies'];
            $company_operating_status = $this->request->data['company_operating_status'];
            $industry = $this->request->data['industry'];
            $group = $this->request->data['groups'];

            $this->set('SearchString', $SearchString);
            $this->set('SearchScope', $SearchScope);
            $this->set('country', $country);
            $this->set('nationality', $nationality);
            $this->set('functionalArea', $functionalArea);
            $this->set('companies', $companies);
            $this->set('company_operating_status', $group);
            $this->set('industry', $industry);
            $this->set('group', $group);

            $conditions = array();
            $conditionsJobs = array();
            $conditionsUsersProfiles = array();
            $conditionsCompanies = array();
            $conditionsGroups = array();
            if (!empty($SearchString)) {
                $conditionsJobs = array('Job.title LIKE' => '%' . $SearchString . '%');
                $temp = explode(" ", $SearchString);
                $conditionsUsersProfiles1 = array();
                foreach ($temp as $item) {
                    $conditionsUsersProfiles1[] = array('Users_profile.firstname LIKE' => '%' . $item . '%');
                    $conditionsUsersProfiles1[] = array('Users_profile.lastname LIKE' => '%' . $item . '%');
                }
                $conditionsUsersProfiles[] = array('OR' => $conditionsUsersProfiles1);
                $conditionsCompanies = array('Company.title LIKE' => '%' . $SearchString . '%');
                $conditionsGroups = array('Group.title LIKE' => '%' . $SearchString . '%');
            }

            $cond = array();
            $i = 1;
            switch ($SearchScope) {
                case 1 : if (!empty($country))
                        $cond[$i++] = array('AND' => array('Users_profile.country_id ' => $country));
                    if (!empty($nationality))
                        $cond[$i++] = array('AND' => array('Users_profile.nationality ' => $nationality));
                    $conditionsUsersProfiles = array_merge($conditionsUsersProfiles, array('AND' => array($cond)));
                    $dataUser = $this->Users_profile->find('all', array('fields' => array('Users_profile.id,Users_profile.firstname,Users_profile.lastname,Users_profile.country_id,Users_profile.nationality,Users_profile.photo,Users_profile.gender'), 'conditions' => $conditionsUsersProfiles, 'limit' => $limit, 'offset' => $offset));
                    $this->paginate = array('conditions' => $conditionsUsersProfiles, 'limit' => $limit);
                    $this->set('datauser', $this->paginate('Users_profile'));
                    break;
                case 2 : if (!empty($country))
                        $cond[$i++] = array('AND' => array('Job.country_id ' => $country));
                    $cond_function = array();
                    if (!empty($functionalArea)) {
                        $function = $this->jobs_functional_area->find('all', array('conditions' => array('jobs_functional_area.functional_area_id' => $functionalArea)));
                        foreach ($function as $row)
                            $cond_function[] = array('Job.id' => $row['jobs_functional_area']['job_id']);
                        $cond[$i++] = array('OR' => $cond_function);
                    }
                    $conditionsJobs = array_merge($conditionsJobs, array('AND' => array($cond)));
                    $datajobs = $this->Job->find('all', array('fields' => array('Job.id,Job.title,Job.country_id,jobs_functional_area.functional_area_id,Job.city,Country.name,Company.title,Company.logo,Company.title'), 'conditions' => $conditionsJobs, 'limit' => $limit, 'offset' => $offset));
                    $this->paginate = array('conditions' => $conditionsJobs, 'limit' => $limit);
                    $this->set('datajobs', $this->paginate('Job'));
                    break;
                case 3 : if (!empty($country))
                        $cond[$i++] = array('AND' => array('Company.country_id ' => $country));
                    $conditionsCompanies = array_merge($conditionsCompanies, array('AND' => array($cond)));
                    $dataCompany = $this->Company->find('all', array('fields' => array('Company.id,Company.title,Company.logo,Country.name'), 'conditions' => $conditionsCompanies, 'limit' => $limit, 'offset' => $offset));
                    $this->paginate = array('conditions' => $conditionsCompanies, 'limit' => $limit);
                    $this->set('datacompany', $this->paginate('Company'));
                    break;
                case 4 : if (!empty($country))
                        $cond[$i++] = array('AND' => array('Group.country_id ' => $country));
                    if (!empty($group))
                        $cond[$i++] = array('AND' => array('Group.group_type_id ' => $group));
                    $conditionsGroups = array_merge($conditionsGroups, array('AND' => array($cond)));
                    $dataGroups = $this->Group->find('all', array(
                        'fields' => array('Group.id,Group.title,groups_types.title'),
                        //'fields'=>array('Group.id,Group.title','groups_type.title'),
                        //'fields' => array('Group.*','Groups_type.*'),
                        /* 'joins' => array(
                          array(
                          'table' => 'Groups_types',
                          'alias' => 'Groups_types',
                          'type' => 'LEFT',
                          'conditions' => array(
                          'Groups_types.id' =>'Group.group_type_id'
                          )
                          ),
                          ), */
                        'conditions' => $conditionsGroups,
                        'limit' => $limit, 'offset' => $offset));
                    $this->paginate = array('conditions' => $conditionsGroups, 'limit' => $limit);
                    $this->set('datagroups', $this->paginate('Group'));
                    break;
                default : $datajobs = $this->Job->find('all', array('fields' => array('Job.id,Job.title,Job.country_id,Job.city,Country.name,Company.title,Company.logo'), 'conditions' => $conditionsJobs, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datajobs', $datajobs);
                    $dataUser = $this->Users_profile->find('all', array('fields' => array('Users_profile.id,Users_profile.photo,Users_profile.firstname,Users_profile.lastname,Users_profile.gender'), 'conditions' => $conditionsUsersProfiles, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datauser', $dataUser);
                    $dataCompany = $this->Company->find('all', array('fields' => array('Company.id,Company.title,Company.logo,Country.name'), 'conditions' => $conditionsCompanies, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datacompany', $dataCompany);
                    $dataGroups = $this->Group->find('all', array('fields' => array('Group.id,Group.title,groups_types.title'), 'conditions' => $conditionsGroups, 'limit' => $limit, 'offset' => $offset));
                    $this->set('datagroups', $dataGroups);

                    break;
            }
            if ($SearchScope != 0)
                $this->set('SearchFilter', TRUE);
            else
                $this->set('SearchFilter', FALSE);

            if ($this->RequestHandler->isAjax()) {
                $this->layout = false;
                $this->autoRender = false;
                if ($SearchScope != 0)
                    $this->render('/Users_profiles/search_result_ajax', 'ajax');
                else
                    $this->render('/Users_profiles/search_result', 'ajax');
            }
        }
    }

    public function review() {
        $this->loadModel('Settings_master');
        $this->Settings_master->recursive = 0;
        $this->loadModel('Settings_detail');
        $this->Settings_detail->recursive = 0;
        $this->loadModel('Users_setting');
        $this->Users_setting->recursive = 0;

        $cuser = $this->Session->read(@$userid);
        $uid = $cuser['userid'];

        $user_handler_record = ClassRegistry::init('users_profiles')->find('all', array('conditions' => array('users_profiles.user_id=' . $uid)));
        $this->set('handler_value', $user_handler_record[0]['users_profiles']['handler']);

        //$SettingsMasterList = $this->Settings_master->find('list');,array('fields'=>array('Settings_master.id,Settings_master.title,Settings_master.icon')
        $SettingsMasterList = $this->Settings_master->find('all');
        $this->set('SettingsMasterList', $SettingsMasterList);
        $SettingsDetailList = $this->Settings_detail->find('all', array(
            'order' => array('Settings_detail.settings_master_id', 'Settings_detail.title ASC'),
        ));
        $this->set('SettingsDetailList', $SettingsDetailList);

        $UsersSettingList = $this->Users_setting->find('all', array('conditions' => array('Users_setting.user_id' => $uid)));

        $this->set('UsersSettingList', $UsersSettingList);

        if (isset($this->request->data)) {

            foreach ($this->request->data as $option => $value) {
                if (substr($option, 0, 7) == 'option_') {
                    $settings_id = str_replace('option_', '', $option);
                    $this->Users_setting->create();
                    $DataGroup['settings_detail_id'] = $settings_id;
                    $DataGroup['user_preference'] = $value;
                    $DataGroup['user_id'] = $uid;
                    $duplicate = $this->Users_setting->find('first', array(
                        'fields' => array('count(*) as CNT'),
                        'conditions' => array(
                            'Users_setting.user_id' => $uid,
                            'Users_setting.settings_detail_id' => $settings_id
                        )
                    ));
                    if ($duplicate[0]['CNT'] > 0) {
                        $res = $this->Users_setting->updateALL(array(
                            'Users_setting.user_preference' => $value), array('Users_setting.user_id' => $uid, 'Users_setting.settings_detail_id' => $settings_id));
                    } else {
                        ClassRegistry::init('Users_setting')->save($DataGroup);
                    }
                }
            }
        }
        if ($this->RequestHandler->isAjax()) {
            $this->autoRender = false;
            //$this->render('/Users_profiles/review');
        }
    }

    public function change_password() {
        $response_array = array();
        $response_array['status'] = 'error';
        if ($this->request->is('post')) {
            if ($this->Session->read(@$userid)) {
                $cuser = $this->Session->read(@$userid);
                $uid = $cuser['userid'];
                $this->loadModel('User');
                $this->User->id = $uid;
                $user = $this->User->findById($uid);

                $usepass = $user['User']['password'];
                $oldpassword = hash('sha256', $this->request->data['oldpassword']);
                $currentpassword = hash('sha256', $this->request->data['password']);
                $conpassword = hash('sha256', $this->request->data['cpassword']);
                if ($usepass == $oldpassword) {
                    $this->request->data = '';
                    $this->request->data['password'] = $currentpassword;
                    if ($this->User->save($this->request->data)) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    $this->set('response_array', $response_array);
                }
            }
        }

        if ($this->RequestHandler->isAjax()) {
            $this->autoRender = false;
        }
    }

    public function camera() {

        $this->autorender = false;
        $this->layout = false;
        $this->render('camera');
    }

    public function add_summary() {
        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $uid = $cuser['userid'];
        }
        if ($this->request->is('post')) {
            $summary = $_POST['summary'];
            if (ClassRegistry::init('users_profiles')->updateAll(array('summary' => '"' . $summary . '"'), array('users_profiles.user_id' => $uid))) {
                
            } else {
                echo "not saved";
            }
            $this->autorender = false;
            $this->layout = false;
            $this->render('add_summary');
        }
    }

	public function user_delete() {
        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $uid = $cuser['userid'];
            $user = ClassRegistry::init('User')->findById($uid);
            unset($user['User']['role_id'], $user['User']['password'], $user['User']['theme_id'], $user['User']['register_mode'], $user['User']['varcode'], $user['User']['status'], $user['User']['created'], $user['User']['modified'], $user['Role']);
            $user_profile = ClassRegistry::init('Users_profile')->findByUserId($uid);
            unset($user_profile['Users_profile']['id'], $user_profile['Users_profile']['fullname']);

            foreach ($user_profile as $k => $v)
                $user_deleted = Hash::insert($user_profile, 'Deleted_users', $v);

            $user_deleted = Hash::remove($user_deleted, 'Users_profile');
            $user_deleted["Deleted_users"]["user_id"] = $user['User']['id'];
            $user_deleted["Deleted_users"]["user_profile_id"] = $user_profile['Users_profile']['user_id'];
            $user_deleted["Deleted_users"]["email"] = $user['User']['email'];
            $this->request->data['account_close_reason'] = $this->request->data['account_close_reason']?$this->request->data['account_close_reason']:'Unspecified.';
            if($this->request->data['account_close_reason'] == 'Other')
                $user_deleted["Deleted_users"]["reason"] = $this->request->data['account_close_reason_other'];
            else
                $user_deleted["Deleted_users"]["reason"] = $this->request->data['account_close_reason'];
            /*if (ClassRegistry::init('Deleted_users')->save($user_deleted) &&
                    ClassRegistry::init('Users_profile')->updateAll(array('Users_profile.firstname' => '\'Anonymous\'', 'Users_profile.lastname' => '\'User\'', 'Users_profile.status' => '-1', 'Users_profile.photo' => '\'\''), array('Users_profile.user_id =' => $uid)) &&
                    ClassRegistry::init('User')->updateAll(array('User.email' => '\'anonymous-' . $uid . '@networkwe.com\''), array('User.id =' => $uid))) {
                $json = json_encode(array('message' => 'Successfully closed account', 'status' => 'success', 'uid' => $uid));
            }*/
            if (ClassRegistry::init('Deleted_users')->save($user_deleted)){               
            
                $db = ConnectionManager::getDataSource('default');
                $db->rawQuery("DELETE FROM blogs WHERE user_id='".$uid."'");
                //$db->rawQuery("DELETE FROM category_news WHERE user_id='".$uid."'");
                //$db->rawQuery("DELETE FROM category_posts WHERE user_id='".$uid."'");
                //$db->rawQuery("DELETE FROM category_presses WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM cometchat WHERE cometchat.to ='".$uid."' OR cometchat.from ='".$uid."'");                
                $db->rawQuery("DELETE FROM cometchat_friends WHERE user_id='".$uid."' OR friend_id = '".$uid."'");
                $db->rawQuery("DELETE FROM cometchat_status WHERE userid='".$uid."'");
                $db->rawQuery("DELETE FROM cometchat_users WHERE id='".$uid."'");
                $db->rawQuery("DELETE FROM comments WHERE user_id ='".$uid."'");
                //$db->rawQuery("DELETE FROM companies WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM company_admins WHERE user_id ='".$uid."'");
                $db->rawQuery("DELETE FROM company_users WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM connections WHERE user_id='".$uid."' OR friend_id = '".$uid."'");
                $db->rawQuery("DELETE FROM entity_comments WHERE user_id='".$uid."'"); 
                $db->rawQuery("DELETE FROM entity_updates WHERE user_id='".$uid."'"); 
                $db->rawQuery("DELETE FROM favorites WHERE user_id='".$uid."'");
                //$db->rawQuery("DELETE FROM groups WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM jobs_applications WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM jobs_referrals WHERE user_id='".$uid."' OR friend_id = '".$uid."'");
                $db->rawQuery("DELETE FROM jobs_saved WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM likes WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM news WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM skill_recommendations WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM statusupdates WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM tags WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM tweets WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM tweet_comments WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_experiences WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_followings WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_profiles WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_qualifications WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_settings WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_skills WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users_viewings WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM user_profile_strengths WHERE user_id='".$uid."'");
                $db->rawQuery("DELETE FROM users WHERE id='".$uid."'");
                
                $this->Session->write('userid', '');
                $this->Session->write('theme', '');
                $this->Session->write('role_id', '');
                $this->Session->write('fullname', '');
                $this->Session->write('email', '');
                $this->Session->write('photo', '');
                $this->Session->write('handler', '');
                setcookie("cc_data", "", time() - 3600);
                $this->Cookie->destroy();
                $this->Session->setFlash('Successfully closed account');
                $this->redirect(NETWORKWE_URL);
                //exit;
                //$this->redirect($this->Auth->logout());
                //$json = json_encode(array('message' => 'Successfully closed account', 'status' => 'success', 'uid' => $uid));
            }
            else
                $json = json_encode(array('message' => 'Error occurred while processing!', 'status' => 'error', 'uid' => $uid));
        }

        if ($this->RequestHandler->isAjax()) {
            $this->autoRender = false;
            $this->layout = false;
            $this->response->body($json);
            $this->set('message', $json);
            $this->render('/Elements/default_json_response');
        }
    }

    /* BIRTH DAY WISH */

    public function wish_birthday() {
        if ($this->Session->read(@$userid)) {
            $cuser = $this->Session->read(@$userid);
            $uid = $cuser['userid'];
        }
        if ($this->request->is('post')) {
            $birthday_text = $_POST['brithday_text'];
            $my_id = $_POST['my_id'];
            $friend_id = $_POST['friend_id'];
            $created_date = date('Y-m-d H:i:s');
            $type = "birthday";
            $this->request->data['users_messages']['user_message'] = $birthday_text;
            $this->request->data['users_messages']['user_id'] = $my_id;
            $this->request->data['users_messages']['friend_id'] = $friend_id;
            $this->request->data['users_messages']['subject_type'] = $type;
            $this->request->data['users_messages']['status'] = 2;
            $this->request->data['users_messages']['created'] = $created_date;
            if (ClassRegistry::init('users_messages')->save($this->request->data)) {

                $birthday_messages = ClassRegistry::init('users_messages')->find('all', array('fields' => array('
																											   users_profiles.birth_date,
																											   users_profiles.firstname,
																											   users_profiles.lastname,
																											   users_profiles.tags,
																											   users_profiles.photo,
																											   users_profiles.user_id,
																											   users_messages.user_message,
																											   users_messages.created
																												'),
																							'joins' => array(
																								array('alias' => 'users_profiles',
																									'table' => 'users_profiles',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('users_messages.user_id  = users_profiles.user_id'
																									)
																								)
																							),
																							'conditions' => array('users_messages.friend_id=' . $friend_id . ' AND users_messages.subject_type="birthday" AND users_messages.created >= DATE_ADD(CURDATE(), INTERVAL -10 DAY)')
																						));


				
                $this->set('birthday_messages', $birthday_messages);

                $sender = $this->getUserEmailID($my_id);
                $reciver = $this->getUserEmailID($friend_id);
                $yourname = $this->getCurrentUser($my_id);
                $friendname = $this->getCurrentUser($friend_id);
                //$birth_day_message = "Hi " . $friendname['firstname'] . " <br /> " . $birthday_text . " <br />" . $yourname['firstname'];
                $this->Email->template = 'message';

                $this->set('subject', 'Happy Birth Day');
                $this->set('email', $sender['email']);
				$this->set('friendname', $friendname['firstname']);
				$this->set('sendername', $yourname['firstname']);
				$this->set('user_designation', $yourname['tags']);
                $this->set('data', $birthday_text);
                $this->Email->sendAs = 'both';
                $this->Email->FromName = 'NetworkWe';
                $this->Email->from = "NetworkWE<".$sender['email'].">";
                $this->Email->to = $reciver['email'];
                $this->Email->subject = 'Happy Birth Day';
                $this->Email->_debug = true;
                if ($this->Email->send()) {
                    
                }
            }
            $this->autorender = false;
            $this->layout = false;
            $this->render('wish_birthday');
        } // post end here
    }

    /* users activities */

    public function activities() {

        if ($friends_Lists) {
            $current_date = date('Y-m-d');

            $friends_Lists = @implode(',', $friends_Lists);

            $currentdate = date("Y-m-d");
            $currentdate = "'" . $currentdate . "'";

            $commingdate = date("Y-m-d", strtotime("+10 day"));
            $commingdate = "'" . $commingdate . "'";
            $users_birthdays = ClassRegistry::init('users_profiles')->find('all', array('fields' => array('
																										   users_profiles.birth_date,
																										   users_profiles.firstname,
																										   users_profiles.lastname,
																										   users_profiles.tags,
																										   users_profiles.photo,
																										   users_profiles.city,
																										   users_profiles.user_id
																										   '),
                'conditions' => array(array('users_profiles.user_id IN (' . $friends_Lists . ')'), 'DATE_FORMAT(date(users_profiles.birth_date),"%m-%d") BETWEEN  DATE_FORMAT(' . $currentdate . ',"%m-%d") AND DATE_FORMAT(' . $commingdate . ',"%m-%d")'),
                'order' => 'users_profiles.birth_date DESC'
            ));
        }
        $this->set('users_birthdays', $users_birthdays);

        $users_birthdays = ClassRegistry::init('users_messages')->find('all', array('fields' => array('
																									users_messages.user_message,
																									users_messages.user_id,
																									users_messages.friend_id,
																									users_messages.created,
																									users_profiles.firstname,
																									users_profiles.lastname,
																									users_profiles.photo,
																									users_profiles.user_id
																									'),
            'joins' => array(
                array('alias' => 'users_profiles',
                    'table' => 'users_profiles',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('users_messages.user_id  = users_profiles.user_id'
                    )
                )
            ),
            'conditions' => array('users_messages.subject_type="birthday"')
        ));
    }

}

?>
