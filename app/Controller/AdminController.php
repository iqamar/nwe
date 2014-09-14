<?php

class AdminController extends AppController {

    var $helpers = array('Form', 'html');
    var $components = array('Auth');

    function beforeFilter() {

	parent::beforeFilter();
	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }

    public function admin_index() {
	$this->render('dashboard');
	//echo "this is the index for home page";
	//exit;
    }

    /* public function jobs() {
      echo $this->request->params['action'];
      $this->render('dashboard');
      //echo "this is the index for home page";
      //exit;
      } */

    public function add() {
	echo "this is the index for home page";
    }




}

