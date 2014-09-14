<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Users_viewing extends AppModel {

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
 public function saveConnection($uid,$friend_id,$request){ 
 
 $result = $this->updateAll(array('Connection.request' =>$request), array('Connection.friend_id' => $friend_id,'Connection.user_id' =>$uid));
 return $result;
 }

}