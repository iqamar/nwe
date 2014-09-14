<?php

class InstitutesController extends AppController {

    var $name = 'Institutes';
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
	//$companies = ClassRegistry::init('institutes')->find('all');
	$institutesListing = ClassRegistry::init('institutes')->find('all',array('fields' => array('institutes.*,countries.*'),'limit'=>20,'order'=>'institutes.id DESC', 
'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('institutes.country_id = countries.id')),																																					  
)));
	$this->set('institutes', $institutesListing);
    }

    function admin_view($id = null) {
	//$this->_set_user($id);
        $instituteListing = ClassRegistry::init('institutes')->find('first', array('conditions' => array('institutes.id' => $id)));
        $this->set('institute', $instituteListing);
    }

    function admin_add() {
//	echo "<pre>";
//	print_r($_REQUEST);
//exit;
	if ($this->request->is('post')) {


	    $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
	    $institute_logo = strtotime(date('m/d/Y h:i:s a', time())) . "." . $ext;
	    $filename = WWW_ROOT . 'files/institutes_logo/' . $institute_logo;
	    
	    move_uploaded_file($this->request->params['form']['logo']['tmp_name'], $filename);



	 

	   $this->request->data['title'] = $this->request->data['selectInstitutes'];
	    $this->request->data['logo'] = $institute_logo;
	   

		$this->request->data['institute_type_id'] = $this->request->data['institutes_types'];
		$this->request->data['established'] = $this->request->data['established'];


		$this->request->data['country_id'] = $this->request->data['locations'];
		$this->request->data['contact_name'] = $this->request->data['contact_name'];
		$this->request->data['designation'] = $this->request->data['design'];
		if(isset($this->request->data['featured_institute'])){
			$this->request->data['featured_display'] = 1;
		}else{
			$this->request->data['featured_display'] = 0;
		}


		if(isset($this->request->data['top_institutes'])){
			$this->request->data['top_institutes_display'] = 1;
		}else{
			$this->request->data['top_institutes_display'] = 0;
		}
/*

echo "<pre>";
print_r($this->request->data);
exit;
*/

	    $userData = $this->Session->read(@$userid);

	    $this->request->data['user_id'] = $userData['Auth']['User']['id'];

	    $this->request->data['created'] = date('Y-m-d H:i:s', (strtotime(date('m/d/Y h:i:s a', time()))));

	    $this->request->data['status'] = 2;



	    //$this->employers->create();

	    if (ClassRegistry::init('institutes')->save($this->request->data)) {
			//$this->redirect(array('action' => 'index'));
			$this->redirect('/admin/institutes/');
	    } else {
			$this->Session->setFlash(___('the institutes could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('institutes_types', ClassRegistry::init('institutes_types')->find('all'));	   

	}
    }

    function admin_edit($id = null) {
        $institute = ClassRegistry::init('institutes')->find('first',array('conditions' => array('institutes.id' => $id)));
        $this->set('institute', $institute);
        $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('institutes_types', ClassRegistry::init('institutes_types')->find('all'));	
            
            if ($this->request->is('post')){
                ClassRegistry::init('institutes')->id = $id;
                ClassRegistry::init('institutes')->save(array(
                    'title' => $this->request->data('selectInstitutes'),
                    'established' => $this->request->data('established'),
                    'institute_type_id' => $this->request->data('institutes_types'),
                    'address' => $this->request->data('address'),
                    'primary_email' => $this->request->data('primary_email'),
                    'alternative_email' => $this->request->data('alternative_email'),
                    'contact_name' => $this->request->data('contact_name'),
                    'designation' => $this->request->data('design'),
                    'fax1' => $this->request->data('fax1'),
                    'fax2' => $this->request->data('fax2'),
                    'mobile' => $this->request->data('mobile'),
                    'country_id' => $this->request->data('locations'),
                    'state' => $this->request->data('state'),
                    'city' => $this->request->data('city'),
                    'weburl' => $this->request->data('weburl'),
                    'featured_display' => $this->request->data('featured_institute'),
                    'top_institutes_display' => $this->request->data('top_institutes')
                ));
                
                $this->redirect(array('action' => 'index'));
            }
//	$this->User->id = $id;
//	if (!$this->User->exists()) {
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

	if (ClassRegistry::init('institutes')->delete($id)){  
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
	    $this->redirect(array('controller' => 'users', 'action' => 'search'));
	}
    }

}

?>
