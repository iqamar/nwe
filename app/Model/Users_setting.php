<?php


class Users_setting extends AppModel {
    
    public $virtualFields = array(
        'option_name' => 'CONCAT("option_", Users_setting.settings_detail_id)'
    );
}



