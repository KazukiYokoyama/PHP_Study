<?php
//###########################################
// Model　エラーページ
//###########################################

class Failure extends Model{
    function __construct() {
        $this->page_data = [
            'page' => 'failure',
            'layout' => 'public_default',
            'title' => 'エラーが発生しました'
        ];
    }
}

?>