<?php

App::uses('AppModel', 'Model');

class Users_profile extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
    var $virtualFields = array('fullname' => 'CONCAT(Users_profile.firstname, " ", Users_profile.lastname)');

    public function getValues($uid, $profile_fields_only = false, $show_heading = false) {
        //$cond = array( 'User.enabled' => 1 );
        $cond['Users_profile.user_id'] = $uid;
        $vals = $this->find('all', array('conditions' => $cond, 'order' => 'Users_profile.user_id'));
        return $vals;
    }
    
    public function get_profiles($id = false, $limit = 1){
        /*
         * @author:     Danish Backer
         * @purppose:   Get full user profile.
         */
        if(!$id){
            return false;
            exit;
        }
        
        $conditions = array(
            'Users_profile.user_id' => $id,
        );
        
        $result = $this->find('all', array('fields' => array(
                'Users_profile.firstname',
                'Users_profile.lastname',
                'Users_profile.title',
                'Users_profile.photo',
                'Users_profile.handler',
                'Users_profile.tags',
                'Users_profile.user_id',
                'Users_profile.hiring',
                'Users_profile.avaliable',
                'Users_profile.mobile',
                'Users_profile.birth_date',
                'Users_profile.summary',
                'Users_profile.city',
                'User.email',
                'Industry.title',
                'Country.name',
                'Country.id'
            ),
            'joins' => array(
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Users_profile.user_id = User.id'
                    )
                ),
                array(
                    'alias' => 'Country',
                    'table' => 'countries',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Users_profile.country_id = Country.id')
                ),
                array(
                    'alias' => 'Industry',
                    'table' => 'industries',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Users_profile.industry_id = Industry.id')
                )
            ),
            'conditions' => $conditions,
            'limit' => $limit
            )
        );
        return $result?$result:false;
    }

    public function get_recommendations($id, $type) {

        if ($type == 'given') {
            //$condition = array('Users_recommendation.user_id='.$id);

            $condition = array('fields' => array(
                    'Users_recommendation.recommended_text,
                    Users_recommendation.created,
                    users_profiles.firstname,
                    users_profiles.lastname,
                    users_profiles.photo,
                    users_profiles.tags'
                ),
                'order' => 'Users_recommendation.id',
                'joins' => array(
                    array('alias' => 'users_profiles',
                        'table' => 'users_profiles',
                        'foreignKey' => false,
                        'conditions' => array('Users_recommendation.friend_id = users_profiles.user_id')
                    )
                ),
                'conditions' => array('Users_recommendation.user_id=' . $id)
            );
        } else {
            //$condition = array('Users_recommendation.friend_id='.$id);
            $condition = array('fields' => array('
                    Users_recommendation.recommended_text,
                    Users_recommendation.created,
                    users_profiles.firstname,
                    users_profiles.lastname,
                    users_profiles.photo,
                    users_profiles.tags
                '),
                'order' => 'Users_recommendation.id',
                'joins' => array(
                    array('alias' => 'users_profiles',
                        'table' => 'users_profiles',
                        'foreignKey' => false,
                        'conditions' => array('Users_recommendation.user_id = users_profiles.user_id')
                    )
                ),
                'conditions' => array('Users_recommendation.friend_id=' . $id)
            );
        }

        $user_recommendations = ClassRegistry::init('Users_recommendation')->find('all', $condition);

        return $user_recommendations;
    }

}