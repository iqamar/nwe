<?php
class  PlansController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Plans';
	//var $uses = array('Company','User');

 function beforeFilter() {
	parent::beforeFilter();
$this->Auth->allow();

	

    }

	function admin_index() {	
		$plansListing = ClassRegistry::init('plans')->find('all',array('fields' => array('plans.*'),'limit'=>20,'order'=>'plans.id DESC'));
		$this->set('plans', $plansListing);
    }


    function admin_view($id = null) {
	$this->_set_user($id);
    }

    function admin_add() {
/*echo "<pre>";
	print_r($_REQUEST);
exit;*/
	if ($this->request->is('post')) {

		$this->request->data['title'] = $this->request->data['plan_name'];
		$this->request->data['type'] = $this->request->data['plan_type'];
		$this->request->data['price'] = $this->request->data['price'];
		$this->request->data['yearly_discount_percentage'] = $this->request->data['yearly_discount_percentage'];
	


/*
echo "<pre>";
print_r($this->request->data);
exit;*/


	    $userData = $this->Session->read(@$userid);

	    $this->request->data['user_id'] = $userData['Auth']['User']['id'];

	    $this->request->data['created'] = date('Y-m-d H:i:s', (strtotime(date('m/d/Y h:i:s a', time()))));

	    $this->request->data['status'] = 2;



	    //$this->employers->create();

	    if (ClassRegistry::init('plans')->save($this->request->data)) {
			//$this->redirect(array('action' => 'index'));
			$this->redirect('/admin/plans/');
	    } else {
			$this->Session->setFlash(___('the employee could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('groups_types', ClassRegistry::init('groups_types')->find('all'));
	    

	}
    }

	function admin_features($type){
	//	echo $id;

		$planDetails = ClassRegistry::init('plans')->find('all' ,array('conditions' => array('plans.type' => "$type"))); 
//echo "<pre>"; 
//print_r($planDetails);


//$features = ClassRegistry::init('plans_features_masters')->find('all' ,array('conditions' => array('plans_features_masters.type' => "$type"))); 
$features = ClassRegistry::init('plans_features_masters')->find('all' ,array('fields' => array('plans_features_masters.*, plans_features.*'),'group' => 'plans_features_masters.title, plans_features.id','order' => 'plans_features_masters.id','conditions' => array('plans_features_masters.type' => "$type"),
'joins' => array(array('alias' => 'plans_features', 'table' => 'plans_features', 'foreignKey' => false, 'conditions' => array('plans_features.feature_id = plans_features_masters.id')))));

//print_r($features);
		$this->set('plans', $planDetails);
	$this->set('features', $features);


	}

}
