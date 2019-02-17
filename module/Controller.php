<?php

include_once ('../module/Page.php');

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
    function __construct(array $url) {
        // セッションの有効期限を1時間に設定
        session_set_cookie_params(60 * 60);
        //セッションスタート
        session_start();

        $this->url = $url;
        $page = array_shift($this->url);
        if($page !== ''){ $this->page = $page; }
    }

    /**
     * 実行するモジュールの判断を行う
     * Modelの実行内容をViewに渡し、編集したページを表示する
     */
    public function Main(){
        $page_data = [];    // ページで使用する情報

        // Modelの処理を実行
        if(file_exists('../models/'.$this->page.'.php')){
            include_once ('../models/'.$this->page.'.php');

            // Modelから実行結果を取得
            $model = new $this->page($this->url);
            $model->Action();
            $page_data = $model->getData();
        }

        // リクエストがAjaxの場合、処理を終了する
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
            exit;
        }

        // 編集したページを表示
        $Page = new Page();
        $Page->setData($page_data);
        $Page->Print();
    }
}

?>