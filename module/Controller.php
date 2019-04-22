<?php
//###########################################
// Controller 
// リクエストに応じたモジュールを実行する
//###########################################
Class Controller{
	private $url = [];          // リクエストされたURL
	private $page = 'home';     // リクエストページ

	/**
	 * URLとリクエストページの設定
	 * URLの先頭をリクエストページとする
	 */
	function __construct() {
		// URL取得
		$this->url = explode('/', filter_input(INPUT_GET, 'url'));
		$page = array_shift($this->url);
		if($page !== ''){ $this->page = $page; }
		// セッションの有効期限を1時間に設定
		session_set_cookie_params(60 * 60);
		//セッションスタート
		session_start();
	}

	/**
	 * 実行するモジュールの判断を行う
	 * Modelの実行内容をViewに渡し、編集したページを表示する
	 */
	public function Main(){
		$page = [];    // ページで使用する情報
		$include_file = $this->page;
		if($include_file === 'user'){
			if(!$_SESSION["account_id"]){
				header("Location: /login");
			}
			$this->page = array_shift($this->url);
			$include_file .= '/'.$this->page;
		}

		// ページが無い場合、404（Not Found）を表示する
		if(!file_exists('../views/'.$include_file.'.view.php')){
			header("HTTP/1.0 404 Not Found");
			header("Location: /404");
		}

		// Modelの処理を実行
		if(file_exists('../models/'.$include_file.'.php')){
			include_once ('../models/'.$include_file.'.php');
			// Modelから実行結果を取得
			$model = new $this->page($this->url);
			$model->Action();
			$page = $model->getPage();
		}
		if ($include_file === '404'){
			$page = new Page('404 not found', $include_file);
		}

		// 編集したページを表示
		$view = new View($page);
		$view->Print();
	}
}
?>