<?php

//###########################################
// Controller 
// リクエストに応じたモジュールの呼び出しを行う
//###########################################
Class Controller{

    private $url = [];          // リクエストされたURL
    private $page = 'home';     // リクエストページ

    // URLとリクエストページの設定
    // URLの先頭をリクエストページとする
    function __construct(array $url) {
        $this->url = $url;
        $page = array_shift($this->url);
        if($page !== ''){ $this->page = $page; }
    }

    public function Main(){

        // Model読み込み
        if(file_exists('../models/'.$this->page.'.php')){
            include ('../models/'.$this->page.'.php');
            // Model::handleから実行結果を取得
            // $ret = handle($params);
            // extract($ret);
        }

        // View読み込み
        if(file_exists('../views/'.$this->page.'.view.php')){
            include ('../views/'.$this->page.'.view.php');
            $page_print = new PagePrint();
            $page_print->PageView();
        }else{
            // ページが無い場合、404（Not Found）を表示する
            echo $this->page . ' (´・ω・｀) 無いよ';
        }
    }
}


?>