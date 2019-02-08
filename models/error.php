<?php
//###########################################
// Model　エラーページ
//###########################################

function handle($params){
    return [
        'page' => 'error',
        'layout' => 'public_default',
        'title' => 'エラーが発生しました'
    ];
}

?>