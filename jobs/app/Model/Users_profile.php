<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Post $Post
 */
class Users_profile extends AppModel {
   
    
var $name = 'Users_profile';
	var $virtualFields = array('fullname' => 'CONCAT(Users_profile.firstname, " ", Users_profile.lastname)');
	
    var $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id'
        )
    );
	
	 

}