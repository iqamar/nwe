<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Post $Post
 */
class users_qualification extends AppModel {
    //var $actsAs = array('Alaxos.UserLinker', 'Containable', 'Acl' => 'requester');
    
/**
 * Display field
 *
 * @var string
 */
	var $name = 'users_qualification';
   var $belongsTo = array(
        'qualification' => array(
            'className'     => 'qualification',
            'foreignKey'    => 'qualification_id'
        )
    );
	/*var $hasMany = array(
        'functional_area' => array(
            'className'     => 'Company',
            'foreignKey'    => 'company_id'
        )
    );*/
}
