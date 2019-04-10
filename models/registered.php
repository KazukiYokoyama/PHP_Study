<?php
//###########################################
// Model　アカウント登録完了
//###########################################

class Registered extends Model{

    public function Action(){
		$this->page = new Page('アカウント登録完了', 'registered');
	}
}

?>