<?php
//###########################################
// Model　エラーページ
//###########################################

class 404 extends Model{
    protected $page_data = [
        'page' => '404',
        'layout' => 'public_default',
        'title' => 'not found'
    ];
}

?>