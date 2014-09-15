<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Post $Post
 */
class jobs_functional_area extends AppModel {
    //var $actsAs = array('Alaxos.UserLinker', 'Containable', 'Acl' => 'requester');
    
/**
 * Display field
 *
 * @var string
 */
	var $name = 'jobs_functional_area';
   var $belongsTo = array(
        'functional_area' => array(
            'className'     => 'functional_area',
            'foreignKey'    => 'functional_area_id'
        )
    );
	/*var $hasMany = array(
        'functional_area' => array(
            'className'     => 'Company',
            'foreignKey'    => 'company_id'
        )
    );*/
}
