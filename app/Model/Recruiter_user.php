<?php
App::uses('AppModel', 'Model');

/**
 * @author  :   Danish Backer
 * @date    :   29-04-2014
 */
class Recruiter_user extends AppModel {
    
    public function isIdUnique($id,$company_id=false){
        //Configure::write('debug', 2);
        if(!$id) { 
            return false; 
            exit;
        }
        $conditions = array(
            'user_id' => $id
            //,'company_id' => $company_id
        );
        if($company_id){
            $cond = array();
            $i = 1;
            $cond[$i++] = array('company_id' => $company_id);
            $conditions = array_merge($conditions, array('AND' => array($cond)));
        }
        return ($this->hasAny($conditions))?false:true;
    }
    
    public function get_assigned_users($company_id){
        /*
         * @author  :   Danish Backer
         * @date    :   15-05-2014
         */
        $result = $this->find('all', array(
            'fields' => array(
                'Users_profile.user_id',
                'Recruiter_user.modified',
				'Recruiter_user.id',
                'CONCAT(Users_profile.title," ",Users_profile.firstname," ",Users_profile.lastname) fullname',
                'Company.title',
                'Company.city',
                'User.email'
            ),
            'joins' => array(
                array(
                    'alias' => 'Users_profile',
                    'table' => 'users_profiles',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Users_profile.user_id = Recruiter_user.user_id')
                ),
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Users_profile.user_id')
                ),
                array(
                    'alias' => 'Company',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Company.id = Recruiter_user.company_id')
                )
            ),
            'conditions' => array(
                'Recruiter_user.company_id' => $company_id,
                'Recruiter_user.status' => 2
            ),
            'order' => 'DATE(`Recruiter_user`.`modified`) DESC, `Recruiter_user`.`created` ASC',
            'group' => 'Users_profile.user_id',
            'recursive' => -1
           )
        );
        //pr($result);
        return $result?$result:false;
    }
    
    public function create_record($user_id,$company_id,$status =2) {
        $data = array();
        $data['user_id'] = $user_id;
        $data['company_id'] = $company_id;
        $data['status'] = $status;
        return $this->save($data);
    }
    
    public function read_record($limit=5) {
        return $this->find('all', array('limit' => $limit));
    }
    
    public function update_record($user_id,$company_id,$status =2) {
        return $user_id.$company_id.$status;
    }
    
    public function delete_record($user_id) {
        return $user_id;
    }

}