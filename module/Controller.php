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

        // Modelの処理を実行
        if(file_exists('../models/'.$this->page.'.php')){
            include_once ('../models/'.$this->page.'.php');

            // Modelから実行結果を取得
            $model = new $this->page($this->url);
            $model->Action();
            $page = $model->getPage();
        }

        if ($this->page === '404'){
            $page = new Page('404 not found', $this->page);
        }

        // 編集したページを表示
        $view = new View($page);
        $view->Print();
    }
}

?>