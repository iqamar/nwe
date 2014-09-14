<?php
/*
 * @author:     Danish Backer
 * @date:       22-05-2014
 */
App::uses('AppModel', 'Model');

class Users_qualification extends AppModel {
   
    public function get_qualification($id = false, $limit = 3){
        /*
         * @author:     Danish Backer
         * @purppose:   Get user skills and recommendations count.
         */
        if(!$id){
            return false;
            exit;
        }
        
        $conditions = array(
            'Users_qualification.user_id' => $id,
        );
        
        $result = $this->find('all', array(
            'fields' => array(
                'Users_qualification.start_date,Users_qualification.end_date,Users_qualification.field_study,Institute.id,Institute.title,Qualification.title'
            ),
            'joins' => array(
                            array('alias' => 'Institute',
                                'table' => 'institutes',
                                'foreignKey' => false,
                                'conditions' => array(
                                    'Users_qualification.institute_id = Institute.id'
                                )
                            ),
                            array('alias' => 'Qualification',
                                'table' => 'qualifications',
                                'foreignKey' => false,
                                'conditions' => array(
                                    'Users_qualification.qualification_id = Qualification.id'
                                )
                            )
            ),
            'conditions' => $conditions,
            'limit' => $limit,
            'order' => 'STR_TO_DATE(CONCAT(Users_qualification.end_date, "-01"),"%m-%Y-%d") DESC'
            )
        );
        return $result?$result:false;
    }
    
}