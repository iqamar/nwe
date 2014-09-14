<?php
/**
 * Users Controller
 *
 * @property User $User
 */
class DashboardController extends AppController {

	var $name = 'Users';
	var $helpers = array('Form', 'Alaxos.AlaxosForm', 'Alaxos.AlaxosHtml');
	var $components = array('Alaxos.AlaxosFilter');

	function beforeFilter()
	{
    parent::beforeFilter();

    $this->Auth->allow(array('login', 'logout'));

    switch($this->request->params['action'])
    {
      case 'index':
      case 'admin_index':
        //$this->Security->validatePost = false;
    }
	}
	
	function index()
	{
echo "<pre>";
		print_r($this->Sessions);
exit;
//		$this->_set_user($id);
		/*$this->User->recursive = 0;
		$this->set('users', $this->paginate($this->User, $this->AlaxosFilter->get_filter()));
		
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));*/
	}


	function _set_user($id)
	{
		$this->User->id = $id;
		if(!$this->User->exists())
		{
			throw new NotFoundException(___('invalid id for user'));
		}
	    
	    /*
	    * Test allowing to not override submitted data
	    */
	    if(empty($this->request->data))
	    {
	    	$this->request->data = $this->User->findById($id);
	    }
	    
	    $this->set('user', $this->request->data);
	    
	    return $this->request->data;
	}
	
	
}
?>
