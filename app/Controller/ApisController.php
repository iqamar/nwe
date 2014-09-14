<?php

/**
 * APIs Controller
 *
 * 
 */
class ApisController extends AppController {

    var $name = 'Apis';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    //var $jobs = array('Job', 'jobs_description', 'jobs_functional_area', 'jobs_keyword', 'jobs_location', 'jobs_qualifications');

    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }



function saveJobs(){

	$data["title"] = $_POST["title"];
    $data["description"] = $_POST["description"];
	$data["start_date"] =  date( 'Y-m-d H:i:s', strtotime(str_replace('-', '/',$_POST["start_date"])));
   	$data["expiry_date"] = date( 'Y-m-d H:i:s',strtotime(str_replace('-', '/',$_POST["expiry_date"])));
    $data["country_id"] = $_POST["locations"];
    $data["city"] = $_POST["city"];
   	$data["job_type"] = $_POST["employment_type"];
    $data["vacancies"] = $_POST["vacancies"];
	if("checked" == $_POST["manages"]){
	   	$data["manages_team"] = 1;
	}else{

		$data["manages_team"] = 0;
	}	



	$jobs = ClassRegistry::init("jobs");
       
 	$jobs->saveAll($data);

	if($jobs->id>0){
		echo $jobs->id;
	}else{
		echo 0;
	}

	


/*
job_id

company_id
posted_on
expiry_date
job_code

experience
offered_salary
enabled
created
created_by
modified
modified_by*/





	exit;
}
    function admin_index() {




	$jobData = ClassRegistry::init('jobs')->find('all', array('fields' => array('DISTINCT countries.name, companies.company_title, jobs.job_id, jobs.title,jobs.experience, jobs.posted_on, jobs.expiry_date, jobs.job_code, jobs.enabled,	jobs.created_by
	    '), 'joins' => array(array('alias' => 'companies', 'table' => 'companies', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('companies.company_id = jobs.company_id')),
		//array('alias' => 'jobs_descriptions', 'table' => 'jobs_descriptions', 'foreignKey' => false, 'conditions' => array('jobs_descriptions.job_id = jobs.job_id')),
		//array('alias' => 'jobs_functional_areas', 'table' => 'jobs_functional_areas', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_functional_areas.job_id = jobs.job_id')),
		//array('alias' => 'functional_areas', 'table' => 'functional_areas', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_functional_areas.functional_area_id = functional_areas.functional_area_id')),
		array('alias' => 'jobs_locations', 'table' => 'jobs_locations', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_locations.job_id = jobs.job_id')),
		array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_locations.location_id = countries.id'))
	    ), 'order' => array('jobs.job_id')));
	//echo "<pre>";
	//print_r($jobData);
	$this->set('jobs', $jobData);
	//print_r($subskill);
//$roles = $this->User->Role->find('list');
//$this->set(compact('roles'));
    }



    function admin_view($id = null) {
	$this->_set_user($id);
    }

    function admin_add() {
	//echo "<pre>";
	//print_r($_REQUEST);
	if ($this->request->is('post')) {

	    $formData['title'] = $this->request->data['jobTitle'];
	    $formData['company_id'] = $this->request->data['selectComapny'];
	    $formData['posted_on'] = date('Y-m-d H:i:s', (strtotime($this->request->data['start_date'])));
	    $formData['expiry_date'] = date('Y-m-d H:i:s', (strtotime($this->request->data['expiryDate'])));
	    $formData['experience'] = $this->request->data['exp_start'] . " to " . $this->request->data['exp_end'];
	    $userData = $this->Session->read(@$userid);
	    $formData['created_by'] = $userData['Auth']['User']['id'];
	    $formData['created'] = date('Y-m-d H:i:s', (strtotime(date())));

	    $formData['enabled'] = '1';

	    //print_r($formData);
	    // exit;
	    ///job_code	varchar(150)	latin1_swedish_ci		No	None		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
	    ///job_type	varchar(255)	latin1_swedish_ci		No	None		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext
	    ///offered_salary	varchar(50)	latin1_swedish_ci		No	None		 Browse distinct values	 Change	 Drop	 Primary	 Unique	 Index	Fulltext



	    $this->Job->create();
	    if ($this->Job->save($formData)) {
		$job_id = $this->Job->getLastInsertId();

		$jdData['job_id'] = $job_id;
		$jdData['position_function'] = $this->request->data['position_function'];
		$jdData['desired_profile'] = $this->request->data['desired_profile'];
		$jdData['extras'] = $this->request->data['more_details'];

		$jlData['job_id'] = $job_id;
		$jlData['location_id'] = $this->request->data['locations'];

		$jfaData['job_id'] = $job_id;
		$jfaData['functional_area_id'] = $this->request->data['functionalArea'];

		$jqData['job_id'] = $job_id;
		$jqData['qualification_id'] = $this->request->data['qualifications'];

		ClassRegistry::init('jobs_descriptions')->save($jdData);
		ClassRegistry::init('jobs_locations')->save($jlData);
		ClassRegistry::init('jobs_functional_areas')->save($jfaData);
		ClassRegistry::init('jobs_qualifications')->save($jqData);


		$this->Session->setFlash(___('the job has been saved '), 'flash_message ', array('plugin' => 'alaxos'));
		$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(___('the job could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1'))));
	    $this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.enabled' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));
	    $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.enabled' => '1'))));
	}
    }

    function admin_edit($id = null) {
	$this->User->id = $id;
	if (!$this->User->exists()) {
	    throw new NotFoundException(___('invalid id for user'));
	}

	if ($this->request->is('post') || $this->request->is('put')) {
	    if ($this->User->save($this->request->data)) {
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

	$this->Job->job_id = $id;
	if (!$this->Job->exists()) {
	    throw new NotFoundException(___('invalid id for Job'));
	}

	if ($this->Job->delete($id)) {
	    $this->Session->setFlash(___('Job deleted'), 'flash_message', array('plugin' => 'alaxos'));
	    $this->redirect(array('action' => 'index'));
	} else {
	    $this->Session->setFlash(___('Job was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
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

    function search() {
	//if ($this->request->data['term'])
	if ($this->request->is('post')) {
	    echo $usernames = $this->request->data['User']['username'];
	    $uss = ClassRegistry::init('users')->find('all', array('conditions' => array('users.username' => $usernames)));
	    print_r($uss);
	    // exit;
	    // $this->set('user_con',$users);
	    $this->redirect(array('controller' => 'users', 'action' => 'search











'));
	}
    }

}
?>