<?php
/*
 * @author:     Danish Backer
 * @date:       22-05-2014
 */

App::uses('AppModel', 'Model');

class Jobs_referral extends AppModel {

    /*
     * @param int $id Requires company user id.
     * @param string $mode (optional) Mode of fetching data, defaults to 'all'.
     */
    public function get_refered_jobs($id = false, $mode = 'all'){
        if(!$id){
            return false;
            exit;
        }
        $conditions = array(
                        'Company.user_id' => $id,
                        'User.status' => 1,
                        'Job.status' => 2,
                        'not' => array(
                            'Jobs_referral.friend_id' => null,
                            'Jobs_referral.user_id' => null,
                            'Jobs_referral.email' => null
                        )
                    );
        $result = $this->find($mode, array(
            'fields' => array(
                'Jobs_referral.id RID, Jobs_referral.job_id, Jobs_referral.user_id, Jobs_referral.friend_id, Jobs_referral.email, Jobs_referral.created,
                Job.id JID, Job.title job_title, Job.`status`,
                (SELECT firstname FROM users_profiles Users_profile WHERE Users_profile.user_id = Jobs_referral.friend_id) refered_to,
                CONCAT(Users_profile.firstname," ",Users_profile.lastname) as refered_by'
            ),
            'joins' => array(
                array(
                    'alias' => 'Job',
                    'table' => 'jobs',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Job.id = Jobs_referral.job_id')
                ),
                array(
                    'alias' => 'Company',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Company.id = Job.company_id')
                ),
                array(
                    'alias' => 'Country',
                    'table' => 'countries',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Country.id = Job.country_id')
                ),
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Jobs_referral.user_id')
                ),
                array(
                    'alias' => 'Users_profile',
                    'table' => 'users_profiles',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Users_profile.user_id = User.id')
                )
            ),
            'conditions' => $conditions,
            'order' => 'DATE(Jobs_referral.created) DESC',
            'recursive' => -1
           )
        );
        return $result?$result:false;
    }
    
}
