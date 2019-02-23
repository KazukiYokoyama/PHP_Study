<?php
//###########################################
// Model　アカウント登録
//###########################################

class Register extends Model{

    public function Action(){
        $this->page = new Page('アカウント登録', 'register');
    }
}

?>