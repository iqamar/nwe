<?php

class EmployersController extends AppController {

    var $name = 'Employers';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    //'ImageResize'
    var $employers = array('companies'); //, 'jobs_description', 'jobs_functional_area', 'jobs_keyword', 'jobs_location', 'jobs_qualifications');

    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }

    function admin_index() {
	$jobData = ClassRegistry::init('companies')->find('all');
	$this->set('companies', $jobData);
    }

    function admin_view($id = null) {
	$this->_set_user($id);
    }

    function admin_add() {
	//echo "<pre>";
	//print_r($_REQUEST);
	if ($this->request->is('post')) {


	    $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
	    $comapny_logo = strtotime(date('m/d/Y h:i:s a', time())) . "." . $ext;
	    $filename = WWW_ROOT . 'files/companies_logo/' . $comapny_logo;
	    //WWW_ROOT. DS . 'documents'.DS.$this->request->data['Post']['doc_file']['name'];
	    move_uploaded_file($this->request->params['form']['logo']['tmp_name'], $filename);



	    /*

	      if ($this->ImageResize->isUploadedFile($this->request->params['form']['logo'])) {
	      // set the resize data for the FileUpload Component
	      // resize_data holds the resize settings
	      $prefs = array('resize_data' => array(RESIZE_WIDTH, '50', null));
	      $errors = $this->ImageResize->uploadFile($filename, $prefs);
	      }
	     */

	    //$uploadFolder = "images";
	    //full path to upload folder
	    // $uploadPath = WWW_ROOT . $uploadFolder;
	    //echo $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot . 'app/webroot/files/' . $this->data['Document']['submittedfile']['name'];
	    $this->request->data['company_title'] = $this->request->data['selectComapny'];
	    $this->request->data['logo'] = $comapny_logo;
	    /* $formData['posted_on'] = date('Y-m-d H:i:s', (strtotime($this->request->data['start_date'])));
	      $formData['expiry_date'] = date('Y-m-d H:i:s', (strtotime($this->request->data['expiryDate'])));
	      $formData['experience'] = $this->request->data['exp_start'] . " to " . $this->request->data['exp_end']; */
	    $userData = $this->Session->read(@$userid);
	    $this->request->data['created_by'] = $userData['Auth']['User']['id'];
	    $this->request->data['created'] = date('Y-m-d H:i:s', (strtotime(date('m/d/Y h:i:s a', time()))));

	    $this->request->data['status'] = '1';

	    /* echo "<pre>";
	      print_r($this->request->data);
	      exit; */

	    //$this->employers->create();

	    if (ClassRegistry::init('companies')->save($this->request->data)) {
		/* $job_id = $this->Job->getLastInsertId();

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
		  ClassRegistry::init('jobs_qualifications')->save($jqData); */


		$this->Session->setFlash(___('the job has been saved '), 'flash_message ', array('plugin' => 'alaxos'));

		//$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(___('the job could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1'))));
	    $this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.status' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));
	    $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.status' => '1'))));
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