<?php
App::uses('AppModel', 'Model');

class Job extends AppModel {

    public $belongsTo = array(
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id'
        ),
        'Company' => array(
            'className' => 'Company',
            'foreignKey' => 'company_id'
        )
    );
    
    public $hasOne = array(
        'jobs_functional_area' => array(
            'className' => 'jobs_functional_area',
            'foreignKey'    => 'job_id'
            //'conditions' => array('jobs_functional_area.job_id' => '1'),
            //'dependent' => true
        )
    );
    
    public function get_job_list($company_id, $mode = false ){
        /*
         * @author  :   Danish Backer
         * @date    :   18-05-2014
         */
        
        /*
         * Default mode set to active jobs.
         */
        $mode = $mode?$mode:2;
        
        if(!$company_id){
            return false;
            exit;
        }
        
        $conditions = array(
                'Job.company_id' => $company_id
            );
        
        if($mode == 3)
            $conditions = array_merge($conditions, array('AND' => array('DATE(Job.expiry_date) < CURDATE()')));
        else if($mode == -1)
            $conditions = array_merge($conditions, array('AND' => array('Job.status' => $mode)));
        else
            $conditions = array_merge($conditions, array('AND' => array('Job.status' => $mode, 'DATE(Job.expiry_date) >= CURDATE()')));
            
        
        $result = $this->find('all', array(
            'fields' => array(
                'Job.id','Job.title','Job.status','Job.start_date','Job.expiry_date','Job.job_code','Job.user_id','Job.country_id',
                'Job.city','Job.min_experience','Job.max_experience','Job.company_id',
                'Company.id','Company.title','Company.user_id',
                'Country.id','Country.name'
            ),
            'joins' => array(
                array(
                    'alias' => 'Company',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Company.user_id = Job.user_id')
                ),
                array(
                    'alias' => 'Country',
                    'table' => 'countries',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Country.id = Job.country_id'
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => 'DATE(`Job`.`modified`) DESC, `Job`.`created` ASC',
            'group' => 'Job.id',
            'recursive' => -1
           )
        );
        //pr($result);
        return $result?$result:false;
    }


    public function get_matching_profiles($job_id){
        /*
         * @author  :   Danish Backer
         * @date    :   14-05-2014
         */
        $result = $this->find('all', array(
            'fields' => array(
                'Job.title',
                'Users_profile.firstname',
                'Users_profile.lastname',
                'Users_profile.title',
                'Users_profile.tags',
                'Users_profile.user_id',
                'Users_profile.hiring'/*,
                'Job.industries',
                'Jobs_skill.job_id',
                'Jobs_skill.skill_id',
                'Users_skill.skill_id'*/
            ),
            'joins' => array(
                array(
                    'alias' => 'Jobs_skill',
                    'table' => 'jobs_skills',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Jobs_skill.job_id = Job.id')
                ),
                array(
                    'alias' => 'Users_skill',
                    'table' => 'users_skills',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Users_skill.skill_id = Jobs_skill.skill_id',
                        'not' => array(
                            'Jobs_skill.skill_id' => null
                        )
                    )
                ),
                array(
                    'alias' => 'Users_profile',
                    'table' => 'users_profiles',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array(
                        'OR' => array(
                            'Users_profile.user_id = Users_skill.user_id',
                            'Users_profile.industry_id = Job.industries',
                        )
                    )
                ),
                array(
                    'alias' => 'User',
                    'table' => 'users',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Users_profile.user_id')
                )
            ),
            'conditions' => array(
                'Job.id' => $job_id,
                'User.status' => 1,
                'Job.status' => 2,
                'not' => array(
                    'Job.industries' => null,
                    'Users_profile.user_id' => null,
                    'Jobs_skill.job_id' => null,
                    'Jobs_skill.skill_id' => null,
                    'Users_skill.skill_id' => null
                )
            ),
            'order' => 'DATE(`User`.`modified`) DESC, `User`.`created` ASC',
            'group' => 'Users_profile.user_id',
            'recursive' => -1
           )
        );
        //pr($result);
        return $result?$result:false;
    }

}
