<?php
class  PlansFeaturesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'PlansFeatures';
	//var $uses = array('Company','User');

 function beforeFilter() {
	parent::beforeFilter();
$this->Auth->allow();

	

    }

function admin_index() {

$PlansFeaturesListing = ClassRegistry::init('plans_features_masters')->find('all',array('limit'=>20,'order'=>'plans_features_masters.id DESC'));
$this->set('plansfeatures', $PlansFeaturesListing);
    }

    function admin_view($id = null) {
	$this->_set_user($id);
    }

    function admin_add() {
/*	echo "<pre>";
	print_r($_REQUEST);
exit;*/
	if ($this->request->is('post')) {


/*
echo "<pre>";
print_r($this->request->data);
exit;*/


	    $userData = $this->Session->read(@$userid);

	    $this->request->data['user_id'] = $userData['Auth']['User']['id'];

	    $this->request->data['created'] = date('Y-m-d H:i:s', (strtotime(date('m/d/Y h:i:s a', time()))));

	    $this->request->data['status'] = 2;





	    if (ClassRegistry::init('plans_features_master')->save($this->request->data)) {
			//$this->redirect(array('action' => 'index'));
			$this->redirect('/admin/plans_features/');
	    } else {
			$this->Session->setFlash(___('the employee could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} 
    }



}
