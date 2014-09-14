<?php
/**
 * Users Controller
 *
 * @property User $User
 */

class UsersExperiencesController extends AppController {

	var $name = 'Users';
	var $helpers = array('Form','html','DatePicker'); 
	
	var $components = array('Auth');
	var $uses = array('User', 'Users_experience','User_profile_strength');
    
	function beforeFilter()
	{
    parent::beforeFilter();

    //$this->Auth->allow(array('login', 'logout','add'));
	$this->Auth->allow();
    switch($this->request->params['action'])
    {
      case 'index':
      case 'admin_index':
        $this->Security->validatePost = false;
    }
	}
	

	public function delete($exp_id) {
	
    if (!$this->request->is('get')) {
        throw new MethodNotAllowedException();
    }
	if ($this->Session->read('userid')) {
		$uid = $this->Session->read('userid');
	}
					/*User profile strength start*/
			$this->loadModel('User_profile_strength');
			$user_Having_exp_count = ClassRegistry::init('Users_experience')->find('all',
														  array(
																'conditions'=>
																 array(
																	   'Users_experience.user_id'=>$uid
																	   )));
			if (sizeof($user_Having_exp_count) == 1) {
				$strength_experience = (5-5);
			}
			else if(sizeof($user_Having_exp_count) == 2){
				$strength_experience = (10-5);
			}
			else if (sizeof($user_Having_exp_count) > 2){
				$strength_experience = (15-5);
			}
    if ($this->Users_experience->delete($exp_id)) {
			
			 if ($this->User_profile_strength->updateAll(array('experience' =>$strength_experience), array('User_profile_strength.user_id' => $uid))) {
				$this->Session->setFlash('Strength successfully saved.');
			}
			else{
				echo "not saved handler strength";
			} 
			/*User profile strength end*/
		
        $this->Session->setFlash(__('The record with id: %s has been deleted.', h($id)));
        return $this->redirect(array('controller'=>'users_profiles','action' => 'display'));
    }
}
}
?>
