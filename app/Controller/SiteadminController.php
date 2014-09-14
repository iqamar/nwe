<?php

class SiteadminController extends AppController {

    var $helpers = array('Form', 'html');
    var $components = array('Auth');

    function beforeFilter() {
	parent::beforeFilter();
    }

    public function index() {
	$this->render('profile');
	//echo "this is the index for home page";
	//exit;
    }

    public function add() {

	//echo "this is the index for home page";
    }

}

