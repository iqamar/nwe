<?php

class Settings_detail extends AppModel {

    public $belongsTo = array(
        'Settings_master' => array(
            'className'     => 'Settings_master',
            'foreignKey'    => 'settings_master_id'
        )
    );   
	
}
