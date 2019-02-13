<?php
//###########################################
// Model　アカウント登録完了
//###########################################

class Registered extends Model{
    function __construct() {
        $this->page_data = [
            'page' => 'registered',
            'layout' => 'public_default',
            'title' => 'アカウント登録完了'
        ];
    }
}

?>