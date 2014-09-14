<?php
App::uses('AppModel', 'Model');

class Users_experience extends AppModel {

    public function saveData($data) {
        $user_id = $data['User']['user_id'];
        $company = $data['User']['company'];
        $employer = $data['User']['employer'];
        $designation = $data['User']['designation'];
        $startdate = $data['User']['startdate'];
        $enddate = $data['User']['enddate'];
        $this->save(array(
            'company' => $company,
            'user_id' => $user_id,
            'employer' => $employer,
            'designation' => $designation,
            'startdate' => $startdate,
            'enddate' => $enddate
        ));
        return;
    }

    public function get_user_experience($id = false, $limit = 5) {

        /*
         * @author:     Danish Backer
         * @date:       22-05-2014
         * @purpose:    Fetch full user experiece in Years and Months format.
         */

        if (!$id) {
            return false;
            exit;
        }

        $conditions = array(
            'Users_experience.user_id' => $id,
        );

        /*
          DATEDIFF(
          COALESCE(STR_TO_DATE(CONCAT(end_date,"-01 00:00:00"), "%m-%Y-%d %H:%i:%s"),NOW()),
          STR_TO_DATE(CONCAT(start_date,"-01 00:00:00"), "%m-%Y-%d %H:%i:%s")
          ) AS days,
         */

        $result = $this->find('all', array(
            'fields' => array(
                'Users_experience.id',
                'Users_experience.start_date',
                'Users_experience.designation',
                'Users_experience.end_date',
                'Users_experience.location',
                'Company.id',
                'Company.title,
                        FLOOR(
                            DATEDIFF(
                                    COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                    STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                            )/365
                        ) AS years,
                        FLOOR(
                                (
                                DATEDIFF(
                                    COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                    STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                )/365
                        -
                                FLOOR(
                                    DATEDIFF(
                                        COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                        STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                    )/365
                                )
                        ) * 12
                    ) AS months,
                    CEILING(
                        (
                            (
                                (
                                    DATEDIFF(
                                        COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                        STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                    )/365
                                -
                                    FLOOR(
                                        DATEDIFF(
                                            COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                            STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                        )/365
                                    )
                                ) * 12
                            )
                            -
                            FLOOR(
                                (
                                    DATEDIFF(
                                        COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                        STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                    )/365
                                -
                                    FLOOR(
                                        DATEDIFF(
                                            COALESCE(STR_TO_DATE(CONCAT(end_date, "-01"), "%m-%Y-%d"),CURDATE()),
                                            STR_TO_DATE(CONCAT(start_date, "-01"),"%m-%Y-%d")
                                        )/365
                                    )
                                ) * 12
                            )
                        ) * 30
                    ) days
                ',
                'Company.logo'
            ),
            'joins' => array(
                array(
                    'alias' => 'Company',
                    'table' => 'companies',
                    'foreignKey' => false,
                    'conditions' => array('Users_experience.company_id = Company.id'
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => 'STR_TO_DATE(CONCAT(Users_experience.start_date, "-01"),"%m-%Y-%d") DESC',
            'recursive' => -1,
            'limit' => $limit
                )
        );

        return $result ? $result : false;
    }

}