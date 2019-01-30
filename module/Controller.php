<?php

include ('../module/Page.php');

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
        $this->url = $url;
        $page = array_shift($this->url);
        if($page !== ''){ $this->page = $page; }
    }

    /**
     * 実行するモジュールの判断を行う
     * Modelの実行内容をViewに渡し、編集したページを表示する
     */
    public function Main(){

        $Page = new Page();

        // Modelの処理を実行
        if(file_exists('../models/'.$this->page.'.php')){
            include ('../models/'.$this->page.'.php');

            if (function_exists('handle')) {
                // Model::handleから実行結果を取得
                $Page->setData( handle($this->url) );
            }
        }

        // 編集したページを表示
        $Page->Print();
    }
}

?>