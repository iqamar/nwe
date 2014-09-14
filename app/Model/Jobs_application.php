<?php
App::uses('AppModel', 'Model');

/**
 * @author  :   Danish Backer
 * @date    :   28-05-2014
 */
class Jobs_application extends AppModel {
    
    /*
     * @purpose get jobs list with maximum job applications.
     * @param int/array $id Requires company user id or array of ids.
     * @param string $mode (optional) Mode of fetching data, defaults to 'all' {Options list: 'all','count','list' }.
     * @param int $cutoff (optional) Minimum no. of applications to list.
     * @param int $limit (optional) Limit for result set
     */
    public function get_hot_jobs($id = false,$mode = 'all',$cutoff = 10,$limit = 5){
        if(!$id){
            return false;
            exit;
        }
        $conditions = array(
            'Company.user_id' => $id,
            'Job.status' => 2,
            'DATE(Job.expiry_date) >= CURDATE()',
            'not' => array(
                'Jobs_application.user_id' => null 
            )
        );
        $result = $this->find($mode, array(
            'fields' => array(
                'count(Jobs_application.job_id) cnt, 
                Jobs_application.id, Jobs_application.job_id, Jobs_application.user_id, Jobs_application.status,
                Job.id,Job.title,Job.company_id,Job.expiry_date,
                Company.id,Company.title'
            ),
            'joins' => array(
                array(
                    'alias' => 'Job',
                    'table' => 'jobs',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Job.id = Jobs_application.job_id')
                ),
                array(
                    'alias' => 'Company',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'type' => 'LEFT',
                    'conditions' => array('Company.id = Job.company_id')
                )
            ),
            'conditions' => $conditions,
            'group' => 'Jobs_application.job_id HAVING cnt >= ' . $cutoff,
            'order' => 'cnt DESC',
            'limit' => $limit,
            'recursive' => -1
           )
        );
        return $result?$result:false;
    }
}