<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property Skill $Skill
 */
class Skill extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    public function get_skills($match, $limit = 10, $type){
        /*
         * @author: Danish Backer
         * @date: 11-05-2014
         * @purpose: get user skills.
         */
        $result = $this->find('all',array(
                    'fields' => array('id', 'title'),
                    'conditions' => array(
                        'AND' => array(
                            array('LOWER(title) LIKE "' . strtolower($match) . '%"'),
                            array('status = 2')
                            )
                        ),
                    'order' => 'title ASC',
                    'limit' => $limit,
                    'recursive' => -1
                    )
                );
        switch ($type){
            case 'json': 
                foreach ($result as $item){
                    $ar[] = $item['Skill']['title'];
                }
                return $ar;
                break;
            default: return $result; break;
        }
    }
    
    public function get_user_skills($id = false){
        /*
         * @author:     Danish Backer
         * @purppose:   Get user skills and recommendations count.
         */
        if(!$id){
            return false;
            exit;
        }
        
        $result = $this->find('all', array(
            'fields' => array(
                'DISTINCT Skill.title',
                'Skill.skills_category_id',
                'Skill.id',
                'Users_skill.id',
                'Users_skill.skill_id',
                'Users_skill.user_id',
                'Users_skill.start_date',
                'Users_skill.end_date',
                'count(Skill_recommendation.recommends) as total_recommendations'
            ),
            'joins' => array(
                array('alias' => 'Users_skill',
                    'table' => 'users_skills',
                    'foreignKey' => false,
                    'conditions' => array('Users_skill.skill_id = Skill.id'
                    )
                ),
                array('alias' => 'Skill_recommendation',
                    'table' => 'skill_recommendations',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('Skill_recommendation.user_id=' . $id . ' AND Skill_recommendation.skill_id = Users_skill.skill_id AND Skill_recommendation.recommendation=1'
                    )
                )
            ),
            'conditions' => array('Users_skill.user_id' => $id),
            'group' => 'Skill.id'
            )
        );
        return $result?$result:false;
    }
    
}