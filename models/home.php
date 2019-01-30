<?php
//###########################################
// Model　トップページ
//###########################################

function handle($params){
    return [
        'page' => 'home',
        'layout' => 'public_default',
        'title' => 'トップページ',
        'msg' => 'Hello World!'
    ];
}

?>