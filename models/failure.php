<?php
//###########################################
// Model　エラーページ
//###########################################

class Failure extends Model{
    protected $page_data = [
        'page' => 'failure',
        'layout' => 'public_default',
        'title' => 'エラーが発生しました'
    ];
}

?>