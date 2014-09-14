<?php
class LoginsController extends AppController {

    //var $helpers = array('Form', 'html');
     var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
	//var $uses = array('User','Comment','Connection','Statusupdate');
    function beforeFilter() {
	parent::beforeFilter();



	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin_index':
	    // $this->Security->validatePost = false;
	}
    }

  function index() {
	$this->User->recursive = 0;
	$this->set('users', $this->paginate($this->User));
	$this->autoRender = false;
	$roles = $this->Login->Role->find('list');
	$this->set(compact('roles'));
    }
	
	
	function admin_login(){
		$this->login();
	}

	function admin_logout(){
		$this->logout();
	}


    function login() {
	if ($this->request->is('post')) {
/*echo "<pre>";

print_r($this->request->data);
exit;*/
		

	    if ($this->Auth->login()) {
			print_r($this->request->data);
		exit;
		$cuser = $this->Session->read('Auth.Login');
		$id = $this->Session->read('Auth.Login.id');
		$theme = $this->Session->read('Auth.Login.theme');
		$this->Session->write('userid', $id);
		$this->Session->write('checkUser', 'logged');
		$this->Session->write('theme', $theme);
		$this->Session->setFlash(__('Congratulations.....'));
		$this->redirect($this->Auth->redirect());
		//$this->redirect('/');
	    } else {
		$this->Session->setFlash(__('Your email or password was incorrect.'));
		$this->redirect('/');
		exit;
	    }
	}
    }

    function logout() {
	$this->Session->write('userid', '');
	$this->Session->write('theme', '');
	$this->redirect($this->Auth->logout());
    }

}

