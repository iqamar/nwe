<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Company_user extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	
/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'user_id'
        ),
		'Company'=>array(
			'className'     => 'Company',
            'foreignKey'    => 'company_id'
		)
    );


}