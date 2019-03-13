<?php
//###########################################
// Model　トップページ
//###########################################

class Home extends Model{

	public function Action(){
		$this->page_data['msg'] = array_shift($this->url);
		$this->page = new Page('トップページ', 'home', $this->page_data);
	}
}

?>