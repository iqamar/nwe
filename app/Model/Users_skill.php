<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Post $Post
 */
class Users_skill extends AppModel {
   
	
	
	public function saveData($data) {
	
	 $user_id = $data['User']['user_id'];
	 $company = $data['User']['company'];
	 $employer = $data['User']['employer'];
	 $designation = $data['User']['designation'];
	 $startdate = $data['User']['startdate'];
	 $enddate = $data['User']['enddate'];
	$this->save(array(
        'company' => $company,
        'user_id' => $user_id,
		'employer' => $employer,
		'designation' => $designation,
		'startdate' => $startdate,
		'enddate' => $enddate
    ));
	return;
	}
}
