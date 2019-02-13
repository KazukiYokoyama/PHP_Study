<?php
//###########################################
// Model　アカウント登録
//###########################################

class Signup extends Model{
    function __construct() {
        $this->page_data = [
            'page' => 'signup',
            'layout' => 'public_default',
            'title' => 'アカウント登録'
        ];
    }
}

?>