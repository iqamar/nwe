<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Post $Post
 */
class Job extends AppModel {
    //var $actsAs = array('Alaxos.UserLinker', 'Containable', 'Acl' => 'requester');
    
/**
 * Display field
 *
 * @var string
 */
	var $name = 'Job';
    var $belongsTo = array(
        'Country' => array(
            'className'     => 'Country',
            'foreignKey'    => 'country_id'
        ),
		'Company'=>array(
			'className'     => 'Company',
            'foreignKey'    => 'company_id'
		)
    );
	 /*var $hasMany = array(
        'Company' => array(
            'className'     => 'Company',
            'foreignKey'    => 'company_id'
        )
    );*/
}
