<?php
//###########################################
// Model　ログアウト
//###########################################

class Logout extends Model{

    /**
     * ログアウトの動作
     * @return void
     */
    public function Action(){
        session_destroy();
        header("Location: /home");
        exit;
    }
}