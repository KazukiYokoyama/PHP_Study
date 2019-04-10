<?php
//###########################################
// Model　トップページ
//###########################################

class Home extends Model{

    public function Action(){
        if($_SESSION['account_id']){
            $this->page_data['msg'] = 'ログイン中だよ！';
        }
        $this->page = new Page('トップページ', 'home', $this->page_data);
    }
}

?>