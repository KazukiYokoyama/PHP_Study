<?php
//###########################################
// Model　トップページ
//###########################################

class Home extends Model{
    function __construct() {
        $this->page_data = [
            'page' => 'home',
            'layout' => 'public_default',
            'title' => 'トップページ',
            'msg' => 'Hello World!'
        ];
    }
}

?>