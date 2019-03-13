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
		$this->page_data['msg'] = array_shift($this->url);
	}
}

?>