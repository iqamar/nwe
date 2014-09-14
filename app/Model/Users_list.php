<?php
/*
 * @author:     Danish Backer
 * @date:       16-06-2014
 */

App::uses('AppModel', 'Model');

class Users_list extends AppModel {
    
    var $name = 'Users_list';
    var $useTable = 'users_lists';
    var $primaryKey = 'id';
    var $useDbConfig = 'default';
    
    public function get_users_all(){
        $result = $this->find('all', array(
            'limit' => 30
           )
        );
        return $result?$result:false;
    }
    
}