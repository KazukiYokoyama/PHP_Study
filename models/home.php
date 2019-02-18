<?php
//###########################################
// Model　トップページ
//###########################################

class Home extends Model{
    protected $page_data = [
        'page' => 'home',
        'layout' => 'public_default',
        'title' => 'トップページ'
    ];

    public function Action(){
        if($_SESSION['account_id']){
            $this->page_data['msg'] = 'ログイン中だよ！';
        }
        //$this->page_data['msg'] = array_shift($this->url);
    }
}

?>