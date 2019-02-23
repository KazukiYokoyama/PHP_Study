<?php
//###########################################
// Model　エラーページ
//###########################################

class Failure extends Model{

    public function Action(){
        $this->page = new Page('エラーが発生しました', 'failure');
    }
}

?>