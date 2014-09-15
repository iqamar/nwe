<?php

class Group extends AppModel {
    
    //public $actsAs = array('Containable');
    //public $hasMany = array('Groups_types');
    public $hasOne = array(
        'groups_types' => array(
            'className' => 'groups_types',
            'foreignKey'    => 'id'
        )
    );
    
    //public $actsAs = array('Containable');
    //public $belongsTo = array('groups_types');
}